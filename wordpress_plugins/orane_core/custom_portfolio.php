<?php  
//Register "container" content element
vc_map( array(
    "name" => __("Custom Portfolio", "orane"),
    "description" => __("Custom Portfolio Section", 'orane'),
    "controls" => "full",
    "base" => "orane_custom_portfolio",
    "as_parent" => array('only' => 'orane_custom_portfolio_single'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/23-175-eye.png', __FILE__),
    "show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "js_view" => 'VcColumnView',
                "params" => array(

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "orane"),
                                    "param_name" => "title",
                                    "description" => __("The Title.", "orane"),
                                    "value" => __("RESPONSIVE |DESIGN|", 'orane'),
                                    "admin_label" => true,
                            ),

                            array(
                                "type" => "textarea",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Details", 'orane'),
                                "param_name" => "details",
                                "value" => __("Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.", 'orane'),
                                "description" => __("Details", 'orane')
                            ),

                            array(
                              "type" => "colorpicker",
                              "class" => "",
                              "heading" => __( "Background Color", "orane" ),
                              "param_name" => "bgcolor",
                              "value" => '#FA7C6E',
                              "description" => __( "Choose background color", "orane" )
                           ),





                  ),
) );

//////////////child elements
vc_map( array(
    "name" => __("Portfolio Item", "orane"),
    "base" => "orane_custom_portfolio_single",
    //"icon" => plugins_url('assets/orane_logo_20.png', __FILE__),
    "content_element" => true,
    //"category" => __('Orane Components', 'orane'), //no need for this
    "as_child" => array('only' => 'orane_custom_portfolio'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "value" => __("Item Title", 'orane'),
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __("Details", "orane"),
            "param_name" => "details",
            "value" => __("Item Details", 'orane'),
        ),


        array(
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => __("Portfolio Item Image", 'orane'),
                "param_name" => "image",
                //"value" => __("", 'vc_extend'),
            ),

       
    )//ends params

) );//ends vc_map



////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Custom_Portfolio extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'title',
        'details' => 'details',
        'bgcolor'   => '',
      ), $atts ) );

      $title = lineToBold($title);
     wp_enqueue_script('orane-portfolio', plugins_url('assets/isotope.pkgd.min.js', __FILE__), array('jquery') );
     wp_enqueue_script('orane-debounce', plugins_url('assets/jquery.debouncedresize.js', __FILE__), array('jquery') );
     wp_enqueue_script('orane-magnificpopup', plugins_url('assets/jquery.magnific-popup.js', __FILE__), array('jquery') );
     wp_enqueue_script('orane-custom-js', plugins_url('assets/vc_extend.js', __FILE__), array('jquery') );

      $output = "<section class='orane-custom-portfolio' style='background-color:{$bgcolor};'>
                    <div class='container'>
                        <div class='col-md-12 tag-heading'>
                            <h2>{$title}</h2>
                            <p>{$details}</p>
                        </div>
                    </div>
                    <div class='container'>
                      <div class='row'>
                      <div class='col-md-12 custom-portfolio'>
                      
                        ". do_shortcode($content)  . "        

                      </div>
                    </div>
                  </div>
              </section>";
      
      return $output;
    }


    }//end of container class
} //end if

///////////////////////////////////////////ends container class


if ( class_exists( 'WPBakeryShortCode' ) ) {
class WPBakeryShortCode_Orane_Custom_Portfolio_Single extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title' => 'title',
            'details' => 'details',
            'image'      => 'Image',
          ), $atts ) );

          $img_full = wp_get_attachment_image_src( $image, 'full' );
          $img_thumb = wp_get_attachment_image_src( $image, 'port-size' ); 

          if($image == "Image"){
            $img_thumb_src = plugins_url('images/restaurant/300x200.jpg', __FILE__);
            $img_thumb[0] = $img_thumb_src;
            $img_full[0] = $img_thumb_src;
          } 

          
          $output = "<div class='orane-portfolio portfolio-slideup'>
                            <div class='port_item port_item-third'>
                                <a href='#' class='itemzoom_outer'><img src='{$img_thumb[0]}'></a>
                                <a href='{$img_full[0]}' title='{$title}' class='itemzoom item-mag'></a>
                                <div class='mask'>
                                    <h2>{$title}</h2>
                                </div>
                            </div>
                    </div>
                    ";
          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>