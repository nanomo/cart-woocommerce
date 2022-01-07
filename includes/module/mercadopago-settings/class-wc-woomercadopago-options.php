<?php

class WC_WooMercadoPago_Options {

	const CREDENTIALS_PUBLIC_KEY_PROD   = '_mp_public_key_prod';
	const CREDENTIALS_PUBLIC_KEY_TEST   = '_mp_public_key_test';
	const CREDENTIALS_ACCESS_TOKEN_PROD = '_mp_access_token_prod';
	const CREDENTIALS_ACCESS_TOKEN_TEST = '_mp_access_token_test';
	const CHECKOUT_COUNTRY              = 'checkout_country';

	private $credentials_public_key_prod;
	private $credentials_public_key_test;
	private $credentials_access_token_prod;
	private $credentials_access_token_test;

	public function __construct() {

		$this->credentials_public_key_prod   = get_option( self::CREDENTIALS_PUBLIC_KEY_PROD, '' );
		$this->credentials_public_key_test   = get_option( self::CREDENTIALS_PUBLIC_KEY_TEST, '' );
		$this->credentials_access_token_prod = get_option( self::CREDENTIALS_ACCESS_TOKEN_PROD, '' );
		$this->credentials_access_token_test = get_option( self::CREDENTIALS_ACCESS_TOKEN_TEST, '' );
		$this->register_endpoints_options();
	}

	/**
	 * Register Mercado Pago Endpoints options
	 */
	public function register_endpoints_options() {
		add_action( 'wp_ajax_mp_update_option_credentials', array( $this, 'mp_update_option_credentials' ) );
	}

	/**
	 * Get Access token and Public Key
	 *
	 * @return mixed|array
	 */
	public function get_access_token_and_public_key() {

		return array(
			'credentials_public_key_prod'   => $this->credentials_public_key_prod,
			'credentials_public_key_test'   => $this->credentials_public_key_test,
			'credentials_access_token_prod' => $this->credentials_access_token_prod,
			'credentials_access_token_test' => $this->credentials_access_token_test,
		);

	}

	/**
	 * Block 3
	 */
	public function get_store_activity_identifier() {
		$store_identificator = get_option( '_mp_store_identificator', 'WC-' );

		return $store_identificator;
	}

	public function get_store_name_on_invoice() {
		$store_identificator = get_option( 'mp_statement_descriptor', 'Mercado Pago' );

		return $store_identificator;
	}

	public function get_store_category() {
		$category_store = get_option( '_mp_category_id', 'other' );

		return $category_store;
	}

	public function get_integrator_id() {
		$integrator_id = get_option( '_mp_integrator_id', '' );

		return $integrator_id;
	}

	public function get_debug_mode() {
		$debug_mode = get_option( '_mp_debug_mode', 'no' );

		return $debug_mode;
	}

	public function get_url_ipn() {
		$url_ipn = get_option( '_mp_custom_domain', '' );

		return $url_ipn;
	}

	public function get_mp_devsite_links() {
		$link          = WC_WooMercadoPago_Module::define_link_country();
		$base_link     = 'https://www.mercadopago.' . $link['sufix_url'] . 'developers/' . $link['translate'];
		$devsite_links = array(
			'dev_program'       => $base_link . '/developer-program',
			'notifications_ipn' => $base_link . '/guides/notifications/ipn',
			'shopping_testing'  => $base_link . '/guides/plugins/woocommerce/testing'
		);

		return $devsite_links;
	}

	/**
	 * Block 4
	 */
	public function get_checkbox_test_mode() {
		$checkbox_test_mode = get_option( 'checkbox_checkout_test_mode', 'yes' );

		return $checkbox_test_mode;
	}

	/**
	 *  Update option Credentials
	 */
	public function mp_update_option_credentials() {
		try {

			$public_key_test   = WC_WooMercadoPago_Credentials::get_sanitize_text_from_post( 'public_key_test' );
			$access_token_test = WC_WooMercadoPago_Credentials::get_sanitize_text_from_post( 'access_token_test' );
			$public_key_prod   = WC_WooMercadoPago_Credentials::get_sanitize_text_from_post( 'public_key_prod' );
			$access_token_prod = WC_WooMercadoPago_Credentials::get_sanitize_text_from_post( 'access_token_prod' );

			$mp = WC_WooMercadoPago_Module::get_mp_instance_singleton();

			$validate_public_key_test   = $mp->get_credentials_wrapper( null, $public_key_test );
			$validate_access_token_test = $mp->get_credentials_wrapper( $access_token_test );
			$validate_public_key_prod   = $mp->get_credentials_wrapper( null, $public_key_prod );
			$validate_access_token_prod = $mp->get_credentials_wrapper( $access_token_prod );
			$me                         = $mp->get_me( $access_token_prod );

			if ( $validate_public_key_test && $validate_access_token_test && $validate_public_key_prod && $validate_access_token_prod ) {
				if ( true === $validate_public_key_test['is_test'] && true === $validate_access_token_test['is_test'] && false === $validate_public_key_prod['is_test'] && false === $validate_access_token_prod['is_test'] ) {
					update_option( self::CREDENTIALS_PUBLIC_KEY_TEST, $public_key_test, true );
					update_option( self::CREDENTIALS_ACCESS_TOKEN_TEST, $access_token_test, true );
					update_option( self::CREDENTIALS_PUBLIC_KEY_PROD, $public_key_prod, true );
					update_option( self::CREDENTIALS_ACCESS_TOKEN_PROD, $access_token_prod, true );
					update_option( self::CHECKOUT_COUNTRY, $me['site_id'], true );

					wp_send_json_success( __( 'Credentials were updated', 'woocommerce-mercadopago' ) );
				}
			}

			throw new Exception( __( 'Update failed, invalid Credentials', 'woocommerce-mercadopago' ) );

		} catch ( Exception $e ) {

			$response = $e->getMessage();

			wp_send_json_error( $response );
		}
	}

}
