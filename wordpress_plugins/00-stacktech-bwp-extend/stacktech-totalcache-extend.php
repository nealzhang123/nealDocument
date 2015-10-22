<?php
/*
Plugin Name: 00 stacktech totalcache extend
Plugin URI: http://www.etongapp.com
Description: extend for supercache cdn
Version: 1.0
Author: Stacktech
Author URI: http://www.etongapp.com
License: GPL
*/

function stack_totalcache_extend(){
	if( defined( 'WP_NETWORK_ADMIN' ) && WP_NETWORK_ADMIN ){
		$is_network = true;
	}else{
		$is_network = false;
	}
	if( !is_super_admin() || !$is_network )
		@remove_menu_page('w3tc_dashboard');

	if( substr($_GET['page'], 0 , 5 ) == 'w3tc_' && !is_super_admin() )
		header('Location:' . admin_url() );

	if($_GET['action'] == 'remove_admin_minify' && is_super_admin() ){
		$folder = WP_CONTENT_DIR . '/cache/backend';
		$fp = opendir($folder);
		
	  	while ( $file = readdir($fp) ) {
	  		if( $file != "." && $file != ".." ){
	  			$fullpath = $folder . "/" . $file;
		  		unlink($fullpath);
	  		}
	    }
	    header('Location:' . admin_url() );
	}		
}

function stack_add_top_menu_item_totalcache(){
	global $wp_admin_bar;

    if( !is_super_admin() ){
    	$wp_admin_bar->remove_menu('w3tc');
    	/*$menu_item = array(
                    'id' => 'clear_cache',
                    'title' => __('clear_total_cache'),
                    'href' => wp_nonce_url(admin_url('admin.php?page=w3tc_dashboard&amp;w3tc_flush_all'), 'w3tc')
                );
   		$wp_admin_bar->add_menu($menu_item);*/
    }else{
    	$menu_item = array(
                        'id' => 'stack_remove_minify',
                        'parent' => 'w3tc',
                        'title' => __('remove_admin_minify'),
                        'href' => admin_url('admin.php?action=remove_admin_minify')
                    );
    	$wp_admin_bar->add_menu($menu_item);
    }
}

function stack_create_minify_js(){
	global $wp_scripts;

	$regist_script = $wp_scripts->registered;
	$site_url = get_site_url();
	$minify_src_arr = array();
	$cache_fold = WP_CONTENT_DIR . '/cache/backend/';
	if( !is_dir($cache_fold) ) 
		mkdir( $cache_fold, 0755, true );

	foreach ($regist_script as $key => $script_obj) {
		if( false !== strpos($script_obj->src, $site_url) ){
			$minify_src_arr[] = str_replace( $site_url, '', $script_obj->src ) ;
			unset($regist_script[$key]);
		}
	}
	$wp_scripts->registered = $regist_script;

	$i = 1;
	$content = '';
	$md5_src = '';

	foreach ($minify_src_arr as $src) {

		$md5_src .= trim( basename($src) );

		if( file_exists(ABSPATH . $src) ){
			$content .= file_get_contents(ABSPATH . $src);
		}

		if( 0 == $i%10 || $i == count($minify_src_arr) ){
			$cache_name = md5($md5_src);
			
			if( !file_exists( $cache_fold . $cache_name . '.js' ) ){
				$fp = fopen( $cache_fold . $cache_name . '.js', 'w+' );
				chmod( $cache_fold . $cache_name . '.js', 0777 );
				fwrite($fp, $content);
				fclose($fp);
			}
			
			wp_enqueue_script( $cache_name, '/wp-content/cache/backend/'.$cache_name.'.js' );
			$md5_src = '';
			$content = '';
		}
		
		$i++;
	}
	$wp_scripts->base_url = STACKTECH_CDN_URL;
}

function stack_create_minify_css(){
	global $wp_styles;

	$regist_style = $wp_styles->registered;
	$site_url = get_site_url();
	$minify_src_arr = array();
	$cache_fold = WP_CONTENT_DIR . '/cache/backend/';
	if( !is_dir($cache_fold) ) 
		mkdir( $cache_fold, 0755, true );

	foreach ($regist_style as $key => $style_obj) {
		if( false !== strpos($style_obj->src, $site_url) ){
			$minify_src_arr[] = str_replace( $site_url, '', $style_obj->src ) ;
			unset($regist_style[$key]);
		}
	}
	$wp_styles->registered = $regist_style;

	$i = 1;
	$content = '';
	$md5_src = '';

	foreach ($minify_src_arr as $src) {

		$md5_src .= trim( basename($src) );

		if( file_exists(ABSPATH . $src) ){
			$content .= file_get_contents(ABSPATH . $src);
		}

		if( 0 == $i%10 || $i == count($minify_src_arr) ){
			$cache_name = md5($md5_src);
			
			if( !file_exists( $cache_fold . $cache_name . '.css' ) ){
				$fp = fopen( $cache_fold . $cache_name . '.css', 'w+' );
				chmod( $cache_fold . $cache_name . '.css', 0777 );
				fwrite($fp, $content);
				fclose($fp);
			}
			wp_enqueue_style( $cache_name , '/wp-content/cache/backend/'.$cache_name.'.css' );
	
			$md5_src = '';
			$content = '';
		}

		$i++;
	}

	$wp_styles->base_url = STACKTECH_CDN_URL;
}

function stack_create_minify_foot_js(){
	global $wp_scripts;
	
	$regist_script = $wp_scripts->registered;
	$site_url = get_site_url();
	$minify_src_arr = array();
	$cache_fold = WP_CONTENT_DIR . '/cache/backend/';
	if( !is_dir($cache_fold) ) 
		mkdir( $cache_fold, 0755, true );

	foreach ($regist_script as $key => $script_obj) {
		if( false !== strpos( $script_obj->src, $site_url ) ){
			$src_name = explode( '.', basename($script_obj->src) );
			$src_name = $src_name[0];
			if( !in_array( $src_name, $wp_scripts->done ) ){
				$minify_src_arr[] = str_replace( $site_url, '', $script_obj->src ) ;
				unset($regist_script[$key]);
			}
		}
	}
	$wp_scripts->registered = $regist_script;

	$i = 1;
	$content = '';
	$md5_src = '';

	foreach ($minify_src_arr as $src) {

		$md5_src .= trim( basename($src) );

		if( file_exists(ABSPATH . $src) ){
			$content .= file_get_contents(ABSPATH . $src);
		}

		if( 0 == $i%10 || $i == count($minify_src_arr) ){

			$cache_name = md5($md5_src);
			
			if( !file_exists( $cache_fold . $cache_name . '.js' ) ){
				$fp = fopen( $cache_fold . $cache_name . '.js', 'w+' );
				chmod( $cache_fold . $cache_name . '.js', 0777 );
				fwrite($fp, $content);
				fclose($fp);
			}
			
			wp_enqueue_script( $cache_name, '/wp-content/cache/backend/'.$cache_name.'.js' );
			$md5_src = '';
			$content = '';
		}

		$i++;
	}

	$wp_scripts->base_url = STACKTECH_CDN_URL;
}


add_action( 'admin_init', 'stack_totalcache_extend' );
add_action( 'admin_bar_menu', 'stack_add_top_menu_item_totalcache' , 160 );

add_action( 'admin_print_scripts','stack_create_minify_js');
add_action( 'admin_print_styles','stack_create_minify_css');

add_action( 'admin_footer','stack_create_minify_foot_js',11 );
