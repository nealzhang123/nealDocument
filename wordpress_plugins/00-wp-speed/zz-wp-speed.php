<?php
/*
Plugin Name: 00 WP Speed
Plugin URI: http://www.etongapp.com
Description: Speed Up Backend Admin
Version: 1.0
Author: Stacktech
Author URI: http://www.etongapp.com
License: GPL
*/



function stacktech_remove_open_sans() {
	wp_deregister_style( 'open-sans' );
	wp_register_style( 'open-sans', false );
	wp_enqueue_style('open-sans','');
}

add_action( 'init', 'stacktech_remove_open_sans' );

function get_ssl_avatar($avatar) {
	$avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "cn.gravatar.com", $avatar);
	return $avatar;
}

add_filter('get_avatar', 'get_ssl_avatar');




function disable_plugin_request($a,$b,$c){
	if(isset($b['body']['plugins']) || isset($b['body']['themes']))
	return array('response'=>array('code'=>404));
}

add_filter("pre_http_request", 'disable_plugin_request',10,3);

