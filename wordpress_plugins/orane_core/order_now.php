<?php  
// Plain Hero, no images and stuff

class Orane_Order_Now {

        var $shortcode = 'orane_order_now';
        var $title = "Order Now";
        var $details = "Order Now Box For Restaurants etc";
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
                  "type" => "attach_image",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Logo", 'orane'),
                  "param_name" => "logo",
                  "description" => __("The Logo above the parallax backgroound", 'orane'),
                  "admin_label" => false,  
              ),



                array(
                  "type" => "textfield",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Title Section 1", 'orane'),
                  "param_name" => "title1a",
                  "value" => __("OUR TASTY FOOD", 'orane'),
                  "admin_label" => false,
              ),

                array(
                  "type" => "textfield",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Subtitle Section 1", 'orane'),
                  "param_name" => "title1b",
                  "value" => __("ON |YOUR DOORS|", 'orane'),
                  "admin_label" => false,
              ),


                array(
                  "type" => "textfield",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Title Section 2", 'orane'),
                  "param_name" => "title2a",
                  "value" => __("CALL US", 'orane'),
                  "admin_label" => false,
              ),

                array(
                  "type" => "textfield",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Subtitle Section 2", 'orane'),
                  "param_name" => "title2b",
                  "value" => __("+0067 977 765 433", 'orane'),
                  "admin_label" => false,
              ),



              array(
                  "type" => "attach_image",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Background Image", 'orane'),
                  "param_name" => "image",
                  "description" => __("The large image in the background", 'orane'),
                  "admin_label" => false,  
              ),



              array(
                  "type" => "vc_link",
                  "holder" => "div",
                  "class" => "",
                  "heading" => __("Order Now Link", 'orane'),
                  "param_name" => "link",
                  "description" => __("The Link To The Page.", 'orane'),
                  "admin_label" => false,
              ),


              array(
                "type" => "colorpicker",
                "class" => "",
                "heading" => __( "Box Background Color", "orane" ),
                "param_name" => "bgcolor",
                "value" => '#FA7C6E', //Default Red color
                "description" => __( "Choose the background color of the text box", "orane" )
             ),




            )
        ) );
    }
    
    /*
    Shortcode logic how it should be rendered
    */
    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'   => '',
        'title1a' => 'Title',
        'title1b' => 'subtitle',
        'title2a' => 'Title',
        'title2b' => 'subtitle',
        'image'   => 'Image',
        'link'    => '',
        'logo'    => 'Image',
        'bgcolor' => '',
      ), $atts ) );

      $title1b = lineToBold($title1b);

          $imgsrc = wp_get_attachment_image_src( $image, 'full' );
          $logosrc = wp_get_attachment_image_src( $logo, 'full' );
    
          if($image == "Image"){
            $img_src = plugins_url('images/restaurant/top_bg.jpg', __FILE__);
            $imgsrc[0] = $img_src;
          }

          if($logo == "Image"){
            $logo_src = plugins_url('images/restaurant/logo.png', __FILE__);
            $logosrc[0] = $logo_src;
          }



          $link = vc_build_link($link); //parse the link
          $link_url = $link["url"];
          $link_target = $link["target"];
          $link_title = $link["title"];

          if($link == ""){
            $link_url = "#";
          }

          if($link_title == ""){
              $link_title = "ORDER NOW";
          }


          wp_enqueue_script( 'orane_parallax_highlight', plugins_url('assets/jquery.parallax-1.1.3.js', __FILE__), array('jquery') );

      $output = "<section class='orane-order-now parallax-1' style='background-image:url({$imgsrc[0]});'>
                         
                         <div class='order-now-title'>
                            <img src='{$logosrc[0]}'>
                          </div>

                  <div class='container order-box-container' style='background-color:{$bgcolor}'>                          
                    <div class='col-md-4 order-box'>
                      <h5>{$title1a}</h5>
                      <h3>{$title1b}</h3>
                    </div>
                    
                    <div class='col-md-4 order-box'>
                              <h6>{$title2a}</h6>
                              <h6>{$title2b}</h6>
                    </div>


                    <div class='col-md-4 order-box'>
                          <a href='{$link_url}' class='order-now-link'>{$link_title}</a>
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
      //wp_enqueue_style( 'orane_style' );

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

/*
function vc_theme_rating_hero($atts, $content = null) {
   return '<div><p>Prepend this div before shortcode</p></div>';
}
*/

?>