<?php  
//Register "container" content element
class Orane_VC_Features_BGImage {

        var $shortcode = 'orane_vc_features_bgimage';
        var $title = "Features With Background Image";
        var $details = "Features Banner With Background Image in the Middle.";
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
            "icon" => plugins_url('assets/icons/28-283-gear.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Orane Components', 'orane'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "orane"),
                                    "param_name" => "title",
                                    "description" => __("The Title.", "orane"),
                                    "value" => __("Say Hello To |The Most| Unique |HTML5| Template", 'orane'),
                                    "admin_label" => true,
                            ),

                            array(
                                "type" => "textarea",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Details", 'orane'),
                                "param_name" => "content",
                                "value" => __("Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.", 'vc_extend'),
                                "description" => __("Details", 'orane')
                            ),

                            array(
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Center Image", 'orane'),
                                "param_name" => "image",
                                "description" => __("The Image in the Middle.", 'orane')
                            ),                            



//////////////////////////////////////////     
                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 1 (Left)", "orane"),
                                    "param_name" => "feature1l",
                                    "description" => __("Feature.", "orane"),
                                    "value" => __("Most Powerful Concept", 'orane')
                            ),

                            array(
                                "type" => "orane_fontawesome_param",
                                "heading" => __("Feature 1 Icon", "orane"),
                                "param_name" => "icon1l",
                                "description" => __("The Icon For This Feature.", "orane"),
                                "value" => "fa-empire",
                            ),
////////////////////////////////////////




/////////////////////////////////////////
                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 2 (Left)", "orane"),
                                    "param_name" => "feature2l",
                                    "description" => __("Feature.", "orane"),
                                    "value" => __("3D Testimonial Slider", 'orane')
                            ),

                            array(
                                "type" => "orane_fontawesome_param",
                                "heading" => __("Feature 2 Icon", "orane"),
                                "param_name" => "icon2l",
                                "description" => __("", "orane"),
                                "value" => "fa-cube",
                            ),
////////////////////////////////////////




//////////////////////////////////////////
                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 3 (Left)", "orane"),
                                    "param_name" => "feature3l",
                                    "description" => __("Feature.", "orane"),
                                    "value" => __("Font Awesome 4.1", 'orane')
                            ),

                            array(
                                "type" => "orane_fontawesome_param",
                                "heading" => __("Feature Icon", "orane"),
                                "param_name" => "icon3l",
                                "description" => __("", "orane"),
                                "value" => "fa-cube",
                            ),
///////////////////////////////////////



//////////////////////////////////////////
                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 4 (Left)", "orane"),
                                    "param_name" => "feature4l",
                                    "description" => __("Feature.", "orane"),
                                    "value" => __("Unique Design", 'orane')
                            ),

                            array(
                                "type" => "orane_fontawesome_param",
                                "heading" => __("Feature Icon", "orane"),
                                "param_name" => "icon4l",
                                "description" => __("", "orane"),
                                "value" => "fa-cube",
                            ),
///////////////////////////////////////




//////////////////////////////////////////
                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 1 (Right)", "orane"),
                                    "param_name" => "feature1r",
                                    "description" => __("Feature.", "orane"),
                                    "value" => __("Most Powerful Support", 'orane')
                            ),

                            array(
                                "type" => "orane_fontawesome_param",
                                "heading" => __("Feature Icon", "orane"),
                                "param_name" => "icon1r",
                                "description" => __("Most Powerful Support", "orane"),
                                "value" => "fa-cube",
                            ),
///////////////////////////////////////



//////////////////////////////////////////
                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 2 (Right)", "orane"),
                                    "param_name" => "feature2r",
                                    "description" => __("Feature.", "orane"),
                                    "value" => __("Eye Catching Design", 'orane')
                            ),

                            array(
                                "type" => "orane_fontawesome_param",
                                "heading" => __("Feature Icon", "orane"),
                                "param_name" => "icon2r",
                                "description" => __("", "orane"),
                                "value" => "fa-cube",
                            ),
///////////////////////////////////////


