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
 * Class WC_WooMercadoPago_Hook_Pix
 */
class WC_WooMercadoPago_Hook_Pix extends WC_WooMercadoPago_Hook_Abstract {

	/**
	 * Load Hooks
	 */
	public function load_hooks() {
		parent::load_hooks();
		if ( ! empty( $this->payment->settings['enabled'] ) && 'yes' === $this->payment->settings['enabled'] ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'add_checkout_scripts_pix' ) );
			add_action( 'woocommerce_after_checkout_form', array( $this, 'add_mp_settings_script_pix' ) );
			add_action( 'woocommerce_thankyou_' . $this->payment->id, array( $this, 'update_mp_settings_script_pix' ) );
		}
	}

	/**
	 *  Add Discount
	 */
	public function add_discount() {
		// @todo need fix Processing form data without nonce verification
		// @codingStandardsIgnoreLine
		if ( ! isset( $_POST['mercadopago_pix'] ) ) {
			return;
		}
		if ( is_admin() && ! defined( 'DOING_AJAX' ) || is_cart() ) {
			return;
		}
		// @todo need fix Processing form data without nonce verification
		// @codingStandardsIgnoreLine
		$pix_checkout = $_POST['mercadopago_pix'];
		parent::add_discount_abst( $pix_checkout );
	}

	/**
	 * Add Checkout Scripts
	 */
	public function add_checkout_scripts_pix() {
		if ( is_checkout() && $this->payment->is_available() && ! get_query_var( 'order-received' ) ) {

			wp_localize_script(
				'woocommerce-mercadopago-pix-checkout',
				'wc_mercadopago_pix_params',
				array(
					'site_id'             => $this->payment->get_option_mp( '_site_id_v1' ),
					'discount_action_url' => $this->payment->discount_action_url,
					'payer_email'         => esc_js( $this->payment->logged_user_email ),
					'apply'               => __( 'Apply', 'woocommerce-mercadopago' ),
					'remove'              => __( 'Remove', 'woocommerce-mercadopago' ),
					'coupon_empty'        => __( 'Please, inform your coupon code', 'woocommerce-mercadopago' ),
					'choose'              => __( 'To choose', 'woocommerce-mercadopago' ),
					'other_bank'          => __( 'Other bank', 'woocommerce-mercadopago' ),
					'discount_info1'      => __( 'You will save', 'woocommerce-mercadopago' ),
					'discount_info2'      => __( 'with discount of', 'woocommerce-mercadopago' ),
					'discount_info3'      => __( 'Total of your purchase:', 'woocommerce-mercadopago' ),
					'discount_info4'      => __( 'Total of your purchase with discount:', 'woocommerce-mercadopago' ),
					'discount_info5'      => __( '*After payment approval', 'woocommerce-mercadopago' ),
					'discount_info6'      => __( 'Terms and conditions of use', 'woocommerce-mercadopago' ),
					'loading'             => plugins_url( '../../assets/images/', plugin_dir_path( __FILE__ ) ) . 'loading.gif',
					'check'               => plugins_url( '../../assets/images/', plugin_dir_path( __FILE__ ) ) . 'check.png',
					'error'               => plugins_url( '../../assets/images/', plugin_dir_path( __FILE__ ) ) . 'error.png',
				)
			);
		}
	}

	/**
	 * MP Settings Ticket
	 */
	public function add_mp_settings_script_pix() {
		parent::add_mp_settings_script();
	}

	/**
	 * Update settings script pix
	 *
	 * @param string $order_id Order Id.
	 */
	public function update_mp_settings_script_pix( $order_id ) {
		parent::update_mp_settings_script( $order_id );
		$order               = wc_get_order( $order_id );
		$transaction_details = ( method_exists( $order, 'get_meta' ) ) ? $order->get_meta( '_transaction_details_pix' ) : get_post_meta( $order->get_id(), '_transaction_details_pix', true );

		if ( empty( $transaction_details ) ) {
			return;
		}

		$parameters = array(
			'img_pix' => plugins_url( '../../assets/images/img-pix.png', plugin_dir_path( __FILE__ ) ),
			'qr_code' => 'data:image/jpeg;base64,qr_code_base64',
		);

		wc_get_template(
			'order-received/show-pix.php',
			$parameters,
			'woo/mercado/pago/module/',
			WC_WooMercadoPago_Module::get_templates_path()
		);

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_style(
			'woocommerce-mercadopago-pix-checkout',
			plugins_url( '../../assets/css/basic_checkout_mercadopago' . $suffix . '.css', plugin_dir_path( __FILE__ ) ),
			array(),
			WC_WooMercadoPago_Constants::VERSION
		);
	}
}
