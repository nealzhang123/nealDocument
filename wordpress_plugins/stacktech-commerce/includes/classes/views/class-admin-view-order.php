<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Commerce_Admin_View_Order extends Stacktech_Commerce_View {

    public static function output() {
		//订单记录
		$orders = Stacktech_Commerce_Data::get_orders( get_current_blog_id() );
		foreach ($orders as $key => $order) {
			// 查询每个订单的商品
			$orders[$key]['products'] = Stacktech_Commerce_Data::get_order_products($order['order_id']);
		}
		//启用的服务
		include STACKTECH_COMMERCE_TEMPLATE_PATH . 'html-admin-order.php';
    }



}


