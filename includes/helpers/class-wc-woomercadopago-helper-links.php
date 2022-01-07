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
 * Class WC_WooMercadoPago_Helper_Links
 */
class WC_WooMercadoPago_Helper_Links {

	/**
	 * Links by country configured in woocommerce.
	 */
	public static function woomercadopago_settings_links() {
		$link_settings    = WC_WooMercadoPago_Module::define_link_country();
		$link_prefix_mp   = 'https://www.mercadopago.';
		$link_costs_mp    = 'costs-section';
		$link_developers  = 'developers/';
		$link_guides      = '/guides/plugins/woocommerce/integration';
		$link_credentials = 'panel/credentials';

		return array (

			'link_costs' => $link_prefix_mp . $link_settings ['sufix_url'] . $link_costs_mp,
			'link_guides_plugin' => $link_prefix_mp . $link_settings ['sufix_url'] . $link_developers . $link_settings ['translate'] . $link_guides,
			'link_credentials' => $link_prefix_mp . $link_settings ['sufix_url'] . $link_developers . $link_credentials,
		);
	}


	public static function get_mp_devsite_links() {
		$link          = WC_WooMercadoPago_Module::define_link_country();
		$base_link     = 'https://www.mercadopago.' . $link['sufix_url'] . 'developers/' . $link['translate'];
		$devsite_links = array(
			'dev_program'       => $base_link . '/developer-program',
			'notifications_ipn' => $base_link . '/guides/notifications/ipn',
			'shopping_testing'  => $base_link . '/guides/plugins/woocommerce/testing'
		);

		return $devsite_links;
	}
}
