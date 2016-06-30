<?php


require_once($_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/wp-load.php');
require( 'deal-image-in-sql.php' );
global $wpdb;


$image_deal = new Image_From_Sql_To_Oss();
$action = $_REQUEST['action'];
$wpdb->query("SET SQL_SAFE_UPDATES = 0");
if( $action == 'add' ){
	$file = $wpdb->get_results("SELECT * FROM {$wpdb->get_blog_prefix(1)}oss_image_upload_url WHERE status = 0");
	if( $file ){
		foreach( $file as $val ){
			$wpdb->update( 
					$wpdb->get_blog_prefix(1).'oss_image_upload_url',
					array(
						'status'	=> 1
					),
					array(
						'ID'		=>$val->ID
					)
				);
		}
	}	
}

if( $action == 'delete' ){
	$file = $wpdb->get_results("SELECT * FROM {$wpdb->get_blog_prefix(1)}oss_image_delete_url WHERE status = 0");
	if( $file ){
		foreach( $file as $val ){
			$wpdb->update( 
					$wpdb->get_blog_prefix(1).'oss_image_delete_url',
					array(
						'status'	=> 1
					),
					array(
						'ID'		=>$val->ID
					)
				);
		}
	}
}

if( $file ){
	foreach( $file as $value){

		if( $action == 'add'){
			$rseult = $image_deal->uploadimagetooss($value->image_url);
			if( $rseult){
				$wpdb->update( 
					$wpdb->get_blog_prefix(1).'oss_image_upload_url',
					array(
						'status'	=> 2
					),
					array(
						'ID'		=>$value->ID
					)
				);
			}else{
				$wpdb->update( 
					$wpdb->get_blog_prefix(1).'oss_image_upload_url',
					array(
						'status'	=> 0
					),
					array(
						'ID'		=>$value->ID
					)
				);
			}
			// $wpdb->query($wpdb->prepare("DELETE FROM {$table_prefix_oss}image_upload_url WHERE image_url = %s",$value->image_url));

		}

		if( $action == 'delete'){
			$res = $image_deal->deleteimagefromoss($value->image_url);
			if( $res ){
				$wpdb->update( 
					$wpdb->get_blog_prefix(1).'oss_image_delete_url',
					array(
						'status'	=> 2
					),
					array(
						'ID'		=>$value->ID
					)
				);
			}else{
				$wpdb->update( 
					$wpdb->get_blog_prefix(1).'oss_image_delete_url',
					array(
						'status'	=> 0
					),
					array(
						'ID'		=>$value->ID
					)
				);
			}
			// $wpdb->query($wpdb->prepare("DELETE FROM {$table_prefix_oss}image_delete_url WHERE image_url = %s",$value->image_url));
		}

	}
	
}
$wpdb->query("SET SQL_SAFE_UPDATES = 1");

