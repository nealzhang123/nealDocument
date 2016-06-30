<?php  
// Plain Hero, no images and stuff

class Orane_VC_Rating_Hero {

        var $shortcode = 'rating_hero';
        var $title = "Hero With Rating";
        var $details = "The Hero box with heading, details and 5 rating icon.";
        //var $path = "/templates/rating_hero.php";

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
 
        /*
        Add your Visual Composer logic here.
        Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

        More info: http://kb.wpbakery.com/index.php?title=Vc_map
        */
        vc_map( array(
            "name" => __($this->title, 'vc_extend'),
            "description" => __($this->details, 'vc_extend'),
            "base" => $this->shortcode,
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/icons/46-297-starfish.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Orane Components', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(
                array(
                  "type" => "textarea",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Title", 'vc_extend'),
                  "param_name" => "title",
                  "value" => __("We Are ORANE, And We Deserve 5 Star Rating.", 'vc_extend'),
                  "description" => __("Title Of The Hero Component.", 'vc_extend')
              ),
              array(
                  "type" => "textarea",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Details", 'vc_extend'),
                  "param_name" => "details",
                  "value" => __("Details For The Hero Component...", 'vc_extend'),
                  "description" => __("Details For The Hero Component...", 'vc_extend')
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
        'details' => 'Details'
      ), $atts ) );
      $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      $title = lineToBold($title);
     
      $output = "<section class='hero-section'>
                  <div class='container'>
                    <div class='col-md-9'>
                      <h2>{$title}</h2>
                      <p>{$details}</p>
                    </div>
                    
                    <div class='col-md-3 stars'>
                      <a href='#'><i class='fa fa-star fa-2x wow zoomIn' data-wow-duration='1s' data-wow-delay='0s'></i></a>
                      <a href='#'><i class='fa fa-star fa-2x wow zoomIn' data-wow-duration='1s' data-wow-delay='.2s'></i></a>
                      <a href='#'><i class='fa fa-star fa-2x wow zoomIn' data-wow-duration='1s' data-wow-delay='.4s'></i></a>
                      <a href='#'><i class='fa fa-star fa-2x wow zoomIn' data-wow-duration='1s' data-wow-delay='.6s'></i></a>
                      <a href='#'><i class='fa fa-star fa-2x wow zoomIn' data-wow-duration='1s' data-wow-delay='.8s'></i></a>
                    </div>
                  </div>
                </section>";
      return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
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

/*
function vc_theme_rating_hero($atts, $content = null) {
   return '<div><p>Prepend this div before shortcode</p></div>';
}
*/

?>