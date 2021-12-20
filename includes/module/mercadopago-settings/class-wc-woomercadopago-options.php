<?php

class WC_WooMercadoPago_Options {

	const CREDENTIALS_PUBLIC_KEY_PROD   = '_mp_public_key_prod';
	const CREDENTIALS_PUBLIC_KEY_TEST   = '_mp_public_key_test';
	const CREDENTIALS_ACCESS_TOKEN_PROD = '_mp_access_token_prod';
	const CREDENTIALS_ACCESS_TOKEN_TEST = '_mp_access_token_test';

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
			add_action( 'wp_ajax_update_option_credentials' , array( $this, 'update_option_credentials' ));
	}

	/**
	 * Get Access token and Public Key
	 *
	 * @return mixed|array
	 */
	public function get_access_token_and_public_key() {

		return array (
			'credentials_public_key_prod' => $this->credentials_public_key_prod,
			'credentials_public_key_test' => $this->credentials_public_key_test,
			'credentials_access_token_prod' => $this->credentials_access_token_prod,
			'credentials_access_token_test' => $this->credentials_access_token_test,
		);

	}
	public function store_name_on_invoice() {
		$store_identificator = get_option( '_mp_store_identificator', 'WC-' );

		return $store_identificator;
	}

	public function store_activity_identifier() {
		$store_identificator = get_option( '_mp_category_id', 'other' );

		return $store_identificator;
	}

	public function store_category() {
		$category_store = get_option( '_mp_category_id', 'other');
		return $category_store;
	}

	/**
	 *  Update option Credentials
	 */
	public function update_option_credentials() {
		try {

		$public_key_test   = WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('public_key_test');
		$access_token_test = WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('access_token_test');
		$public_key_prod   = WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('public_key_prod');
		$access_token_prod = WC_WooMercadoPago_Credentials::get_sanitize_text_from_post('access_token_prod');

		$mp = WC_WooMercadoPago_Module::get_mp_instance_singleton();

		$validate_public_key_test   = $mp->get_credentials_wrapper( null, $public_key_test);
		$validate_access_token_test = $mp->get_credentials_wrapper( $access_token_test );
		$validate_public_key_prod   = $mp->get_credentials_wrapper( null, $public_key_prod);
		$validate_access_token_prod = $mp->get_credentials_wrapper( $access_token_prod );

			if ( $validate_public_key_test && $validate_access_token_test && $validate_public_key_prod && $validate_access_token_prod ) {
				if ( true === $validate_public_key_test['is_test'] && true === $validate_access_token_test['is_test'] && false === $validate_public_key_prod['is_test'] && false === $validate_access_token_prod['is_test'] ) {
					update_option( self::CREDENTIALS_PUBLIC_KEY_TEST, $public_key_test, true );
					update_option( self::CREDENTIALS_ACCESS_TOKEN_TEST, $access_token_test, true );
					update_option( self::CREDENTIALS_PUBLIC_KEY_PROD, $public_key_prod, true );
					update_option( self::CREDENTIALS_ACCESS_TOKEN_PROD, $access_token_prod, true );
					wp_send_json_success( 'sucess');
				}
			}

			throw new Exception( 'error');

		} catch ( Exception $e ) {
			$response = [
				'message' => $e->getMessage()
			];

			wp_send_json_error( $response );
		}
	}
}
