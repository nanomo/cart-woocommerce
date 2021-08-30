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
		add_action( 'admin_enqueue_scripts', array( $this, 'payment_status_metabox_script' ) );
	}

	/**
	 * Get sufix to static files
	 */
	public function get_suffix() {
		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
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
				[
					// TODO: Corrigir caminho do arquivo depois de mudar de pasta, pois pretendo tirar de payment
					'img_src' => esc_url( plugins_url( '../../assets/images/generics/circle-alert.png', plugin_dir_path( __FILE__ ) ) ),
					'alert_title' => 'Pagamento Pendente',
					'alert_description' => 'Descrição do pagamento pendente',
					'link' => 'https://www.mercadopago.com.br/home',
					'border_left_color' => '#f73',
					'link_description' => 'Ver detalhes da compra no Mercado Pago'
				],
				'woo/mercado/pago/module/',
				WC_WooMercadoPago_Module::get_templates_path()
			);
		}

		add_meta_box(
			'payment-status-metabox',
			'Status de pagamento no Mercado Pago', // TODO: Colocar traduções
			'payment_status_metabox_content',
			$screen_name
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
			'payment_status_metabox',
			plugins_url( '../../assets/js/payment_status_metabox' . $suffix . '.js', plugin_dir_path( __FILE__ ) ),
			array(),
			WC_WooMercadoPago_Constants::VERSION,
			false
		);
	}
}
