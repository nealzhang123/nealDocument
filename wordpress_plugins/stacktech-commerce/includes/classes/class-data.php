<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Commerce_Data {

	// 从插件或主题获取相应的产品
	public static function get_product_by_plugin_name( $plugin_name ) {

		global $wpdb;
		$product = $wpdb->get_row( $wpdb->prepare('SELECT p.* FROM '. $wpdb->base_prefix . 'posts as p, ' . $wpdb->base_prefix . 
		'postmeta as pm  WHERE pm.post_id = p.ID AND p.post_type = %s  AND pm.meta_key = %s AND pm.meta_value = %s', 
			'stacktech_product',
			'_plugin_name',
			$plugin_name
		), ARRAY_A );
		return $product;
	}

	public static function get_account_logs( $user_id ) {
		global $wpdb;
		$services = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_account_log  WHERE user_id = %d ORDER BY log_id DESC ', $user_id), ARRAY_A );
		return $services;
	}

	public static function get_order_logs( $order_id ) {
		global $wpdb;
		$services = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_order_log  WHERE order_id = %d ORDER BY log_id DESC ', $order_id), ARRAY_A );
		return $services;
	}


	public static function get_service_logs( $service_id ) {
		global $wpdb;
		$services = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_service_log  WHERE service_id = %d ORDER BY log_id DESC ', $service_id), ARRAY_A );
		return $services;
	}

	public static function get_service_logs_by_note( $note ) {
		global $wpdb;
		$services = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_service_log  WHERE note = %s ORDER BY log_id DESC ', $note), ARRAY_A );
		return $services;
	}

	public static function delete_service ( $service_id ) {
		global $wpdb;
		$wpdb->delete( $wpdb->base_prefix . 'stacktech_service', array( 'service_id' => $service_id ) );
	}


	// 检查产品是否是购物车里面
	public static function check_is_in_cart( $product_id ) {
		$cart = get_option('stacktech_cart');
		$cart = $cart ? unserialize($cart) : array('products' => array());
		if ( $cart['products'] ) {
			foreach ( $cart['products'] as $product ) {
				if ( $product['product_id'] == $product_id ) {
					return 1;
				}
			}
		}
		return 0;
	}

	// 获取某个产品的依赖包
	public static function get_dependences( $product_id ) {
		$product_ids = array_filter( array_map( 'absint', (array) unserialize( get_global_post_meta( $product_id, '_dependence_ids', true ) ) ) );
		if ( !$product_ids ) {
			return array();
		}

		return $product_ids;
	}
	
	// 检查是否试用过这个产品
	public static function check_is_site_trailed( $product_id ) {
		global $wpdb;
		$current_blog_id = get_current_blog_id();
		$result = $wpdb->query($wpdb->prepare('SELECT * FROM '.$wpdb->base_prefix. 'stacktech_order_product op 
			LEFT JOIN '. $wpdb->base_prefix .'stacktech_order o ON op.order_id = o.order_id 
			WHERE op.product_id = %d AND o.blog_id = %d AND o.order_type = %s', $product_id, $current_blog_id, Stacktech_Commerce_Order::$trail_type));
		if($result){
			return 1;
		}
		return 0;
	}

	// 检查是否正在试用这个产品
	public static function check_is_site_trailing( $product_id ) {
		global $wpdb;
		$current_blog_id = get_current_blog_id();
		$result = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$wpdb->base_prefix. 'stacktech_order_product op 
			LEFT JOIN '. $wpdb->base_prefix .'stacktech_order o ON op.order_id = o.order_id 
			WHERE op.product_id = %d AND o.blog_id = %d AND o.order_type = %s AND o.order_status = %d', $product_id, $current_blog_id, Stacktech_Commerce_Order::$trail_type, Stacktech_Commerce_Order::$finished), ARRAY_A);
		if($wpdb->num_rows == 0){
			return 0;
		}
		// 检查运行时间是否
		$end_time = mysql2date( 'U', $result['pay_time'] ? $result['pay_time'] : $result['create_time'] ) + $result['period'] * 24*60*60;
		if(current_time('timestamp') <= $end_time){
			return 1;
		}
		return 0;
	}

	// 检查这个产品是否已经购买
	// 查出最后购买的订单
	public static function check_is_site_purchased( $product_id ) {
		global $wpdb;
		$current_blog_id = get_current_blog_id();
		$result = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$wpdb->base_prefix. 'stacktech_order_product op 
			LEFT JOIN '. $wpdb->base_prefix .'stacktech_order o ON op.order_id = o.order_id 
			WHERE o.order_status = %d AND op.product_id   = %d AND o.blog_id = %d   AND (o.order_type = %s OR o.order_type = %s) ORDER BY op.order_product_id DESC LIMIT 0, 1',Stacktech_Commerce_Order::$finished, $product_id, $current_blog_id, Stacktech_Commerce_Order::$sale_type, Stacktech_Commerce_Order::$free_type), ARRAY_A);
		if($wpdb->num_rows == 0){
			return 0;
		}
		if($result['order_type'] == Stacktech_Commerce_Order::$sale_type){
			// 检查运行时间是否
			$end_time = mysql2date( 'U', $result['pay_time'] ? $result['pay_time'] : $result['create_time'] ) + $result['period'] * 24*60*60;
			if(current_time('timestamp') <= $end_time){
				return 1;
			}
		} else {
			// Free product
			return 1;
		}
		return 0;
	}


	public static function update_product($id, $data) {
		// do some db actions
	}


	public static function get_order_products( $order_id, $product_id = 0 ) {
		global $wpdb;
		if( $product_id ) {
			$products = $wpdb->get_results( $wpdb->prepare('SELECT op.*, p.post_title FROM '. $wpdb->base_prefix . 'stacktech_order_product as op LEFT JOIN ' . $wpdb->base_prefix .'posts as p ON p.ID = op.product_id  WHERE order_id = %d AND op.product_id = %d', $order_id, $product_id), ARRAY_A );
		}else {
			$products = $wpdb->get_results( $wpdb->prepare('SELECT op.*, p.post_title FROM '. $wpdb->base_prefix . 'stacktech_order_product as op LEFT JOIN ' . $wpdb->base_prefix .'posts as p ON p.ID = op.product_id  WHERE order_id = %d', $order_id), ARRAY_A );
		}
		return $products;
	}

	public static function get_plugins_from_order ( $order_id ) {
		global $wpdb;
		$products = $wpdb->get_results( $wpdb->prepare('SELECT op.product_id,op.period, pm.meta_value FROM '. $wpdb->base_prefix . 'stacktech_order_product as op LEFT JOIN ' . $wpdb->base_prefix .'postmeta as pm ON pm.post_id = op.product_id   WHERE order_id = %d AND meta_key = %s', $order_id, '_plugin_name'), ARRAY_A );
		return $products;
	}

	// 获取订单列表
	public static function get_orders ( $blog_id ) {
		global $wpdb;
		$orders = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_order  WHERE blog_id = %d ORDER BY order_id DESC ', $blog_id), ARRAY_A );
		return $orders;
	}
	// 获取所有站点的订单
	public static function get_all_orders ( ) {
		global $wpdb;
		$orders = $wpdb->get_results( 'SELECT * FROM '. $wpdb->base_prefix . 'stacktech_order ORDER BY order_id DESC ', ARRAY_A );
		return $orders;
	}

	public static function search_orders( $args ) {
		global $wpdb;
		// Child Order sql
		if( (isset( $args['filter_by_author'] ) && $args['filter_by_author']) || 
			(isset( $args['filter_order_no'] ) && $args['filter_order_no'] && strpos( $args['filter_order_no'], '-' ) !== false) ) {
			$sql = 'SELECT 1 AS is_child_order, sop.*, so.* FROM '. $wpdb->base_prefix . 'stacktech_order_product sop LEFT JOIN ' . $wpdb->base_prefix . 'stacktech_order so ON sop.order_id = so.order_id WHERE 1=%d  ';
		} else {
			// Main Order sql
			$sql = 'SELECT 0 AS is_child_order, so.* FROM '. $wpdb->base_prefix . 'stacktech_order AS so WHERE 1= %d ';
		}

		$query_args = array(1);

		if( isset( $args['filter_by_author'] ) && $args['filter_by_author'] ) {
			$sql .= ' AND sop.author_id = %d  ';
			$query_args[] = $args['filter_by_author'];
		}

		if( isset( $args['filter_order_no'] ) && $args['filter_order_no'] ) {
			// Check which type of order no
			if ( strpos( $args['filter_order_no'], '-' ) === false ) {
				$sql .= ' AND so.order_no = %s ';
				$query_args[] = $args['filter_order_no'];
			} else {
				$params = explode( '-', $args['filter_order_no'] );
				$sql .= ' AND so.order_no = %s AND sop.product_id = %d ';
				$query_args[] = $params[0];
				$query_args[] = $params[1];
			}
		}
		$sql .= ' ORDER BY so.order_id DESC';
		$orders = $wpdb->get_results( $wpdb->prepare( $sql, $query_args), ARRAY_A );

		return $orders;
	}

	// 获取service列表
	public static function get_services ( $blog_id = 0 ) {
		global $wpdb;
		if ( $blog_id ) {
			$services = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_service ss LEFT JOIN '. $wpdb->base_prefix . 'posts as p ON p.ID  = ss.product_id  WHERE blog_id = %d', $blog_id), ARRAY_A );
		} else {
			$services = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_service ss LEFT JOIN '. $wpdb->base_prefix . 'posts as p ON p.ID  = ss.product_id'), ARRAY_A );
			
		}
		return $services;
	}

	public static function get_theme_services ( $blog_id = 0 ) {
		global $wpdb;
		if ( $blog_id ) {
			$services = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_service ss LEFT JOIN '. $wpdb->base_prefix . 'posts as p ON p.ID  = ss.product_id LEFT JOIN '. $wpdb->base_prefix .'postmeta as pm ON pm.post_id = p.ID  WHERE blog_id = %d AND meta_key = %s AND meta_value = %s', $blog_id, '_product_type', 'theme'), ARRAY_A );
		} else {
			$services = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_service ss LEFT JOIN '. $wpdb->base_prefix . 'posts as p ON p.ID  = ss.product_id LEFT JOIN '. $wpdb->base_prefix .'postmeta as pm ON pm.post_id = p.ID WHERE meta_key = %s AND meta_value = %s', '_product_type', 'theme'), ARRAY_A );
			
		}
		return $services;
	}

	// 获取only service
	public static function get_services_only () {
		global $wpdb;
		$services = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM '. $wpdb->base_prefix . 'stacktech_service'), ARRAY_A );

		return $services;
	}



	// 获取service
	public static function get_service( $service_id ) {

		global $wpdb;
		$service = $wpdb->get_row( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_service WHERE service_id = %d', $service_id), ARRAY_A );
		return $service;
	}

	
	public static function get_service_by_product( $product_id, $blog_id = 0 ) {

		global $wpdb;
		$service = $wpdb->get_row( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_service WHERE product_id = %d AND blog_id = %d', $product_id, $blog_id), ARRAY_A );
		return $service;
	}


	public static function update_service($data, $where) {
		global $wpdb;
		return $wpdb->update($wpdb->base_prefix . 'stacktech_service',  $data, $where);
	}


	public static function get_order( $order_id ) {

		global $wpdb;
		$order = $wpdb->get_row( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_order WHERE order_id = %d', $order_id), ARRAY_A );
		return $order;
	}

	public static function get_order_product( $order_product_id ) {

		global $wpdb;
		$order = $wpdb->get_row( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_order_product WHERE order_product_id = %d', $order_product_id), ARRAY_A );
		return $order;
	}

	public static function add_order( $data ) {
		global $wpdb;
		$wpdb->insert( $wpdb->base_prefix . 'stacktech_order', $data);

		$order_id = $wpdb->insert_id;

		return $order_id;
	}

	public static function add_service_log( $data ) {
		global $wpdb;
		$wpdb->insert( $wpdb->base_prefix . 'stacktech_service_log', $data);

		$order_id = $wpdb->insert_id;

		return $order_id;
	}
	public static function add_order_log( $data ) {
		global $wpdb;
		$wpdb->insert( $wpdb->base_prefix . 'stacktech_order_log', $data);

		$order_id = $wpdb->insert_id;

		return $order_id;
	}

	public static function add_account_log( $data ) {
		global $wpdb;
		$wpdb->insert( $wpdb->base_prefix . 'stacktech_account_log', $data);

		$order_id = $wpdb->insert_id;

		return $order_id;
	}




	public static function add_service( $data ) {
		global $wpdb;
		$wpdb->insert( $wpdb->base_prefix . 'stacktech_service', $data);

		$service_id = $wpdb->insert_id;

		return $service_id;
	}
	public static function add_order_product( $data ) {
		global $wpdb;
		$wpdb->insert( $wpdb->base_prefix . 'stacktech_order_product', $data);

		$order_product_id = $wpdb->insert_id;

		return $order_product_id;
	}

	public static function generate_order_no() {
		return time();
	}

	/**
	 * 获取最新的产品列表，从主site
	 */
	public static function get_products( $args ) {
		$blog_id = get_current_blog_id();
		switch_to_blog( BLOG_ID_CURRENT_SITE );

		$posts = get_posts( $args );

		restore_current_blog( $blog_id );
		return $posts;
	}

	/**
	 * 获取当前site已购买的产品列表
	 */
	public static function get_purchased_products() {
	}

	/**
	 * 获取可绑定的插件
	 *
	 */
	public static function load_avaiable_modules($type, $current = '') {
		global $wpdb;
		// 抓取所有已经绑定到产品的插件
		$active_modules = $wpdb->get_results( 
			$wpdb->prepare(
				"SELECT * FROM " . $wpdb->prefix . "posts as p
				LEFT JOIN " . $wpdb->prefix . "postmeta as pm ON pm.post_id = p.ID 
				WHERE p.post_type = %s AND meta_key = %s",
				'stacktech_product',
				'_plugin_name'
			)
		);
		$active_modules_arr = array();
		foreach ( $active_modules as $row ) {
			$active_modules_arr[] = $row->meta_value;
		}

		if ( $type == 'plugin' ) {
			$all_plugins = get_plugins();
		} else {
			$all_plugins = wp_get_themes();
			foreach ( $all_plugins as $key => $plugin ) {
				$all_plugins[$key] = array(
					'Name' => $plugin->display('Name')
				);
			}
		}

		foreach ( $all_plugins as $key => $plugin ) {
			if ( $key == $current ) {
				continue;
			}
			// 如果这个插件已经在network启用，那么移除掉
			if ( $type == 'plugin' && is_plugin_active_for_network( $key ) ) {
				unset( $all_plugins[$key] );
			}
			// 如果这个插件允许所有站点试用，则移除掉
			if ( $type == 'theme' ) {
				$allowed_themes = get_site_option( 'allowedthemes' );
				if ( isset( $allowed_themes[$key] ) && $allowed_themes[$key] ) {
					unset( $all_plugins[$key] );
				}
			}
			if ( in_array( $key, $active_modules_arr ) ) {
				unset( $all_plugins[$key] );
			}
		}

		return $all_plugins;
	}

	public static function update_order($data, $where) {
		global $wpdb;
		stacktech_write_log( "\n HERE is my order id: " . $wpdb->base_prefix ." \n" );
		return $wpdb->update($wpdb->base_prefix . 'stacktech_order',  $data, $where);
	}

	public static function check_service_info($blog_id, $product_id){
		global $wpdb;
		$service = $wpdb->get_row( $wpdb->prepare('SELECT * FROM '. $wpdb->base_prefix . 'stacktech_service WHERE blog_id = %d And product_id = %d', $blog_id ,$product_id), ARRAY_A );

		return $service;
	}


	// 有时候，我们知道这个service的last_order_id已经是错误了，我们必须要将它指向正确的订单，比如退款操作
	// 上一个订单是购买订单，就必须要求是完成状态
	public static function get_last_order_by_service( $service ) {

		global $wpdb;
		$order = $wpdb->get_row( $wpdb->prepare(
			'SELECT o.* FROM '. $wpdb->base_prefix . 'stacktech_order_product as op LEFT JOIN '
			. $wpdb->base_prefix . 'stacktech_order as o ON o.order_id = op.order_id '
			.'  WHERE o.blog_id = %d And op.product_id = %d AND  o.order_type = %s AND o.order_status = %d  ORDER BY o.order_id DESC LIMIT 0, 1', 
			$service['blog_id'] ,$service['product_id'], 
			Stacktech_Commerce_Order::$sale_type, 
			Stacktech_Commerce_Order::$finished
		), ARRAY_A );

		return $order;
	}
}
