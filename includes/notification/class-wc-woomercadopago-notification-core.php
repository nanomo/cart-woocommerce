<?php
/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 * @package MercadoPago
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WC_WooMercadoPago_Notification_Core
 */
class WC_WooMercadoPago_Notification_Core extends WC_WooMercadoPago_Notification_Abstract {

	/**
	 * SDK Preference
	 */
	protected $sdkNotification;

	public function __construct($payment)
	{
		parent::__construct($payment);

		$sdk = $payment->get_sdk_instance();
		$this->sdkNotification = $sdk->getNotificationInstance();
	}

	/**
	 *  IPN
	 */
	public function check_ipn_response() {
		parent::check_ipn_response();
		// @todo need fix Processing form data without nonce verification
		// @codingStandardsIgnoreLine
		$postContent = json_decode(file_get_contents('php://input'));

		status_header( 200, 'OK' );

		//TODO remove useless logs and add new reasonable log
		$this->log->write_log( __FUNCTION__, ' Core Notification $entityBody: ' . $postContent );

		try {
			$notificationEntity = $this->sdkNotification->read(array("id" => $postContent));

			do_action( 'valid_mercadopago_ipn_request', $notificationEntity->toArray() );
			
			$this->set_response( 200, 'OK', 'Successfull Notification by Core' );
		} catch ( Exception $e ) {
			$this->log->write_log( __FUNCTION__, 'receive notification failed: ' . $e->getMessage() );
			return $this->set_response(500, 'Internal Server Error', $e->getMessage());
		}
	}

	/**
	 * Process success response
	 *
	 * @param array $data Payment data.
	 *
	 * @return bool|void|WC_Order|WC_Order_Refund
	 */
	public function successful_request( $data ) {
		try {
			$order            = parent::successful_request( $data );
			$processed_status = $this->process_status_mp_business( $data, $order );
			$this->log->write_log( __FUNCTION__, 'Changing order status to: ' . parent::get_wc_status_for_mp_status( str_replace( '_', '', $processed_status ) ) );
			$this->proccess_status( $processed_status, $data, $order );
		} catch ( Exception $e ) {
			$this->set_response( 422, null, $e->getMessage() );
			$this->log->write_log( __FUNCTION__, $e->getMessage() );
		}
	}

	/**
	 * Process status
	 *
	 * @param array  $data Payment data.
	 * @param object $order Order.
	 * @return string
	 */
	public function process_status_mp_business( $data, $order ) {
		$status   = 'pending';
		$payments = $data['payments_details'];

		if ( is_array($payments) ) {
			$total        = $data['transaction_amount'];
			$total_paid   = 0.00;
			$total_refund = 0.00;
			// Grab some information...
			foreach ( $data['payments_details'] as $payment ) {
				$coupon_mp = $payment['coupon_amount'];

				if ( $coupon_mp > 0 ) {
					$total_paid += (float) $coupon_mp;
				}

				if ( 'approved' === $payment['status'] ) {
					// Get the total paid amount, considering only approved incomings.
					$total_paid += (float) $payment['paid_amount'];
				} elseif ( 'refunded' === $payment['status'] ) {
					// Get the total refounded amount.
					$total_refund += (float) $payment['amount_refunded']; // TODO iterar refunds
				}
			}

			if ( $total_paid >= $total ) {
				$status = 'approved';
			} elseif ( $total_refund >= $total ) {
				$status = 'refunded';
			} else {
				$status = 'pending';
			}
		}
		// WooCommerce 3.0 or later.
		if ( method_exists( $order, 'update_meta_data' ) ) {
			// Updates the type of gateway.
			$order->update_meta_data( '_used_gateway', get_class( $this ) );
			if ( ! empty( $data['payer']['email'] ) ) {
				$order->update_meta_data( __( 'Buyer email', 'woocommerce-mercadopago' ), $data['payer']['email'] ); // TODO ignorar
			}
			if ( ! empty( $data['payment_type_id'] ) ) {
				$order->update_meta_data( __( 'Payment type', 'woocommerce-mercadopago' ), $data['payment_type_id'] ); // TODO ignorar
			}
			if ( ! empty( $data['payment_method_id'] ) ) {
				$order->update_meta_data( __( 'Payment method', 'woocommerce-mercadopago' ), $data['payment_method_id'] ); // TODO ignorar
			}
			if ( ! empty( $data['payments_details'] ) ) {
				$payment_ids = array();
				foreach ( $data['payments_details'] as $payment ) {
					$coupon_mp     = $payment['coupon_amount'];
					$payment_ids[] = $payment['id'];
					$order->update_meta_data(
						'Mercado Pago - Payment ' . $payment['id'],
						'[Date ' . gmdate( 'Y-m-d H:i:s', strtotime( $payment['date_created'] ) ) .
							']/[Amount ' . $data['transaction_amount'] .
							']/[Paid ' . $payment['paid_amount'] .
							']/[Coupon ' . $coupon_mp .
							']/[Refund ' . $payment['amount_refunded'] . ']' // TODO somar amount refunded
					);
				}
				if ( count( $payment_ids ) > 0 ) {
					$order->update_meta_data( '_Mercado_Pago_Payment_IDs', implode( ', ', $payment_ids ) );
				}
			}
			$order->save();
		} else {
			// TODO consertar isso aqui ????
			// Updates the type of gateway.
			update_post_meta( $order->id, '_used_gateway', 'WC_WooMercadoPago_Basic_Gateway' );
			if ( ! empty( $data['payer']['email'] ) ) {
				update_post_meta( $order->id, __( 'Buyer email', 'woocommerce-mercadopago' ), $data['payer']['email'] ); // TODO ignorar
			}
			if ( ! empty( $data['payment_type_id'] ) ) {
				update_post_meta( $order->id, __( 'Payment type', 'woocommerce-mercadopago' ), $data['payment_type_id'] ); // TODO ignorar
			}
			if ( ! empty( $data['payment_method_id'] ) ) {
				update_post_meta( $order->id, __( 'Payment method', 'woocommerce-mercadopago' ), $data['payment_method_id'] ); // TODO ignorar
			}
			if ( ! empty( $data['payments'] ) ) {
				$payment_ids = array();
				foreach ( $data['payments'] as $payment ) {
					$coupon_mp     = $payment['coupon_amount'];
					$payment_ids[] = $payment['id'];
					update_post_meta(
						$order->id,
						'Mercado Pago - Payment ' . $payment['id'],
						'[Date ' . gmdate( 'Y-m-d H:i:s', strtotime( $payment['date_created'] ) ) .
							']/[Amount ' . $payment['transaction_amount'] .
							']/[Paid ' . $payment['total_paid_amount'] .
							']/[Coupon ' . $coupon_mp .
							']/[Refund ' . $payment['amount_refunded'] . ']'
					);
				}
				if ( count( $payment_ids ) > 0 ) {
					update_post_meta( $order->id, '_Mercado_Pago_Payment_IDs', implode( ', ', $payment_ids ) );
				}
			}
		}
		return $status;
	}
}
