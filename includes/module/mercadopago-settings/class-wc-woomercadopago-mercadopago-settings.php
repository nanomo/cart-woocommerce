<?php

class WC_WooMercadoPago_MercadoPago_Settings {

	const PRIORITY_ON_MENU = 90;

	/**
	 * Action to insert Mercado Pago in WooCommerce Menu and Load JavaScript and CSS
	 */
	public function init() {
		$this->load_menu();
		$this->load_scripts_and_styles();
	}

	/**
	 * Load menu
	 */
	public function load_menu() {
		add_action( 'admin_menu', array( $this, 'register_mercadopago_in_woocommerce_menu' ), self::PRIORITY_ON_MENU );
	}

	/**
	 * Load Scripts
	 *
	 * @return void
	 */
	public function load_scripts_and_styles() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_style' ) );
	}

	/**
	 * Load CSS
	 */
	public function load_admin_style() {
		wp_register_style(
			'mercadopago_settings_admin_css',
			$this->get_url( '../../../assets/css/mercadopago-settings/base', '.css' ),
			false,
			WC_WooMercadoPago_Constants::VERSION
		);
		wp_enqueue_style( 'mercadopago_settings_admin_css' );
	}

	/**
	 * Load JavaScripts
	 */
	public function load_admin_scripts() {
		wp_enqueue_script(
			'mercadopago_settings_javascript',
			$this->get_url( '../../../assets/js/mercadopago-settings/base', '.js' ),
			array(),
			WC_WooMercadoPago_Constants::VERSION,
			true
		);
	}

	/**
	 * Register Mercado Pago Option in WooCommerce Menu
	 */
	public function register_mercadopago_in_woocommerce_menu() {
		add_submenu_page(
			'woocommerce',
			__( 'Mercado Pago Settings', 'woocommerce-mercadopago' ),
			'Mercado Pago',
			'manage_options',
			'my-custom-submenu-page',
			array( $this, 'mercadopago_submenu_page_callback' )
		);
	}

	/**
	 * Mercado Pago Template Call
	 */
	public function mercadopago_submenu_page_callback() {
		include __DIR__ . '/../../../templates/mercadopago/admin-mercadopago.php';
	}

	/**
	 * Get URL with path
	 *
	 * @param $path
	 * @param $extension
	 *
	 * @return string
	 */
	public function get_url( $path, $extension ) {
		return sprintf(
			'%s%s%s%s',
			plugin_dir_url( __FILE__ ),
			$path,
			$this->get_suffix(),
			$extension
		);
	}

	/**
	 * Get suffix to static files
	 *
	 * @return string
	 */
	public function get_suffix() {
		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	}
}
