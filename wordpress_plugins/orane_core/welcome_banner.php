<?php  
// Plain Hero, no images and stuff
class Orane_VC_Welcome_Banner {

        var $shortcode = 'orane_welcome_banner';
        var $title = "Welcome Banner";
        var $details = "The Welcome Banner With Large Image At The Bottom.";
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
            "icon" => plugins_url('assets/icons/34-337-golf.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Orane Components', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                              array(
                                "type" => "textarea",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Title", 'orane'),
                                "param_name" => "title",
                                "value" => __("|ADORABLE| & |UNIQUE| CONCEPT", 'orane'),
                                "description" => __("Title", 'orane'),
                                
                            ),

                            array(
                                "type" => "textarea",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Details", 'orane'),
                                "param_name" => "details",
                                "value" => __("Orane is a unique and stylish template and everybody loves it. Overall designing is a good example of awesome designing. Orane gives you the feeling of love towards web designing. GO GO and Buy This Template!", 'orane'),
                                "description" => __("Details", 'orane')
                            ),

              
                              array(
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Image", 'orane'),
                                "param_name" => "image",
                                //"value" => __("", 'vc_extend'),
                                "description" => __("The Image Under The Welcome Banner.", 'orane')
                            )



                    )
        ) );
    }
    

    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'Title',
        'details' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut recusandae, nobis? Modi quas, veritatis nesciunt id debitis, hic voluptatem eius cupiditate optio ut itaque fuga est, corrupti repellat fugit repellendus!',
        'image'   => 'Image'
      ), $atts ) );
     // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      
      $img = wp_get_attachment_image( $image, 'full' );
      $title = lineToSpanColor($title);

      //if no image uploaded
      if($image == "Image"){
        $imgsrc = plugins_url('images/imacs-2.png', __FILE__);
        $img = "<img src='{$imgsrc}' alt='imac'>";
      }


      $output = "<section class='welcome'>
                  <div class='container'>
                    <div class='col-md-12 wow fadeIn' data-wow-duration='1s' data-wow-delay='.4s'>
                      <h2>{$title}</h2>
                      <p>{$details}</p>
                    </div>    
                    <div class='col-md-12 wow fadeInUp' data-wow-duration='1s' data-wow-delay='.4s'>
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