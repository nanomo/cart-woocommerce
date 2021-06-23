<?php
/**
 * Class SampleTest
 *
 * @package Sample_Plugin
 */

/**
 * Sample test case.
 */
class WC_WooMercadoPago_ConfigsTest extends WP_UnitTestCase {

	/**
	 * get_country_configs.
	 */
	function test_get_country_configs() {
		$country_configs = WC_WooMercadoPago_Configs::get_country_configs();

		$urlSrc = str_replace(
			'/tests',
			'',
			plugins_url( '../../assets/images/minilogo.png', plugin_dir_path( __FILE__ ) )
		);

		$country_configs_mock = array(
			'MCO' => array(
				'site_id'                => 'MCO',
				'sponsor_id'             => 208687643,
				'checkout_banner'        => plugins_url( '../../assets/images/MCO/standard_mco.jpg', __FILE__ ),
				'checkout_banner_custom' => plugins_url( '../../assets/images/MCO/credit_card.png', __FILE__ ),
				'currency'               => 'COP',
				'zip_code'               => '110111',
				'currency_symbol'        => '$',
			),
			'MLA' => array(
				'site_id'                => 'MLA',
				'sponsor_id'             => 208682286,
				'checkout_banner'        => plugins_url( '../../assets/images/MLA/standard_mla.jpg', __FILE__ ),
				'checkout_banner_custom' => plugins_url( '../../assets/images/MLA/credit_card.png', __FILE__ ),
				'currency'               => 'ARS',
				'zip_code'               => '3039',
				'currency_symbol'        => '$',
			),
			'MLB' => array(
				'site_id'                => 'MLB',
				'sponsor_id'             => 208686191,
				'checkout_banner'        => plugins_url( '../../assets/images/MLB/standard_mlb.jpg', __FILE__ ),
				'checkout_banner_custom' => plugins_url( '../../assets/images/MLB/credit_card.png', __FILE__ ),
				'currency'               => 'BRL',
				'zip_code'               => '01310924',
				'currency_symbol'        => 'R$',
			),
			'MLC' => array(
				'site_id'                => 'MLC',
				'sponsor_id'             => 208690789,
				'checkout_banner'        => plugins_url( '../../assets/images/MLC/standard_mlc.gif', __FILE__ ),
				'checkout_banner_custom' => plugins_url( '../../assets/images/MLC/credit_card.png', __FILE__ ),
				'currency'               => 'CLP',
				'zip_code'               => '7591538',
				'currency_symbol'        => '$',
			),
			'MLM' => array(
				'site_id'                => 'MLM',
				'sponsor_id'             => 208692380,
				'checkout_banner'        => plugins_url( '../../assets/images/MLM/standard_mlm.jpg', __FILE__ ),
				'checkout_banner_custom' => plugins_url( '../../assets/images/MLM/credit_card.png', __FILE__ ),
				'currency'               => 'MXN',
				'zip_code'               => '11250',
				'currency_symbol'        => '$',
			),
			'MLU' => array(
				'site_id'                => 'MLU',
				'sponsor_id'             => 243692679,
				'checkout_banner'        => plugins_url( '../../assets/images/MLU/standard_mlu.png', __FILE__ ),
				'checkout_banner_custom' => plugins_url( '../../assets/images/MLU/credit_card.png', __FILE__ ),
				'currency'               => 'UYU',
				'zip_code'               => '11800',
				'currency_symbol'        => '$',
			),
			'MLV' => array(
				'site_id'                => 'MLV',
				'sponsor_id'             => 208692735,
				'checkout_banner'        => plugins_url( '../../assets/images/MLV/standard_mlv.jpg', __FILE__ ),
				'checkout_banner_custom' => plugins_url( '../../assets/images/MLV/credit_card.png', __FILE__ ),
				'currency'               => 'VEF',
				'zip_code'               => '1160',
				'currency_symbol'        => '$',
			),
			'MPE' => array(
				'site_id'                => 'MPE',
				'sponsor_id'             => 216998692,
				'checkout_banner'        => plugins_url( '../../assets/images/MPE/standard_mpe.png', __FILE__ ),
				'checkout_banner_custom' => plugins_url( '../../assets/images/MPE/credit_card.png', __FILE__ ),
				'currency'               => 'PEN',
				'zip_code'               => '15074',
				'currency_symbol'        => '$',
			),
		);

		$this->assertEqualSets( $country_configs_mock , $country_configs );
	}
}
