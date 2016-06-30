<?php  
// Page Title
class Orane_VC_Page_Title {

        var $shortcode = 'orane_page_title';
        var $title = "Page Title";
        var $details = "The Title And Subtitle Of The Page";

    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( $this->shortcode, array( $this, 'renderShortcode' ) );

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
 
        vc_map( array(
            "name" => __($this->title, 'orane'),
            "description" => __($this->details, 'orane'),
            "base" => $this->shortcode,
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/icons/7-254-tag.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "orane_my_class"
            "category" => __('Orane Components', 'orane'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/orane_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "orane"),
                                    "param_name" => "title",
                                    "description" => __("The Title.", "orane"),
                                    "value" => __("Page |Title|", 'orane'),
                                    "admin_label" => true,
                            ),


                            array(
                                "type" => "textarea",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Details", 'orane'),
                                "param_name" => "content",
                                "value" => __("Details Under The Title", 'orane'),
                                "description" => __("Details Under The Title", 'orane')
                            ),



                      )
        ) );
    }
    
    /*
    Shortcode logic how it should be rendered
    */
    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'Title',
      ), $atts ) );
      $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      $title = lineToSpanColor($title);
     
      $output = "<section class='page-title-section'>
                  <div class='container'>
                      <div class='col-md-12 tag-heading'>
                        <h1>{$title}</h1>
                        <p>{$content}</p>
                      </div>
                  </div>
                </section>";
      return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
      // wp_register_style( 'orane_style', plugins_url('assets/orane.css', __FILE__) );
      // wp_enqueue_style( 'orane_style' );

      // If you need any javascript files on front end, here is how you can load them.
      //wp_enqueue_script( 'orane_js', plugins_url('assets/orane.js', __FILE__), array('jquery') );
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