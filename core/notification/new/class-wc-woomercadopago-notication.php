<?php

class Notification {
    public function __construct()
    {
        add_action( 'woocommerce_api_new_notification', array( $this, 'check_ipn_response' ) );
		// @todo remove when 5 is the most used.
		add_action( 'woocommerce_api_new_notification_gateway', array( $this, 'check_ipn_response' ) );
        add_action( 'valid_mercadopago_ipn_request', array( $this, 'successful_request' ) );
		add_action( 'woocommerce_order_status_cancelled', array( $this, 'process_cancel_order_meta_box_actions' ), 10, 1 );
    }
}