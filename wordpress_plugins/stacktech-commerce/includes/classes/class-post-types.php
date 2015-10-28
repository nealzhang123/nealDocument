<?php
/**
 * 注册Post type
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 注册类型
 */
class Stacktech_Commerce_Post_types {

	/**
	 * Hook
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 5 );
		add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
	}

	public static function register_post_types() {
		if ( post_type_exists('stacktech_product') ) {
			return;
		}

		register_post_type( 'stacktech_product',
			array(
				'labels'              => array(
						'name'               => __( '产品' ),
						'singular_name'      => __( '产品' ),
						'menu_name'          => __( '产品' ),
						'add_new'            => __( '添加产品' ),
						'add_new_item'       => __( '添加产品' ),
						'edit'               => __( '编辑' ),
						'edit_item'          => __( '编辑产品' ),
						'new_item'           => __( '编辑新产品' ),
						'view'               => __( '查看' ),
						'view_item'          => __( '查看产品' ),
						'search_items'       => __( '搜索产品' ),
						'not_found'          => __( '没有发现产品' ),
						'not_found_in_trash' => __( '垃圾箱里没有发现产品' ),
						'parent'             => __( '父产品' )
					),
				'description'         => __( '你可以在这里添加一个产品到APP商店。', '' ),
				'public'              => false,
				'show_ui'             => true,
				'capability_type'     => 'stacktech_product',
				'map_meta_cap'        => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'hierarchical'        => false,
				'rewrite'             => false,
				'query_var'           => false,
				'supports'            => array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'comments' ),
				'has_archive'         => false,
				'show_in_nav_menus'   => true
			)
		);
	}

	public static function register_taxonomies () {

		// 注册产品类型 插件和模板
		/*
		register_taxonomy( 'stacktech_product_type',
			array(
				'hierarchical'      => false,
				'show_ui'           => false,
				'show_in_nav_menus' => false,
				'query_var'         => is_admin(),
				'rewrite'           => false,
				'public'            => false
			)
		);
		 */

		// 注册插件分类
		register_taxonomy( 'stacktech_product_cat_plugin', 
			array('stacktech_product'),
			array(
				'hierarchical'          => true,
				// 'update_count_callback' => '_wc_term_recount',
				'label'                 => __( '插件分类' ),
				'labels' => array(
						'name'              => __( '插件分类' ),
						'singular_name'     => __( '插件分类' ),
						'menu_name'         => __( '插件分类' ),
						'search_items'      => __( '搜索插件分类' ),
						'all_items'         => __( '所有插件分类' ),
						'parent_item'       => __( '上级插件分类' ),
						'parent_item_colon' => __( '上级插件分类:' ),
						'edit_item'         => __( '编辑插件分类' ),
						'update_item'       => __( '修改插件分类' ),
						'add_new_item'      => __( '添加新插件分类' ),
						'new_item_name'     => __( '新插件分类名称' )
					),
				'show_ui'               => true,
				'query_var'             => true,
				'capabilities'          => array(
					'manage_terms' => 'manage_network',
				),
				'rewrite'               => array(
					'with_front'   => false,
					'hierarchical' => true,
				),
			)
		);
		
		// 注册主题分类
		register_taxonomy( 'stacktech_product_cat_theme', 
			array('stacktech_product'),
			array(
				'hierarchical'          => true,
				// 'update_count_callback' => '_wc_term_recount',
				'label'                 => __( '主题分类' ),
				'labels' => array(
						'name'              => __( '主题分类' ),
						'singular_name'     => __( '主题分类' ),
						'menu_name'         => __( '主题分类' ),
						'search_items'      => __( '搜索主题分类' ),
						'all_items'         => __( '所有主题分类' ),
						'parent_item'       => __( '上级主题分类' ),
						'parent_item_colon' => __( '上级主题分类:' ),
						'edit_item'         => __( '编辑主题分类' ),
						'update_item'       => __( '修改主题分类' ),
						'add_new_item'      => __( '添加新主题分类' ),
						'new_item_name'     => __( '新主题分类名称' )
					),
				'show_ui'               => true,
				'query_var'             => true,
				'capabilities'          => array(
					'manage_terms' => 'manage_network',
				),
				'rewrite'               => array(
					'with_front'   => false,
					'hierarchical' => true,
				),
			)
		);
	}
};
