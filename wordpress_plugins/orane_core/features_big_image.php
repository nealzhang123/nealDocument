<?php  
// Plain Hero, no images and stuff
class Orane_VC_Features_Big_Image {

        var $shortcode = 'orane_vc_features_big_image';
        var $title = "Features With Large Sidebar Image";
        var $details = "ENDLESS POSSIBILTIES Banner From The Demo.";
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
            "category" => __('Orane Components', 'orane'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                              array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "orane"),
                                    "param_name" => "title",
                                    "description" => __("The Title.", "orane"),
                                    "value" => __("SEO Ready |Coding|", 'orane'),
                                    "admin_label" => true,
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
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Side Image", 'vc_extend'),
                                "param_name" => "image",
                                //"value" => __("", 'vc_extend'),
                                "description" => __("The Image in the left Side.", 'orane')
                            ),  

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 1", "orane"),
                                    "param_name" => "feature1",
                                    "description" => __("", "orane"),
                                    "value" => __("Get Support From High Class Professionals", 'orane')
                            ),

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 2", "orane"),
                                    "param_name" => "feature2",
                                    "description" => __("", "orane"),
                                    "value" => __("24/7 Supporting Team", 'orane')
                            ),

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 3", "orane"),
                                    "param_name" => "feature3",
                                    "description" => __("", "orane"),
                                    "value" => __("Best In Class Communication", 'orane')
                            ),
        
                            array(
                                    "type" => "textfield",
                                    "heading" => __("Feature 4", "orane"),
                                    "param_name" => "feature4",
                                    "description" => __("", "orane"),
                                    "value" => __("Advanced Troubleshooting", 'orane')
                            ),

                            array(
                                "type" => "vc_link",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Link To The Page", 'vc_extend'),
                                "param_name" => "link",
                                "description" => __("The Link To The Page.", 'vc_extend')
                            ),

                            array(
                                "type" => "textfield",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Link Text", 'orane'),
                                "param_name" => "link_title",
                                "value" => __("LEARN MORE", 'orane'),
                                "admin_label" => false,
                            ),


                    )
        ) );
    }
    

    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'         => 'Title',
        'link'          => 'Link',
        'image'         => 'Image',
        'feature1'      => 'feature1',
        'feature2'      => 'feature2',
        'feature3'      => 'feature3',
        'feature4'      => 'feature4',
        'link_title'     => '',
      ), $atts ) );
     // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      
      $img = wp_get_attachment_image( $image, 'full' );
      $title = lineToSpanColor($title);

      if($image == "Image"){
          $imgsrc = plugins_url('images/slide10.png', __FILE__);
          $img = "<img src='{$imgsrc}' alt='slide'>";
      }

      $link = vc_build_link($link); //parse the link
      $link = $link["url"];

      $link_text = "";
      if( !empty($link) ){
            $link_text = "<a class='btn-1' href='{$link}'><i class='fa fa-arrow-circle-right '></i>{$link_title}</a>";
      }

      $strr = " ";

      if($feature1 != ""){
            $strr .= "<li><i class='fa fa-star-o '></i> {$feature1}</li>";
      }

      if($feature2 != ""){
            $strr .= "<li><i class='fa fa-star-o '></i> {$feature2}</li>";
      }

      if($feature3 != ""){
            $strr .= "<li><i class='fa fa-star-o '></i> {$feature3}</li>";
      }

      if($feature4 != ""){
            $strr .= "<li><i class='fa fa-star-o '></i> {$feature4}</li>";
      }

      $output = "<section class='top-support'>
                            <div class='container'>
                                <div class='col-md-8 wow fadeInLeft' data-wow-duration='2.5s' data-wow-delay='.2s'>
                                    {$img}
                                </div>
                                
                                <div class='col-md-4 wow fadeInRight' data-wow-duration='1s' data-wow-delay='.6s'>
                                    <h2>{$title}</h2>
                                    <p>{$content}</p>
                                    <ul class='support-points'>
                                        {$strr}
                                    </ul>
                                    <div class='try-btn'>
                                        <a href='{$link}' class='tr-btn'>{$link_title}</a>
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