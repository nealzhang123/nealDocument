<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 */
class Stacktech_Commerce_Admin_Meta_Box{

	private static $saved_meta_boxes = false;
	private static $meta_box_errors  = array();

	/**
	 * Constructor
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ), 30 );
		add_action( 'save_post', array( __CLASS__, 'save_meta_boxes' ), 1, 3 );
	}

	/**
	 * 
	 */
	public static function add_meta_boxes() {
		// 添加产品页面的metabox
		add_meta_box( 'stacktech-product-data', __( '产品数据' ), array('Stacktech_Commerce_Admin_View_Product_Data', 'output'), 'stacktech_product', 'normal', 'high' );
		// 添加产品相册
		add_meta_box( 'stacktech-product-images', __( '产品相册' ), array('Stacktech_Commerce_Admin_View_Product_Images', 'output'), 'stacktech_product', 'side', 'low' );
	}

	public static function save_meta_boxes( $post_id, $post, $updated ) {
		$slug = 'stacktech_product';

		if ( $slug != $post->post_type ) {
			return;
		}
		if ( !$updated ) {
			return;
		}

		$attachment_ids = isset( $_POST['product_image_gallery'] ) ? array_filter( explode( ',', $_POST['product_image_gallery'] )  ) : array();

		update_post_meta( $post_id, '_product_image_gallery', implode( ',', $attachment_ids ) );

		// 销售类型
		$sale_type = (int) sanitize_text_field( $_REQUEST['_product_sale_type'] );
		update_post_meta( $post_id, '_product_sale_type',  $sale_type);

		// 如果是单个产品那么
		if($sale_type == 1){
			// 清空
			delete_post_meta( $post_id, '_plugin_name');
			delete_post_meta( $post_id, '_product_type');

			$package_ids    = isset( $_REQUEST['_package_ids'] ) ? array_filter( array_map( 'intval', explode( ',', $_POST['_package_ids'] ) ) ) : array();
			update_post_meta( $post_id, '_package_ids', $package_ids);

		} else {
			// 清空
			delete_post_meta( $post_id, '_package_ids' );

			if ( isset( $_REQUEST['_plugin_name'] ) ) {
				update_post_meta( $post_id, '_plugin_name', sanitize_text_field( $_REQUEST['_plugin_name'] ) );
			}
			if ( isset( $_REQUEST['_product_type'] ) ) {
				update_post_meta( $post_id, '_product_type', sanitize_text_field( $_REQUEST['_product_type'] ) );
			}
		}

		// 变量价格
		if ( isset( $_REQUEST['_price_condition'] ) ) {
			update_post_meta( $post_id, '_price_condition', sanitize_text_field( $_REQUEST['_price_condition'] ) );
		}

		if ( isset( $_REQUEST['_sale_price'] ) ) {
			$new_sale_price = $_REQUEST['_sale_price'] === '' ? '' : stacktech_format_decimal( $_REQUEST['_sale_price'] );
			update_post_meta( $post_id, '_sale_price', $new_sale_price );
		}

		// 是否允许试用
		update_post_meta( $post_id, '_allow_trail', sanitize_text_field( $_REQUEST['_allow_trail'] ) );
		// 是否永久购买
		update_post_meta( $post_id, '_allow_purchase_forever', sanitize_text_field( $_REQUEST['_allow_purchase_forever'] ) );

		// 是否设置特价
		update_post_meta( $post_id, '_allow_discount_price', sanitize_text_field( $_REQUEST['_allow_discount_price'] ) );

		// 特价价格
		if ( isset( $_REQUEST['_sale_discount_price'] ) ) {
			$new_sale_price = $_REQUEST['_sale_discount_price'] === '' ? '' : stacktech_format_decimal( $_REQUEST['_sale_discount_price'] );
			update_post_meta( $post_id, '_sale_discount_price', $new_sale_price );
		}
		// 特价开始日期
		if ( isset( $_REQUEST['_discount_start_date'] ) ) {
			update_post_meta( $post_id, '_discount_start_date', sanitize_text_field( $_REQUEST['_discount_start_date'] ) );
		}
		// 特价结束日期
		if ( isset( $_REQUEST['_discount_end_date'] ) ) {
			update_post_meta( $post_id, '_discount_end_date', sanitize_text_field( $_REQUEST['_discount_end_date'] ) );
		}

		// 特价按月
		if ( isset( $_REQUEST['_month_discount'] ) ) {
			update_post_meta( $post_id, '_month_discount', sanitize_text_field( $_REQUEST['_month_discount'] ) );
		}

		// 存入依赖产品
		if ( isset( $_REQUEST['_dependence_ids'] ) ) {
			$dependence_ids    = isset( $_REQUEST['_dependence_ids'] ) ? array_filter( array_map( 'intval', explode( ',', $_POST['_dependence_ids'] ) ) ) : array();
			update_post_meta( $post_id, '_dependence_ids', $dependence_ids );
		}


		if ( isset( $_REQUEST['_trail_days'] ) ) {
			update_post_meta( $post_id, '_trail_days', (int)$_REQUEST['_trail_days'] );
		}

	}
}
