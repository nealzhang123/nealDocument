<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 注册类型
 */
class Stacktech_Commerce_Admin_Post_types {
	public static function init() {
		add_action( 'restrict_manage_posts', array( $this, 'restrict_manage_posts' ) );
	}

	/**
	 * 过滤内容类型
	 */
	public function restrict_manage_posts() {
		global $typenow, $wp_query;

	}
}
