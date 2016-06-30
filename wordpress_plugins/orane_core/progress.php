<?php  
//Register "container" content element

vc_map( array(
    "name" => __("Progress Bars", "orane"),
    "description" => __("Horizontal Progress Bars", 'orane'),
    "controls" => "full",
    "base" => "orane_progress",
    "as_parent" => array('only' => 'orane_single_progress'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/47-149-olympics.png', __FILE__),
    "show_settings_on_create" => false,
    "category" => __('Orane Components', 'orane'),
    "js_view" => 'VcColumnView'
) );

/////////////////////////////////////////////////////////////////child elements
vc_map( array(
                "name" => __("Progress Bar Item", "orane"),
                "base" => "orane_single_progress",
                //"icon" => plugins_url('assets/orane_logo_20.png', __FILE__),
                "content_element" => true,
                //"category" => __('Orane Components', 'orane'), //no need for this
                "as_child" => array('only' => 'orane_progress'), // Use only|except attributes to limit parent (separate multiple values with comma)
                "params" => array(
                                  // add params same as with any other content element
                                  array(
                                      "type" => "textfield",
                                      "heading" => __("Title", "orane"),
                                      "param_name" => "title",
                                      "description" => __("The Feature.", "orane"),
                                      "value" => __("WordPress", 'orane'),
                                      "admin_label" => true,
                                  ),
                                  array(
                                      "type" => "textfield",
                                      "heading" => __("Percentage", "orane"),
                                      "param_name" => "percent",
                                      "description" => __("Progress Percentage(without the percentage sign)", "orane"),
                                      "value" => __("90", 'orane'),
                                      "admin_label" => true,
                                  ),


                  )//ends params

) );//ends vc_map

////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Progress extends WPBakeryShortCodesContainer {

            public function content( $atts, $content = null ) {
              extract( shortcode_atts( array(
                    'title'     => 'title',
              ), $atts ) );
             

             $title = lineToSpanColor($title);    


              $output = "<div class='container'><div class='col-md-12 p-bar-1'>
                            
                              ".do_shortcode($content)."

                        </div></div>";
              
              return $output;
            }


    }//end of container class
} //end if

///////////////////////////////////////////ends container class


if ( class_exists( 'WPBakeryShortCode' ) ) {
      class WPBakeryShortCode_Orane_Single_Progress extends WPBakeryShortCode {


              public function content( $atts, $content = null ) {
              
                extract( shortcode_atts( array(
                  'title' => 'title',
                  'percent'    => '100'
                ), $atts ) );
               // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
                
                $output = "<div class='progress'>
                                <div class='progress-bar progress-bar-warning' role='progressbar' aria-valuenow='{$percent}' aria-valuemin='0' aria-valuemax='100' style='width: {$percent}%;'>
                                {$title} - {$percent}%
                                </div>
                          </div>";
                return $output;
              }


      }//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>