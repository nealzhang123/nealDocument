<?php  
//Register "container" content element
vc_map( array(
    "name" => __("Restaurant - Menu Carousel", "orane"),
    "description" => __("Restaurant Menu Carousel", 'orane'),
    "controls" => "full",
    "base" => "orane_restaurant_menu",
    "as_parent" => array('only' => 'orane_restaurant_menu_single'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
                                  //"value" => __("", 'orane'),
                                  "description" => __("The pattern in the background", 'orane'),
                              ),

                           array(
                                "type" => "textfield",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Title", 'orane'),
                                "param_name" => "title",
                                "value" => __("Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.", 'orane'),
                                "description" => __("The Menu Title", 'orane')
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
                            "type" => "vc_link",
                            "holder" => "div",
                            "class" => "",
                            "heading" => __("Link To The Page", 'orane'),
                            "param_name" => "link",
                            "description" => __("The Link To The Page.", 'orane')
                        ), 


                        array(
                          "type" => "colorpicker",
                          "class" => "",
                          "heading" => __( "Text Color", "orane" ),
                          "param_name" => "color",
                          "value" => '#333333', //Default Red color
                          "description" => __( "Choose text color", "orane" )
                       ),


            ),
) );

//////////////child elements
vc_map( array(
    "name" => __("Resturant Menu Item", "orane"),
    "base" => "orane_restaurant_menu_single",
    //"icon" => plugins_url('assets/orane_logo_20.png', __FILE__),
    "content_element" => true,
    //"category" => __('Orane Components', 'orane'), //no need for this
    "as_child" => array('only' => 'orane_restaurant_menu'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
         array(
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => __("Item Image", 'orane'),
                "param_name" => "image",
                //"value" => __("", 'orane'),
                "description" => __("The Menu Item Image", 'orane'),
            ),      


        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "description" => __("Item Name", "orane"),
            "value" => __("Pizza", 'orane'),
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __("Details", "orane"),
            "param_name" => "details",
            "description" => __("If you wish to style particular content element differently .", "orane"),
            "value" => __("Onions, Cheese", 'orane'),
            "admin_label" => false,
        ),

        array(
            "type" => "textfield",
            "heading" => __("Price", "orane"),
            "param_name" => "price",
            "description" => __("The Price", "orane"),
            "value" => __("$10", 'orane'),
            "admin_label" => false,
        ),


        // array(
        //     "type" => "vc_link",
        //     "holder" => "div",
        //     "class" => "",
        //     "heading" => __("Link To The Item", 'orane'),
        //     "param_name" => "link",
        //     "description" => __("The Link To The Page.", 'orane')
        // ), 



       
    )//ends params

) );//ends vc_map



////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Restaurant_Menu extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'title',
        'details' => 'details',
        'image_bg'      => 'Image',
        'color'       => '',
      ), $atts ) );

    
    $img_bg = wp_get_attachment_image_src( $image_bg, 'full' );

    if($image_bg == "Image"){
      $img_bg_src = plugins_url('images/restaurant/menu_bg.jpg', __FILE__);
      $img_bg[0] = $img_bg_src;
    }     


      wp_enqueue_script( 'orane_owl_carousel', plugins_url('assets/owl-carousel/owl.carousel.min.js', __FILE__), array('jquery') );
      wp_enqueue_script( 'orane_owl_carousel_custom', plugins_url('assets/owl-carousel/menu-carousel.js', __FILE__), array('jquery') );
      wp_enqueue_script( 'orane_parallax_highlight', plugins_url('assets/jquery.parallax-1.1.3.js', __FILE__), array('jquery') );



      $title = lineToSpanColor($title);
      $output = "<style>.restaurant-menu p{color:{$color};}</style>
                  <section class='restaurant-menu' style='background-image:url({$img_bg[0]});'>
                    <div class='container'>
                          <div class='col-md-4'>
                              <h3>{$title}</h3>
                              <p>{$details}</p>
                          </div>
                            
                            <div class='col-md-8'>
                                  <div id='owl-demo' class='menu-carousel-container owl-carousel owl-theme'>
                                        
                                        ".do_shortcode($content)."  

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
class WPBakeryShortCode_Orane_Restaurant_Menu_Single extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title' => 'title',
            'details' => 'details',
            'price'   => 'price',
            'image'   => 'Image',
          ), $atts ) );

          $img = wp_get_attachment_image_src( $image, 'port-size' );

          if($image == "Image"){

            $img_bg_src = plugins_url('images/restaurant/300x200.jpg', __FILE__);
            $img[0] = $img_bg_src;
          }   
          
          $output = "<div class='item'>
                            <figure>
                              <img src='{$img[0]}' class='img-responsive' />
                              <figcaption>
                                <h2>{$title}</h2>
                                <p>{$details}</p>
                                <a href='#'>{$price}</a>
                              </figcaption>
                            </figure>
                          </a>
                    </div>";
          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>