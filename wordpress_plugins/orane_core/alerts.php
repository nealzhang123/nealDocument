<?php  
// Plain Hero, no images and stuff
class Orane_VC_Alerts {

        var $shortcode = 'orane_vc_alerts';
        var $title = "Alert Messages";
        var $details = "Alert Messages with different Styles";
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
            "icon" => plugins_url('assets/icons/16-122-paper.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Orane Components', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "orane"),
                                    "param_name" => "title",
                                    "admin_label" => true,
                                    "description" => __("The Title.", "orane"),
                                    "value" => __("RESPONSIVE |DESIGN|", 'orane'),
                                    "admin_label" => true,
                            ),

                            array(
                                  "type"        => "dropdown",
                                  "heading"     => __("Type", "orane"),
                                  "param_name"  => "type",
                                  "value"       => array(
                                                        '0'   => 'Success',
                                                        '1'   => 'Danger',
                                                        '2'   => 'Info',
                                                        '3'   => 'Warning',
                                                ),
                                  "std"         => 0,
                                  "description" => __("Different Type will show up in different color combination", "orane"),
                            ),

                            array(
                                  "type"        => "dropdown",
                                  "heading"     => __("Dismissable?", "orane"),
                                  "param_name"  => "diss",
                                  "value"       => array(
                                                        '0'   => 'Yes',
                                                        '1'   => 'No',
                                                ),
                                  "std"         => 0,
                                  "description" => __("Dismissable messages can be dismissed with a close icon link", "orane"),
                            ),




                    )
        ) );
    }
    

    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'         => 'Title',
        'type'         => 'Success',
        'diss'          => 'diss',
      ), $atts ) );


      $dd = "";

      if($diss == "Yes"){
        $dd  = "alert-dismissible";
      }else{
        $dd  = "";
      }


      $type = strtolower($type);

      $output = "<div class='alerts'>
                    <div class='col-md-12 alert-1'>

                        <div class='alert alert-{$type} {$diss}' role='alert'>
                            <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
                            {$title}.
                        </div>
            
                    </div>
                </div>";
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
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
        </div>';
    }



}//end of class
?>