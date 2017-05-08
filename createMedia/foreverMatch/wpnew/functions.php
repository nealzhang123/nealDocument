<?php
register_nav_menus(array(
      'Top Menu Location' => '頂部菜單'));

add_theme_support( 'post-thumbnails' );


	register_sidebar(array(
	'name' => 'Bottom1',
		'before_widget' => '<div class="widget">', // widget 的开始标签
		'after_widget' => '</div>', // widget 的结束标签
		'before_title' => '<h3>', // 标题的开始标签
		'after_title' => '</h3>' // 标题的结束标签
	));
	register_sidebar(array(
	'name' => 'Bottom2',
		'before_widget' => '<div class="widget">', // widget 的开始标签
		'after_widget' => '</div>', // widget 的结束标签
		'before_title' => '<h3>', // 标题的开始标签
		'after_title' => '</h3>' // 标题的结束标签
	));



//***********work**************//



add_action( 'init', 'create_work' );
function create_work() {
  $labels = array(
    'name' => '作品',
    'singular_name' => '作品',
    'add_new' => '增加作品',
    'add_new_item' => '增加作品',
    'edit_item' => '修改作品',
    'new_item' => '新的作品',
    'view_item' => '查看作品',
    'search_items' => '搜索作品',
    'not_found' =>  '沒有找到作品',
    'not_found_in_trash' => '垃圾箱沒有作品',
    'parent_item_colon' => ''
  );

  $supports = array('title', 'editor', 'revisions','thumbnail');

  register_post_type( 'work',
    array(
      'labels' => $labels,
      'public' => true,
	  // 'taxonomies' => array('portfolios'), 
	  'show_in_nav_menus'        => false,
	  
      'supports' => $supports
    )
  );
}
  
    
add_action( 'init', 'create_cloth' );
function create_cloth() {
  $labels = array(
    'name' => '姊妹裙',
    'singular_name' => '姊妹裙',
    'add_new' => '增加姊妹裙',
    'add_new_item' => '增加姊妹裙',
    'edit_item' => '修改姊妹裙',
    'new_item' => '新的姊妹裙',
    'view_item' => '查看姊妹裙',
    'search_items' => '搜索姊妹裙',
    'not_found' =>  '沒有找到姊妹裙',
    'not_found_in_trash' => '垃圾箱沒有姊妹裙',
    'parent_item_colon' => ''
  );

  $supports = array('title', 'editor', 'revisions','thumbnail');

  register_post_type( 'cloth',
    array(
      'labels' => $labels,
      'public' => true,
    // 'taxonomies' => array('portfolios'), 
    'show_in_nav_menus'        => false,
    
      'supports' => $supports
    )
  );
}



/**
 * Enqueue scripts and styles.
 */
function thbusiness_scripts() {
  wp_enqueue_style( 'bootstrap.min.css', get_template_directory_uri() . '/css/bootstrap.min.css' );
  wp_enqueue_style( 'bootstrap-theme.min.css', get_template_directory_uri() . '/css/bootstrap-theme.min.css' );
  wp_enqueue_style( 'sweetalert.min.css', get_template_directory_uri() . '/css/sweetalert.min.css' );
  wp_enqueue_style( 'font-awesome.css', get_template_directory_uri() . '/css/font-awesome.css' );
  wp_enqueue_style( 'style.css', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'red.css', get_template_directory_uri() . '/color-schemes/red/red.css' );
  wp_enqueue_style( 'prettyPhoto.css', get_template_directory_uri() . '/css/prettyPhoto.css' );
  wp_enqueue_style( 'audioplayer.css', get_template_directory_uri() . '/css/audioplayer.css' );
  wp_enqueue_style( 'settings.css', get_template_directory_uri() . '/rs-plugin/css/settings.css' );
  wp_enqueue_style( 'responsive.css', get_template_directory_uri() . '/css/responsive.css' );
  wp_enqueue_style( 'template-changer.css', get_template_directory_uri() . '/template-changer.css' );
 


  wp_enqueue_script( 'jquery-1.8.3.min.js', get_template_directory_uri() . '/js/jquery-1.8.3.min.js', array(), '20120206', true );
  wp_enqueue_script( 'hoverIntent.js', get_template_directory_uri() . '/js/hoverIntent.js' );
  wp_enqueue_script( 'jquery.jcarousel.js', get_template_directory_uri() . '/js/jquery.jcarousel.js' );
  wp_enqueue_script( 'jflickrfeed.js', get_template_directory_uri() . '/js/jflickrfeed.js' );
  wp_enqueue_script( 'jquery.prettyPhoto.js', get_template_directory_uri() . '/js/jquery.prettyPhoto.js' );
  wp_enqueue_script( 'slides.min.jquery.js', get_template_directory_uri() . '/js/slides.min.jquery.js' );
  wp_enqueue_script( 'jquery.mobilemenu.js', get_template_directory_uri() . '/js/jquery.mobilemenu.js' );
  wp_enqueue_script( 'jquery.contact.js', get_template_directory_uri() . '/js/jquery.contact.js',array( 'jQuery' ) );
  wp_enqueue_script( 'jquery.preloadify.min.js', get_template_directory_uri() . '/js/jquery.preloadify.min.js',array( 'jQuery' ) );
  wp_enqueue_script( 'jquery.isotope.min.js', get_template_directory_uri() . '/js/jquery.isotope.min.js' );
  wp_enqueue_script( 'bootstrap.min.js', get_template_directory_uri() . '/js/bootstrap.min.js' );
  wp_enqueue_script( 'sweet.min.js', get_template_directory_uri() . '/js/sweet.min.js' );
  
  wp_enqueue_script( 'custom.js', get_template_directory_uri() . '/js/custom.js' );

}
add_action( 'wp_enqueue_scripts', 'thbusiness_scripts' );



add_action('wp_head','ajaxurl');
function ajaxurl() {
?>
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
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

    $subject = '站點聯繫我們表單';
    $message = '聯繫人 : ' . esc_attr( $data['name'] ) . '<br />';
    $message .= '電話 : ' . esc_attr( $data['tel'] ) . '<br />';
    $message .= '電郵 : ' . esc_attr( $data['email'] ) . '<br />';
    $message .= '查詢內容 : ' . esc_attr( $data['message'] ) . '<br />';

    $head = 'Content-Type: text/html;charset=UTF-8';

    wp_mail($to,$subject,$message,$head);

  exit();
}




//移除一些後台不希望顯示的功能
//
$admin_test = 1;
if( !$admin_test ){
  function wpdocs_remove_menus(){
     
     //remove_menu_page( 'index.php' );                  //Dashboard
     remove_menu_page( 'edit-comments.php' );          //Comments
     remove_menu_page( 'themes.php' );                 //Appearance
     remove_menu_page( 'plugins.php' );                //Plugins
     remove_menu_page( 'tools.php' );                  //Tools
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

