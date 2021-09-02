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
	 * Get Alert Description
	 *
	 * @param String $payment_status_detail Come from MP API
	 *
	 * @return String
	 */
	public function get_alert_description( $payment_status_detail ) {
		$all_status_detail = [
			'accredited' => 'accredited',
			'settled' => 'settled',
			'reimbursed' => 'reimbursed',
			'refunded' => 'refunded',
			'partially_refunded' => 'partially_refunded',
			'by_collector' => 'by_collector',
			'by_payer' => 'by_payer',
			'pending' => 'pending',
			'pending_waiting_payment' => 'pending_waiting_payment',
			'pending_waiting_for_remedy' => 'pending_waiting_for_remedy',
			'pending_waiting_transfer' => 'pending_waiting_transfer',
			'pending_review_manual' => 'pending_review_manual',
			'waiting_bank_confirmation' => 'waiting_bank_confirmation',
			'pending_capture' => 'pending_capture',
			'in_process' => 'in_process',
			'pending_contingency' => 'pending_contingency',
			'pending_card_validation' => 'pending_card_validation',
			'pending_online_validation' => 'pending_online_validation',
			'pending_additional_info' => 'pending_additional_info',
			'offline_process' => 'offline_process',
			'pending_challenge' => 'pending_challenge',
			'pending_provider_response' => 'pending_provider_response',
			'bank_rejected' => 'bank_rejected',
			'rejected_by_bank' => 'rejected_by_bank',
			'rejected_insufficient_data' => 'rejected_insufficient_data',
			'bank_error' => 'bank_error',
			'by_admin' => 'by_admin',
			'expired' => 'expired',
			'cc_rejected_bad_filled_card_number' => 'cc_rejected_bad_filled_card_number',
			'cc_rejected_bad_filled_security_code' => 'cc_rejected_bad_filled_security_code',
			'cc_rejected_bad_filled_date' => 'cc_rejected_bad_filled_date',
			'cc_rejected_high_risk' => 'cc_rejected_high_risk',
			'cc_rejected_fraud' => 'cc_rejected_fraud',
			'cc_rejected_blacklist' => 'cc_rejected_blacklist',
			'cc_rejected_insufficient_amount' => 'cc_rejected_insufficient_amount',
			'cc_rejected_other_reason' => 'cc_rejected_other_reason',
			'cc_rejected_max_attempts' => 'cc_rejected_max_attempts',
			'cc_rejected_invalid_installments' => 'cc_rejected_invalid_installments',
			'cc_rejected_call_for_authorize' => 'cc_rejected_call_for_authorize',
			'cc_rejected_duplicated_payment' => 'cc_rejected_duplicated_payment',
			'cc_rejected_card_disabled' => 'cc_rejected_card_disabled',
			'payer_unavailable' => 'payer_unavailable',
			'rejected_high_risk' => 'rejected_high_risk',
			'rejected_by_regulations' => 'rejected_by_regulations',
			'rejected_cap_exceeded' => 'rejected_cap_exceeded',
			'cc_rejected_3ds_challenge' => 'cc_rejected_3ds_challenge',
			'rejected_other_reason' => 'rejected_other_reason',
			'authorization_revoked' => 'authorization_revoked',
			'cc_amount_rate_limit_exceeded' => 'cc_amount_rate_limit_exceeded',
			'cc_rejected_expired_operation' => 'cc_rejected_expired_operation',
			'cc_rejected_bad_filled_other' => 'cc_rejected_bad_filled_other',
			'rejected_call_for_authorize' => 'rejected_call_for_authorize',
			'am_insufficient_amount' => 'am_insufficient_amount',
			'generic' => 'generic',
		];
		$description       = array_key_exists($payment_status_detail, $all_status_detail) ? $all_status_detail[$payment_status_detail] : $all_status_detail['generic'];

		return $description;
	}

	/**
	 * Get Alert Status
	 *
	 * @param String $payment_status Come from MP API
	 *
	 * @return String 'success' | 'pending' | 'rejected'
	 */
	public function get_alert_status( $payment_status ) {
		$all_payment_status = [
			'approved' => 'success',
			'authorized' => 'success',
			'pending' => 'pending',
			'in_process' => 'pending',
			'in_mediation' => 'pending',
			'rejected' => 'rejected',
			'canceled' => 'rejected',
			'refunded' => 'rejected',
			'charged_back' => 'rejected',
			'generic' => 'rejected'
		];
		$status             = array_key_exists($payment_status, $all_payment_status) ? $all_payment_status[$payment_status] : $all_payment_status['generic'];

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

		$payment_method                = $order->get_payment_method();
		$is_mercadopago_payment_method = in_array($payment_method, WC_WooMercadoPago_Constants::GATEWAYS_IDS, true);
		$payment_id                    = $order->get_meta( '_Mercado_Pago_Payment_IDs' );
		$is_production_mode            = $order->get_meta( 'is_production_mode' );

		if ( ! $is_mercadopago_payment_method || ! $payment_id ) {
			return;
		}

		$access_token = 'no' === $is_production_mode
			? get_option( '_mp_access_token_test' )
			: get_option( '_mp_access_token_prod' );
		$mp           = new MP($access_token);
		$payment      = $mp->search_payment_v1($payment_id);

		if ( ! $payment || ! $payment['status'] || 200 !== $payment['status'] ) {
			return;
		}

		$payment_status         = $payment['response']['status'];
		$payment_status_details = $payment['response']['status_detail'];
		$alert_status           = $this->get_alert_status($payment_status);
		$alert_description      = $this->get_alert_description($payment_status_details);
		$metabox_data           = $this->get_metabox_data($alert_status, $alert_description);

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
	 * @param String $alert_description
	 *
	 * @return Array
	 */
	public function get_metabox_data( $alert_status, $alert_description ) {
		$country = get_option( 'checkout_country', '' );

		if ( 'success' === $alert_status ) {
			return [
				'img_src' => esc_url( plugins_url( '../../assets/images/generics/circle-green-check.png', plugin_dir_path( __FILE__ ) ) ),
				'alert_title' => __( 'Payment approved', 'woocommerce-mercadopago' ),
				'alert_description' => $alert_description,
				'link' => $this->get_mp_home_link($country),
				'border_left_color' => '#00A650',
				'link_description' => __( 'View purchase details at Mercado Pago', 'woocommerce-mercadopago' )
			];
		}

		if ( 'pending' === $alert_status ) {
			return [
				'img_src' => esc_url( plugins_url( '../../assets/images/generics/circle-alert.png', plugin_dir_path( __FILE__ ) ) ),
				'alert_title' => __( 'Payment pending', 'woocommerce-mercadopago' ),
				'alert_description' => $alert_description,
				'link' => $this->get_mp_home_link($country),
				'border_left_color' => '#f73',
				'link_description' => __( 'View purchase details at Mercado Pago', 'woocommerce-mercadopago' )
			];
		}

		if ( 'rejected' === $alert_status ) {
			return [
				'img_src' => esc_url( plugins_url( '../../assets/images/generics/circle-red-alert.png', plugin_dir_path( __FILE__ ) ) ),
				'alert_title' => __( 'Payment refused', 'woocommerce-mercadopago' ),
				'alert_description' => $alert_description,
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
