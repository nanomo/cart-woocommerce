<?php

/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version   2 or higher
 *
 * @package MercadoPagogi
 */

class WC_WooMercadoPago_Notification extends WC_WooMercadoPago_Notification_Abstract {
	public function check_ipn_response() {
		parent::check_ipn_response();
		$data2 = $_POST;
		$auth  = Request::getAuthorizationHeader();
		if (isset($data2) && !empty($data2)) {
			$key       = Cryptography::encrypt(json_decode($data2, true), $this->mp->get_access_token());
			$resultKey = Cryptography::verify($key, $auth);
			$date      = new DateTime();
			if (true === $resultKey) {
				$resultT        = parent::successful_request($data2);
				$result         = array(
					'old_status' => $data2['status'],
					'newstatus' => $resultT,
					'timestamp' => $date->getTimestamp(),
				);
				$keyResponse    = Cryptography::encrypt(json_decode($result, true), $this->mp->get_access_token());
				$result['hmac'] = $keyResponse;
				$result->hmac   = $keyResponse;
				$this->set_response(200, null, wp_json_encode($result));
			} else {
				$obj = array(
					'error' => 'Sorry, an error was found please check the data and try again'
				);
				$this->set_response(401, null, wp_json_encode($obj));
			}
		}
	}
	public function successful_request( $data ) {
		try {
			$order  = parent::successful_request( $data );
			$status = $this->process_status_mp_business( $data, $order );
			$this->log->write_log(
				__FUNCTION__,
				'Changing order status to: ' .
				parent::get_wc_status_for_mp_status( str_replace( '_', '', $status ) )
			);
			$this->proccess_status( $status, $data, $order );
			return $status;
		} catch ( Exception $e ) {
			$this->log->write_log( __FUNCTION__, $e->getMessage() );
		}
	}

	public function process_status_mp_business( $data, $order ) {
		$status = $data['status'] ? $data['status'] : 'pending';
		if ( method_exists( $order, 'update_meta_data' ) ) {
			if ( ! empty( $data['payment_type_id'] ) ) {
				$order->update_meta_data( __( 'Payment type', 'woocommerce-mercadopago' ), $data['payment_type_id'] );
			}
			if ( ! empty( $data['payment_method_id'] ) ) {
				$order->update_meta_data( __( 'Payment method', 'woocommerce-mercadopago' ), $data['payment_method_id'] );
			}
			if (!empty($data['timestamp']) &&
				!empty($data['id']) &&
				!empty($data['total_refunded']) &&
				!empty($data['total_paid']) &&
				!empty($data['total']) &&
				!empty($data['payment_id'])) {
				$payment_id = $data['payment_id'];
				$order->update_meta_data(
					'Mercado Pago - Payment ' . $data['payment_id'],
					'[Date ' . gmdate( 'Y-m-d H:i:s', strtotime( $data['timestamp'] ) ) .
					']/[Amount ' . $data['total'] .
					']/[Paid ' . $data['total_paid'] .
					']/[Refund ' . $data['total_refunded'] . ']'
				);
				$order->update_meta_data( '_Mercado_Pago_Payment_IDs', $payment_id);
			}
			$order->save();
		} else {
			if ( ! empty( $data['payment_type_id'] ) ) {
				update_post_meta( $order->id, __( 'Payment type', 'woocommerce-mercadopago' ), $data['payment_type_id'] );
			}
			if ( ! empty( $data['payment_method_id'] ) ) {
				update_post_meta( $order->id, __( 'Payment method', 'woocommerce-mercadopago' ), $data['payment_method_id'] );
			}
			if ( !empty($data['payment_id'])  &&
				!empty($data['timestamp'])  &&
				!empty($data['total_paid'])  &&
				!empty($data['total_refunded'])
			) {
				$payment_id = $data['payment_id'];
				update_post_meta(
					$order->id,
					'Mercado Pago - Payment ' . $data['payment_id'],
					'[Date ' . gmdate( 'Y-m-d H:i:s', strtotime( $data['timestamp'] ) ) .
					']/[Amount ' . $data['total'] .
					']/[Paid ' . $data['total_paid'] .
					']/[Refund ' . $data['total_refunded'] . ']'
				);
					update_post_meta($order->id, '_Mercado_Pago_Payment_IDs', $payment_id);
			}
		}
		return $status;
	}



	public function proccess_status( $processed_status, $data, $order ) {
		$used_gateway = get_class( $this->payment );

		switch ( $processed_status ) {
			case 'approved':
				$this->mp_rule_approved( $data, $order, $used_gateway );
				break;
			case 'pending':
				$this->mp_rule_pending( $data, $order, $used_gateway );
				break;
			case 'in_process':
				$this->mp_rule_in_process( $data, $order );
				break;
			case 'rejected':
				$this->mp_rule_rejected( $data, $order );
				break;
			case 'refunded':
				$this->mp_rule_refunded( $order );
				break;
			case 'cancelled':
				$this->mp_rule_cancelled( $data, $order );
				break;
			case 'in_mediation':
				$this->mp_rule_in_mediation( $order );
				break;
			case 'charged_back':
				$this->mp_rule_charged_back( $order );
				break;
			default:
				throw new WC_WooMercadoPago_Exception( 'Process Status - Invalid Status: ' . $processed_status );
		}
	}

