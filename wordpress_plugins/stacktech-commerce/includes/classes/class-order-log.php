<?php
/**
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 */
class Stacktech_Commerce_Order_Log {

	public static function load_order_logs() {
		$order_id = $_GET['order_id'];

		$logs = Stacktech_Commerce_Data::get_order_logs( $order_id );
		foreach ($logs as $key => $val) {
			$user_info = stacktech_call_global_func( 'get_userdata', $val['user_id'] );
			$logs[$key]['username'] = $user_info->user_login;
		}
		echo json_encode( $logs );
		exit;
	}

	public static function add_order_log( $order_id, $action = '', $blog_id = 0, $user_id = 0 ){
		$info = array();

		$info['user_id'] = get_current_user_id();
		$info['order_id'] = $order_id;
		$info['site_id'] = SITE_ID_CURRENT_SITE;
		$info['blog_id'] = get_current_blog_id();
		$info['action_time'] = current_time( 'mysql' );
		$info['action'] = $action;

		Stacktech_Commerce_Data::add_order_log( $info );
	}
}

