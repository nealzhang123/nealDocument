<?php  
// Plain Hero, no images and stuff
class Orane_VC_Parallax {

        var $shortcode = 'orane_vc_parallax';
        var $title = "Parallax Banner";
        var $details = "Parallax banner with text and background image";
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
            "icon" => plugins_url('assets/icons/16-122-paper.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "orane_my_class"
            "category" => __('Orane Components', 'orane'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/orane_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                              array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "orane"),
                                    "param_name" => "title",
                                    "description" => __("The Title.", "orane"),
                                    "value" => __("We Are Orane", 'orane')
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
                                "heading" => __("Background Image", 'orane'),
                                "param_name" => "image",
                                "description" => __("The Banner Image", 'orane')
                            ),                            

                    )
        ) );
    }
    

    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'Title',
        'link' => 'Link',
        'image'   => 'Image'
      ), $atts ) );

      $img = wp_get_attachment_image( $image, 'full' );
      $imgsrc = wp_get_attachment_image_src( $image, 'full' );
      $imgsrc = $imgsrc[0];
      $title = lineToSpanColor($title);

      if($image == "Image"){
        $imgsrc = plugins_url('images/4.jpg', __FILE__);
      }

      wp_enqueue_script('orane-parallax', plugins_url('assets/parallax.js', __FILE__), array('jquery') );

      $output = "<div class='prx' style='background:url({$imgsrc}) no-repeat scroll 0 0 / cover  rgba(0, 0, 0, 0)'>
                    <div class='container'>
                        <div class='col-md-12'>
                            <ul class='px-bgs'>
                                <li id='parallax-bg6'>
                                {$title}
                                <p>{$content}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>";
      return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {

      //Load javascript at the front-end
      
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