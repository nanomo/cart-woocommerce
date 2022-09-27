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
 * Class WC_WooMercadoPago_Preference_Ticket
 */
class WC_WooMercadoPago_Preference_Ticket extends WC_WooMercadoPago_Preference_Abstract {

	/**
	 * WC_WooMercadoPago_PreferenceTicket constructor.
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $payment Payment.
	 * @param object                             $order Order.
	 * @param mixed                              $ticket_checkout Ticket checkout.
	 */
	public function __construct( $payment, $order, $ticket_checkout ) {
		parent::__construct( $payment, $order, $ticket_checkout );
		$this->transaction = $this->sdk->getPaymentInstance();

		$helper                               = new WC_WooMercadoPago_Composite_Id_Helper();
		$id                                   = $ticket_checkout['paymentMethodId'];
		$date_expiration                      = $payment->get_option( 'date_expiration', WC_WooMercadoPago_Constants::DATE_EXPIRATION ) . ' days';
		$this->paymentPlaceId                 = $helper->getPaymentPlaceId($id);

		$this->transaction = $this->sdk->getPaymentInstance();
		$this->make_comum_transaction();

		$this->transaction->binary_mode        = true;
		$this->transaction->payment_method_id  = $helper->getPaymentMethodId($id);
		$this->transaction->date_of_expiration = $this->get_date_of_expiration( $date_expiration );
		$this->transaction->transaction_amount = $this->get_transaction_amount();
		$this->transaction->description        = implode( ', ', $this->list_of_items );
		$this->transaction->external_reference = $this->get_external_reference();

		$this->transaction->payer->setEntity($this->get_payer_ticket($ticket_checkout));

		if ( 'webpay' === $ticket_checkout['paymentMethodId'] ) {
			$this->set_webpay_properties();
		}

		$this->transaction->additional_info->items->setEntity($this->items);
		$this->transaction->additional_info->payer->setEntity($this->get_payer_custom());
		$this->transaction->additional_info->shipments->setEntity($this->shipments_receiver_address());

		if (
			isset( $this->checkout['discount'] ) && ! empty( $this->checkout['discount'] ) &&
			isset( $this->checkout['coupon_code'] ) && ! empty( $this->checkout['coupon_code'] ) &&
			$this->checkout['discount'] > 0 && 'woo-mercado-pago-ticket' === WC()->session->chosen_payment_method
		) {
			$this->transaction->additional_info->items->setEntity($this->add_discounts());
			$this->transaction->setEntity($this->add_discounts_campaign());
		}
	}

	public function get_internal_metadata() {
		$metadata = parent::get_internal_metadata();
		$metadata['checkout']      = 'custom';
		$metadata['checkout_type'] = 'pix';

		if ( $this->paymentPlaceId ) {
			$metadata['payment_option_id'] = $this->paymentPlaceId;
		}

		return $metadata;
	}

	public function set_webpay_properties() {
		$this->transaction->transaction_details->financial_institution = '1234';
		$this->transaction->callback_url                               = get_site_url();
		$this->transaction->additional_info->ip_address                = '127.0.0.1';
		$this->transaction->payer->identification->type                = 'RUT';
		$this->transaction->payer->identification->number              = '0';
		$this->transaction->payer->entity_type                         = 'individual';
	}

	public function get_payer_ticket($ticket_checkout) {
		$payer = $this->get_payer_custom();
		$payer['email'] = $this->get_email();
		unset($payer['phone']);

		if ( 'BRL' === $this->site_data[ $this->site_id ]['currency'] ) {
			$this->transaction->payer->identification->type   = 14 === strlen( $this->checkout['docNumber'] ) ? 'CPF' : 'CNPJ';
			$this->transaction->payer->identification->number = $this->checkout['docNumber'];
		}

		if ( 'UYU' === $this->site_data[ $this->site_id ]['currency'] ) {
			$this->transaction->payer->identification->type   = $ticket_checkout['docType'];
			$this->transaction->payer->identification->number = $ticket_checkout['docNumber'];
		}

		return $payer;
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
	 * Get internal metadata ticket
	 *
	 * @return array
	 */
	public function get_internal_metadata_ticket() {
		return array(
			'checkout'      => 'custom',
			'checkout_type' => 'ticket',
		);
	}
}
