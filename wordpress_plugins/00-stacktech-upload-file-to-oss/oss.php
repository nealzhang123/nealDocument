<?php
/*
Plugin Name: 00 Stacktech Upload file to oss
Plugin URI: http://www.stacktech.cn
Description: copy file to oss 
Version: 1.0
Author: Stacktech
Author URI: http://www.stacktech.cn
License: GPL
*/

if (is_file(WP_PLUGIN_DIR . '/00-stacktech-upload-file-to-oss/aliyun-oss-php-sdk-2.0.1/autoload.php')) {
    require_once WP_PLUGIN_DIR . '/00-stacktech-upload-file-to-oss/aliyun-oss-php-sdk-2.0.1/autoload.php';
}

if (is_file(WP_PLUGIN_DIR . '/00-stacktech-upload-file-to-oss/aliyun-oss-php-sdk-2.0.1/vendor/autoload.php')) {
    require_once WP_PLUGIN_DIR . '/00-stacktech-upload-file-to-oss/aliyun-oss-php-sdk-2.0.1/vendor/autoload.php';
}

require( WP_PLUGIN_DIR.'/00-stacktech-upload-file-to-oss/upload-file-to-oss.php' );
require( WP_PLUGIN_DIR.'/00-stacktech-upload-file-to-oss/image-url-store.php' );
new Media_To_Oss();
register_activation_hook( __FILE__, 'image_from_media_to_oss_install'); 
function image_from_media_to_oss_install(){
	$image_url = new oss_image_url_model();
 	$image_url->create_tables();
} 
