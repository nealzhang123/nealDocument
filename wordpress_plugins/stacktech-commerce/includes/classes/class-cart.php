<?php
/**
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 */
class Stacktech_Commerce_Cart {

	// All cart data will be saved into database
	public static function get_products() {
		$cart = get_option('stacktech_cart');
		$cart = $cart ? unserialize($cart) : array('products' => array());
		echo json_encode($cart);
	}

	public static function add_to_cart() {

		// TODO: Here we need to use the API of "calculate_order_product_price" from "class-order.php" to get the correct price.
		$products = isset($_POST['products']) ? $_POST['products'] : array();
		$data = array();
		$data['products'] = $products;
		$data['total'] = 0;
		foreach($products as $product){
			$data['total'] += $product['total'];
			// 检查该商品是否有依赖包，如果有就判断该依赖包是否已经购买或者已经购物车里，如果没有就添加
			$products = Stacktech_Commerce_Data::get_dependences( $product['product_id'] );
			if ( !$products ) { continue; }

		}
		delete_option('stacktech_cart');
		add_option('stacktech_cart', serialize($data));
		// 返回
		echo json_encode($data);
	}
}

