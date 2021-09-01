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
 * Class WC_WooMercadoPago_Hook_Order_Details
 */
class WC_WooMercadoPago_Hook_Order_Details {

	public function __construct() {
		$this->load_hooks();
		$this->load_scripts();
	}

	/**
	 * Load Hooks
	 *
	 * @return void
	 */
	public function load_hooks() {
		add_action( 'add_meta_boxes_shop_order', array( $this, 'payment_status_metabox' ));
	}

	/**
	 * Load Scripts
	 *
	 * @return void
	 */
	public function load_scripts() {
		add_action( 'admin_enqueue_scripts', array( $this, 'payment_status_metabox_script' ) );
	}

	/**
	 * Get sufix to static files
	 */
	public function get_suffix() {
		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	}

	/**
	 * Get processed status for alert
	 *
	 * @return String 'success' | 'pending' | 'rejected'
	 */
	public function get_processed_status( $order_status ) {
		$processed_status = [
			'accredited' => 'success',
			'settled' => 'success',
			'reimbursed' => 'success',
			'refunded' => 'success',
			'partially_refunded' => 'success',
			'by_collector' => 'success',
			'by_payer' => 'success',
			'pending' => 'pending',
			'pending_waiting_payment' => 'pending',
			'pending_waiting_for_remedy' => 'pending',
			'pending_waiting_transfer' => 'pending',
			'pending_review_manual' => 'pending',
			'waiting_bank_confirmation' => 'pending',
			'pending_capture' => 'pending',
			'in_process' => 'pending',
			'pending_contingency' => 'pending',
			'pending_card_validation' => 'pending',
			'pending_online_validation' => 'pending',
			'pending_additional_info' => 'pending',
			'offline_process' => 'pending',
			'pending_challenge' => 'pending',
			'pending_provider_response' => 'pending',
			'bank_rejected' => 'rejected',
			'rejected_by_bank' => 'rejected',
			'rejected_insufficient_data' => 'rejected',
			'bank_error' => 'rejected',
			'by_admin' => 'rejected',
			'expired' => 'rejected',
			'cc_rejected_bad_filled_card_number' => 'rejected',
			'cc_rejected_bad_filled_security_code' => 'rejected',
			'cc_rejected_bad_filled_date' => 'rejected',
			'cc_rejected_high_risk' => 'rejected',
			'cc_rejected_fraud' => 'rejected',
			'cc_rejected_blacklist' => 'rejected',
			'cc_rejected_insufficient_amount' => 'rejected',
			'cc_rejected_other_reason' => 'rejected',
			'cc_rejected_max_attempts' => 'rejected',
			'cc_rejected_invalid_installments' => 'rejected',
			'cc_rejected_call_for_authorize' => 'rejected',
			'cc_rejected_duplicated_payment' => 'rejected',
			'cc_rejected_card_disabled' => 'rejected',
			'payer_unavailable' => 'rejected',
			'rejected_high_risk' => 'rejected',
			'rejected_by_regulations' => 'rejected',
			'rejected_cap_exceeded' => 'rejected',
			'cc_rejected_3ds_challenge' => 'rejected',
			'rejected_other_reason' => 'rejected',
			'authorization_revoked' => 'rejected',
			'cc_amount_rate_limit_exceeded' => 'rejected',
			'cc_rejected_expired_operation' => 'rejected',
			'cc_rejected_bad_filled_other' => 'rejected',
			'rejected_call_for_authorize' => 'rejected',
			'am_insufficient_amount' => 'rejected',
			'generic' => 'rejected',
		];
		$status           = array_key_exists($order_status, $processed_status) ? $processed_status[$order_status] : $processed_status['generic'];

		return $status;
	}

	/**
	 * Create payment status metabox
	 *
	 * @return void
	 */
	public function payment_status_metabox() {
		add_meta_box(
			'mp-payment-status-metabox',
			__( 'Payment status on Mercado Pago', 'woocommerce-mercadopago' ),
			[$this, 'payment_status_metabox_content']
		);
	}

