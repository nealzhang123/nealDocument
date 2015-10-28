<?php
/**
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 */
class Stacktech_Commerce_Ajax {

	public static function init() {
		add_action('wp_ajax_load_avaiable_modules', array(__CLASS__, 'load_avaiable_modules'));
		add_action('wp_ajax_search_products', array(__CLASS__, 'search_products'));
		add_action('wp_ajax_add_order', array(__CLASS__, 'add_order'));
		add_action('wp_ajax_get_cart_products', array(__CLASS__, 'get_cart_products'));
		add_action('wp_ajax_add_to_cart', array(__CLASS__, 'add_to_cart'));
		add_action('wp_ajax_toggle_service', array(__CLASS__, 'toggle_service'));
		add_action('wp_ajax_stacktech_json_search_products', array(__CLASS__, 'json_search_products'));
		add_action('wp_ajax_get_product_detail', array(__CLASS__, 'get_product_detail'));
		add_action('wp_ajax_load_service_logs', array( 'Stacktech_Commerce_Service_Log', 'load_service_logs'));
		add_action('wp_ajax_load_account_logs', array( 'Stacktech_Commerce_Account_Log', 'load_account_logs'));
		add_action('wp_ajax_load_order_logs', array( 'Stacktech_Commerce_Order_Log', 'load_order_logs'));
		add_action('wp_ajax_renew_order', array( 'Stacktech_Commerce_Order', 'renew_order'));
		add_action('wp_ajax_load_order_detail', array( 'Stacktech_Commerce_Order', 'load_order_detail'));
		add_action('wp_ajax_cancel_order', array( 'Stacktech_Commerce_Order', 'cancel_order'));
	}


	// 载入可用的模块
	public static function load_avaiable_modules() {
		$type = $_POST['type'];
		$modules = Stacktech_Commerce_Data::load_avaiable_modules($type, $_POST['current']);

		echo json_encode($modules);
		exit;
	}

	// 启动或停用服务
	public static function  toggle_service(){
		Stacktech_Commerce_Service::toggle_service();
		exit;
	}

	// 搜索商品这里返回必须json
	public static function search_products() {


		Stacktech_Commerce_Product::search_products();

		exit;
	}

	public static function get_product_detail() {


		Stacktech_Commerce_Product::get_product();

		exit;
	}

	// 这个用来搜索商品，但是只返回标题
	public static function json_search_products() {

		Stacktech_Commerce_Product::json_search_products();
		exit;
	}

	// 保存订单
	public static function add_order() {
		Stacktech_Commerce_Order::add_order();

		exit;
	}

	// 获取购物车里面的商品
	public static function get_cart_products() {
		Stacktech_Commerce_Cart::get_products();

		exit;
	}

	// 放进购物车
	public static function add_to_cart() {
		Stacktech_Commerce_Cart::add_to_cart();
		exit;
	}
}

