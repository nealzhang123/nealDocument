<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Commerce_Admin_View_Product_Data extends Stacktech_Commerce_View {

    public static function output() {
		global $post;

		$product_sale_type = get_post_meta( $post->ID, '_product_sale_type', true );
		$product_sale_type = ($product_sale_type === '') ? 0 : $product_sale_type;
		$product_type = get_post_meta( $post->ID, '_product_type', true );
		$plugin_name = get_post_meta( $post->ID, '_plugin_name', true );
		$sale_price = get_post_meta( $post->ID, '_sale_price', true );
		$sale_discount_price = get_post_meta( $post->ID, '_sale_discount_price', true );

		$allow_trail = get_post_meta( $post->ID, '_allow_trail', true );
		$allow_trail = ($allow_trail === '') ? 1 : $allow_trail;

		$allow_purchase_forever = get_post_meta( $post->ID, '_allow_purchase_forever', true );
		$allow_purchase_forever = ($allow_purchase_forever === '') ? 0 : $allow_purchase_forever;

		$allow_discount_price = get_post_meta( $post->ID, '_allow_discount_price', true );
		$allow_discount_price = ($allow_discount_price === '') ? 0 : $allow_discount_price;

		$trail_days = get_post_meta( $post->ID, '_trail_days', true );
		$discount_start_date = get_post_meta( $post->ID, '_discount_start_date', true );
		$discount_end_date = get_post_meta( $post->ID, '_discount_end_date', true );
		$month_discount = get_post_meta( $post->ID, '_month_discount', true );
		$price_condition = get_post_meta( $post->ID, '_price_condition', true );


		$product_ids = array_filter( array_map( 'absint', (array) get_post_meta( $post->ID, '_dependence_ids', true ) ) );

		// 生成产品类型选择框，插件和主题
		$product_type_selector = array (
			'plugin'   => __( '插件' ),
			'theme'  => __( '主题' ),
		);
		$type_box = '<select id="product-type" name="_product_type">';
		foreach ( $product_type_selector as $value => $label ) {
			$type_box .= '<option value="' . esc_attr( $value ) . '" ' . selected( $product_type, $value, false ) .'>' . esc_html( $label ) . '</option>';
		}
		$type_box .= '</select>';

		include STACKTECH_COMMERCE_TEMPLATE_PATH . 'html-admin-product-data.php';
    }
}


