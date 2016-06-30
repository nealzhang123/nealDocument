<?php  
//Register "container" content element
vc_map( array(
    "name" => __("Simple Testimonials", "orane"),
    "description" => __("Plain and Simple Testimonials", 'orane'),
    "controls" => "full",
    "base" => "orane_simple_testimonials",
    "as_parent" => array('only' => 'orane_simple_testimonials_single'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/23-175-eye.png', __FILE__),
    "show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "js_view" => 'VcColumnView',
    "params" => array(

        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "description" => __("Testimonials Top Title", "orane"),
            "value" => __("What Our |Clients| Say?", 'orane'),
            "admin_label" => true,
        ), 

          array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => __( "background color", "orane" ),
            "param_name" => "color",
            "value" => '#EEEEEE',
            "description" => __( "Choose background color", "orane" )
         ),


    ),

));//ends vc_map

//////////////child elements
vc_map( array(
    "name" => __("Testimonial", "orane"),
    "base" => "orane_simple_testimonials_single",
    "content_element" => true,
    "as_child" => array('only' => 'orane_simple_testimonials'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(

        array(
            "type" => "textfield",
            "heading" => __("Client Name", "orane"),
            "param_name" => "title",
            "description" => __("Client Title and Position", "orane"),
            "value" => __("John Doe - Doe Designs", 'orane'),
            "admin_label" => true,
        ), 

        array(
            "type" => "textarea",
            "holder" => "div",
            "class" => "",
            "heading" => __("The tesimonial", 'orane'),
            "param_name" => "details",
            "value" => __("Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.", 'orane'),
            "description" => __("The Details", 'orane'),
            "admin_label" => false,
        ),
       
    )//ends params

) );//ends vc_map



////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_orane_Simple_Testimonials extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'title',
        'color' => '',
      ), $atts ) );


      $title = lineToSpanColor($title);

      wp_enqueue_script( 'orane_owl_carousel', plugins_url('assets/owl-carousel/owl.carousel.min.js', __FILE__), array('jquery') );
      wp_enqueue_script( 'orane_owl_carousel_custom', plugins_url('assets/owl-carousel/menu-carousel.js', __FILE__), array('jquery') );
      wp_enqueue_script( 'orane_parallax_highlight', plugins_url('assets/jquery.parallax-1.1.3.js', __FILE__), array('jquery') );



      $output = "<div class='testimonials' style='background-color:{$color};'>
                    <div class='row'>
                        <div class='col-lg-10 col-lg-offset-1 info'>
                            <h3 class='animated' data-animation='fadeInUp' data-animation-delay='100'>{$title}</h3>
                            <div class='testimonial-carousel col-xs-10 col-xs-offset-1 animated' data-animation='flipInX' data-animation-delay='300'>
                  " . do_shortcode($content) . "        
                          </div>
                        </div>
                    </div>
                </div>";
      
      return $output;
    }


    }//end of container class
} //end if

///////////////////////////////////////////ends container class


if ( class_exists( 'WPBakeryShortCode' ) ) {
class WPBakeryShortCode_orane_Simple_Testimonials_Single extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title'   => 'title',
            'details' => 'details',
          ), $atts ) );
          
          $output = "<div>
                        
                        <div class='description'>{$details}</div>
                        <div class='name'>{$title}</div>
                        
                    </div>";

          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>