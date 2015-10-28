<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Commerce_Admin_View_Manage extends Stacktech_Commerce_View {

    public static function output() {
		//订单记录
		$services = Stacktech_Commerce_Data::get_services( get_current_blog_id() );
		//$allowed_themes = get_option( 'allowedthemes' );

		//$t = wp_get_theme();
		// 抓取所有默认的主题
		$allowed_themes = wp_get_themes( array( 'allowed' => true ) );


		$purchased_themes = array();
		foreach ( $services as $key=>$service ){
			$services[$key]['product_type'] = get_global_post_meta( $service['product_id'], '_product_type', true );
			if ( $services[$key]['product_type'] == 'theme' ) {
				$theme_name = get_global_post_meta( $service['product_id'], '_plugin_name', true );
				$purchased_themes[] = $theme_name;
			}
		}

		foreach( $allowed_themes as $key => $theme ) {
			if ( in_array( $key, $purchased_themes) ){
				unset($allowed_themes[$key]);
			}
		}

		//启用的服务
		include STACKTECH_COMMERCE_TEMPLATE_PATH . 'html-admin-manage.php';
    }
}


