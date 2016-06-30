<?php
/*
Plugin Name: 00-stacktech-add-tag-cloud
Plugin URI: http://www.etongapp.com
Description:the plugin will add tag cloud into vs composer
Version: 1.0
Author: Stacktech
Author URI: http://www.etongapp.com
License: GPL
*/




// don't load directly
if (!defined('ABSPATH')) die('-1');
define( 'STACKTECH_VC_PLUGIN_LANG_DOMAIN', '00-stacktech-visual-composer-extend' );

class Add_Tag_Cloud_Composer {
    function __construct() {
        add_action( 'init',                     array( $this, 'stacktech_integrateWithVC' ) );
        add_shortcode('stacktech-tag-cloud',    array( $this, 'add_tag_cloud_function' ));
        //add_action( 'wp_enqueue_scripts',       array( $this, 'stacktech_loadCssAndJs' ) );
        add_action( 'plugins_loaded',           array($this, 'stacktech_tag_cloud_load_text_domain') );
    }

    /**
     * Load the plugin text domain and MO files
     *
     * These can be uploaded to the main WP Languages folder
     * or the plugin one
     */
    public function stacktech_tag_cloud_load_text_domain() {

      $locale = apply_filters( 'plugin_locale', get_locale(), STACKTECH_VC_PLUGIN_LANG_DOMAIN );

      load_textdomain( STACKTECH_VC_PLUGIN_LANG_DOMAIN, WP_LANG_DIR . '/' . STACKTECH_VC_PLUGIN_LANG_DOMAIN . '/' . $locale . '.mo' );
      load_plugin_textdomain( STACKTECH_VC_PLUGIN_LANG_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
    }

    public function stacktech_integrateWithVC() {
    
        if ( ! defined( 'WPB_VC_VERSION' ) ) {

            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }
 
        //Tag Cloud START
        vc_map( array(
            "name" => __("post tag cloud", STACKTECH_VC_PLUGIN_LANG_DOMAIN),
            "description" => __("this will show cloud of tags", STACKTECH_VC_PLUGIN_LANG_DOMAIN),
            "base" => "stacktech-tag-cloud",
            "class" => "stacktech_tag_cloud",
            //"controls" => "full",
            "icon" => plugins_url('assets/tag_cloud_icon.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Content', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
              array(
                "param_name"  => "info_title_separator",
                "heading"     => __("Tag cloud settings", STACKTECH_VC_PLUGIN_LANG_DOMAIN),
                'group'       => __('General Settings', STACKTECH_VC_PLUGIN_LANG_DOMAIN),
              ),

              array(
                'type'        => 'textfield',
                'heading'     =>  __('title', STACKTECH_VC_PLUGIN_LANG_DOMAIN),
                'param_name'  => 'tag_cloud_title',
                'value'       => 'tag cloud',
                "class"       => "stacktech_tag_cloud_title",
                'admin_label' => true,
                'group'       => __('General Settings', STACKTECH_VC_PLUGIN_LANG_DOMAIN),
                'description' => __('the title of tag cloud', STACKTECH_VC_PLUGIN_LANG_DOMAIN)
              ),

              array(
                'type'        => 'textfield',
                'heading'     =>  __('number of tag cloud', STACKTECH_VC_PLUGIN_LANG_DOMAIN),
                'param_name'  => 'tag_cloud_number',
                'value'       => '400',
                "class"       => "stacktech_tag_cloud_number",
                'admin_label' => true,
                'group'       => __('General Settings', STACKTECH_VC_PLUGIN_LANG_DOMAIN),
                'description' => __('the number of tag cloud', STACKTECH_VC_PLUGIN_LANG_DOMAIN)
              ),
              array(
                'type' => 'css_editor',
                'heading' => __( 'CSS box', 'js_composer' ),
                'param_name' => 'css',
                'group' => __( 'Design Options', 'js_composer' ),
              ),
            ),
        ) );
        //Tag Cloud END
        
    }
    
    /*
    Shortcode For Tag Cloud
    */
    public function add_tag_cloud_function($atts){
      extract(shortcode_atts(array(
          'tag_cloud_number' =>'400',
          'tag_cloud_title' =>__('Tag Cloud', STACKTECH_VC_PLUGIN_LANG_DOMAIN),
      ),$atts));
   
      //标签云的选项
      $args = array(
          'smallest'                  => 15,
          'largest'                   => 15,
          'unit'                      => 'pt', 
          'number'                    => $tag_cloud_number,  
          'format'                    => 'flat',
          'separator'                 => "\n",
          'orderby'                   => 'name', 
          'order'                     => 'ASC',
          'exclude'                   => null, 
          'include'                   => null, 
          'topic_count_text_callback' => default_topic_count_text,
          'link'                      => 'view', 
          'taxonomy'                  => 'post_tag', 
          'echo'                      => true,
      );  

      $tags = get_tags($args);
      foreach ($tags as $tag){
          $tag_link = get_tag_link($tag->term_id);             
          $tag_html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
          $tag_html .= "{$tag->name}</a>";
      }

      $output='<section class="stacktech_tag_clouds">
                  <div class="container">
                      <h2 class="widgettitle">'.$tag_cloud_title.'</h2>
                  </div>
                  <div class="tagcloud">'.$tag_html.'</div>
              </section>';
      return $output;
    }

    




    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function stacktech_loadCssAndJs() {
      wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
      wp_enqueue_style( 'vc_extend_style' );

      // If you need any javascript files on front end, here is how you can load them.
      //wp_enqueue_script( 'vc_extend_js', plugins_url('assets/vc_extend.js', __FILE__), array('jquery') );
    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function showVcVersionNotice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
        </div>';
    }
}
// Finally initialize code
new Add_Tag_Cloud_Composer();