<?php

class WC_WooMercadoPago_Options {

	public function store_name_on_invoice( ) {
		$store_identificator = get_option( '_mp_store_identificator', 'WC-' );

		return $store_identificator;
	}

	public function store_activity_identifier( ) {
		$store_identificator = get_option( '_mp_category_id', 'other' );

		return $store_identificator;
	}

	public function store_category( ) {
		$category_store = get_option( '_mp_category_id', 'other'); 
		return $category_store;
	}
}
