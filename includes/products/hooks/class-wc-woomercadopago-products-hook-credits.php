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
 * Class WC_WooMercadoPago_Products_Hook_Credits
 */
class WC_WooMercadoPago_Products_Hook_Credits {

	/**
	 * Site Id
	 *
	 * @var string
	 */
	public $site_id;

	/**
	 * Checkout Pro Enabled
	 *
	 * @var boolean
	 */
	public $checkout_pro_enabled;

	/**
	 * Checkout Pro Credits Banner Enabled
	 *
	 * @var boolean
	 */
	public $credits_banner;

	/**
	 * WC_WooMercadoPago_Products_Hook_Credits constructor.
	 *
	 */
	public function __construct() {
		if ( ! is_admin() ) {
			$checkout_pro_configs       = get_option( 'woocommerce_woo-mercado-pago-basic_settings', '' );
			$this->checkout_pro_enabled = 'no';
			$this->site_id              = strtolower(get_option( '_site_id_v1' ));

			if ( isset( $checkout_pro_configs['enabled'] ) ) {
				$this->checkout_pro_enabled = $checkout_pro_configs['enabled'];
				$this->credits_banner       = $checkout_pro_configs['credits_banner'];
			}

			$this->load_hooks();
		}
	}

	/**
	 * Get sufix to static files
	 */
	private function get_suffix() {
		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	}

	/**
	 * Load Hooks
	 */
	public function load_hooks() {
		add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'before_add_to_cart_form' ) );
	}

	public function before_add_to_cart_form() {
		global $woocommerce;
		$suffix = $this->get_suffix();

		wp_enqueue_script(
			'mp-credits-modal-js',
			plugins_url( '../../assets/js/credits/script' . $suffix . '.js', plugin_dir_path( __FILE__ ) ),
			array(),
			WC_WooMercadoPago_Constants::VERSION,
			false
		);

		wp_enqueue_script(
			'mercadopago_melidata',
			plugins_url( '../../assets/js/melidata/melidata-client' . $suffix . '.js', plugin_dir_path( __FILE__ ) ),
			array(),
			WC_WooMercadoPago_Constants::VERSION,
			true
		);

		wp_localize_script(
			'mercadopago_melidata',
			'wc_melidata_params',
			array(
				'type'             => 'buyer',
				'site_id'          => $this->site_id ? strtoupper( $this->site_id ) : 'MLA',
				'location'         => '/products',
				'payment_method'   => null,
				'plugin_version'   => WC_WooMercadoPago_Constants::VERSION,
				'platform_version' => $woocommerce->version,
			)
		);

		wp_enqueue_style(
			'mp-credits-modal-style',
			plugins_url( '../../assets/css/credits/modal' . $suffix . '.css', plugin_dir_path( __FILE__ ) ),
			array(),
			WC_WooMercadoPago_Constants::VERSION
		);

		wc_get_template(
			'credits/mp-credits-modal.php',
			array (
				'banner_title'   => __( 'Pague', 'woocommerce-mercadopago' ),
				'banner_title_bold' => __('parcelado sem cartão', 'woocommerce-mercadopago' ),
				'banner_title_end' => __('com Mercado Pago', 'woocommerce-mercadopago' ),
				'banner_link'    => __( 'Ler mais', 'woocommerce-mercadopago' ),
				'modal_title'    => __( 'Compre agora e pague parcelado sem cartão depois!', 'woocommerce-mercadopago' ),
				'modal_subtitle' => __( 'Pague as parcelas com', 'woocommerce-mercadopago' ),
				'modal_subtitle_bold_pixbol' => __('Pix, boleto', 'woocommerce-mercadopago'),
				'modal_subtitle_or' => __('ou', 'woocommerce-mercadopago'),
				'modal_subtitle_bold_accmoney' => __('saldo da conta Mercado Pago', 'woocommerce-mercadopago'),
				'modal_subtitle_end' => __(', 100% online e sem custos extras.', 'woocommerce-mercadopago'),
				'modal_how_to'   => __( 'Como usar!', 'woocommerce-mercadopago' ),
				'modal_step_1'   => __( 'No pagamento, escolha', 'woocommerce-mercadopago' ),
				'modal_step_1_bold' => __('Mercado Pago', 'woocommerce-mercadopago' ),
				'modal_step_1_end'  => __('. Entre na sua conta ou crie uma em poucos passos.', 'woocommerce-mercadopago'),
				'modal_step_2'   => __( 'Procure por', 'woocommerce-mercadopago' ),
				'modal_step_2_bold' => __('Mercado Crédito', 'woocommerce-mercadopago' ),
				'modal_step_2_end' => __('entre as opções, selecione e defina em quantas vezes quer pagar.', 'woocommerce-mercadopago'),
				'modal_step_3'   => __( 'Pague as parcelas todo mês como preferir, no app do Mercado Pago.', 'woocommerce-mercadopago' ),
				'modal_footer'   => __( 'Dúvidas? ', 'woocommerce-mercadopago' ),
				'modal_footer_help_link' => __('https://www.mercadopago.com.br/ajuda/19040', 'woocommerce-mercadopago'),
				'modal_footer_link' => __('Consulte nossa FAQ', 'woocommerce-mercadopago'),
				'modal_footer_end' => __('. Crédito sujeito a aprovação.', 'woocommerce-mercadopago')
			),
			'',
			WC_WooMercadoPago_Module::get_templates_path()
		);
	}

}
