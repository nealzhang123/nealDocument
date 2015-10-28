<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Commerce_Admin_View_Network_Order extends Stacktech_Commerce_View {

    public static function output() {
		global $wpdb;

		$args = array();
		$args['filter_by_author'] = isset( $_GET['filter-by-author'] ) ? (int) $_GET['filter-by-author'] : 0;
		$args['filter_order_no'] = ( isset( $_GET['filter-order-no'] ) && $_GET['filter-order-no'] ) ? $_GET['filter-order-no'] : '';
		$orders = Stacktech_Commerce_Data::search_orders( $args );
		foreach( $orders as $key => $val) {
			if($val['is_child_order']){
				$orders[$key]['total_price'] = $val['total'];
				$orders[$key]['products'] = Stacktech_Commerce_Data::get_order_products($val['order_id'], $val['product_id']);
			} else {
				$orders[$key]['products'] = Stacktech_Commerce_Data::get_order_products($val['order_id']);
			}
		}

		// Here we need to fetch all of developers according the role
		$developers = get_users();
		
		include STACKTECH_COMMERCE_TEMPLATE_PATH . 'html-admin-network-order.php';
    }

	public static function edit_order() {
		if ( $_POST ){
			self::save_order();
		}

		$order = Stacktech_Commerce_Data::get_order( $_GET['order_id'] );
		$products = Stacktech_Commerce_Data::get_order_products($order['order_id']);

		$user_info = stacktech_call_global_func( 'get_userdata', $order['user_id'] );
		$blog = get_blog_details($order['blog_id']);


		include STACKTECH_COMMERCE_TEMPLATE_PATH . 'html-admin-network-order-form.php';
	}

	public static function save_order() {
		$order = Stacktech_Commerce_Data::get_order( $_GET['order_id'] );

		if( !$order ){
			// error
			exit;
		}

		if ( $_POST['order_status'] == $order['order_status'] ) {
			return;
		}

		Stacktech_Commerce_Data::update_order(
			array('order_status' => $_POST['order_status'] ), 
			array('order_id' => $_GET['order_id'] )
		);
		$action = '订单状态从' . Stacktech_Commerce_Order::get_order_status_text( $order['order_status'] ) . '改成'
			 . Stacktech_Commerce_Order::get_order_status_text( $_POST['order_status'] );
		Stacktech_Commerce_Order_Log::add_order_log( $_GET['order_id'], $action );

		// 如果将订单更改成已经退款
		if ( $_POST['order_status'] == Stacktech_Commerce_Order::$refunded || $_POST['order_status'] == Stacktech_Commerce_Order::$cancel ) {
			Stacktech_Commerce_Order::deactivate_order( $_GET['order_id'] );
		} else if ( $_POST['order_status'] == Stacktech_Commerce_Order::$finished ) {

			/*
			Stacktech_Commerce_Data::update_order(
				array('pay_time' => current_time('mysql') ), 
				array('order_id' => $_GET['order_id'] )
			);
			 */
			Stacktech_Commerce_Order::activate_order( $_GET['order_id'] );
		}

	}
}


