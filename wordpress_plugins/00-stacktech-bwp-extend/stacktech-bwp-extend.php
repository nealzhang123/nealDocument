<?php
/*
Plugin Name: 00 stacktech bwp extend
Plugin URI: http://www.etongapp.com
Description: extend for bwp minify
Version: 1.0
Author: Stacktech
Author URI: http://www.etongapp.com
License: GPL
*/

function stack_bwp_minify_extend(){

	if( !is_super_admin() )
		@remove_menu_page('bwp_minify_general');

	if( substr($_GET['page'], 0 , 10 ) == 'bwp_minify' && !is_super_admin() )
		header('Location:' . admin_url() );
	
}

add_action( 'admin_init', 'stack_bwp_minify_extend' );

function stack_bwp_init_option($string, $original_string){

	$bwp_minify_advanced_blog = get_option('bwp_minify_advanced');
	
	if( 'yes' == $bwp_minify_advanced_blog['enable_cdn'] && (!empty($bwp_minify_advanced_blog['input_cdn_host']) || !empty($bwp_minify_advanced_blog['input_cdn_host_js']) || empty($bwp_minify_advanced_blog['input_cdn_host_css']) ) )
		return $string;

	switch_to_blog( BLOG_ID_CURRENT_SITE );
	$bwp_minify_advanced_site = get_option('bwp_minify_advanced');
	restore_current_blog();

	$ext = preg_match('/\.([^\.]+)$/ui', $original_string, $matches)
			? $matches[1] : '';

	if (empty($ext))
		return $string;

	$cdn_host = $bwp_minify_advanced_site['input_cdn_host'];

	// use file-type specific CDN host if needed
	$js_cdn = !empty($bwp_minify_advanced_site['input_cdn_host_js'])
		? $bwp_minify_advanced_site['input_cdn_host_js']
		: $cdn_host;
	$css_cdn = !empty($bwp_minify_advanced_site['input_cdn_host_css'])
		? $bwp_minify_advanced_site['input_cdn_host_css']
		: $cdn_host;

	$cdn_host = ('js' == $ext) ? $js_cdn : $css_cdn;

	if (empty($cdn_host))
		return $string;

	// force SSL when WordPress is on SSL, or use scheme-less URL
	$ssl_type = $bwp_minify_advanced_site['select_cdn_ssl_type'];

	$scheme = is_ssl() ? 'https://' : 'http://';
	$scheme = 'less' == $ssl_type ? '//' : $scheme;
	$scheme = 'off' == $ssl_type ? 'http://' : $scheme;

	$string = preg_replace('#https?://[^/]+#ui',
		$scheme . $cdn_host,
		$string
	);

	return $string;
}

add_action( 'bwp_minify_get_src' , 'stack_bwp_init_option',12,2);