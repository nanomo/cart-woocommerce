<?php
/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 * @package MercadoPago
 * @category Includes
 * @author Mercado Pago
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WC_WooMercadoPago_Preference_Pix
 */
class WC_WooMercadoPago_Preference_Pix extends WC_WooMercadoPago_Preference_Abstract {


	/**
	 * WC_WooMercadoPago_PreferencePix constructor.
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $payment Payment.
	 * @param object                             $order Order.
	 * @param mixed                              $pix_checkout Pix checkout.
	 */
	public function __construct( $payment, $order, $pix_checkout ) {
		parent::__construct( $payment, $order, $pix_checkout );
		$this->preference                       = $this->make_commum_preference();
		$this->preference['date_of_expiration'] = $this->get_date_of_expiration( $payment );
		$this->preference['transaction_amount'] = $this->get_transaction_amount();
		$this->preference['description']        = implode( ', ', $this->list_of_items );
		$this->preference['payment_method_id']  = $this->checkout['paymentMethodId'];
		$this->preference['payer']['email']     = $this->get_email();

		if ( 'BRL' === $this->site_data[ $this->site_id ]['currency'] ) {
			$this->preference['payer']['first_name']               = $this->checkout['firstname'];
			$this->preference['payer']['last_name']                = 14 === strlen( $this->checkout['docNumber'] ) ? $this->checkout['lastname'] : $this->checkout['firstname'];
			$this->preference['payer']['identification']['type']   = 14 === strlen( $this->checkout['docNumber'] ) ? 'CPF' : 'CNPJ';
			$this->preference['payer']['identification']['number'] = $this->checkout['docNumber'];
			$this->preference['payer']['address']['street_name']   = $this->checkout['address'];
			$this->preference['payer']['address']['street_number'] = $this->checkout['number'];
			$this->preference['payer']['address']['neighborhood']  = $this->checkout['city'];
			$this->preference['payer']['address']['city']          = $this->checkout['city'];
			$this->preference['payer']['address']['federal_unit']  = $this->checkout['state'];
			$this->preference['payer']['address']['zip_code']      = $this->checkout['zipcode'];
		}

		$this->preference['external_reference']           = $this->get_external_reference();
		$this->preference['additional_info']['items']     = $this->items;
		$this->preference['additional_info']['payer']     = $this->get_payer_custom();
		$this->preference['additional_info']['shipments'] = $this->shipments_receiver_address();
		$this->preference['additional_info']['payer']     = $this->get_payer_custom();

		if (
			isset( $this->checkout['discount'] ) && ! empty( $this->checkout['discount'] ) &&
			isset( $this->checkout['coupon_code'] ) && ! empty( $this->checkout['coupon_code'] ) &&
			$this->checkout['discount'] > 0 && 'woo-mercado-pago-pix' === WC()->session->chosen_payment_method
		) {
			$this->preference['additional_info']['items'][] = $this->add_discounts();
			$this->preference                               = array_merge( $this->preference, $this->add_discounts_campaign() );
		}

		$internal_metadata            = parent::get_internal_metadata();
		$merge_array                  = array_merge( $internal_metadata, $this->get_internal_metadata_pix() );
		$this->preference['metadata'] = $merge_array;
	}

	/**
	 * Get date of expiration
	 *
	 * @param WC_WooMercadoPago_Pix_Gateway $payment Payment.
	 * @return string date
	 */
	public function get_date_of_expiration( WC_WooMercadoPago_Pix_Gateway $payment = null ) {
		$date_expiration = ! is_null( $payment )
			? $payment->get_option_mp( 'date_expiration' )
			: $this->get_option( 'date_expiration', '' );

		if ( '' !== $date_expiration ) {
			return gmdate( 'Y-m-d\TH:i:s.000O', strtotime( '+' . $date_expiration . ' days' ) );
		}
	}

	/**
	 * Get items build array
	 *
	 * @return array
	 */
	public function get_items_build_array() {
		$items = parent::get_items_build_array();
		foreach ( $items as $key => $item ) {
			if ( isset( $item['currency_id'] ) ) {
				unset( $items[ $key ]['currency_id'] );
			}
		}

		return $items;
	}

	/**
	 * Get internal metadata pix
	 *
	 * @return array
	 */
	public function get_internal_metadata_pix() {
		return array(
			'checkout'      => 'custom',
			'checkout_type' => 'pix',
		);
	}
}
