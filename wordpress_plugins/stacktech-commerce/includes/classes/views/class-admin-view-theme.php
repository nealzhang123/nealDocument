<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Commerce_Admin_View_theme extends Stacktech_Commerce_View {

    public static function output() {

	  	// 获取产品的所有分类
		$terms = stacktech_call_global_func( 'get_terms', 'stacktech_product_cat_theme' );
?>
		<script type="text/javascript">
		window.stacktech_taxonomy = 'stacktech_product_cat_theme';
		window.stacktech_product_type = 'theme';
		</script>
		<?php
		// 这个页面使用了Backbone单页面应用
		include STACKTECH_COMMERCE_TEMPLATE_PATH . 'html-admin-plugin.php';
    }
}


