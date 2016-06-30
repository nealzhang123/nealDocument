<?php  
//Register "container" content element
vc_map( array(
    "name" => __("Features 2 Columns", "orane"),
    "description" => __("Features Section with 1 image column and 1 image column", 'orane'),
    "controls" => "full",
    "base" => "orane_features_vertical",
    "as_parent" => array('only' => 'orane_single_feature_vertical'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/0-351-table-lamp-off.png', __FILE__),
    "show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "description" => __("Features Section Title", "orane"),
            "value" => __("Our Features", 'orane'),
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __("Details", "orane"),
            "param_name" => "details",
            "description" => __("Features Section Details", "orane"),
            "value" => __("Features Section Details", 'orane')
        ),
        array(
            "type" => "attach_image",
            "holder" => "div",
            "class" => "",
            "heading" => __("Side Image", 'orane'),
            "param_name" => "image",
            //"value" => __("", 'vc_extend'),
            "description" => __("The Image on the Left Side.", 'orane')
        )


    ),
    "js_view" => 'VcColumnView'
) );

/////////////////////////////////////////////////////////////////child elements
vc_map( array(
    "name" => __("Orane Feature", "orane"),
    "base" => "orane_single_feature_vertical",
    "content_element" => true,
    "as_child" => array('only' => 'orane'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "description" => __("If you wish to style particular content element differently .", "orane"),
            "value" => __("Feature Title", 'orane'),
            "admin_label" => true,
        ),


        array(
            "type" => "orane_fontawesome_param",
            "heading" => __("Feature Icon", "orane"),
            "param_name" => "feature_icon",
            // "description" => __("Find The Icon Codes here: http://fortawesome.github.io/Font-Awesome/icons/", "orane"),
            "value" => __("fa-gears", 'orane'),
        ),



        array(
            "type" => "textarea",
            "holder" => "div",
            "class" => "",
            "heading" => __("Details", 'orane'),
            "param_name" => "details",
            "value" => __("I love this theme, it has tons of features and more.", 'orane'),
            "description" => __("Details", 'orane'),
            "admin_label" => true,
        ),
       


    )//ends params

) );//ends vc_map

////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Features_Vertical extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'   => 'title',
        'details' => 'details',
        'image'   => 'Image',
      ), $atts ) );
     

     //ipad-hand.png

      $img = wp_get_attachment_image( $image, 'full' );
      $title = lineToSpanColor($title);


      if($image == "Image"){
        $imgsrc = plugins_url('images/ipad-hand.png', __FILE__);
        $img = "<img src='{$imgsrc}' alt='ipad-in-hands'>";
      }


     $title = lineToSpanColor($title);

      $output = "<section class='why-choose'>
                        <div class='container'>
                          <div class='row'>
                            <div class='col-md-6 ipad wow fadeInLeft' data-wow-duration='1s' data-wow-delay='.4s'>
                              {$img}
                            </div>
                            
                            <div class='col-md-6 why-2 wow fadeInRight' data-wow-duration='1s' data-wow-delay='.4s'>
                              <h2>{$title}</h2>
                              <p>{$details}</p>

                              <ul class='advantages'>
                                ".do_shortcode($content)."
                              </ul>

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
class WPBakeryShortCode_Orane_Single_Feature_Vertical extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title'           => 'title',
            'details'         => 'details',
            'feature_icon'    => 'fa-gears'
          ), $atts ) );
         // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
          
          $output = "<li><a href=''><i class='fa {$feature_icon} fa-lg'></i></a> <span class='heading'>{$title}</span> <p>{$details}</p></li>";
          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>