<?php
/**
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 */
class Stacktech_Commerce_Account_Log {

	const ACT_PURCHASE = 0,// Purchase product
		ACT_SALE = 1; // Sale product

	static $action_names = array(
		0 => '购买产品',
		1 => '出售产品'
	);

	public static function load_account_logs() {
		$user_id = $_GET['user_id'];

		$logs = Stacktech_Commerce_Data::get_account_logs( $user_id );
		foreach($logs as $key => $val) {
			$logs[$key]['action_name'] = self::$action_names[$val['action_type']];
		}
		echo json_encode( $logs );
		exit;
	}

	public static function change_user_money( $user_id, $user_money, $action_type, $action = '' ){
		$user_money = (float) $user_money;
		$info = array();

		$info['user_id'] = $user_id;
		$info['site_id'] = SITE_ID_CURRENT_SITE;
		$info['blog_id'] = get_current_blog_id();
		$info['user_money'] = $user_money;
		$info['action_type'] = $action_type;
		$info['action_time'] = current_time( 'mysql' );
		$info['action'] = $action;

		Stacktech_Commerce_Data::add_account_log( $info );

		$user_money = stacktech_get_user_money( $user_id ) + $user_money;

		update_user_meta( $user_id, 'user_money', $user_money );
	}

	

}

