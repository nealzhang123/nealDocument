<?php  
// Plain Hero, no images and stuff
class Orane_VC_Banner_Side_Image {

        var $shortcode = 'orane_vc_banner_side_image';
        var $title = "Banner With Sidebar Image";
        var $details = "The SEO Ready Coding Banner From The Demo.";
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
            "name" => __($this->title, 'orane'),
            "description" => __($this->details, 'orane'),
            "base" => $this->shortcode,
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/icons/9-413-monitar.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "orane_my_class"
            "category" => __('Orane Components', 'orane'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/orane_admin.css', __FILE__)), // This will load css file in the VC backend editor
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
                                "heading" => __("Side Image", 'orane'),
                                "param_name" => "image",
                            
                                "description" => __("The Image in the left Side.", 'orane')
                            ),                            

              
                            array(
                                "type" => "vc_link",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Link To The Page", 'orane'),
                                "param_name" => "link",
                                "description" => __("The Link To The Page.", 'orane')
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
        'title' => 'Title',
        'link' => 'Link',
        'image'   => 'Image',
        'link_title' => '',
        'image_bg'    => 'Image',
      ), $atts ) );
     // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content



      $img = wp_get_attachment_image( $image, 'full' );
      $title = lineToSpanColor($title);

      if($image == "Image"){
        $imgsrc = plugins_url('images/seo-2.png', __FILE__);
        $img = "<img src='{$imgsrc}' alt='bulbs'>";
      }


    $img_bg = wp_get_attachment_image_src( $image_bg, 'full' );

    if($image_bg == "Image"){
      $img_bg_src = plugins_url('images/pattern/10.png', __FILE__);
      $img_bg[0] = $img_bg_src;
    }


      $link = vc_build_link($link); //parse the link
      $link = $link["url"];

      $link_text = "";
      if( !empty($link) ){
            $link_text = "<a class='btn-1' href='{$link}'><i class='fa fa-arrow-circle-right '></i> {$link_title}</a>";
      }

      $output = "<section class='seo-2' style='background-image:url({$img_bg[0]});'>
                    <div class='container'>
                        <div class='col-md-7 wow fadeIn' data-wow-duration='1s' data-wow-delay='.6s'>
                            {$img}
                        </div>
                        
                        <div class='col-md-5 wow fadeInRight' data-wow-duration='1s' data-wow-delay='.6s'>
                            <h2>{$title}</h2>
                            <p>{$content}</p>
                            {$link_text}
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



}//end of class
?>