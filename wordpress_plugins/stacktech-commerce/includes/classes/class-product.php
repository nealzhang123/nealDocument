<?php
/**
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 */
class Stacktech_Commerce_Product {

	static $sold_month = 0;
	static $sold_forever = 1;
	static $sold_free = 2;

	static $is_package = 1;
	static $is_single_product = 0;


	public static function get_product() {



		$product = stacktech_call_global_func( 'get_post', $_GET['id'] );
		$feature_image = '';
		if (stacktech_call_global_func( 'has_post_thumbnail', $product->ID ) ) {
			$feature_image = stacktech_call_global_func( 'wp_get_attachment_image_src', stacktech_call_global_func( 'get_post_thumbnail_id', $product->ID ), 'single-post-thumbnail' );
			$feature_image = $feature_image[0];
		}

		$blog_id = get_current_blog_id();
		$allow_trail = get_global_post_meta( $product->ID, '_allow_trail', true );
		$trail_days = get_global_post_meta( $product->ID, '_trail_days', true );
		$price = get_global_post_meta( $product->ID, '_sale_price', true );

		$product_sale_type = get_global_post_meta( $product->ID, '_product_sale_type', true );

		$allow_purchase_forever = get_global_post_meta( $product->ID, '_allow_purchase_forever', true );
		$allow_discount_price = get_global_post_meta( $product->ID, '_allow_discount_price', true );
		$sale_discount_price = get_global_post_meta( $product->ID, '_sale_discount_price', true );
		$discount_start_date = get_global_post_meta( $product->ID, '_discount_start_date', true );
		$product_type = get_global_post_meta( $product->ID, '_product_type', true );
		$discount_end_date = get_global_post_meta( $product->ID, '_discount_end_date', true );
		$month_discount = get_global_post_meta( $product->ID, '_month_discount', true );
		if($month_discount){$month_discount = json_decode($month_discount, true);};
		$price_condition = get_global_post_meta( $product->ID, '_price_condition', true );
		if($price_condition){$price_condition = json_decode($price_condition, true);};

		$images = get_global_post_meta( $product->ID, '_product_image_gallery', true );
		$gallery = array();
		$big_gallery = array();

		$current_blog_id = get_current_blog_id();
		switch_to_blog( BLOG_ID_CURRENT_SITE );

		require_once(STACKTECH_COMMERCE_PLUGIN_PATH . "includes/vendor/aq_resizer.php");
		if ( $images ) {
			$attachments = array_filter( explode( ',', $images ) );
			foreach ( $attachments as $attachment_id ) {
				$i = wp_get_attachment_image_src( $attachment_id );
				$small_image = aq_resize($i[0], 100, 100);
				$gallery[] = $small_image;
				$j = wp_get_attachment_image_src( $attachment_id, 'full' );
				$big_image = aq_resize($j[0], 430,430);
				if( !$big_image ) {
					$big_image = $small_image;
				}
				$big_gallery[] = $big_image;
			}
		}
		restore_current_blog( $current_blog_id );

		$json_ids    = array();
		// 如果这个产品是个package, 那么搜索出所有的产品数据
		$product_ids = unserialize(get_global_post_meta( $product->ID, '_package_ids', true ));
		if( $product_ids ){
			$product_ids = array_filter( array_map( 'absint', $product_ids ) );
			if ($product_ids){
				foreach ( $product_ids as $pid ) {
					$temp_product = stacktech_call_global_func( 'get_post', $pid );

					$feature_image = '';
					if (stacktech_call_global_func( 'has_post_thumbnail', $pid ) ) {
						$feature_image = stacktech_call_global_func( 'wp_get_attachment_image_src', stacktech_call_global_func( 'get_post_thumbnail_id', $pid ), 'single-post-thumbnail' );
						$feature_image = $feature_image[0];
						$feature_image = aq_resize($feature_image, 100, 100);
					}

					if ( is_object( $temp_product ) ) {
						$json_ids[ $pid ] = array(
							'post_title' => wp_kses_post( html_entity_decode( $temp_product->post_title) ),
							'product_type' => get_global_post_meta( $pid, '_product_type', true ),
							'feature_image' => $feature_image
						);
					}
				}
			}
		}
		
		$dependence_ids = Stacktech_Commerce_Data::get_dependences( $product->ID );
		$dependences = array();
		if ( $dependence_ids ) {
			foreach ( $dependence_ids as $key => $di ) {
				$temp_post = stacktech_call_global_func( 'get_post', $di );
				$dependences[$key]['title'] = $temp_post->post_title;
				$dependences[$key]['id'] = $di;
			}
		}


		// 判断这个商品是否使用特价
		$use_discount_price = 0;
		if ($allow_discount_price){
		  if( $discount_start_date && $discount_end_date) {
			// 这里为什么使用+1，因为2015-06-01默认是从2015-06-01 23:59:59
			if(strtotime('+1 day') >= strtotime($discount_start_date) && strtotime('+1 day') <= strtotime($discount_end_date)){
			  $use_discount_price = 1;
			}
		  } else {
			$use_discount_price = 1;
		  }
		}

		//如果是免费使用的插件
		$product_service_status = 0;
		if(2 == $allow_purchase_forever){
			$product_service = Stacktech_Commerce_Data::check_service_info( $blog_id, $product->ID );
			if( !is_null($product_service) ){
				$product_service_status = $product_service['status'];
			}	
		}

		// 判断这个产品是否使用，试用，或者试用过
		$data = array(
			'id' => $product->ID,
			'post_title' => $product->post_title,
			'price' => $price,
			'allow_trail' => $allow_trail,
			'trail_days' => $trail_days,
			'feature_image' => $feature_image,
			'post_excerpt' => '',
			'product_type' => $product_type,
			'post_content' => $product->post_content,
			'is_trailing' => Stacktech_Commerce_Data::check_is_site_trailing($product->ID),
			'is_trailed' => Stacktech_Commerce_Data::check_is_site_trailed($product->ID),
			'is_purchased' => Stacktech_Commerce_Data::check_is_site_purchased($product->ID),
			'is_in_cart' => Stacktech_Commerce_Data::check_is_in_cart($product->ID),
			'allow_purchase_forever' => $allow_purchase_forever,
			'allow_discount_price' => $allow_discount_price,
			'sale_discount_price' => $sale_discount_price,
			'discount_start_date' => $discount_start_date,
			'discount_end_date' => $discount_end_date,
			'month_discount' => $month_discount,
			'price_condition' => $price_condition,
			'use_discount_price' => $use_discount_price,
			'dependence_ids' => $dependences,
			'is_package' => $product_sale_type ? $product_sale_type : 0,
			'product_service_status' => $product_service_status,
			'package_products' => $json_ids,
			'gallery' => $gallery,
			'big_gallery' => $big_gallery
		);

		echo json_encode( $data );
		exit;
	}