	/**
	 * Rule of approved payment
	 *
	 * @param array  $data Payment data.
	 * @param object $order Order.
	 * @param string $used_gateway Class of gateway.
	 */
	public function mp_rule_approved( $data, $order, $used_gateway ) {
		$order->add_order_note( 'Mercado Pago: ' . __( 'Payment approved.', 'woocommerce-mercadopago' ) );

		$payment_completed_status = apply_filters(
			'woocommerce_payment_complete_order_status',
			$order->needs_processing() ? 'processing' : 'completed',
			$order->get_id(),
			$order
		);

		if ( method_exists( $order, 'get_status' ) && $order->get_status() !== 'completed' ) {
			switch ( $data['checkout_type'] ) {
				case 'pix':
				case 'ticket':
					if ( 'no' === get_option( 'stock_reduce_mode', 'no' ) ) {
						$order->payment_complete();
						if ( 'completed' !== $payment_completed_status ) {
							$order->update_status( self::get_wc_status_for_mp_status( 'approved' ) );
						}
					}
					break;
				default:
					$order->payment_complete();
					if ( 'completed' !== $payment_completed_status ) {
						$order->update_status( self::get_wc_status_for_mp_status( 'approved' ) );
					}
					break;
			}
		}
	}

	/**
	 * Rule of pending
	 *
	 * @param array  $data         Payment data.
	 * @param object $order        Order.
	 * @param string $used_gateway Gateway Class.
	 */
	public function mp_rule_pending( $data, $order, $used_gateway ) {
		if ( $this->can_update_order_status( $order ) ) {
			$order->update_status( self::get_wc_status_for_mp_status( 'pending' ) );
			switch ($data['checkout_type'] ) {
				case 'pix':
					$notes    = $order->get_customer_order_notes();
					$has_note = false;
					if ( count( $notes ) > 1 ) {
						$has_note = true;
						break;
					}
					if ( ! $has_note ) {
						$order->add_order_note(
							'Mercado Pago: ' . __( 'Waiting for the PIX payment.', 'woocommerce-mercadopago' )
						);
						$order->add_order_note(
							'Mercado Pago: ' . __( 'Waiting for the PIX payment.', 'woocommerce-mercadopago' ),
							1,
							false
						);
					}
					break;
				case 'ticket':
					$notes    = $order->get_customer_order_notes();
					$has_note = false;
					if ( count( $notes ) > 1 ) {
						$has_note = true;
						break;
					}
					if ( ! $has_note ) {
						$order->add_order_note(
							'Mercado Pago: ' . __( 'Waiting for the ticket payment.', 'woocommerce-mercadopago' )
						);
						$order->add_order_note(
							'Mercado Pago: ' . __( 'Waiting for the ticket payment.', 'woocommerce-mercadopago' ),
							1,
							false
						);
					}
					break;
				default:
					$order->add_order_note(
						'Mercado Pago: ' . __( 'The customer has not made the payment yet.', 'woocommerce-mercadopago' )
					);
					break;
			}
		} else {
			$this->validate_order_note_type( $data, $order, 'pending' );
		}
	}

	/**
	 * Rule of In Process
	 *
	 * @param array  $data  Payment data.
	 * @param object $order Order.
	 */
	public function mp_rule_in_process( $data, $order ) {
		if ( $this->can_update_order_status( $order ) ) {
			$order->update_status(
				self::get_wc_status_for_mp_status( 'inprocess' ),
				'Mercado Pago: ' . __( 'Payment is pending review.', 'woocommerce-mercadopago' )
			);
		} else {
			$this->validate_order_note_type( $data, $order, 'in_process' );
		}
	}

	/**
	 * Rule of Rejected
	 *
	 * @param array  $data  Payment data.
	 * @param object $order Order.
	 */
	public function mp_rule_rejected( $data, $order ) {
		if ( $this->can_update_order_status( $order ) ) {
			$order->update_status(
				self::get_wc_status_for_mp_status( 'rejected' ),
				'Mercado Pago: ' . __( 'Payment was declined. The customer can try again.', 'woocommerce-mercadopago' )
			);
		} else {
			$this->validate_order_note_type( $data, $order, 'rejected' );
		}
	}

	/**
	 * Rule of Refunded
	 *
	 * @param object $order Order.
	 */
	public function mp_rule_refunded( $order ) {
		$order->update_status(
			self::get_wc_status_for_mp_status( 'refunded' ),
			'Mercado Pago: ' . __( 'Payment was returned to the customer.', 'woocommerce-mercadopago' )
		);
	}

	/**
	 * Rule of Cancelled
	 *
	 * @param array  $data  Payment data.
	 * @param object $order Order.
	 */
	public function mp_rule_cancelled( $data, $order ) {
		if ( $this->can_update_order_status( $order ) ) {
			$order->update_status(
				self::get_wc_status_for_mp_status( 'cancelled' ),
				'Mercado Pago: ' . __( 'Payment was canceled.', 'woocommerce-mercadopago' )
			);
		} else {
			$this->validate_order_note_type( $data, $order, 'cancelled' );
		}
	}

	/**
	 * Rule of In mediation
	 *
	 * @param object $order Order.
	 */
	public function mp_rule_in_mediation( $order ) {
		$order->update_status( self::get_wc_status_for_mp_status( 'inmediation' ) );
		$order->add_order_note(
			'Mercado Pago: ' . __( 'The payment is in mediation or the purchase was unknown by the customer.', 'woocommerce-mercadopago' )
		);
	}

	/**
	 * Rule of Charged back
	 *
	 * @param object $order Order.
	 */
	public function mp_rule_charged_back( $order ) {
		$order->update_status( self::get_wc_status_for_mp_status( 'chargedback' ) );
		$order->add_order_note(
			'Mercado Pago: ' . __(
				'The payment is in mediation or the purchase was unknown by the customer.',
				'woocommerce-mercadopago'
			)
		);
	}
}
