<?php
/**
 * Plugin Name: 万锦新科APP平台
 * Plugin URI: http://stacktech.cn
 * Description: 史上最大的Web App平台
 * Version: 1.0
 * Author: 万锦新科
 * Author URI: http://stacktech.cn
 *
 * @package Stacktech
 * @category Core
 * @author 万锦新科
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Stacktech_Commerce {

	private $constant_prefix = 'STACKTECH_COMMERCE_';
	public $plugin_name = 'stacktech_commerce';
	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		// Include necessary libraries here
		include_once 'includes/functions/helper.php';

		$this->define_constants();
		$this->init();
	}

	public function autoload( $class ) {
		$class = strtolower( $class );
		$class = str_replace( $this->plugin_name . '_', '', $class );
		$file  = 'class-' . str_replace( '_', '-', $class ) . '.php';

		if( strpos( $file, '-view' ) != false ){
			$path = constant($this->constant_prefix . 'PLUGIN_PATH') . '/includes/classes/views/' . $file;
		}else{
			$path = constant($this->constant_prefix . 'PLUGIN_PATH') . '/includes/classes/' . $file;
		}

		if ( $path && is_readable( $path ) ) {
			include_once( $path );
			return true;
		}
		return false;
	}
	
	private function define_constants() {
		$upload_dir = stacktech_call_global_func( 'wp_upload_dir' );

		$this->define( $this->constant_prefix . "PLUGIN_FILE", __FILE__ );
		$this->define( $this->constant_prefix . "PLUGIN_BASENAME", plugin_basename( __FILE__ ) );
		$this->define( $this->constant_prefix . "PLUGIN_PATH", plugin_dir_path( __FILE__ ) );
		$this->define( $this->constant_prefix . "PLUGIN_URL", untrailingslashit( plugins_url( '/', __FILE__ ) ) );
		$this->define( $this->constant_prefix . "TEMPLATE_PATH", plugin_dir_path( __FILE__ ) . '/includes/templates/' );
		$this->define( $this->constant_prefix . "PLUGIN_BASENAME", plugin_basename( __FILE__ ) );
		$this->define( 'STACKTECH_LOG_DIR', $upload_dir['basedir'] . '/', true );
	}

	private function define( $name, $value ) {

		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Check which type the current request is, so we can load specific scripts
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	public function init() {
		if ( function_exists( "__autoload" ) ) {
			spl_autoload_register( "__autoload" );
		}
		spl_autoload_register( array( $this, 'autoload' ) );

        // Plugin activation hooks
        Stacktech_Commerce_Install::init();
        // Registe all of new post types in the plugin
        Stacktech_Commerce_Post_types::init();
		// Registe the hooks from other third-part plugins and global hooks that are called by any request
        Stacktech_Commerce_Hooks::init();

		if ( $this->is_request( 'admin' ) ) {
			Stacktech_Commerce_Admin_Menus::init();
			Stacktech_Commerce_Admin_Meta_Box::init();
			Stacktech_Commerce_Admin_Scripts::init();
			Stacktech_Commerce_Ajax::init();
		}

		if ( $this->is_request( 'ajax' ) ) {
		}

		if ( $this->is_request( 'frontend' ) ) {
			//  
			//Stacktech_Commerce_Rest::init();
			Stacktech_Commerce_Front::init();
		}

		if ( $this->is_request( 'cron' ) ) {
			Stacktech_Commerce_Cron::init();
		}
	}


	/**
	 * 获取ajax路径
	 */
	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}
}

function stacktech_commerce() {
	return Stacktech_Commerce::instance();
}

stacktech_commerce();
