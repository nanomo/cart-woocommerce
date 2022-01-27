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
 * Class WC_WooMercadoPago_Helper_Current_Url
 */
class WC_WooMercadoPago_Helper_Current_Url {

    public static function get_current_page() {
		// @codingStandardsIgnoreLine
		$current_page = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';

        return $current_page;
    }

    public static function get_current_section() {
		// @codingStandardsIgnoreLine
		$current_section = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : '';

        return $current_section;
    }

    public static function validate_page( $expected_page, $current_page = null, $allow_partial_match = false ) {
        if ( ! $current_page ) {
            $current_page = WC_WooMercadoPago_Helper_Current_Url::get_current_page();
        }

        return WC_WooMercadoPago_Helper_Current_Url::compare_strings( $expected_page, $current_page );
    }

    public static function validate_session( $expected_section, $current_section = null, $allow_partial_match = true ) {
        if ( ! $expected_section ) {
            $current_section = WC_WooMercadoPago_Helper_Current_Url::get_current_section();
        }

        return WC_WooMercadoPago_Helper_Current_Url::compare_strings( $expected_section, $current_section );
    }

    public static function compare_strings( $expected, $current, $allow_partial_match ) {
        if ( $allow_partial_match ) {
            return strpos($expected, $current) !== false;
        }
        
        return $expected === $current;
    }

}
