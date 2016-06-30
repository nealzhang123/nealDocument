<?php  
// Plain Hero, no images and stuff

class Orane_VC_Plain_Hero {
    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'plain_hero', array( $this, 'renderPlainHero' ) );

        // Register CSS and JS
        add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
    }
 
    public function integrateWithVC() {
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }
 
        /*
        Add your Visual Composer logic here.
        Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

        More info: http://kb.wpbakery.com/index.php?title=Vc_map
        */
        vc_map( array(
            "name" => __("Hero Box With A Link", 'orane'),
            "description" => __("The Hero box with a heading and details and a link", 'orane'),
            "base" => "plain_hero",
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/icons/17-169-tie.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "orane_my_class"
            "category" => __('Orane Components', 'js_composer'),
            "params" => array(
                array(
                  "type" => "textfield",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Title", 'orane'),
                  "param_name" => "title",
                  
                  "value" => __("Hero Title", 'orane'),
                  "description" => __("Title Of The Hero Component.", 'orane')
              ),
              array(
                  "type" => "textarea_html",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Details", 'orane'),
                  "param_name" => "content",
                  "value" => __("Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum dolore eu fugiat nulla pariatur.", 'orane'),
                  "description" => __("Details For The Hero Component...", 'orane')
              ),

                array(
                  "type" => "textfield",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Link Text", 'orane'),
                  "param_name" => "link_text",
                  "value" => __("PURCHASE", 'orane'),
                  "description" => __("", 'orane')
              ),


              array(
                  "type" => "vc_link",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Link To The Page", 'orane'),
                  "param_name" => "link",
                  "description" => __("", 'orane')
              ),



            )
        ) );
    }
    
    /*
    Shortcode logic how it should be rendered
    */
    public function renderPlainHero( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'Title',
        'details' => 'Details',
        'link'    => '',
        'link_text' => 'PURCHASE',
      ), $atts ) );


      $title = lineToBold($title);
      $link = vc_build_link($link); //parse the link
      $link = $link["url"];
     
      $output = "<section class='hero-section'>
                  <div class='container'>   
                    <div class='col-md-10'>
                      <h2><i class='fa fa-thumbs-o-up fa'></i> {$title}</h2>
                      <p>{$content}</p>
                    </div>
                    
                    <div class='col-md-2 purchase-btn'>
                      <a href='{$link}' class='pr-btn'>{$link_text}</a>
                    </div>


                  </div>
                </section>";
      return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {

    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function showVcVersionNotice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'orane'), $plugin_data['Name']).'</p>
        </div>';
    }
}
?>