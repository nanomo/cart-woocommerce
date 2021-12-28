<?php

class WC_WooMercadoPago_MercadoPago_Settings {


	const PRIORITY_ON_MENU = 90;

	protected $options;

	public function __construct( WC_WooMercadoPago_Options $options ) {
		$this->options = $options;
	}

	/**
	 * Action to insert Mercado Pago in WooCommerce Menu and Load JavaScript and CSS
	 */
	public function init() {
		$this->load_menu();
		$this->register_endpoints();
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
		$categories_store    = WC_WooMercadoPago_Module::$categories;
		$category_selected   = $this->options->get_store_category();
		$category_id         = $this->options->get_store_activity_identifier();
		$store_identificator = $this->options->get_store_name_on_invoice();
		$integrator_id       = $this->options->get_integrator_id();
		$devsite_links       = $this->options->get_mp_devsite_links();
		$debug_mode          = $this->options->get_debug_mode();
		$url_ipn             = $this->options->get_url_ipn();
		$links               = WC_WooMercadoPago_Helper_Links::woomercadopago_settings_links();
		$checkbox_test_mode  = $this->options->get_checkbox_test_mode();
		$options_credentials = $this->options->get_access_token_and_public_key();
		include __DIR__ . '/../../../templates/mercadopago-settings/mercadopago-settings.php';
	}

	/**
	 * Register Mercado Pago Endpoints
	 */
	public function register_endpoints() {
		add_action( 'wp_ajax_mp_get_requirements' , array( $this, 'mercadopago_get_requirements' ));
		add_action( 'wp_ajax_mp_validate_credentials', array($this, 'mp_validate_credentials'));
		add_action( 'wp_ajax_mp_validate_store_information', array($this, 'mp_validate_store_info'));
		add_action( 'wp_ajax_mp_store_mode', array($this, 'mp_set_mode'));
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
	 * Validate credentials Ajax
	 */
	public function mp_validate_credentials() {
		try {
			$access_token = WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('access_token');
			$public_key   = WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('public_key');
			$is_test      = ( WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('is_test') === 'true' );

			$mp = WC_WooMercadoPago_Module::get_mp_instance_singleton();

			if ( $access_token ) {
				$validate_access_token = $mp->get_credentials_wrapper( $access_token );
				if ( ! $validate_access_token || $validate_access_token['is_test'] !== $is_test ) {
					wp_send_json_error( 'error' );
				}
				wp_send_json_success( 'sucess');
			}

			if ( $public_key ) {
				$validate_public_key = $mp->get_credentials_wrapper( null, $public_key );
				if ( ! $validate_public_key || $validate_public_key['is_test'] !== $is_test ) {
					wp_send_json_error( 'error' );
				}

				wp_send_json_success( 'sucess');
			}

				throw new Exception( 'error');

		} catch ( Exception $e ) {
			$response = [
				'message' => $e->getMessage()
			];

			wp_send_json_error( $response );
		}
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

	/**
	 * Validate store info Ajax
	 */
	public function mp_validate_store_info() {
		try {
			$store_info = array(
				'mp_statement_descriptor'           => WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('store_identificator'),
				'_mp_category_id'   => WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('store_categories'),
				'_mp_store_identificator'       => WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('store_category_id'),
				'_mp_custom_domain'         => WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('store_url_ipn'),
				'_mp_integrator_id' => WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('store_integrator_id'),
				'_mp_debug_mode'        => WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('store_debug_mode'),
			);

			foreach ( $store_info as $key => $value ) {
				update_option( $key , $value, true );
			}

			wp_send_json_success( 'success' );

		} catch ( Exception $e ) {
			$response = [
				'message' => $e->getMessage()
			];

			wp_send_json_error( $response );
		}
	}

	/**
	 * Switch store mode
	 */
	public function mp_set_mode() {
		try {
			$checkout_test_mode = WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('input_mode_value');

			update_option( 'checkbox_checkout_test_mode' , $checkout_test_mode, true );

			wp_send_json_success( 'success' );

		} catch ( Exception $e ) {
			$response = [
				'message' => $e->getMessage()
			];

			wp_send_json_error( $response );
		}
	}

	/**
	 * Get payment class properties
	 */
	public function mp_get_payment_class_properties() {

			$payments_gateways          = WC_WooMercadoPago_Constants::PAYMENT_GATEWAYS;
			$payment_gateway_properties = array();
		foreach ( $payments_gateways as $payment_gateway ) {
			$gateway = new $payment_gateway();

			$payment_gateway_properties[] = array(

			'id'     => $gateway->id,
			'description'   => $gateway->description,
			'title'   => $gateway->title,
			'enabled' => $gateway->settings['enabled'],
			);
		}
			return $payment_gateway_properties;
	}
}
