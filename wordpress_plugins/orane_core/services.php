<?php  
//Register "container" content element
vc_map( array(
    "name" => __("Orane Services", "orane"),
    "description" => __("Services Section", 'orane'),
    "controls" => "full",
    "base" => "orane_services",
    "as_parent" => array('only' => 'orane_single_service'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/23-175-eye.png', __FILE__),
    "show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "js_view" => 'VcColumnView',
                "params" => array(

                                array(
                                        "type" => "attach_image",
                                        "holder" => "div",
                                        "class" => "",
                                        "heading" => __("Background Pattern Image", 'orane'),
                                        "param_name" => "image_bg",
                                        //"value" => __("", 'vc_extend'),
                                        "description" => __("The pattern in the background", 'orane'),
                                    )



                  ),
) );

//////////////child elements
vc_map( array(
    "name" => __("Orane Service", "orane"),
    "base" => "orane_single_service",
    //"icon" => plugins_url('assets/orane_logo_20.png', __FILE__),
    "content_element" => true,
    //"category" => __('Orane Components', 'orane'), //no need for this
    "as_child" => array('only' => 'orane_services'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "description" => __("If you wish to style particular content element differently .", "orane"),
            "value" => __("Service Title", 'orane'),
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __("Details", "orane"),
            "param_name" => "details",
            "description" => __("If you wish to style particular content element differently .", "orane"),
            "value" => __("Service Details", 'orane'),
        ),


       
    )//ends params

) );//ends vc_map



////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Services extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'title',
        'details' => 'details',
        'image_bg'      => 'Image',
      ), $atts ) );


    $img_bg = wp_get_attachment_image_src( $image_bg, 'full' );

    if($image_bg == "Image"){
      $img_bg_src = plugins_url('images/tiles.jpg', __FILE__);
      $img_bg[0] = $img_bg_src;
    }     


      $output = "<section class='mt-px' style='background-image:url({$img_bg[0]});'>
                    <div class='container'>
        
          ". do_shortcode($content)  . "        

        </div>
    </section>";
      
      return $output;
    }


    }//end of container class
} //end if

///////////////////////////////////////////ends container class


if ( class_exists( 'WPBakeryShortCode' ) ) {
class WPBakeryShortCode_Orane_Single_Service extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title' => 'title',
            'details' => 'details'
          ), $atts ) );
         // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
          
          $output = "<div class='col-md-4 wow fadeInLeft' data-wow-duration='1s' data-wow-delay='.6s'>
                      <div class='moving-zone'>
                        <div class='popup shadow-1'>
                          <div class='popup-content'>
                            <div class='popup-text'>
                              <h2>{$title}</h2>
                              <p>{$details}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>";
          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>