//////////////////////////////////////////
                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 3 (Right)", "orane"),
                                    "param_name" => "feature3r",
                                    "description" => __("Feature.", "orane"),
                                    "value" => __("Google Web Font", 'orane')
                            ),

                            array(
                                "type" => "orane_fontawesome_param",
                                "heading" => __("Feature Icon", "orane"),
                                "param_name" => "icon3r",
                                "description" => __("", "orane"),
                                "value" => "fa-cube",
                            ),
///////////////////////////////////////


//////////////////////////////////////////
                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 4 (Right)", "orane"),
                                    "param_name" => "feature4r",
                                    "description" => __("Feature.", "orane"),
                                    "value" => __("HTML5/CSS3", 'orane')
                            ),

                            array(
                                "type" => "orane_fontawesome_param",
                                "heading" => __("Feature Icon", "orane"),
                                "param_name" => "icon4r",
                                "description" => __("", "orane"),
                                "value" => "fa-cube",
                            ),
///////////////////////////////////////

                    )
        ) );
    }
    

    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'           => 'Title',
        'image'           => 'Image',

        'feature1l'       => 'Feature 1 (Left)',
        'icon1l'       => 'Icon 1 (Left)',

        'feature2l'       => 'Feature 2 (Left)',
        'icon2l'       => 'Icon 2 (Left)',

        'feature3l'       => 'Feature 3 (Left)',
        'icon3l'       => 'Icon 3 (Left)',

        'feature4l'       => 'Feature 4 (Left)',
        'icon4l'       => 'Icon 4 (Left)',

        'feature1r'       => 'Feature 1 (Right)',
        'icon1r'       => 'Icon 1 (Right)',

        'feature2r'       => 'Feature 2 (Right)',
        'icon2r'       => 'Icon 2 (Right)',

        'feature3r'       => 'Feature 3 (Right)',
        'icon3r'       => 'Icon 3 (Right)',

        'feature4r'       => 'Feature 4 (Right)',
        'icon4r'       => 'Icon 4 (Right)'


      ), $atts ) );
     // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      
      $img = wp_get_attachment_image_src( $image, 'full' );
      $title = lineToSpanColor($title);



      if($image == "Image"){
        $imgsrc = plugins_url('images/macs.png', __FILE__);
        $img[0] = $imgsrc;
      }


      $output = "<section class='macs'>
                    <div class='container'>
                      <div class='wow fadeIn' data-wow-duration='1s' data-wow-delay='.6s'>
                      <h2>{$title}</h2>
                      <p>{$content}</p>
                      </div>
                      
                      <div class='row gap'>
                      <div class='col-md-3'>
                        <ul class='right-ul'>
                          <li class='wow fadeInLeft' data-wow-duration='1s' data-wow-delay='.6s'><i class='fa {$icon1l} '></i> {$feature1l} </li>
                          <li class='wow fadeInLeft' data-wow-duration='1s' data-wow-delay='.8s'><i class='fa {$icon2l} '></i> {$feature2l} </li>
                          <li class='wow fadeInLeft' data-wow-duration='1s' data-wow-delay='1s'><i class='fa {$icon3l} '></i> {$feature3l}</li>
                          <li class='wow fadeInLeft' data-wow-duration='1s' data-wow-delay='1.2s'><i class='fa {$icon4l} '></i> {$feature4l} </li>
                        </ul>
                      </div>
                      
                      <div class='col-md-6 wow fadeInUp' data-wow-duration='1s' data-wow-delay='.4s'>
                        <img class='mac' src='{$img[0]}' alt='' />
                      </div>
                      
                      <div class='col-md-3'>
                        <ul class='left-ul'>
                          <li class='wow fadeInRight' data-wow-duration='1s' data-wow-delay='.6s'> {$feature1r} <i class='fa {$icon1r} '></i></li>
                          <li class='wow fadeInRight' data-wow-duration='1s' data-wow-delay='.8s'> {$feature2r} <i class='fa {$icon2r} '></i></li>
                          <li class='wow fadeInRight' data-wow-duration='1s' data-wow-delay='1s'> {$feature3r} <i class='fa {$icon3r} '></i></li>
                          <li class='wow fadeInRight' data-wow-duration='1s' data-wow-delay='1.2s'> {$feature4r} <i class='fa {$icon4r} '></i></li>
                        </ul>
                      </div>

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