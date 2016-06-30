<?php  
// Plain Hero, no images and stuff
class Orane_VC_Features_Small_Image {

        var $shortcode = 'orane_vc_features_small_image';
        var $title = "Small Single Feature Banner";
        var $details = "RESPONSIVE DESIGN Banner From The Demo.";
        //var $path = "/templates/rating_hero.php";

    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( $this->shortcode, array( $this, 'renderShortcode' ) );

        // Register CSS and JS
        //add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
    }
 
    public function integrateWithVC() {
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }
 
        vc_map( array(
            "name" => __($this->title, 'vc_extend'),
            "description" => __($this->details, 'vc_extend'),
            "base" => $this->shortcode,
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/icons/0-351-table-lamp-off.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Orane Components', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "js_composer"),
                                    "param_name" => "title",
                                    "description" => __("The Title.", "js_composer"),
                                    "value" => __("RESPONSIVE |DESIGN|", 'js_composer'),
                                    "admin_label" => true,
                            ),

                            array(
                                "type" => "textarea",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Details", 'vc_extend'),
                                "param_name" => "content",
                                "value" => __("Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.", 'vc_extend'),
                                "description" => __("Details", 'vc_extend')
                            ),

                            array(
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Side Image", 'orane'),
                                "param_name" => "image",
                                //"value" => __("", 'vc_extend'),
                                "description" => __("The Image on the Right Side.", 'orane')
                            ),

                            array(
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Background Pattern Image", 'orane'),
                                "param_name" => "image_bg",
                                //"value" => __("", 'vc_extend'),
                                "description" => __("The pattern in the background", 'orane')
                            )



                    )
        ) );
    }
    

    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'         => 'Title',
        'image'         => 'Image',
        'image_bg'		=> 'Image',
      ), $atts ) );
     // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      
      $img = wp_get_attachment_image( $image, 'full' );

      $title = lineToSpanColor($title);


    if($image == "Image"){
      $imgsrc = plugins_url('images/features-icon.png', __FILE__);
      $img = "<img src='{$imgsrc}' alt='features'>";

    }

    $img_bg = wp_get_attachment_image_src( $image_bg, 'full' );
    if($image_bg == "Image"){
      $img_bg_src = plugins_url('images/pattern/10.png', __FILE__);
      $img_bg[0] = $img_bg_src;
    }



      $strr = " ";

      $output = "<section class='features' style='background-image:url({$img_bg[0]});'>
                        <div class='container'>
                            <div class='col-md-6'>
                                <h1>{$title}</h1>
                                <p>{$content}</p>
                            </div>
                            <div class='col-md-6 wow fadeInUp' data-wow-duration='1s' data-wow-delay='.2s'>
                                {$img}
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



}//end of class
?>