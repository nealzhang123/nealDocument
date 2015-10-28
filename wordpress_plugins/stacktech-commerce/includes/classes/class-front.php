<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Commerce_Front {

	public static function init() {
		add_filter( 'query_vars', array( __CLASS__, 'add_query_vars_filter' ) );
		add_filter( 'template_include', array( __CLASS__, 'template_include' ) );
	}

	public static function add_query_vars_filter( $vars ) {
		$vars[] = 'stacktech-store';

		return $vars;
	}

	public static function template_include($template) {
		if($path = get_query_var('stacktech-store')) {
			$arr = explode('_', $path);
			if(count($arr) != 2){
				exit;
			}
			$path = $arr[0];
			$gateway = $arr[1];
			if ( 'pay-notify' == $path ) {
				Stacktech_Commerce_Payment::pay_notify($gateway);
			} else if ( 'pay-return' == $path ) {
				Stacktech_Commerce_Payment::pay_return($gateway);
			}
			exit;
		}
		return $template;
	}

}
