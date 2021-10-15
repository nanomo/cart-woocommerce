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
