<?php
/**
 * 安装后台菜单
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Stacktech_Commerce_Admin_Menus {

	public static function init() {
		// Add menus
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		add_action( 'admin_bar_menu', array( __CLASS__, 'cart_item' ), 8 );
		add_action( 'admin_menu', array( __CLASS__, 'check_pay_request' ) );
		add_action( 'admin_menu', array( __CLASS__, 'register_order_page') );
		add_action( 'admin_menu', array( __CLASS__, 'register_setting_page') );
		// 对于子站点，我们不得不移除主题列表页面
		// add_action( 'admin_menu', array( __CLASS__, 'remove_theme_page' ) );
		// 现在如果不是super admin是看不见产品添加菜单的，但是当super admin去其它子站点时还是看见这个菜单
		// 我们要移除它
		add_action( 'admin_menu', array( __CLASS__, 'remove_product_page' ) );
	}

	public static function register_order_page() {
	    add_submenu_page( 'edit.php?post_type=stacktech_product', '订单记录', '订单记录', 'manage_network', 'stacktech-store-network-order-page', array( __CLASS__, 'network_order_page_callback') );
	}

	public static function register_setting_page() {
	    add_submenu_page( 'edit.php?post_type=stacktech_product', '商城设置', '商城设置', 'manage_network', 'stacktech-store-setting', array( __CLASS__, 'store_setting') );
	}

	public static function network_order_page_callback() {
		// 检查是不是订单编辑
		if( isset($_GET['action']) && $_GET['action'] == 'edit' ){
			Stacktech_Commerce_Admin_View_Network_Order::edit_order();
		} else {
			Stacktech_Commerce_Admin_View_Network_Order::output();
		}
	}

    public static function admin_menu() {

		add_menu_page( __( 'APP商城' ), __( 'APP商城' ), 'manage_options', 'stacktech-store-plugin', '', '', 1 );
		// add_submenu_page( 'stacktech-store',  __( 'APP商城' ), __( '所有产品' ), 'manage_options', 'stacktech-store', array( __CLASS__, 'store_page') );
		add_submenu_page( 'stacktech-store-plugin',  __( 'APP商城' ), __( '插件' ), 'manage_options', 'stacktech-store-plugin', array( __CLASS__, 'plugin_page') );
		add_submenu_page( 'stacktech-store-plugin',  __( 'APP商城' ), __( '主题' ), 'manage_options', 'stacktech-store-theme', array( __CLASS__, 'theme_page') );
		add_submenu_page( 'stacktech-store-plugin',  __( 'APP商城' ), __( '订单管理' ), 'manage_options', 'stacktech-store-order', array( __CLASS__, 'order_page') );
		add_submenu_page( 'stacktech-store-plugin',  __( 'APP商城' ), __( '服务管理' ), 'manage_options', 'stacktech-store-manage', array( __CLASS__, 'manage_page') );

		add_submenu_page( null,  __( '支付' ), __( '支付' ), 'manage_options', 'stacktech-store-pay', array( __CLASS__, 'pay') );

		
    }

	public static function remove_theme_page() {
		remove_submenu_page( 'themes.php', 'themes.php' );
	}

	public static function remove_product_page() {
		if( get_current_blog_id() != BLOG_ID_CURRENT_SITE ){
			remove_menu_page( 'edit.php?post_type=stacktech_product' );
		}
	}

	public static function check_pay_request() {
		if ( preg_match('/stacktech-store-pay/', $_SERVER['REQUEST_URI']) ) {
			Stacktech_Commerce_Payment::pay($_GET['gateway']);
			exit;
		}
	}

	public static function store_page() {

		Stacktech_Commerce_Admin_View_Store::output();
	}

	public static function plugin_page() {

		Stacktech_Commerce_Admin_View_Plugin::output();
	}

	public static function theme_page() {

		Stacktech_Commerce_Admin_View_Theme::output();
	}

	public static function order_page() {
		Stacktech_Commerce_Admin_View_Order::output();
	}

	public static function manage_page() {
		Stacktech_Commerce_Admin_View_Manage::output();
	}

	public static function store_setting() {
		Stacktech_Commerce_Admin_View_Store_Setting::output();
	}

	// 添加一个购物车链接
	public static function cart_item( $wp_admin_bar ) {

		// Todo:查询目前购物车产品总数

		$wp_admin_bar->add_menu( array(
			'id'        => 'stacktech-cart',
			'parent'    => 'top-secondary',
			'title'     => '<i class="fa fa-shopping-cart"></i><span class="stacktech-total-num" id="stacktech-total-num">0</span>',
			'href'      => '#',
			'meta'      => array(
				'class'     => 'stacktech-cart-menu'
			),
		) );

		// 加一个去结算的链接
		$wp_admin_bar->add_group( array(
			'parent' => 'stacktech-cart',
			'id'     => 'cart-actions',
		) );
	}
}
