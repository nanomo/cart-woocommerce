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

class WC_WooMercadoPago_PreferenceAnalytics {
	public static $ignoreFields = array( '_mp_public_key_prod', '_mp_public_key_test', 'title', 'description', '_mp_access_token_prod', '_mp_access_token_test' );

	public function getBasicSettings() {
		return $this->getSettings( 'woocommerce_woo-mercado-pago-basic_settings' );
	}
	public function getCustomSettings() {
		return $this->getSettings( 'woocommerce_woo-mercado-pago-custom_settings' );
	}
	public function getTicketSettings() {
		return $this->getSettings( 'woocommerce_woo-mercado-pago-ticket_settings' );
	}

	public function getSettings( $option ) {

		$db_options = get_option( $option, array() );

		$validValues = array();
		foreach ( $db_options as $key => $value ) {
			if ( ! empty( $value ) && ! in_array( $key, self::$ignoreFields ) ) {
				$validValues[ $key ] = $value;
			}
		}
		return $validValues;
	}
}
