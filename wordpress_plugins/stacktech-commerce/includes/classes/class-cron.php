<?php
/**
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 */
class Stacktech_Commerce_Cron {

	public static function init() {
		add_action( 'wp_loaded', array( __CLASS__, 'auto_cron' ) );
	}

	public static function auto_cron() {
		if ( false !== strpos( $_SERVER['REQUEST_URI'], '/wp-cron.php' ) ) {
			if ( isset( $_GET['action'] ) && $_GET['action'] == 'check_service' ) {
				Stacktech_Commerce_Service::check_service();
				exit;
			}
		}

	}

}
