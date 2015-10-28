<?php
/**
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 */
class Stacktech_Commerce_Service {
	static $running = 1;
	static $stop = 0;
	static $expired = 2;
	static $unused = 10;

	public static function get_status_text ( $status, $product_type = 'plugin' ) {
		if ( $product_type == 'plugin' ) {
			if ( $status == self::$running ) {
				return '运行中';
			} else if ( $status == self::$stop ) {
				return '暂停';
			}
		} else {
			if ( $status == self::$running ) {
				return '已下载-已启动';
			} else if ( $status == self::$stop ) {
				return '已下载-已停止';
			}
		}
		return '已过期';
	}

	public static function is_permanent_service( $service_info ) {
		return $service_info['start_time'] == $service_info['end_time'];
	}

	public static function activate_service($service_id){
		$service = Stacktech_Commerce_Data::get_service($service_id);

		// 激活服务预留的钩子
		do_action( 'activate_service', $service );

		$blog_id = get_current_blog_id();
		switch_to_blog( $service['blog_id'] );
		// 获取该插件
		$plugin_name = get_global_post_meta( $service['product_id'], '_plugin_name', true );
		$plugin_type = get_global_post_meta( $service['product_id'], '_product_type', true );
		
		if ( $plugin_type == 'theme' ) {
			$allowed_themes = get_option( 'allowedthemes' );
			$allowed_themes[ $plugin_name ] = true;
			update_option( 'allowedthemes', $allowed_themes );
			$default_theme = get_option( 'default_blog_theme', false );
			if ( $default_theme === false ) {
				$t = wp_get_theme();
				add_option( 'default_blog_theme', strtolower($t->get_stylesheet()) );
			}

			// 这里我们注释了在服务面板切换主题的功能，
			// 如果我们在服务面板启用某一个主题，那么就把该主题添加进“外观》主题”列表里面
			// 如果停止某一个主题，那么就把该主题从外观里面删除
			/* 
			$result = self::activate_theme( $plugin_name );
			// 如果是主题则必须禁用其它主题服务
			// 插件你可以启用很多个，但是主题你只能启用一个
			$all_themes = Stacktech_Commerce_Data::get_theme_services($service['blog_id']);
			if($all_themes){
				foreach ($all_themes as $theme){
					if($theme['status'] == Stacktech_Commerce_Service::$running){
						Stacktech_Commerce_Data::update_service( array('status' => self::$stop), array('service_id' => $theme['service_id']));
					}
				}
			}
			 */
		} else {
			$result = self::activate_plugin( $plugin_name );
		}

		// 如果成功，更改服务状态
		Stacktech_Commerce_Data::update_service(array('status' => self::$running), array('service_id' => $service_id));

		restore_current_blog( $blog_id );
	}


	public static function unactivate_service($service_id){
		$service = Stacktech_Commerce_Data::get_service($service_id);

		// 激活服务预留的钩子
		do_action( 'deactivate_service', $service );

		$blog_id = get_current_blog_id();
		switch_to_blog( $service['blog_id'] );
		// 获取该插件
		$plugin_name = get_global_post_meta( $service['product_id'], '_plugin_name', true );
		$plugin_type = get_global_post_meta( $service['product_id'], '_product_type', true );

		if ( $plugin_type == 'theme' ) {
			$t = wp_get_theme();
			// 如果刚好停止的这个主题正在被使用，那么先切换到默认主题
			if ( strtolower($t->get_stylesheet()) == $plugin_name ) {
				$default_theme = get_option( 'default_blog_theme', false );
				if ( $default_theme === false ) {
					$default_theme = 'storefront';
				}
				$result = self::activate_theme( $default_theme );

			}

			$allowed_themes = get_option( 'allowedthemes' );
			unset($allowed_themes[ $plugin_name ]);
			update_option( 'allowedthemes', $allowed_themes );
			
		} else {
			$result = self::deactivate_plugins($plugin_name);
		}


		// 如果成功，更改服务状态
		Stacktech_Commerce_Data::update_service(array('status' => self::$stop), array('service_id' => $service_id));

		restore_current_blog( $blog_id );
	}

	public static function toggle_service(){
		$data = array();
		$status = $_POST['status'];
		$service_id = $_POST['service_id'];

		if($status == self::$running){
			// 取消激活
			self::unactivate_service($service_id);
			$data['message'] = '取消激活';
		}else{
			// 激活
			self::activate_service($service_id);
			$data['message'] = '成功激活';
		}

		echo json_encode( $data );
		exit;
	}

	// 1.如果运行中的服务已经过期则应该停止掉，如果该服务还有一个月过期，则应该通知用户
	public static function check_service() {
		//
		$services = Stacktech_Commerce_Data::get_services_only();
		foreach ( $services as $service ) {

			if ( $service['status'] != self::$running ) {
				continue;
			}
			if ( mysql2date( 'U', $service['end_time'] ) > current_time( 'timestamp' ) ) {
				continue;
			}
			self::unactivate_service( $service['service_id'] );
			self::set_service_expired( $service['service_id'] );
		}
	}

	public static function set_service_expired( $service_id ) {
		Stacktech_Commerce_Data::update_service(array('status' => self::$expired), array('service_id' => $service_id));
	}

	// 这里封装下默认的插件激活或禁用，主题激活
	public static function activate_plugin( $plugin_name ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$result = activate_plugin( WPMU_PLUGIN_DIR . '/'. $plugin_name );

		if ( is_wp_error( $result ) ) {
			stacktech_write_log( var_export( $result, true ) );
		}
		return $result;
	}

	public static function deactivate_plugins( $plugin_name ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$result = deactivate_plugins( WPMU_PLUGIN_DIR . '/'. $plugin_name );
		return $result;
	}

	// 不管是激活主题还是禁用主题都是调用这个函数
	public static function activate_theme( $theme_name ) {
		/*
		// 这里是在所有站点开放此主题
		$allowed_themes = get_site_option( 'allowedthemes' );
		$allowed_themes[ $theme_name ] = true;
		update_site_option( 'allowedthemes', $allowed_themes );
		 */
		include_once( ABSPATH . 'wp-includes/class-wp-theme.php' );
		include_once( ABSPATH . 'wp-includes/theme.php' );
		$theme = wp_get_theme( $theme_name );
		switch_theme( $theme->get_stylesheet() );
	}

	public static function close_service( $service_id ) {
		Stacktech_Commerce_Data::delete_service( $service_id );
	}

}
