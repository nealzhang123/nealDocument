<?php
/**
 * 安装相关函数和钩子
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 */
class Stacktech_Commerce_Install {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'add_rewrite_rule' ) );
		register_activation_hook( STACKTECH_COMMERCE_PLUGIN_FILE, array( __CLASS__, 'install' ) );
	}

	public static function add_rewrite_rule() {
		// 重写前台url
		$indexer = "";
		$permalinks = get_option( 'permalink_structure' );
		if ( $permalinks ) {
			$pos = strpos( $permalinks, "index.php" );
			if ( $pos > 0 ) {
				$indexer = "index.php/";
			}
		}
		add_rewrite_rule(
			"^{$indexer}stacktech-store/([^/]+)/?",
			'index.php?stacktech-store=$matches[1]',
			"top"
		);
	}

	public static function install() {

		// 只在stacktechmu里面修行数据库修改
		$blog_id = get_current_blog_id();
		switch_to_blog( BLOG_ID_CURRENT_SITE );

		self::create_tables();

		restore_current_blog( $blog_id );

		self::add_rewrite_rule();

		Stacktech_Commerce_Post_types::register_post_types();
		flush_rewrite_rules();
	}

	public static function create_tables() {
		global $wpdb;

		$wpdb->hide_errors();

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( self::get_schema() );
	}

	public static function get_schema() {
		global $wpdb;

		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}

		return "
CREATE TABLE {$wpdb->prefix}stacktech_order (
  order_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  site_id bigint(20) NOT NULL,
  blog_id bigint(20) NOT NULL,
  user_id bigint(20) NOT NULL,
  order_type varchar(50) NOT NULL,
  order_no varchar(100) NOT NULL,
  order_status tinyint(1) NOT NULL,
  create_time datetime NOT NULL,
  pay_time datetime NULL,
  total_price varchar(50) NOT NULL,
  PRIMARY KEY  (order_id)
) $collate;
CREATE TABLE {$wpdb->prefix}stacktech_order_product (
  order_product_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  author_id bigint(20) NOT NULL,
  order_id bigint(20) NOT NULL,
  product_id bigint(20) NOT NULL,
  period int(10) NOT NULL,
  price varchar(50) NOT NULL,
  total varchar(50) NOT NULL,
  price_condition_key varchar(100) NULL,
  PRIMARY KEY  (order_product_id)
) $collate;
CREATE TABLE {$wpdb->prefix}stacktech_service (
  service_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  site_id bigint(20) NOT NULL,
  blog_id bigint(20) NOT NULL,
  start_time datetime NOT NULL,
  end_time datetime NOT NULL,
  product_id bigint(20) NOT NULL,
  status tinyint(1) NOT NULL,
  last_order_id bigint(20) NOT NULL,
  PRIMARY KEY  (service_id)
) $collate;
CREATE TABLE {$wpdb->prefix}stacktech_service_log (
	log_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	site_id bigint(20) NOT NULL,
	blog_id bigint(20) NOT NULL,
	user_id bigint(20) NOT NULL,
	service_id bigint(20) NOT NULL,
	ip varchar(55) NOT NULL DEFAULT '127.0.0.1',
	action_time datetime NOT NULL,
	action varchar(255) NOT NULL,
	note TEXT,
	PRIMARY KEY (log_id)
) $collate;
CREATE TABLE {$wpdb->prefix}stacktech_account_log (
	log_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	site_id bigint(20) NOT NULL,
	blog_id bigint(20) NOT NULL,
	user_id bigint(20) NOT NULL,
	user_money bigint(20) NOT NULL,
	action_time datetime NOT NULL,
	action varchar(255) NOT NULL,
	action_type tinyint(1) NOT NULL,
	PRIMARY KEY (log_id)
) $collate;
CREATE TABLE {$wpdb->prefix}stacktech_order_log (
	log_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	site_id bigint(20) NOT NULL,
	blog_id bigint(20) NOT NULL,
	user_id bigint(20) NOT NULL,
	order_id bigint(20) NOT NULL,
	action_time datetime NOT NULL,
	action varchar(255) NOT NULL,
	PRIMARY KEY (log_id)
) $collate;
           ";
	}
}
