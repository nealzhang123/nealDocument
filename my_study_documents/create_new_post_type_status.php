<?php
/*
Plugin Name: 00 stacktech verify userinfo
Plugin URI: http://www.etongapp.com
Description: stacktech verify user info
Version: 1.0
Author: Stacktech
Author URI: http://www.etongapp.com
License: GPL
*/
class StacktechVerifyUserInfo {
	static $post_type = 'verify_userinfo';

	public function init(){
		self::register_verify_post_type();
		self::register_verify_status();
	}

	public function admin_init(){
		global $current_user;

		
	}

	public function add_meta_boxes(){
		add_meta_box( 'verify-custom-data', __( '自定义参数' ), 'StacktechVerifyUserInfo::edit_verify_html', 'verify_userinfo', 'normal', 'high' );
	}

	public function remove_bar_menu(){
		global $current_user,$menu;
		$current_user_roles = $current_user->roles;
		$is_developer = ( in_array('developer', $current_user_roles) ) ? 1 : 0 ;
		if($is_developer){
			if( count($menu) > 0 )
				remove_menu_page('edit.php?post_type=verify_userinfo');
		}
	}

	public static function edit_verify_html(){
		$url_for_agree = 'http://www.baidu.com';
		$verify_style = 1;

		include_once('verify_userinfo_template.php');
		
	}

	public static function register_verify_post_type(){
		register_post_type( self::$post_type,
			array(
				'labels' => array(
					'name' => __( 'Developer Platform' ),
					'menu_name'=> __( 'Developer Platform' ),
					'singular_name' => __( 'Developer Platform' ),
					'all_items' => __( 'All Verify' ),
					'add_new' => __( 'Add Verify' ),
					'add_new_item' => __( 'Add New Verify' ),
					'edit' => __( 'Edit' ),
					'edit_item' => __( 'Edit Verify' ),
					'new_item' => __( 'New Verify' ),
					'view' => __( 'View Verify' ),
					'view_item' => __( 'View Verify' ),
					'search_items' => __( 'Search Verify' ),
					'not_found' => __( 'No Verify found' ),
					'not_found_in_trash' => __( 'No Verify found in Trash' ),
				),
				'public' => true,
				'exclude_from_search' => false,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'capability_type' => 'verify',
				//'taxonomies' => array('category'),
				//'menu_position' => 60,
				'query_var' => true,
				'supports' => false,
				//'rewrite' => array('slug' => self::$post_type),
				'can_export' => false,
			)
		);

		

	}

	public function register_verify_status(){
		register_post_status( 'unread', array(
	        'label'                     => __( '打钱中' ),
	        'public'                    => true,
	        'exclude_from_search'       => false,
	        'show_in_admin_all_list'    => true,
	        'show_in_admin_status_list' => true,
	        'label_count'               => _n_noop( 'Unread <span class="count">(%s)</span>', 'Unread <span class="count">(%s)</span>' ),
	    ) );
	}

	public function my_post_submitbox_misc_actions(){

		global $post;

		//only when editing a post
		if( $post->post_type == 'verify_userinfo' ){

		    // custom post status: approved
		    $complete = '';
		    $label = '';   

		    if( $post->post_status == 'unread' ){
		        $complete = ' selected=\"selected\"';
		        $label = '<span id=\"post-status-display\">'.__( '打钱中' ).'</span>';
		    }

		    echo '<script>
		    jQuery(document).ready(function($){
		        $("select#post_status").append("<option value=\"unread\" '.$complete.'>'.__( '打钱中' ).'</option>");
		        $(".misc-pub-section label").append("'.$label.'");
		    });
		    </script>';

		}
	}
}

add_action( 'init', array('StacktechVerifyUserInfo' ,'init') );
//add_action( 'admin_init', array('StacktechVerifyUserInfo' ,'admin_init') );

add_action( 'post_submitbox_misc_actions', array('StacktechVerifyUserInfo' ,'my_post_submitbox_misc_actions') );
add_action( 'add_meta_boxes', array( 'StacktechVerifyUserInfo', 'add_meta_boxes' ), 30 );
add_action( 'admin_init' , array( 'StacktechVerifyUserInfo', 'remove_bar_menu' ) );