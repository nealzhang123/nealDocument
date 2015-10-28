<?php
/**
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Commerce_Payment_Gateways {

	public $payment_gateways;

	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Initialize payment gateways.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Load gateways and hook in functions.
	 */
	public function init() {
		$load_gateways = array(
			'Stacktech_Commerce_Gateway_Alipay',
			'Stacktech_Commerce_Gateway_Wechatpay',
		);

		// Filter
		$load_gateways = apply_filters( 'sc_payment_gateways', $load_gateways );

		// Load gateways in order
		foreach ( $load_gateways as $gateway ) {
			$load_gateway = is_string( $gateway ) ? new $gateway() : $gateway;

			$this->payment_gateways[] = $load_gateway;
		}
	}

	public function payment_gateways() {
		$_available_gateways = array();

		if ( sizeof( $this->payment_gateways ) > 0 ) {
			foreach ( $this->payment_gateways as $gateway ) {
				$_available_gateways[ $gateway->id ] = $gateway;
			}
		}

		return $_available_gateways;
	}

	public function get_gateway( $id ) {
		$gateways = $this->payment_gateways();

		return $gateways[$id];
	}

}
