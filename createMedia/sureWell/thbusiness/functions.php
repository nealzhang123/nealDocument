<?php
/**
 * thbusiness functions and definitions
 *
 * @package thbusiness
 */


if ( ! function_exists( 'thbusiness_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function thbusiness_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on thbusiness, use a find and replace
	 * to change 'thbusiness' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'thbusiness', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// ThBusiness Image Sizes
	add_image_size( 'featured', 345, 259, true ); 	
	add_image_size( 'featured-large', 677, 400, true ); 
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'thbusiness' ),
	) );

	// Enable support for Post Formats.
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'thbusiness_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );
	
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 677; /* pixels */
	}
}
endif; // thbusiness_setup
add_action( 'after_setup_theme', 'thbusiness_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function thbusiness_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'thbusiness' ),
		'id'            => 'thbusiness-main-sidebar',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Business Template Top Area', 'thbusiness' ),
		'id'            => 'thbusiness-business-top-sidebar',
		'description'   => 'Shows the widgets on the top area of the business page.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="business-page-widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Business Template Left Area', 'thbusiness' ),
		'id'            => 'thbusiness-business-left-sidebar',
		'description'   => 'Shows the widgets on the left area of the business page.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="business-page-widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Business Template Right Area', 'thbusiness' ),
		'id'            => 'thbusiness-business-right-sidebar',
		'description'   => 'Shows the widgets on the right area of the business page.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="business-page-widget-title">',
		'after_title'   => '</h1>',
	) );	
	register_sidebar( array(
		'name'          => __( 'Business Template Bottom Area', 'thbusiness' ),
		'id'            => 'thbusiness-business-bottom-sidebar',
		'description'   => 'Shows the widgets on the bottom area of the business page.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="business-page-widget-title">',
		'after_title'   => '</h1>',
	) );				
	register_sidebar( array(
		'name'          => __( 'Footer Left Sidebar', 'thbusiness' ),
		'id'            => 'footer-left',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="footer-widget-title">',
		'after_title'   => '</h1>',
	) );	
	register_sidebar( array(
		'name'          => __( 'Footer Mid Sidebar', 'thbusiness' ),
		'id'            => 'footer-mid',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="footer-widget-title">',
		'after_title'   => '</h1>',
	) );	
	register_sidebar( array(
		'name'          => __( 'Footer Right Sidebar', 'thbusiness' ),
		'id'            => 'footer-right',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="footer-widget-title">',
		'after_title'   => '</h1>',
	) );			
}
add_action( 'widgets_init', 'thbusiness_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function thbusiness_scripts() {
	
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.6.3' );

	wp_enqueue_style( 'bootstrap.css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), 'all' );
	
	wp_enqueue_style( 'thbusiness-style', get_stylesheet_uri() );

	wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js',array( 'jquery' ),'', true );

	

    wp_enqueue_script( 'html5shiv',get_template_directory_uri().'/js/html5shiv.js');
    wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

    wp_enqueue_script( 'respond', get_template_directory_uri().'/js/respond.min.js' );
    wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'thbusiness-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );


	wp_enqueue_script( 'sweet-js', get_template_directory_uri() . '/js/sweet.min.js' );
	wp_enqueue_style( 'sweet-style', get_template_directory_uri() . '/css/sweetalert.min.css' );
	wp_enqueue_script( 'themepunch-plugins',get_template_directory_uri().'/js/jquery.themepunch.plugins.min.js');
	wp_enqueue_script( 'themepunch-revolution',get_template_directory_uri().'/js/jquery.themepunch.revolution.min.js');

	wp_enqueue_script( 'prettyPhoto-js',get_template_directory_uri().'/js/jquery.prettyPhoto.js');
	wp_enqueue_style( 'prettyPhoto-css',get_template_directory_uri().'/css/prettyPhoto.css');

	wp_enqueue_style( 'revolution-slider-style', get_template_directory_uri().'/css/revolution-slider.css' );

	wp_enqueue_script( 'unslider-js',get_template_directory_uri().'/js/unslider-min.js');
	wp_enqueue_style( 'unslider-css',get_template_directory_uri().'/css/unslider.css');

	wp_enqueue_script( 'swiper-js',get_template_directory_uri().'/js/swiper.min.js');
	wp_enqueue_style( 'swiper-css',get_template_directory_uri().'/css/swiper.min.css');

	wp_enqueue_script( 'thbusiness-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'thbusiness_scripts' );

/**
* Admin Scripts
*/
function thbusiness_admin_scripts() {
	wp_enqueue_style( 'admin-css', get_template_directory_uri() . '/css/admin.css', false );
	wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
    wp_enqueue_media();
	wp_enqueue_script( 'admin-js', get_template_directory_uri() . '/js/custom-admin.js', array('jquery'), '', true );
}
add_action( 'admin_enqueue_scripts', 'thbusiness_admin_scripts' );

/**
 * This function contains all the custom styles that will be loaded in the Theme Header.
 */
function thbusiness_initialize_header() {
	
	$style = get_theme_mod( 'custom_css', '' ); 
	if ( ! empty( $style ) ) {
		echo '<style type="text/css">';
			echo $style;
		echo '</style>';
	} 
		
}
add_action('wp_head', 'thbusiness_initialize_header');

/**
* Enqueue thbusiness options panel custom css.
*/
function thbusiness_option_panel_style() {
	wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin.css', false );
}
add_action( 'admin_enqueue_scripts', 'thbusiness_option_panel_style' );


/**
* Add flex slider.
*/
function thbusiness_flex_scripts() {
    
    wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), false, true );
    wp_register_script( 'add-thbusiness-flex-js', get_template_directory_uri() . '/js/thbusiness.flexslider.js', array(), '', true );
	wp_enqueue_script( 'add-thbusiness-flex-js' );    
    wp_register_style( 'add-flex-css', get_template_directory_uri() . '/css/flexslider.css','','', 'screen' );
    wp_enqueue_style( 'add-flex-css' );

}

add_action( 'wp_enqueue_scripts', 'thbusiness_flex_scripts' );


/**
 * Activate a favicon for the website.
 */
function thbusiness_favicon() {

	if ( get_theme_mod( 'display_site_favicon', false ) ) {
		$favicon = get_theme_mod( 'site_favicon', '' );
		$thbusiness_favicon_output = '';
		if ( !empty( $favicon ) ) {
			$thbusiness_favicon_output .= '<link rel="shortcut icon" href="'.esc_url( $favicon ).'" type="image/x-icon" />';
		}
		echo $thbusiness_favicon_output;
	}
}
add_action( 'admin_head', 'thbusiness_favicon' );
add_action( 'wp_head', 'thbusiness_favicon' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Custom widgets.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Theme info page.
 */
require get_template_directory() . '/inc/theme-info.php';



add_action( 'init', 'create_introduce' );
function create_introduce() {
  $labels = array(
    'name' => '公司簡介',
    'singular_name' => '公司簡介',
    'add_new' => '增加簡介',
    'add_new_item' => '新的簡介',
    'edit_item' => '修改簡介',
    'new_item' => '新的簡介',
    'view_item' => '查看簡介',
    'search_items' => '搜索簡介',
    'not_found' =>  '沒有一個簡介',
    'not_found_in_trash' => '回收站沒有簡介',
    'parent_item_colon' => ''
  );

  $supports = array('title', 'editor','thumbnail',);

  register_post_type( 'introduce',
    array(
      'labels' => $labels,
      'public' => true,
	  'show_in_nav_menus' => false,
      'supports' => $supports,
    )
  );

//   register_taxonomy_for_object_type('category','project');
}



// function custom_post_type() {

// // Set UI labels for Custom Post Type
// 	$labels = array(
// 		'name'                => _x( 'Movies', 'Post Type General Name', 'twentythirteen' ),
// 		'singular_name'       => _x( 'Movie', 'Post Type Singular Name', 'twentythirteen' ),
// 		'menu_name'           => __( 'Movies', 'twentythirteen' ),
// 		'parent_item_colon'   => __( 'Parent Movie', 'twentythirteen' ),
// 		'all_items'           => __( 'All Movies', 'twentythirteen' ),
// 		'view_item'           => __( 'View Movie', 'twentythirteen' ),
// 		'add_new_item'        => __( 'Add New Movie', 'twentythirteen' ),
// 		'add_new'             => __( 'Add New', 'twentythirteen' ),
// 		'edit_item'           => __( 'Edit Movie', 'twentythirteen' ),
// 		'update_item'         => __( 'Update Movie', 'twentythirteen' ),
// 		'search_items'        => __( 'Search Movie', 'twentythirteen' ),
// 		'not_found'           => __( 'Not Found', 'twentythirteen' ),
// 		'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
// 	);
	
// // Set other options for Custom Post Type
	
// 	$args = array(
// 		'label'               => __( 'movies', 'twentythirteen' ),
// 		'description'         => __( 'Movie news and reviews', 'twentythirteen' ),
// 		'labels'              => $labels,
// 		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
// 		'hierarchical'        => false,
// 		'public'              => true,
// 		'show_ui'             => true,
// 		'show_in_menu'        => true,
// 		'show_in_nav_menus'   => true,
// 		'show_in_admin_bar'   => true,
// 		'menu_position'       => 5,
// 		'can_export'          => true,
// 		'has_archive'         => true,
// 		'exclude_from_search' => false,
// 		'publicly_queryable'  => true,
// 		'capability_type'     => 'page',
		
// 		// This is where we add taxonomies to our CPT
// 		'taxonomies'          => array( 'category' ),
// 	);
	
// 	// Registering your Custom Post Type
// 	register_post_type( 'movies', $args );
// }

// /* Hook into the 'init' action so that the function
// * Containing our post type registration is not 
// * unnecessarily executed. 
// */

// add_action( 'init', 'custom_post_type', 0 );





/**
 * Add excerpts for pages.
 */
add_action('init', 'thbusiness_excerpt_support');
function thbusiness_excerpt_support() {
	add_post_type_support( 'page', 'excerpt' );
}

add_action('wp_head','ajaxurl');
function ajaxurl() {
	$site_url = site_url();
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
var load_image = '<?php bloginfo('template_url');?>/images/timg.gif';
var product_url_hk = '<?php  echo $site_url . '/產品目錄/';?>';
var product_url_en = '<?php  echo $site_url . '/en/products/';?>';
</script>
<?php
}

add_action('wp_ajax_about-form-save-ajax', 'about_form_save');
add_action('wp_ajax_nopriv_about-form-save-ajax', 'about_form_save');

function about_form_save() {
    if( empty( $_POST ) )
        return;

    foreach ($_POST['form_data'] as $key => $val) {
        $data[$val['name']] = $val['value'];
    }

    $to = array(
        'sherlock.cheung@c-m.hk',
        );
    //$to = 'info@c-m.hk';

    $subject = '迪偉企業網站聯絡我們表單';
    $message .= '公司名稱 : ' . esc_attr( $data['company'] ) . '<br />';
    $message .= '聯繫人 : ' . esc_attr( $data['name'] ) . '<br />';
    $message .= '電話 : ' . esc_attr( $data['tel'] ) . '<br />';
    $message .= '傳真 : ' . esc_attr( $data['tax'] ) . '<br />';
    $message .= '電郵 : ' . esc_attr( $data['email'] ) . '<br />';
    $message .= '地址 : ' . esc_attr( $data['address'] ) . '<br />';
    $message .= '查詢內容 : ' . esc_attr( $data['message'] ) . '<br />';

    $head = 'Content-Type: text/html;charset=UTF-8';

    wp_mail($to,$subject,$message,$head);

    exit();
}    

add_action('wp_ajax_get-product-infor-ajax', 'get_product_infor_ajax');
add_action('wp_ajax_nopriv_get-product-infor-ajax', 'get_product_infor_ajax');

function get_product_infor_ajax(){
	$post = get_post( $_POST['pid'] );

	$response['image_url'] = get_the_post_thumbnail_url( $post->ID );
	$response['content'] = $post->post_content;

	echo json_encode( $response );
	exit();
}



//移除一些後台不希望顯示的功能
//$admin_test: 1為顯示, 0為隱藏
$admin_test = 1;

if( !$admin_test ){
  function wpdocs_remove_menus(){
     
     //remove_menu_page( 'index.php' );                  //Dashboard
     remove_menu_page( 'edit-comments.php' );          //Comments
     remove_menu_page( 'themes.php' );                 //Appearance
     remove_menu_page( 'plugins.php' );                //Plugins
     remove_menu_page( 'tools.php' );                  //Tools
     remove_menu_page( 'multi-post-image' );                  //Tools
     remove_submenu_page( 'options-general.php','tinymce-advanced' );         //tinymce
     remove_menu_page( 'wpml_manage_languages' );                  //wpml
     remove_menu_page( basename( ICL_PLUGIN_PATH ) . '/menu/languages.php' );   //wpml
     remove_submenu_page( 'index.php', 'update-core.php' ); //update notice
     //remove email config 需要修改mail插件裡面的鉤子
     remove_submenu_page( 'options-general.php', 'wp_mail_smtp_plugins' ); 
     remove_action( 'admin_notices', 'update_nag', 3 );  //update notice
  }
  add_action( 'admin_menu', 'wpdocs_remove_menus' );

  /**
   * 隐藏插件更新提示 WP 3.0+
   */
  remove_action( 'load-update-core.php', 'wp_update_plugins' );
  add_filter( 'pre_site_transient_update_plugins', create_function( '$b', "return null;" ) );


  /**
   * 隐藏主题更新提示 WP 3.0+
   */
  remove_action( 'load-update-core.php', 'wp_update_themes' );
  add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );

  // Disable All Automatic Updates
  add_filter( 'automatic_updater_disabled', '__return_true' );
  // Disable Automatic Update Result Emails
  add_filter( 'auto_core_update_send_email', '__return_false' );


  // 禁止 WordPress 检查更新
  remove_action('admin_init', '_maybe_update_core');    

  // 禁止 WordPress 更新插件
  remove_action('admin_init', '_maybe_update_plugins'); 

  // 禁止 WordPress 更新主题
  remove_action('admin_init', '_maybe_update_themes');  

  //修改wordpress後台左上角
  function annointed_admin_bar_remove() {
      global $wp_admin_bar;
      /* Remove their stuff */
      $wp_admin_bar->remove_menu('wp-logo');
      $wp_admin_bar->remove_menu('updates');
      $wp_admin_bar->remove_menu('comments');
  }
  add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);

  //修改後台左下角提示
  function remove_footer_admin () {
    echo 'Designed by <a href="http://www.c-m.hk" target="_blank">創意國際</a>';
  }

  add_filter('admin_footer_text', 'remove_footer_admin');

  //移除後台右下角版本號提示
  add_filter('update_footer', 'update_footer_admin', 11 );

  function update_footer_admin(){
    return '<notice style="display:none;">Developed by <a href="http://nealblog.superzw.com">Sherlock</a></notice>';
  }

  //去除控制臺一些widget
  function remove_dashboard_widgets(){
      remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // 概况
      // remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // 近期评论
      // remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // 链入链接
      // remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // 插件
      // remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // 快速发布
      remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // 近期草稿
      remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
      remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // 其它 WordPress 新闻
  // 使用 'dashboard-network' 作为第二个参数，可以从多站点网络的仪表盘移除Meta模块
  }
  add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

  //去除控制臺中的welcome widget
  remove_action('welcome_panel', 'wp_welcome_panel');


  add_filter('login_headertitle', 'cm_login_headertitle');

  function cm_login_headertitle(){
    return '創意國際傳媒有限公司';
  }

  add_filter('login_headerurl', 'cm_login_headerurl');

  function cm_login_headerurl(){
    return 'http://www.c-m.hk';
  }

  function nowspark_login_head() {    
      echo '<style type="text/css">body.login #login h1 a {background:url('.get_template_directory_uri().'/cm-logo.png) no-repeat 0 0 transparent;width: 155px;padding:0;margin:0 auto 1em;}</style>';
  }
  add_action("login_head", "nowspark_login_head");//modify the background image
}

