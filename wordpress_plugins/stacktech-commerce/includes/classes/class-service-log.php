<?php
/**
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 */
class Stacktech_Commerce_Service_Log {

	public static function load_service_logs() {
		$service_id = $_GET['service_id'];
		if( isset($_GET['theme']) && $_GET['theme'] ) {
			$logs = Stacktech_Commerce_Data::get_service_logs_by_note(  'theme#' . $_GET['theme']  );
		}else {
			$logs = Stacktech_Commerce_Data::get_service_logs( $service_id );
		}
		foreach ( $logs as $key => $log ) {
			$user_info = get_userdata($log['user_id']);
			$logs[$key]['username'] = $user_info->user_login;
			$logs[$key]['content'] = self::generate_content_by_log( $log );
		}
		echo json_encode( $logs );
		exit;
	}

	public static function hooks_activate_service( $service ) {
		$log_info = self::get_common_info();
		$log_info['service_id'] = $service['service_id'];
		$log_info['action'] = 'activate';
		$log_info['site_id'] = $service['site_id'];
		$log_info['blog_id'] = $service['blog_id'];
		Stacktech_Commerce_Data::add_service_log( $log_info );
	}

	public static function hooks_deactivate_service( $service ) {
		$log_info = self::get_common_info();
		$log_info['service_id'] = $service['service_id'];
		$log_info['action'] = 'deactivate';
		$log_info['site_id'] = $service['site_id'];
		$log_info['blog_id'] = $service['blog_id'];
		Stacktech_Commerce_Data::add_service_log( $log_info );
	}


	public static function hooks_switch_theme( $new_name, WP_Theme $new_theme ) {
		// 首先我们得检查这个主题是否有此站点相应的service，如果没有，那么就是站点初始化自带的了，只有存note了
		$stylesheet = $new_theme->get_stylesheet();
		$product = Stacktech_Commerce_Data::get_product_by_plugin_name( $stylesheet );
		$all_services = Stacktech_Commerce_Data::get_services( get_current_blog_id() );
		$service_id = 0;
		foreach ( $all_services as $service ) {
			if ( $service['product_id'] == $product['ID'] ) {
				$service_id = $service['service_id'];
				break;
			}
		}
		$log_info = self::get_common_info();
		$log_info['service_id'] = $service_id;
		$log_info['action'] = 'switch';
		$log_info['site_id'] = SITE_ID_CURRENT_SITE;

		$log_info['blog_id'] = $service['blog_id'];

		if ( $service_id == 0 ){
			$log_info['note'] = 'theme#' . $stylesheet;
		}

		Stacktech_Commerce_Data::add_service_log( $log_info );
	}


	public static function get_common_info() {
		$log_info = array();
		$log_info['user_id'] = get_current_user_id();
		if ( $log_info['user_id'] == 0 ) {
			$order_info = Stacktech_Commerce_Data::get_order( $service['last_order_id'] );
			$log_info['user_id'] = $order_info['user_id'];
		}
		$log_info['ip'] = stacktech_get_ip_address();
		$log_info['action_time'] = current_time( 'mysql' );

		return $log_info;
	}

	// 根据日志生成相应的内容
	public static function generate_content_by_log( $log ){
		$text = array(
			'activate' => '启用',
			'deactivate' => '停用',
			'switch' => '切换主题',
		);
		return $text[$log['action']];
	}
}
