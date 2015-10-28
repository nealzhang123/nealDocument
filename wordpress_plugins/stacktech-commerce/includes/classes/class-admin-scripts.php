<?php
/**
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 */
class Stacktech_Commerce_Admin_Scripts {
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'load_scripts' ) );
		// 加载一些全局的模板
		add_action( 'admin_footer', array( __CLASS__, 'add_templates' ) );
	}

	public static function load_scripts($hook) {
		/*
		if( !(strstr($hook, 'stacktech-store') !== false 
			|| $hook === 'post.php'
		)){
			return;
		}
		 */

		wp_enqueue_style( 'jquery-ui-style', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/jquery-ui/jquery-ui.css');
		wp_enqueue_style( 'stacktech-commerce-tiptip', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/css/tipTip.css' );
		wp_enqueue_style( 'stacktech-commerce-admin-css', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/css/admin.css', array('jquery-ui-style') );
		wp_enqueue_style( 'jBox-css', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/jbox/jBox.css' );
		wp_register_style( 'select2', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/css/select2.css' );
		wp_enqueue_style( 'select2' );


		wp_register_style( 'jcarousel', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/jcarousel/jcarousel.responsive.css' );
		wp_enqueue_style( 'jcarousel' );
		wp_register_style( 'font-awesome', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/font-awesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'font-awesome' );
		// 加载ladda spin样式
		wp_register_style( 'stacktech-commerce-ladda-css', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/ladda/ladda-themeless.min.css' );
		wp_enqueue_style( 'stacktech-commerce-ladda-css' );
		wp_enqueue_script( 'stacktech-jcarousel', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/jcarousel/jquery.jcarousel.min.js', array('jquery')  );
		wp_register_script( 'stacktech-spin', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/ladda/spin.min.js', array('jquery'));
		wp_register_script( 'stacktech-ladda', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/ladda/ladda.min.js', array('jquery'));
		wp_register_script( 'stacktech-tiptip', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/js/jquery.tipTip.min.js', array('jquery'));
		wp_register_script( 'select2', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/select2/select2.js', array('jquery'));

		wp_enqueue_script( 'stacktech-spin' );
		wp_enqueue_script( 'stacktech-ladda' );
		wp_enqueue_script( 'stacktech-tiptip' );
		wp_enqueue_script( 'select2' );
		wp_register_script( 'stacktech-jrumble', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/js/jquery.jrumble.1.3.min.js', array('jquery'));
		wp_enqueue_script( 'stacktech-jrumble' );
		// Remodal
		wp_register_style( 'remodal-css', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/remodal/remodal.css' );
		wp_enqueue_style( 'remodal-css' );
		wp_register_style( 'remodal-theme-css', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/remodal/remodal-default-theme.css' );
		wp_enqueue_style( 'remodal-theme-css' );
		wp_register_script( 'remodal-js', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/remodal/remodal.js');
		wp_enqueue_script( 'remodal-js' );

		wp_register_script( 'underscore', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/js/underscore.js', array('jquery'));
		wp_enqueue_script( 'underscore' );

		wp_register_script( 'backbone', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/js/backbone.js', array('underscore'));
		wp_enqueue_script( 'backbone' );

		wp_register_script( 'jBox-js', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/jbox/jBox.min.js', array('jquery'));
		wp_enqueue_script( 'jBox-js' );
		
		wp_register_script( 'loading-js', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/js/jquery.isloading.min.js', array('jquery'));
		wp_enqueue_script( 'loading-js' );

		wp_register_script( 'stacktech-commerce-models', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/js/models.js', array('backbone'));
		wp_enqueue_script( 'stacktech-commerce-models' );

		wp_register_script( 'stacktech-commerce-views', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/js/views.js', array('stacktech-commerce-models'));
		wp_enqueue_script( 'stacktech-commerce-views' );

		wp_register_script( 'stacktech-commerce-sc', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/js/sc.js', array('stacktech-commerce-views'));
		wp_enqueue_script( 'stacktech-commerce-sc' );

		wp_register_script( 'stacktech-commerce-admin', STACKTECH_COMMERCE_PLUGIN_URL . '/assets/js/admin.js', array('stacktech-tiptip','jquery-ui-datepicker'));
		wp_enqueue_script( 'stacktech-commerce-admin' );
	}

	public static function add_templates() {
		include STACKTECH_COMMERCE_TEMPLATE_PATH . 'html-admin-global-template.php';
	}
}
