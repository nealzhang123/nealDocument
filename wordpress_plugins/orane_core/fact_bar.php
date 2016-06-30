<?php  
// Plain Hero, no images and stuff
class Orane_VC_Fact_Bar {

        var $shortcode = 'orane_fact_bar';
        var $title = "Fact Bar";
        var $details = "The Fact Banner With Image, Title, Details and A Link To That Fact.";
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
            "icon" => plugins_url('assets/icons/25-252-target-point.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Orane Components', 'orane'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                            array(
                                "type" => "textarea",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Title", 'orane'),
                                "param_name" => "title",
                                "value" => __("Orane is a unique and stylish template and everybody loves it. Overall designing is a good example of awesome designing. Orane gives you the feeling of love towards web designing. GO GO and Buy This Template!", 'orane'),
                                "description" => __("Details", 'orane')
                            ),

              
                            array(
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Left Side Image", 'orane'),
                                "param_name" => "image",
                                "description" => __("The Image On The Left.", 'orane')
                            ),

                            array(
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Background Image", 'orane'),
                                "param_name" => "bgimage",
                                //"value" => __("", 'orane'),
                                "description" => __("The Image in the Background.", 'orane')
                            ),


                            array(
                                "type" => "vc_link",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Fact Link", 'orane'),
                                "param_name" => "link",
                                //"value" => __("", 'orane'),
                                "description" => __("The Link To The Fact Page or An External Link.", 'orane')
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
                                "type" => "textarea_html",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Details", 'orane'),
                                "param_name" => "content",
                                "value" => __("Details ...", 'orane'),
                                "description" => __("Details About The Fact...", 'orane')
                            )

                    )
        ) );
    }
    

    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'Title',
        'link' => 'Link',
        'image'   => 'Image',
        'bgimage' => "BImage",
        "link_title" => 'Read More',
      ), $atts ) );
     // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      
      $img = wp_get_attachment_image( $image, 'full' );
      $bgimg = wp_get_attachment_image_src( $bgimage, 'full' );


      if($image == "Image"){
        $imgsrc = plugins_url('images/bulbs.png', __FILE__);
        $img = "<img src='{$imgsrc}' alt='bulbs'>";
      }


      if($bgimage == "BImage"){
        $imgsrc = plugins_url('images/px.jpg', __FILE__);
        $bgimg[0] = $imgsrc;
      }


      $link = vc_build_link($link); //parse the link
      $link = $link["url"];

      $link_text = "";
      if( !empty($link) ){
            $link_text = "<a href='{$link}' class='lrn-more'>{$link_title}</a>";
      }
      //$ti = base64_decode($title);

      $output = "<section class='ideas'  style='background:url({$bgimg[0]}) no-repeat scroll 0 0 / cover  rgba(0, 0, 0, 0)'>
                    <div class='container'>
                        <div class='col-md-4 wow fadeIn' data-wow-duration='1s' data-wow-delay='.2s'>
                            {$img}
                        </div>
                        <div class='col-md-8 idea-text wow fadeIn' data-wow-duration='1s' data-wow-delay='.4s'>
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
      //wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
      //wp_enqueue_style( 'vc_extend_style' );

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
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'orane'), $plugin_data['Name']).'</p>
        </div>';
    }



}//end of class
?>