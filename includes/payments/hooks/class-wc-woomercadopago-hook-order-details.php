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


	/**
	 * WC_WooMercadoPago_Hook_Order_Details instance
	 *
	 * @var WC_WooMercadoPago_Hook_Order_Details|null
	 */
	public static $instance = null;

	public function __construct() {
		$this->load_hooks();
		$this->load_scripts();
	}

	/**
	 * Singleton of self class
	 *
	 * @return WC_WooMercadoPago_Hook_Order_Details|null
	 */
	public static function init_hook_order_details() {
		if ( is_null(self::$instance) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Load Hooks
	 *
	 * @return void
	 */
	public function load_hooks() {
		add_action( 'add_meta_boxes', array( $this, 'payment_status_metabox' ));
	}

	/**
	 * Load Scripts
	 *
	 * @return void
	 */
	public function load_scripts() {
		// TODO: Deixar isso em um script
		echo '<script>window.addEventListener("load", () => document.querySelector("#payment-status-metabox").after(document.querySelector("#woocommerce-order-items")))</script>';
	}

	/**
	 * Create payment status metabox
	 *
	 * @return void
	 */
	public function payment_status_metabox( $screen_name ) {
		function payment_status_metabox_content() {
			wc_get_template(
				'order/payment-status-metabox-content.php',
				[],
				'woo/mercado/pago/module/',
				WC_WooMercadoPago_Module::get_templates_path()
			);
		}

		add_meta_box(
			'payment-status-metabox',
			'Status Mercado Pago', // TODO: Colocar traduções
			'payment_status_metabox_content',
			$screen_name
		);
	}
}
