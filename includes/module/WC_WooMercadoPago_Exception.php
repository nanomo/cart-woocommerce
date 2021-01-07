<?php
/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 * @package MercadoPago
 * @category Includes
 * @author Mercado Pago
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WC_WooMercadoPago_Exception
 */
class WC_WooMercadoPago_Exception extends Exception {

	/**
	 * WC_WooMercadoPago_Exception constructor.
	 *
	 * @param $message
	 * @param int            $code
	 * @param Exception|null $previous
	 */
	public function __construct( $message, $code = 500, Exception $previous = null ) {
		parent::__construct( $message, $code, $previous );
	}
}
