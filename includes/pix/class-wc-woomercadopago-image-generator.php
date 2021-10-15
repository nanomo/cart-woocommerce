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
 * Class WC_WooMercadoPago_Image_Generator
 */
class WC_WooMercadoPago_Image_Generator{
 
	/**
	 * Static Instance
	 */
	public static $instance = null;
  
	/**
	 * WC_WooMercadoPago_Notification_Abstrac constructor.
	 */
	public function __construct() {
    
		add_action( 'woocommerce_api_wc_mp_pix_image', array($this, 'get_image_qr'));
    
	}
 
	/**
	 * Get qr code image
	 */
	public function get_image_qr( ){
    
    echo "testing endpoint";

  }  

  public static function get_access_data(){
    
    $post = $_GET['id'];
    $order = wc_get_order($post);
    $payment_method                = $order->get_payment_method();
		$is_mercadopago_payment_method = in_array($payment_method, WC_WooMercadoPago_Constants::GATEWAYS_IDS, true);
		$payment_ids                   = explode(',', $order->get_meta( '_Mercado_Pago_Payment_IDs' ));

    
		if ( ! $is_mercadopago_payment_method || empty($payment_ids) ) {
			return;
		}
    
		$is_production_mode = $order->get_meta( 'is_production_mode' );
		$access_token       = 'no' === $is_production_mode || ! $is_production_mode
			? get_option( '_mp_access_token_test' )
			: get_option( '_mp_access_token_prod' );
    
    $data = array(
			'payment_id'     => $payment_ids,
			'access_token' => $access_token,
		);
    
    return $data;
	}
  
	/**
	 * Init Mercado Pago Image Generator Class
	 *
	 * @return WC_WooMercadoPago_Image_Generator|null
	 * Singleton
	 */
	public static function init_image_generator_class() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
    }
}
