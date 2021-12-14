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

class WC_WooMercadoPago_Options {

	const CREDENTIALS_PUBLIC_KEY_PROD = '_mp_public_key_prod';
	const CREDENTIALS_PUBLIC_KEY_TEST = '_mp_public_key_test';
	const CREDENTIALS_ACCESS_TOKEN_PROD = '_mp_access_token_prod';
	const CREDENTIALS_ACCESS_TOKEN_TEST = '_mp_access_token_test';

	private $credentials_public_key_prod;
	private $credentials_public_key_test;
	private $credentials_access_token_prod;
	private $credentials_access_token_test;

	public function __construct() {

		$this->credentials_public_key_prod = get_option( self::CREDENTIALS_PUBLIC_KEY_PROD, '' );
		$this->credentials_public_key_test = get_option( self::CREDENTIALS_PUBLIC_KEY_TEST, '' );
		$this->credentials_access_token_prod = get_option( self::CREDENTIALS_ACCESS_TOKEN_PROD, '' );
		$this->credentials_access_token_test = get_option( self::CREDENTIALS_ACCESS_TOKEN_TEST, '' );
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

}
