<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * All routes
 */
class Stacktech_Commerce_Rest {
	public static function init() {
		add_action( 'rest_api_init' , array( __CLASS__, 'add_route' ) );
	}

	public static function add_route() {
		include_once STACKTECH_COMMERCE_PLUGIN_PATH . 'endpoints/class-sc-rest-products.php';
		include_once STACKTECH_COMMERCE_PLUGIN_PATH . 'endpoints/class-sc-rest-orders.php';

		$sc_product = new 

//		register_rest_route(
//			'stacktech/v1',
//			'/products/',
//			array(
//				'methods' => 'GET',
//				'callback' => array(
//					Stacktech_Commerce_Product,
//					'search_products'
//				)
//			)
//		);
	}
}