	// 搜索商品这里返回必须json
	public static function search_products() {

		$category  = isset( $_GET['category'] ) ? $_GET['category'] : '';
		$allow_purchase_forever = isset( $_GET['allow_purchase_forever'] ) ? $_GET['allow_purchase_forever'] : 3;
		$allow_trail = isset( $_GET['allow_trail'] ) ? $_GET['allow_trail'] : 2;
		$product_type = isset( $_GET['product_type'] ) ? $_GET['product_type'] : 'plugin';
		$hide_trailing_products = isset( $_GET['hide_trailing_products'] ) ? $_GET['hide_trailing_products'] : 0;
		$hide_using_products= isset( $_GET['hide_using_products'] ) ? $_GET['hide_using_products'] : 0;

		$keyword  = isset( $_GET['keyword'] ) ? $_GET['keyword'] : '';
		$blog_id = get_current_blog_id();
		$args = array(
			'posts_per_page' => 12,
			'post_type' => 'stacktech_product',
			'offset' => 0
		);
		// 搜索产品标题
		if ($keyword) {
			$args['s'] = $keyword;
		}

		// 要么是package 要么是某个产品类型
		$args['meta_query'] = array();
		$args['meta_query'][] = array(
			'relation' => 'OR',
			array(
				'key' => '_product_type',
				'value' => $product_type,
				'compare' => '=',
			),
			array(
				'key' => '_product_sale_type',
				'value' => self::$is_package,
				'compare' => '=',
			),
		);
		// 如果有过滤按月出售或永久出售那么
		if ( $allow_purchase_forever == 1 || $allow_purchase_forever == 0 || $allow_purchase_forever == 2 ){
			$args['meta_query'][] = array(
				 array(
					'key' => '_allow_purchase_forever',
					'value' => $allow_purchase_forever,
					'compare' => '=',
				 ),
			);
		}
		if ( $allow_trail == 1 || $allow_trail == 0 ){
			$args['meta_query'][] = array(
				 array(
					'key' => '_allow_trail',
					'value' => $allow_trail,
					'compare' => '=',
				 ),
			);
		}
		if ( $category ) {
			$args['tax_query'] = array(
				array(
					'terms' => $category,
					'field' => 'term_id',
					'taxonomy' => $_GET['taxonomy'],
				),
			);
		}



		// 搜索所有的产品
		$products = Stacktech_Commerce_Data::get_products( $args );

		$data = array();
		foreach ( $products as $product ) {
			// Here we will do one filter for package.
			// If the current request is "plugin", we will check if the package has plugin, if not, we will remove it from search result.
			$product_sale_type = get_global_post_meta( $product->ID, '_product_sale_type', true );
			if( $product_sale_type == self::$is_package ) {
				$product_ids = unserialize(get_global_post_meta( $product->ID, '_package_ids', true ));
				if( $product_ids ){
					$product_ids = array_filter( array_map( 'absint', $product_ids ) );
					if ($product_ids){
						$package_is_ok = false;
						foreach ( $product_ids as $pid ) {
							$temp_product = stacktech_call_global_func( 'get_post', $pid );
							if ( is_object( $temp_product ) ) {
								if( get_global_post_meta( $pid, '_product_type', true ) == $product_type ){
									$package_is_ok = true;
								}
							}
						}
					}
				}

				if ( !$package_is_ok ) {
					continue;
				}
			}
			$product_trailing_result = Stacktech_Commerce_Data::check_is_site_trailing($product->ID);
			if( $hide_trailing_products && $product_trailing_result ) {
				continue;
			}
			$product_purchase_result = Stacktech_Commerce_Data::check_is_site_purchased($product->ID);
			if( $hide_using_products && $product_purchase_result) {
				continue;
			}

			$feature_image = '';
			if (stacktech_call_global_func( 'has_post_thumbnail', $product->ID ) ) {
				$feature_image = stacktech_call_global_func( 'wp_get_attachment_image_src', stacktech_call_global_func( 'get_post_thumbnail_id', $product->ID ), 'single-post-thumbnail' );
				$feature_image = $feature_image[0];
			}

			$allow_trail = get_global_post_meta( $product->ID, '_allow_trail', true );
			$trail_days = get_global_post_meta( $product->ID, '_trail_days', true );
			$price = get_global_post_meta( $product->ID, '_sale_price', true );


			$s_allow_purchase_forever = get_global_post_meta( $product->ID, '_allow_purchase_forever', true );
			$allow_discount_price = get_global_post_meta( $product->ID, '_allow_discount_price', true );
			$sale_discount_price = get_global_post_meta( $product->ID, '_sale_discount_price', true );
			$discount_start_date = get_global_post_meta( $product->ID, '_discount_start_date', true );
			$s_product_type = get_global_post_meta( $product->ID, '_product_type', true );
			$discount_end_date = get_global_post_meta( $product->ID, '_discount_end_date', true );
			$month_discount = get_global_post_meta( $product->ID, '_month_discount', true );
			if($month_discount){$month_discount = json_decode($month_discount, true);};
			
			$product_service_status = self::get_product_service_status( $product->ID );
			$dependence_ids = Stacktech_Commerce_Data::get_dependences( $product->ID );
			$service_id = Stacktech_Commerce_Product::get_service_id( $product->ID );
			$dependences = array();
			if ( $dependence_ids ) {
				foreach ( $dependence_ids as $key => $di ) {
					$temp_post = stacktech_call_global_func( 'get_post', $di );
					$dependences[$key]['title'] = $temp_post->post_title;
					$dependences[$key]['id'] = $di;
				}
			}

			// 判断这个商品是否使用特价
			$use_discount_price = self::use_discount_price( $product->ID );

			// 判断这个产品是否使用，试用，或者试用过
			$data[] = array(
				'id' => $product->ID,
				'post_title' => $product->post_title,
				'price' => $price,
				'allow_trail' => $allow_trail,
				'trail_days' => $trail_days,
				'feature_image' => $feature_image,
				'post_excerpt' => '',
				'is_trailing' => $product_trailing_result,
				'is_trailed' => Stacktech_Commerce_Data::check_is_site_trailed($product->ID),
				'is_purchased' => $product_purchase_result,
				'is_in_cart' => Stacktech_Commerce_Data::check_is_in_cart($product->ID),
				'allow_purchase_forever' => $s_allow_purchase_forever,
				'allow_discount_price' => $allow_discount_price,
				'sale_discount_price' => $sale_discount_price,
				'discount_start_date' => $discount_start_date,
				'product_type' => $s_product_type,
				'discount_end_date' => $discount_end_date,
				'month_discount' => $month_discount,
				'use_discount_price' => $use_discount_price,
				'dependence_ids' => $dependences,
				'is_package' => $product_sale_type ? $product_sale_type : 0,
				'product_service_status' => $product_service_status,
				'service_id' => $service_id,

			);
		}


		$json_data = array();
		$json_data['category'] = $category;
		$json_data['products'] = $data;
		$json_data['product_type'] = $product_type;
		$json_data['allow_purchase_forever'] = $allow_purchase_forever;
		$json_data['keyword'] = $keyword;
		print(json_encode($json_data));
		exit;
	}


