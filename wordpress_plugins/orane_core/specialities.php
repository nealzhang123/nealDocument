<?php  
//Register "container" content element
vc_map( array(
    "name" => __("Orane Specialities", "orane"),
    "description" => __("Specialities Section", 'orane'),
    "controls" => "full",
    "base" => "orane_special",
    "as_parent" => array('only' => 'orane_single_special'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/46-400-mustache.png', __FILE__),
    "show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "admin_label" => true,
            "description" => __("Features Section Title", "orane"),
            "value" => __("Our Specialities", 'orane')
        ),
        array(
            "type" => "textarea",
            "heading" => __("Details", "orane"),
            "param_name" => "details",
            "description" => __("Details", "orane"),
            "value" => __("Details", 'orane'),
        ),

        array(
            "type" => "attach_image",
            "holder" => "div",
            "class" => "",
            "heading" => __("Background Pattern Image", 'orane'),
            "param_name" => "image",
            "description" => __("The Pattern in the Background", 'orane')
        ), 


    ),
    "js_view" => 'VcColumnView'
) );

//////////////child elements
vc_map( array(
    "name" => __("Speciality", "orane"),
    "base" => "orane_single_special",
    //"icon" => plugins_url('assets/orane_logo_20.png', __FILE__),
    "content_element" => true,
    //"category" => __('Orane Components', 'orane'), //no need for this
    "as_child" => array('only' => 'orane_special'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "admin_label" => true,
            "param_name" => "title",
            "description" => __("speciality Name", "orane"),
            "value" => __("Photoshop", 'orane')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Details", "orane"),
            "admin_label" => true,
            "param_name" => "details",
            "description" => __("Percentage Value (without the % sign)", "orane"),
            "value" => __("90", 'orane')
        )
       
    )//ends params

) );//ends vc_map



////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Special extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'title',
        'details' => 'details',
        'image'     => 'image',
      ), $atts ) );
        

      $imgsrc = wp_get_attachment_image_src( $image, 'full' );
      $imgsrc = $imgsrc[0];

      if($image == "image"){
        $imgsrc = plugins_url('images/pattern/1.png', __FILE__);
      }



    wp_enqueue_script('orane-easypie', plugins_url('assets/waypoints.min.js', __FILE__), array('jquery') );
    wp_enqueue_script('orane-waypoint', plugins_url('assets/jquery.easypiechart.min.js', __FILE__), array('jquery') );


      $title = lineToSpanColor($title);

      $output = "<section class='specialities' style='background:url({$imgsrc}) repeat scroll 0 0 rgba(0, 0, 0, 0)' >
                    <div class='container'>
                    
                          <div class='col-md-12 tag-heading'>
                            <h2>{$title}</h2>
                            <p>{$details}</p>
                          </div>
                  
                          <div class='row piecharts'  id='pie-charts'>
        
                             ". do_shortcode($content)  . "        

                          </div>

                    </div>
              </section>";
      
      return $output;
    }


    }//end of container class
} //end if

///////////////////////////////////////////ends container class


if ( class_exists( 'WPBakeryShortCode' ) ) {
class WPBakeryShortCode_Orane_Single_Special extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title' => 'Title',
            'details' => '90'
          ), $atts ) );
         // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
          
          $output = "<div class='col-md-3'>
                        <span class='chart blue-circle' data-percent='{$details}' data-delay='100'>
                            <span class='percent'></span>
                            <span class='skill-name'>{$title}</span>
                        </span>
                     </div>";
          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>