<?php  
// Page Title
class Orane_VC_Construct {

        var $shortcode = 'orane_under_construct';
        var $title = "Under Construction";
        var $details = "Under Construction Page";

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
            "name"              => __($this->title, 'orane'),
            "description"       => __($this->details, 'orane'),
            "base"              => $this->shortcode,
            "class"             => "",
            "controls"          => "full",
            "icon"              => plugins_url('assets/icons/22-170-penruller.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "orane_my_class"
            "category"          => __('Orane Components', 'orane'),
            //'front_enqueue_js'  => plugins_url('assets/flip.js', __FILE__), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/orane_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "orane"),
                                    "param_name" => "title",
                                    "description" => __("Under Construction Section Title", "orane"),
                                    "value" => __("UNDER |CONSTRUCTION|", 'orane')
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

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Start Date (DD-MM-YYYY)", "orane"),
                                    "param_name" => "days",
                                    "description" => __("Example: 15-04-2016", "orane"),
                                    "value" => __("15-06-2015", 'orane')
                            ),

                            array(
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Background Image", 'orane'),
                                "param_name" => "image",
                                "description" => __("The Image in the left Side.", 'orane'),
                                "default" => plugins_url('assets/cartoon.png', __FILE__)
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
        'image' => 'Image',
        'days'  => '',
      ), $atts ) );


        wp_enqueue_script( 'orane-flipclock', plugins_url('assets/flipclock.js', __FILE__), array('jquery') );
        wp_enqueue_script( 'orane-flipjs', plugins_url('assets/flip.js', __FILE__), array('jquery') );


        //pass the variables to javascript
        $days = days_until($days);
        $orane_flip = array( 'days' => $days);
        wp_localize_script( 'orane-flipjs', 'orane_flip', $orane_flip );

      $img = wp_get_attachment_image( $image, 'full' );
      $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      $title = lineToSpanColor($title);

      if($image == "Image"){
        $imgsrc = plugins_url('images/cartoon3.png', __FILE__);
        $img = "<img src='{$imgsrc}' alt='cartoon'>";
      }

     
      $output = "<div class='container construction-page'>
                    <div class='col-md-4'>
                        {$img}
                    </div>
                    
                    <div class='col-md-8'>
                        <h1>{$title}</h1>
                        <p>{$content}<p>
                        <div class='clock-example daily-counter clearfix'></div>
                        <!--<div class='subscribe-input'>
                            <input type='text' placeholder='Type your email here...'/><a href='#' class='subscribe'>SUBSCRIBE</a>
                        </div>-->
                    </div>
                    
                </div>";
      return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
      // wp_register_style( 'orane_style', plugins_url('assets/orane.css', __FILE__) );
      // wp_enqueue_style( 'orane_style' );

      // If you need any javascript files on front end, here is how you can load them.


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


function days_until($date){
    return (isset($date)) ? floor((strtotime($date) - time())/60/60/24) : FALSE;
}

?>