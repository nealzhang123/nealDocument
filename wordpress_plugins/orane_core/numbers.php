<?php  
//Register "container" content element
vc_map( array(
    "name" => __("Orane Magical Numbers", "orane"),
    "description" => __("Magical Numbers Section", 'orane'),
    "controls" => "full",
    "base" => "orane_magical",
    "as_parent" => array('only' => 'orane_single_magical'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/1-56-monitor-graph-up.png', __FILE__),
    "show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "description" => __("Magical Numbers Section Title", "orane"),
            "value" => __("Some Facts About Us", 'orane'),
            "admin_label" => true,
        ),
    ),
    "js_view" => 'VcColumnView'
) );

//////////////child elements
vc_map( array(
    "name" => __("Fact", "orane"),
    "base" => "orane_single_magical",
    //"icon" => plugins_url('assets/orane_logo_20.png', __FILE__),
    "content_element" => true,
    //"category" => __('Orane Components', 'orane'), //no need for this
    "as_child" => array('only' => 'orane_magical'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "admin_label" => true,
            "param_name" => "title",
            "description" => __("Stat Title", "orane"),
            "value" => __("Photoshop", 'orane')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Stat Details", "orane"),
            "param_name" => "details",
            "admin_label" => true,
            "description" => __("Enter A Number", "orane"),
            "value" => __("100", 'orane')
        )
       
    )//ends params

) );//ends vc_map



////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Magical extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'title',
      ), $atts ) );
     
      $title = lineToBold($title);

          $output = "<section class='numbers'>
                        <div class='container'>
                            <div class='row'>
                                    <div class='col-md-12'>
                                        <h1>{$title}</h1>
                                    </div>
                                    <div class='clearfix'></div>
                                    
                                    <div class='magical-numbers'>
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
class WPBakeryShortCode_Orane_Single_Magical extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title' => 'title',
            'details' => 'details'
          ), $atts ) );
         // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
          
          $output = "
                            <div class='col-md-4'>
                                <span class='counter' style='display: inline-block;'>{$details}</span>
                                <span class='counter-text'> - {$title}</span>
                            </div>
                    ";
          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>