	public static function json_search_products() {

		ob_start();
		$post_types = array('stacktech_product');

		$term    = (string) trim( stripslashes( $_GET['term'] ) );
		$exclude = array();

		if ( empty( $term ) ) {
			die();
		}

		if ( ! empty( $_GET['exclude'] ) ) {
			$exclude = array_map( 'intval', explode( ',', $_GET['exclude'] ) );
		}

		$args = array(
			'post_type'      => $post_types,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			's'              => $term,
			'fields'         => 'ids',
			'exclude'        => $exclude
		);

		if ( is_numeric( $term ) ) {

			if ( false === array_search( $term, $exclude ) ) {
				$posts2 = get_posts( array(
					'post_type'      => $post_types,
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'post__in'       => array( 0, $term ),
					'fields'         => 'ids'
				) );
			} else {
				$posts2 = array();
			}

			$posts3 = get_posts( array(
				'post_type'      => $post_types,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'post_parent'    => $term,
				'fields'         => 'ids',
				'exclude'        => $exclude
			) );

			$posts4 = get_posts( array(
				'post_type'      => $post_types,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'key'     => '_sku',
						'value'   => $term,
						'compare' => 'LIKE'
					)
				),
				'fields'         => 'ids',
				'exclude'        => $exclude
			) );

			$posts = array_unique( array_merge( get_posts( $args ), $posts2, $posts3, $posts4 ) );

		} else {

			$args2 = array(
				'post_type'      => $post_types,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
					'key'     => '_sku',
					'value'   => $term,
					'compare' => 'LIKE'
					)
				),
				'fields'         => 'ids',
				'exclude'        => $exclude
			);

			$posts = array_unique( array_merge( get_posts( $args ), get_posts( $args2 ) ) );

		}

		$found_products = array();

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$product = get_post($post);
				$found_products[ $post ] = rawurldecode( $product->post_title );
			}
		}


		echo json_encode( $found_products );
		exit;
	}

	// Get the service id related the product
	public static function get_service_id( $product_id, $blog_id = 0 ) {
		$service_id = 0;
		$blog_id = get_current_blog_id();
		$product_service = Stacktech_Commerce_Data::check_service_info( $blog_id, $product_id );
		if( !is_null($product_service) ){
			return $product_service['service_id'];
		}
	
		return $service_id;
	}

	// get the product service status of current site
	public static function get_product_service_status( $product_id, $blog_id = 0 ) {
		$blog_id = get_current_blog_id();
		$product_service = Stacktech_Commerce_Data::check_service_info( $blog_id, $product_id );
		if( !is_null($product_service) ){
			$product_service_status = $product_service['status'];

			return $product_service_status;
		}

		return Stacktech_Commerce_Service::$unused;
	}

	// Check the product if it's using discount
	public static function use_discount_price( $product_id ) {
		$allow_discount_price = get_global_post_meta( $product_id, '_allow_discount_price', true );
		$discount_start_date = get_global_post_meta( $product_id, '_discount_start_date', true );
		$discount_end_date = get_global_post_meta( $product_id, '_discount_end_date', true );

		$use_discount_price = 0;
		if ($allow_discount_price){
			if( $discount_start_date && $discount_end_date) {
				// 这里为什么使用+1，因为2015-06-01默认是从2015-06-01 23:59:59
				if(strtotime('+1 day') >= strtotime($discount_start_date) && strtotime('+1 day') <= strtotime($discount_end_date)){
					$use_discount_price = 1;
				}
			} else {
				$use_discount_price = 1;
			}
		}

		return $use_discount_price;
	}


}
