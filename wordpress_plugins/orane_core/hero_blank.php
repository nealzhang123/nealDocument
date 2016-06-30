<?php  
// Plain Hero, no images and stuff
class Orane_VC_Blank_Hero {

        var $shortcode = 'blank_hero';
        var $title = "Simple Hero Box";
        var $details = "The Hero box with heading and details";
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
            "name" => __($this->title, 'orane'),
            "description" => __($this->details, 'orane'),
            "base" => $this->shortcode,
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/icons/46-297-starfish.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "orane_my_class"
            "category" => __('Orane Components', 'js_composer'),
            "params" => array(
                array(
                  "type" => "textarea",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Title", 'orane'),
                  "param_name" => "title",
                  "value" => __("We Are |ORANE|, And We Deserve 5 Star Rating.", 'orane'),
                  "description" => __("Title Of The Hero Component.", 'orane')
              ),
              array(
                  "type" => "textarea",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Details", 'orane'),
                  "param_name" => "details",
                  "value" => __("Details For The Hero Component...", 'orane'),
                  "description" => __("Details For The Hero Component...", 'orane'),

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
                    <div class='col-md-10'>
                      <h2>{$title}</h2>
                      <p>{$details}</p>
                    </div>
                  </div>
                </section>";
      return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {


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