<?php

class WC_WooMercadoPago_Options {

	const CREDENTIALS_PUBLIC_KEY_PROD   = '_mp_public_key_prod';
	const CREDENTIALS_PUBLIC_KEY_TEST   = '_mp_public_key_test';
	const CREDENTIALS_ACCESS_TOKEN_PROD = '_mp_access_token_prod';
	const CREDENTIALS_ACCESS_TOKEN_TEST = '_mp_access_token_test';
	const CHECKOUT_COUNTRY              = 'checkout_country';
	const STORE_IDENTIFICATOR           = '_mp_store_identificator';
	const STORE_NAME                    = 'mp_statement_descriptor';
	const STORE_CATEGORY                = '_mp_category_id';
	const INTEGRATOR_ID               	= '_mp_integrator_id';
	const DEBUG_MODE               			= '_mp_debug_mode';
	const CUSTOM_DOMAIN                 = '_mp_custom_domain';
	const CHECKBOX_TEST_MODE            = 'checkbox_checkout_test_mode';


	private $credentials_public_key_prod;
	private $credentials_public_key_test;
	private $credentials_access_token_prod;
	private $credentials_access_token_test;
	private $checkout_country;
	private $store_identificator;
	private $store_name;
	private $store_category;
	private $integrator_id;
	private $debug_mode;
	private $custom_domain;
	private $checkbox_test_mode;


	public static $instance;


	public function __construct() {

		$this->credentials_public_key_prod   = get_option( self::CREDENTIALS_PUBLIC_KEY_PROD, '' );
		$this->credentials_public_key_test   = get_option( self::CREDENTIALS_PUBLIC_KEY_TEST, '' );
		$this->credentials_access_token_prod = get_option( self::CREDENTIALS_ACCESS_TOKEN_PROD, '' );
		$this->credentials_access_token_test = get_option( self::CREDENTIALS_ACCESS_TOKEN_TEST, '' );
		$this->checkout_country              = get_option( self::CHECKOUT_COUNTRY, '' );
		$this->store_identificator           = get_option( self::STORE_IDENTIFICATOR, 'WC-' );
		$this->store_name             			 = get_option( self::STORE_NAME, 'Mercado Pago' );
		$this->store_category                = get_option( self::STORE_CATEGORY, 'other' );
		$this->integrator_id                 = get_option( self::INTEGRATOR_ID, '' );
		$this->debug_mode                    = get_option( self::DEBUG_MODE, 'no' );
		$this->custom_domain                 = get_option( self::CUSTOM_DOMAIN, '' );
		$this->checkbox_test_mode            = get_option( self::CHECKBOX_TEST_MODE, 'yes' );

	}

	/**
	 *
	 * Init Options
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
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
	 *  Get option Store Identificator
	 */
	public function get_store_activity_identifier() {
		$store_identificator = get_option( '_mp_store_identificator', 'WC-' );

		return $store_identificator;
	}

	/**
	 *  Get option Store Name
	 */
	public function get_store_name_on_invoice() {
		$store_name = get_option( 'mp_statement_descriptor', 'Mercado Pago' );

		return $store_name;
	}

	/**
	 *  Get option Store Category
	 */
	public function get_store_category() {
		$category_store = get_option( '_mp_category_id', 'other' );

		return $category_store;
	}

	/**
	 *  Get option Integrator id
	 */
	public function get_integrator_id() {
		$integrator_id = get_option( '_mp_integrator_id', '' );

		return $integrator_id;
	}

	/**
	 *  Get option Debug Mode
	 */
	public function get_debug_mode() {
		$debug_mode = get_option( '_mp_debug_mode', 'no' );

		return $debug_mode;
	}

	/**
	 *  Get option Custom Domain
	 */
	public function get_custom_domain() {
		$custom_domain = get_option( '_mp_custom_domain', '' );

		return $custom_domain;
	}

	/**
	 *  Get option Checkbox Test Mode
	 */
	public function get_checkbox_test_mode() {
		$checkbox_test_mode = get_option( 'checkbox_checkout_test_mode', 'yes' );

		return $checkbox_test_mode;
	}
}
