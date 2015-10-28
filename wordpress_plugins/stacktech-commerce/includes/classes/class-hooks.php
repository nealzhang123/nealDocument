<?php
/**
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 */
class Stacktech_Commerce_Hooks {

	public static function init() {
		// From third-part plugin "incsub-support"
		add_action('support_system_insert_ticket', array(__CLASS__, 'save_refund_ticket'), 10, 2 );
		add_action( 'activate_service', array( 'Stacktech_Commerce_Service_Log', 'hooks_activate_service' ) );
		add_action( 'deactivate_service', array( 'Stacktech_Commerce_Service_Log', 'hooks_deactivate_service' ) );
		// We need to save the switch theme action
		add_action( 'switch_theme', array( 'Stacktech_Commerce_Service_Log', 'hooks_switch_theme' ), 10, 2 );


		add_action( 'restrict_manage_posts', array( __CLASS__, 'add_filter_param' ), 12 );
		add_action( 'pre_get_posts', array( __CLASS__, 'add_query_parameter' ), 12, 1 );

		//add_filter('views_edit-stacktech_product', array( __CLASS__, 'add_filter_links' ), 12, 1);
		add_filter( 'query_vars', array( __CLASS__, 'add_query_vars_filter' ), 12, 1 );

		// save theme
		add_action( "blog_templates-copy-after_copying", array(__CLASS__, 'save_theme'), 12, 2 );

		// Add money field into user profile
		add_action( 'edit_user_profile', array( __CLASS__, 'edit_user_money_field' ) );

		add_filter( "manage_users_columns", array( __CLASS__, 'add_user_money_column' ), 12 );

		add_filter( 'manage_users_custom_column', array( __CLASS__, 'show_user_money_column' ), 12, 3 );
	}

	public static function add_user_money_column( $c ) {
		$c['user_money'] = '用户余额';

		return $c;
	}

	public static function show_user_money_column( $output, $column_name, $user_id ) {
		if( $column_name == 'user_money' ) {
			return '<span class="price">' . stacktech_get_user_money( $user_id ) . '</span><a href="javascript:void(0)" data-user-id="' . $user_id .'" class="button load_account_history_btn">查看历史记录</a>';
		}

	}

	public static function edit_user_money_field( $user ) {
		$user_money = stacktech_get_user_money( $user->data->ID);
?>
<h3>资金管理</h3>
<table class="form-table">
<tbody>
<tr>
	<th><label>我的余额</label></th>
	<td>
	<span class="price"><?php echo stacktech_format_decimal($user_money); ?></span>
	</td>
</tr>
</tbody></table>

<?php
	}

	public static function save_theme( $template, $blog_id ){
		$source_blog_id = absint( $template['blog_id'] );
		switch_to_blog( $source_blog_id );
		$t = wp_get_theme();
		$theme_name = strtolower($t->get_stylesheet());
		restore_current_blog();

		switch_to_blog( $blog_id );
		$allowed_themes = get_option( 'allowedthemes' );
		$allowed_themes[ $theme_name ] = true;
		update_option( 'allowedthemes', $allowed_themes );
		restore_current_blog();

	}

	public static function add_query_vars_filter( $vars ) {
		$vars[] = "filter-by-product-type";
		return $vars;
	}

	public static function add_filter_param() {
		global $wp_query;
		$val = isset($wp_query->query['filter-by-product-type']) ? $wp_query->query['filter-by-product-type'] : '';
		echo '<select name="filter-by-product-type">';
		echo '<option value="all" ' . selected('all', $val) . '>全部类型</option>';
		echo '<option value="plugin" ' . selected('plugin', $val) . '>插件</option>';
		echo '<option value="theme" ' . selected('theme', $val) . '>主题</option>';
		echo '<option value="package" ' . selected('package', $val) . '>产品包</option>';
		echo '</select>';
	}

	public static function add_query_parameter( $query ) {
		// At first, we need to check if it's edit stacktech-product page
	
		if ( !$query->is_admin ){ return; }
		if ( !function_exists('get_current_screen') ) { return; }
		$scrren = get_current_screen();
		if( !is_object($scrren) ){ return;}
		if ( $scrren->id != 'edit-stacktech_product' ) { return;}
		if ( !isset($query->query['filter-by-product-type']) ) { return;}
			$query->set('meta_query', array(
				array(
					'key' => '_product_type',
					'value' => 'plugin',
					'compare' => '=',
				),
			));

		if ( $query->query['filter-by-product-type'] == 'plugin' ) {
			$query->set('meta_query', array(
				array(
					'key' => '_product_type',
					'value' => 'plugin',
					'compare' => '=',
				),
			));

		} else if (   $query->query['filter-by-product-type'] == 'theme'){
			$query->set('meta_query', array(
				array(
					'key' => '_product_type',
					'value' => 'theme',
					'compare' => '=',
				),
			));

		} else if ($query->query['filter-by-product-type'] == 'package'){
			$query->set('meta_query', array(
				array(
					'key' => '_product_sale_type',
					'value' => 1,
					'compare' => '=',
				),
			));
		}
	}

	public static function add_filter_links( $views ) {
		$second_views = array();
		$second_views['all_plugins'] = "<a href='edit.php?post_type=stacktech_product&filter-by-product-type=plugin'>" . '插件' . '</a>';
		$second_views['all_themes'] = "<a href='edit.php?post_type=stacktech_product&filter-by-product-type=theme'>" . '主题' . '</a>';
		$second_views['all_packages'] = "<a href='edit.php?post_type=stacktech_product&filter-by-product-type=package'>" . '产品包' . '</a>';

		echo "<ul class='subsubsub'>\n";
		foreach ( $second_views as $class => $view ) {
			$second_views[ $class ] = "\t<li class='$class'>$view";
		}
		echo implode( " |</li>\n", $second_views ) . "</li>\n";
		echo "</ul>";
		echo '<div class="clearfix"></div>';

		return $views;
	}

	public static function save_refund_ticket( $ticket_id, $args ) {
		if ( isset( $_POST['stacktech_order_id'] ) ) {
			// 将order_id存入
			incsub_support_update_ticket_meta( $ticket_id, 'stacktech_order_id', $_POST['stacktech_order_id'] );
		}
	}

}
