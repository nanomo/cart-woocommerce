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

use MercadoPago\PP\Sdk\Entity\Payment\AdditionalInfo;
use MercadoPago\PP\Sdk\Entity\Payment\Payer;

/**
 * Class WC_WooMercadoPago_PreferenceCustom
 */
class WC_WooMercadoPago_Preference_Custom extends WC_WooMercadoPago_Preference_Abstract {

	/**
	 * WC_WooMercadoPago_PreferenceCustom constructor.
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $payment Payment.
	 * @param object                             $order Order.
	 * @param array|null                         $custom_checkout Custom checkout.
	 */
	public function __construct( $payment, $order, $custom_checkout ) {
		parent::__construct( $payment, $order, $custom_checkout );
		$this->sdkPayment = $this->make_comum_payment();

		$this->sdkPayment->transaction_amount = $this->get_transaction_amount();
		$this->sdkPayment->token = $this->checkout['token'];
		$this->sdkPayment->description = implode( ', ', $this->list_of_items );
		$this->sdkPayment->installments = (int) $this->checkout['installments'];
		$this->sdkPayment->payment_method_id = $this->checkout['paymentMethodId'];

		$payer = new Payer();
		$payer->email = $this->get_email();

		if ( array_key_exists( 'token', $this->checkout ) ) {
			$this->sdkPayment->metadata['token'] = $this->checkout['token'];
			if ( ! empty( $this->checkout['CustomerId'] ) ) {
				$payer->id = $this->checkout['CustomerId'];
			}
			if ( ! empty( $this->checkout['issuer'] ) ) {
				$this->sdkPayment->issuer_id = (int) $this->checkout['issuer'];
			}
		}

		$this->sdkPayment->payer = $payer;

		$additional_info = new AdditionalInfo();

		// TODO: create proper instances for additional info properties
		$additional_info->items     = $this->items;
		$additional_info->payer     = $this->get_payer_custom();
		$additional_info->shipments = $this->shipments_receiver_address();

		if (
			isset( $this->checkout['discount'] ) && ! empty( $this->checkout['discount'] ) &&
			isset( $this->checkout['coupon_code'] ) && ! empty( $this->checkout['coupon_code'] ) &&
			$this->checkout['discount'] > 0 && 'woo-mercado-pago-custom' === WC()->session->chosen_payment_method
		) {
			$additional_info->items[] = $this->add_discounts();
			// TODO create proper setDiscountsCampaign method
			$this->sdkPayment             = array_merge( $this->preference, $this->add_discounts_campaign() );
		}

		$internal_metadata       = parent::get_internal_metadata();
		$merge_array             = array_merge( $internal_metadata, $this->get_internal_metadata_custom() );
		$this->sdkPayment->metadata = $merge_array;
	}

	/**
	 * Ship cost item
	 *
	 * @return array
	 */
	public function ship_cost_item() {
		$item = parent::ship_cost_item();
		if ( isset( $item['currency_id'] ) ) {
			unset( $item['currency_id'] );
		}
		return $item;
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
	 * Get internal metadata custom
	 *
	 * @return array
	 */
	public function get_internal_metadata_custom() {
		return array(
			'checkout'      => 'custom',
			'checkout_type' => 'credit_card',
		);
	}
}
