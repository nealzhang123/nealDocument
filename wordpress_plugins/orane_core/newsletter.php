<?php  
// Plain Hero, no images and stuff
class Orane_VC_Newsletter {

        var $shortcode = 'orane_vc_newsletter';
        var $title = "Newsletter Signup";
        var $details = "Newsletter Signup Form with background image.";
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
            "name" => __($this->title,'orane'),
            "description" => __($this->details,'orane'),
            "base" => $this->shortcode,
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/icons/11-315-paper-plain.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Orane Components', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "orane"),
                                    "param_name" => "title",
                                    "description" => __("The Title.", "orane"),
                                    "value" => __("SUBSCRIBE TO OUR NEWSLETTER", 'orane'),
                                    "admin_label" => true,
                            ),


                          array(
	                            "type" => "colorpicker",
	                            "class" => "",
	                            "heading" => __( "Title color", "orane" ),
	                            "param_name" => "title_color",
	                            "value" => '#FFFFFF', //Default Red color
	                            "description" => __( "Choose title text color", "orane" )
	                         ),


                            array(
                                "type" => "textarea",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Details", 'orane'),
                                "param_name" => "content",
                                "value" => __("Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.", 'orane'),
                                "description" => __("Details", 'orane')
                            ),

                          array(
	                            "type" => "colorpicker",
	                            "class" => "",
	                            "heading" => __( "Text color", "orane" ),
	                            "param_name" => "color",
	                            "value" => '#FFFFFF', //Default Red color
	                            "description" => __( "Choose text color", "orane" )
	                         ),



                            array(
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Background Image", 'orane'),
                                "param_name" => "image",
                                //"value" => __("", 'vc_extend'),
                                "description" => __("The Image in the Background, leave blank for default", 'orane')
                            )

                    )
        ) );
    }
    

    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'         => 'Title',
        'image'         => 'Image',
        'color'			=> '#ffffff',
        'title_color'	=> '#ffffff',
      ), $atts ) );
     // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      
      $imgsrc = wp_get_attachment_image_src( $image, 'full' );
      $title = lineToSpanColor($title);


    if($image == "Image"){
      $imgsrc[0] = plugins_url('images/subscribe.jpg', __FILE__);
    }


    $mc_active = is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php');



      $strr = " ";

      if($mc_active){

            $output = "<section class='subscribe' style='background: url({$imgsrc[0]}) no-repeat scroll 0 0 / cover  rgba(0, 0, 0, 0)'>
                        <div class='container'>
                            <div class='col-md-4'>
                            </div>
                            <div class='col-md-8 subscribe-details'>
                                <h2 style='color:{$title_color}'>{$title}</h2>
                                <p style='color:{$color}'>{$content}</p>
                            </div>
                            <div class='clearfix'></div>
                            
                            <div class='row sub-in'>
                                <div class='col-md-4'>
                                </div>
                                    ".do_shortcode('[mc4wp_form]')."
                            </div>
                        </div>
                </section>";

        }else{

            $output = "<section class='subscribe' style='background: url({$imgsrc[0]}) no-repeat scroll 0 0 / cover  rgba(0, 0, 0, 0)'>
                        <div class='container'>
                            <div class='col-md-4'>
                            </div>
                            <div class='col-md-8 subscribe-details'>
                                <h2>{$title}</h2>
                                <p>{$content}</p>
                            </div>
                            <div class='clearfix'></div>
                            
                            <div class='row sub-in'>
                                <div class='col-md-4'>
                                </div>
                                    ".__('Mailchimp needs to be installed', 'orane')."
                            </div>
                        </div>
                </section>";

        }        


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