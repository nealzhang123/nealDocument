<?php

class Media_To_Oss {

	public $curl_url="curl --max-time 10 http://www.etongapp.com/wp-content/plugins/00-stacktech-upload-file-to-oss/upload-delete.php";

	public function __construct() {

		add_action( 'add_attachment',               		array( $this, 'stacktech_upload_attachment' ) );
		add_filter( 'image_make_intermediate_size', 		array( $this, 'stacktech_upload_intermediate_sizes' ) );
		add_action( 'edit_attachment',            			array( $this, 'stacktech_upload_attachment' ) );
		add_filter( 'wp_delete_file',						array( $this, 'stacktech_delete_intermediate_sizes' ) );
		add_filter( 'wp_generate_attachment_metadata',		array( $this, 'stacktech_add_image') );
		//add_action( 'after_delete_post',							array( $this, 'stacktech_delete_image') );
		//add_action( 'delete_attachment',            		array( $this, 'stacktech_delete_attachment' ) );
		// add_action('wp_ajax_stacktech_imginfo_deal',		array($this,  'stacktech_imginfo_deal'));
		// add_action('wp_ajax_nopriv_stacktech_imginfo_deal', array($this,  'stacktech_imginfo_deal'));

	}

	public function stacktech_delete_image( $post_id){
		$url = $this->curl_url . '?action=delete > /dev/null & ';
		exec($url);
		return $post_id;
	}
	public function stacktech_add_image( $image_sizes ){
		$url = $this->curl_url . '?action=add > /dev/null & ';
		error_log($url);
		exec($url);
		return $image_sizes;
	}
	public function stacktech_upload_attachment( $post_id) {
		$file_dir	= get_attached_file( $post_id ); 
		global $wpdb;
		$wpdb->insert(
			$wpdb->get_blog_prefix(1).'oss_image_upload_url',
			array(
				'upload_date'		=>	current_time( 'mysql' ),
				'image_url'			=>	$file_dir
			),
			array(
				'%s',
				'%s'
			)
		);
		// $url ='curl '.WP_PLUGIN_URL.'/00-stacktech-upload-file-to-oss/upload-delete.php?action=add > /dev/null & ';
		// exec($url);
		return $post_id;
	}

	public function stacktech_upload_intermediate_sizes($file_path) {
		global $wpdb;
		$wpdb->insert(
			$wpdb->get_blog_prefix(1).'oss_image_upload_url',
			array(
				'upload_date'		=>	current_time( 'mysql' ),
				'image_url'			=>	$file_path
			),
			array(
				'%s',
				'%s'
			)
		);
		// $url ='curl '.WP_PLUGIN_URL.'/00-stacktech-upload-file-to-oss/upload-delete.php?action=add > /dev/null & ';
		// exec($url);
		return $file_path;
	}


	public function stacktech_delete_attachment( $post_id) {
		$file_dir	= get_attached_file( $post_id ); 
		global $wpdb;
		$wpdb->insert(
			$wpdb->get_blog_prefix(1).'oss_image_delete_url',
			array(
				'delete_date'		=>	current_time( 'mysql' ),
				'image_url'			=>	$file_dir
			),
			array(
				'%s',
				'%s'
			)
		);
		$url = $this->curl_url . '?action=delete > /dev/null & ';
		exec($url);
		return $post_id;
	}


	public function stacktech_delete_intermediate_sizes($file_path) {
		global $wpdb;
		$wpdb->insert(
			$wpdb->get_blog_prefix(1).'oss_image_delete_url',
			array(
				'delete_date'		=>	current_time( 'mysql' ),
				'image_url'			=>	$file_path
			),
			array(
				'%s',
				'%s'
			)
		);
		$url = $this->curl_url . '?action=delete > /dev/null & ';
		//exec($url);
		return $file_path;
	}

}