	/**
	 * Payment Status Metabox Script
	 *
	 * @return void
	 */
	public function payment_status_metabox_script() {
		$suffix = $this->get_suffix();

		wp_enqueue_script(
			'mp_payment_status_metabox',
			plugins_url( '../../assets/js/payment_status_metabox' . $suffix . '.js', plugin_dir_path( __FILE__ ) ),
			array(),
			WC_WooMercadoPago_Constants::VERSION,
			false
		);
	}

	/**
	 * Payment Status Metabox Content
	 *
	 * @param WP_Post $post
	 *
	 * @return void
	 */
	public function payment_status_metabox_content( $post ) {
		$order = wc_get_order($post->ID);

		if ( is_null($order) || is_null($post->ID) ) {
			return;
		}

		$is_mercadopago_payment_method = in_array($order->get_payment_method(), WC_WooMercadoPago_Constants::GATEWAYS_IDS, true);

		if ( ! $is_mercadopago_payment_method ) {
			return;
		}

		$alert_status = $this->get_processed_status($order->get_status());
		$metabox_data = $this->get_metabox_data($alert_status);

		wc_get_template(
			'order/payment-status-metabox-content.php',
			$metabox_data,
			'woo/mercado/pago/module/',
			WC_WooMercadoPago_Module::get_templates_path()
		);
	}

	/**
	 * Metabox Data
	 *
	 * @param String $alert_status Alert Status (success|pending|rejected)
	 *
	 * @return Array
	 */
	public function get_metabox_data( $alert_status ) {
		$country = get_option( 'checkout_country', '' );

		if ( 'success' === $alert_status ) {
			return [
				'img_src' => esc_url( plugins_url( '../../assets/images/generics/circle-green-check.png', plugin_dir_path( __FILE__ ) ) ),
				'alert_title' => __( 'Payment approved', 'woocommerce-mercadopago' ),
				'alert_description' => 'Descrição do pagamento aprovado', // TODO: Chavear descrição
				'link' => $this->get_mp_home_link($country),
				'border_left_color' => '#00A650',
				'link_description' => __( 'View purchase details at Mercado Pago', 'woocommerce-mercadopago' )
			];
		}

		if ( 'pending' === $alert_status ) {
			return [
				'img_src' => esc_url( plugins_url( '../../assets/images/generics/circle-alert.png', plugin_dir_path( __FILE__ ) ) ),
				'alert_title' => __( 'Payment pending', 'woocommerce-mercadopago' ),
				'alert_description' => 'Descrição do pagamento pendente', // TODO: Chavear descrição
				'link' => $this->get_mp_home_link($country),
				'border_left_color' => '#f73',
				'link_description' => __( 'View purchase details at Mercado Pago', 'woocommerce-mercadopago' )
			];
		}

		if ( 'rejected' === $alert_status ) {
			return [
				'img_src' => esc_url( plugins_url( '../../assets/images/generics/circle-red-alert.png', plugin_dir_path( __FILE__ ) ) ),
				'alert_title' => __( 'Payment refused', 'woocommerce-mercadopago' ),
				'alert_description' => 'Descrição do pagamento reprovado', // TODO: Chavear descrição
				'link' => 'https://www.mercadopago.com.br/home', // TODO: Colocar link do devsite com as infos de pagametos recusados
				'border_left_color' => '#F23D4F',
				'link_description' => __( 'Check the reasons why the purchase was declined.', 'woocommerce-mercadopago' )
			];
		}
	}

	/**
	 * Get Mercado Pago Home Link
	 *
	 * @param String $country Country Acronym
	 *
	 * @return String
	 */
	public function get_mp_home_link( $country ) {
		$country_links = [
			'mla' => 'https://www.mercadopago.com.ar/home',
			'mlb' => 'https://www.mercadopago.com.br/home',
			'mlc' => 'https://www.mercadopago.cl/home',
			'mco' => 'https://www.mercadopago.com.co/home',
			'mlm' => 'https://www.mercadopago.com.mx/home',
			'mpe' => 'https://www.mercadopago.com.pe/home',
			'mlu' => 'https://www.mercadopago.com.uy/home',
		];
		$link          = array_key_exists($country, $country_links) ? $country_links[$country] : $country_links['mla'];

		return $link;
	}
}
