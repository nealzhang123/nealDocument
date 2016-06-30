<?php  
// Plain Hero, no images and stuff
class Orane_VC_GetStarted_Banner {

        var $shortcode = 'orane_vc_gtstarted_banner';
        var $title = "Getting Started Banner";
        var $details = "The large Getting Started Banner.";
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
            "icon" => plugins_url('assets/icons/47-149-olympics.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "orane_my_class"
            "category" => __('Orane Components', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/orane_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                              array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "orane"),
                                    "param_name" => "title",
                                    "description" => __("The Title.", "orane"),
                                    "value" => __("GROW BUSINESS", 'orane'),
                                    "admin_label" => true,
                            ),

                            array(
                                "type" => "textarea",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Details", 'orane'),
                                "param_name" => "content",
                                "value" => __("Orane is a unique and stylish template and everybody loves it. Overall designing is a good example of awesome designing. Orane gives you the feeling of love towards web designing. GO GO and Buy This Template!", 'orane'),
                                "description" => __("Details", 'orane')
                            ),

                            array(
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Background Image", 'orane'),
                                "param_name" => "image",
                                //"value" => __("", 'orane'),
                                "description" => __("The Image in the Background.", 'orane')
                            ),                            

              
                            array(
                                "type" => "vc_link",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Link To The Page", 'orane'),
                                "param_name" => "link",
                                "description" => __("The Link To The Getting Started Page.", 'orane')
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
        'title' => 'Title',
        'link' => 'Link',
        'image'   => 'Image',
        'link_title' => 'Read More',
      ), $atts ) );
     // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      
      //default image: seo-2.jpg

      $img = wp_get_attachment_image_src( $image, 'full' );
      $title = lineToSpanColor($title);


      if($image == "Image"){
        $imgsrc = plugins_url('images/seo-2.jpg', __FILE__);
        $img[0] = $imgsrc;
      }


      $link = vc_build_link($link); //parse the link
      $link = $link["url"];

      $link_text = "";
      if( !empty($link) ){
            $link_text = "<a class='btn-1' href='{$link}'>{$link_title} &nbsp;<i class='fa fa-hand-o-right '></i></a>";
      }

      //orane_add_inline_css('.seo', 'background', 'background:url({$img[0]}) no-repeat scroll 0 0 / cover  rgba(0, 0, 0, 0)');

      $output = "<section class='seo' style='background:url({$img[0]}) no-repeat scroll 0 0 / cover  rgba(0, 0, 0, 0)'>
                    <div class='container'>
                            <div class='col-md-8'>
                                <div class='box-1 shadow-1'>
                                <h2>{$title}</h2>
                                <span id='typed'></span>
                                <p>{$content}</p>
                                {$link_text}
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