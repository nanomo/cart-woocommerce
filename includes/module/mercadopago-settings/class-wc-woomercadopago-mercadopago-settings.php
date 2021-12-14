<?php

class WC_WooMercadoPago_MercadoPago_Settings {

	const PRIORITY_ON_MENU = 90;

	protected $options;

	public function __construct( WC_WooMercadoPago_Options $options ){
		$this->options = $options;
	}

	/**
	 * Action to insert Mercado Pago in WooCommerce Menu and Load JavaScript and CSS
	 */
	public function init() {
		$this->load_menu();
		$this->load_scripts_and_styles();
		$this->register_endpoints();
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
			$this->get_url( '../../../assets/css/mercadopago-settings/mercadopago_settings', '.css' ),
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
			$this->get_url( '../../../assets/js/mercadopago-settings/mercadopago_settings', '.js' ),
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
			'mercadopago-settings',
			array( $this, 'mercadopago_submenu_page_callback' )
		);
	}

	/**
	 * Mercado Pago Template Call
	 */
	public function mercadopago_submenu_page_callback() {
		$categories_store       = WC_WooMercadoPago_Module::$categories;
		$category_selected = 'art';
		$category_id = $this->options->store_activity_identifier();
		$store_identificator = $this->options->store_name_on_invoice();
		$links = WC_WooMercadoPago_Helper_Links::woomercadopago_settings_links();
		include __DIR__ . '/../../../templates/mercadopago-settings/mercadopago-settings.php';
	}

	/**
	 * Register Mercado Pago Endpoints
	 */
	public function register_endpoints() {
		add_action( 'wp_ajax_mp_get_requirements' , array( $this, 'mercadopago_get_requirements' ));
	}

	/**
	 * Requirements
	 */
	public function mercadopago_get_requirements() {
		$hasCurl = in_array( 'curl', get_loaded_extensions(), true );
		$hasGD   = in_array( 'gd', get_loaded_extensions(), true );
		$hasSSL  = is_ssl();

		wp_send_json_success([
			'ssl' => $hasSSL,
			'gd_ext' => $hasGD,
			'curl_ext' => $hasCurl
		]);
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
