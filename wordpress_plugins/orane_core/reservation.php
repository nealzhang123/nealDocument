<?php  
// Plain Hero, no images and stuff
class Orane_Reservation_Form {

        var $shortcode = 'orane_reservation_form';
        var $title = "Reserve A Seat";
        var $details = "Reserve A Seat With Contact Form 7";

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
            "icon" => plugins_url('assets/icons/13-161-document.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Orane Components', 'orane'),
            "params" => array(
                                        // fields for tab 1
                                        array(
                                            "type" => "textfield",
                                            "heading" => __("Title", "orane"),
                                            "param_name" => "title",
                                            "description" => __("The Title", "orane"),
                                            "value" => __("High Quality |Designs|", 'orane'),
                                            "admin_label" => true,
                                        ), 

                                        array(
                                            "type" => "textarea",
                                            "holder" => "div",
                                            "class" => "",
                                            "heading" => __("Details", 'orane'),
                                            "param_name" => "details",
                                            "value" => __("Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.", 'orane'),
                                            "description" => __("The details below the title", 'orane'),
                                            "admin_label" => false,
                                        ),


                                        array(
                                            "type" => "textfield",
                                            "heading" => __("Contact Form 7 Shortcode ID", "orane"),
                                            "param_name" => "shortcode",
                                            "description" => __("You can shortcode id from the contact form page, example: <a target='_blank' href='http://i.imgur.com/3R4lGx6.png'>screenshot</a>", "orane"),
                                            "value" => __("2", 'orane'),
                                            "admin_label" => true,
                                        ), 


                                        array(
                                          "type" => "colorpicker",
                                          "class" => "",
                                          "heading" => __( "Background Color", "orane" ),
                                          "param_name" => "bgcolor",
                                          "value" => '#EEEEEE',
                                          "description" => __( "Choose background color", "orane" )
                                       ),




                    )
        ) );
    }
    

    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'         => 'title',
        'details'       => 'details',
        'link'          => '#',
        'link_text'     => '',
        'shortcode'     => '',
        'bgcolor'       => '',
      ), $atts ) );
     // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
            
          $title = lineToSpanColor($title);


          $scode = "[contact-form-7 id='{$shortcode}' title='Untitled']";


      $output = "<section class='restaurant-reservation' style='background-color:{$bgcolor};'>
                    <div class='container'>

                            
                            <div class='row'>    
                                <div class='col-md-12'>
                                    <div class='info'>
                                        <h3 class='animated' data-animation='fadeInUp' data-animation-delay='100'>{$title}</h3>
                                        <div class='description animated' data-animation='fadeInUp' data-animation-delay='300'><p>{$details}</p></div>
                                            <div class='col-md-offset-2 col-md-8 contact-form7-reserve'>
                                                ".do_shortcode($scode)."                                                       
                                            </div>
                                    </div>
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


    public function outputTitleTrue( $title ) {
        return '<h4 class="wpb_element_title">' . __( $title, 'js_composer' ) . ' ' . $this->settings( 'logo' ) . '</h4>';
    }





}//end of class
?>