<?php

function stacktech_get_user_money( $user_id ) {
	$user_money = get_user_meta( $user_id, 'user_money', true );
	$user_money = $user_money ? (float)$user_money : 0;

	return $user_money;
}

function get_global_post_meta( $post_id, $key, $single = true ) {
	global $wpdb;

	return $wpdb->get_var( $wpdb->prepare('SELECT pm.meta_value FROM '. $wpdb->base_prefix . 'posts as p, '. $wpdb->base_prefix .'postmeta as pm  WHERE pm.post_id = p.ID and pm.meta_key = %s and p.ID = %d', $key, $post_id) );
}

// 有些数据，比如产品信息是存在主站点的，那么在分站点的环境下
// 如何获取主站点的数据，我们不得不调用这个函数
function stacktech_call_global_func( $func_name ) {
	$current_blog_id = get_current_blog_id();
	switch_to_blog( BLOG_ID_CURRENT_SITE );

	$params = func_get_args();
	unset($params[0]);
	$result = call_user_func_array( $func_name, $params );

	restore_current_blog( $current_blog_id );

	return $result;
}

function stacktech_write_log($data) {
	$filename = STACKTECH_LOG_DIR . 'debug';
	file_put_contents( $filename, $data, FILE_APPEND);
}

function stacktech_get_price_decimal_separator() {
	return '.';
}

function stacktech_get_price_decimals() {
	return 2;
}

function stacktech_clean( $var ) {
	return sanitize_text_field( $var );
}

function stacktech_format_decimal( $number, $dp = false, $trim_zeros = false ) {
	$locale   = localeconv();
	$decimals = array( stacktech_get_price_decimal_separator(), $locale['decimal_point'], $locale['mon_decimal_point'] );

	// Remove locale from string
	if ( ! is_float( $number ) ) {
		$number = stacktech_clean( str_replace( $decimals, '.', $number ) );
	}

	if ( $dp !== false ) {
		$dp     = intval( $dp == "" ? stacktech_get_price_decimals() : $dp );
		$number = number_format( floatval( $number ), $dp, '.', '' );

	// DP is false - don't use number format, just return a string in our format
	} elseif ( is_float( $number ) ) {
		$number = stacktech_clean( str_replace( $decimals, '.', strval( $number ) ) );
	}

	if ( $trim_zeros && strstr( $number, '.' ) ) {
		$number = rtrim( rtrim( $number, '0' ), '.' );
	}

	return $number;
}

function stacktech_public_url($code) {
	$indexer = "";
	$permalinks = get_option( 'permalink_structure' );
	$pos = strpos($permalinks, "index.php");
	if ( $pos > 0 ) {
		$indexer = 'index.php';
	}
	if ( $permalinks ) {
		$link = home_url("{$indexer}/stacktech-store/".$code."/");
	} else {
		$link = home_url("?stacktech-store=" . $code);
	}

	return $link;
}


function stacktech_get_ip_address() {
	$server_ip_keys = array(
		'HTTP_CLIENT_IP',
		'HTTP_X_FORWARDED_FOR',
		'HTTP_X_FORWARDED',
		'HTTP_X_CLUSTER_CLIENT_IP',
		'HTTP_FORWARDED_FOR',
		'HTTP_FORWARDED',
		'REMOTE_ADDR',
	);
	
	foreach ( $server_ip_keys as $key ) {
		if ( isset( $_SERVER[ $key ] ) ) {
			return $_SERVER[ $key ];
		}
	}
	
	// Fallback local ip.
	return '127.0.0.1';
}


