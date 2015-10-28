<?php
/**
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 */
class Stacktech_Commerce_Payment {

	public static function pay($gateway) {

		$gateway_helper = Stacktech_Commerce_Payment_Gateways::instance();
		$gateway = $gateway_helper->get_gateway( $gateway );
		$gateway->send_request();

		exit;
	}

	public static function pay_return($gateway) {

		stacktech_write_log(var_export($_GET, true));

		$_POST = $_GET;
		$res = self::pay_notify($gateway);
		if($res) {

		}else{
		}
		header("Location:" . get_admin_url(null, 'admin.php?page=stacktech-store-manage'));
	}

	public static function pay_notify($gateway) {
		$gateway_helper = Stacktech_Commerce_Payment_Gateways::instance();

		$gateway = $gateway_helper->get_gateway( $gateway );
		$gateway->handle_response();
	}
}
