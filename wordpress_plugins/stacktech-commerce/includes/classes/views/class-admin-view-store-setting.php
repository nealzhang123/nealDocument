<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Commerce_Admin_View_Store_Setting extends Stacktech_Commerce_View {

    public static function output() {
		if ( $_POST ){
			self::save_setting();
		}
		global $wpdb;

		$sc_enable_alipay_gateway = get_option( 'sc_enable_alipay_gateway', 1 );

		$sc_alipay_partner = get_option( 'sc_alipay_partner', '2088021328151993' );
		$sc_alipay_key = get_option( 'sc_alipay_key', '9ds434n9slzyu6lcfn7llhu813yd5lhj' );
		$sc_alipay_seller_email = get_option( 'sc_alipay_seller_email', 'ying@stacktech.cn' );

		include STACKTECH_COMMERCE_TEMPLATE_PATH . 'html-admin-store-setting.php';
    }

	public static function save_setting() {
		$sc_enable_alipay_gateway = isset( $_POST['sc_enable_alipay_gateway'] ) && $_POST['sc_enable_alipay_gateway'] ? 1 : 0;

		$sc_alipay_partner = sanitize_text_field( $_POST['sc_alipay_partner'] );
		$sc_alipay_key = sanitize_text_field( $_POST['sc_alipay_key'] );
		$sc_alipay_seller_email = sanitize_text_field( $_POST['sc_alipay_seller_email'] );

		// Check if these values are valid

		update_option( 'sc_enable_alipay_gateway',  $sc_enable_alipay_gateway);
		update_option( 'sc_alipay_partner',  $sc_alipay_partner);
		update_option( 'sc_alipay_key',  $sc_alipay_key);
		update_option( 'sc_alipay_seller_email',  $sc_alipay_seller_email);
	}

}


