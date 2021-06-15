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
 * Class WC_WooMercadoPago_Log
 */
class Log {

	/**
	 * Log
	 *
	 * @var Log
	 */
	public $log;

	/**
	 * Name
	 *
	 * @var Log::$name
	 */
	public $name;

	/**
	 * Log constructor.
	 *
	 * @param null $name .
	 */
	public function __construct( $name ) {
		if ( ! empty( $name ) ) {
			$this->name = $name;
		} else {
			$this->name = 'Logger-MercadoPago';
		}
		return $this->init_log();
	}

	/**
	 * Init_log function
	 *
	 * @return WC_Logger|null
	 */
	public function init_log() {
		if ( class_exists( 'WC_Logger' ) ) {
			$this->log = new WC_Logger();
		} else {
			$this->log = WC_WooMercadoPago_Module::woocommerce_instance()->logger();
		}
		return $this->log;
	}

	/**
	 * Init_mercado_pago_log function
	 *
	 * @param null $name .
	 * @return WC_WooMercadoPago_Log|null
	 */
	public static function init_mercado_pago_log( $name = null ) {
		$log = new self( null, true );
		if ( ! empty( $log ) && ! empty( $name ) ) {
			$log->set_name( $name );
		}
		return $log;
	}

	/**
	 * Write_log function
	 *
	 * @param [type] $function .
	 * @param [type] $message .
	 * @return void
	 */
	public function write_log( $function, $message ) {
		$this->log->add( $this->name, '[' . $function . ']: ' . $message );
	}

	/**
	 * Set_name function
	 *
	 * @param [type] $name .
	 * @return void
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}
}
