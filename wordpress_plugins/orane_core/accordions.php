<?php  
//Register "container" content element

vc_map( array(
    "name" => __("Orane Accordions", "orane"),
    "description" => __("Accordions and Toggles", 'orane'),
    "controls" => "full",
    "base" => "orane_accord",
    "as_parent" => array('only' => 'orane_single_accord'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/16-122-paper.png', __FILE__),
    "show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "js_view" => 'VcColumnView',
    "params" => array(
        array(
            "type" => "dropdown",
            "heading" => __("Type", "orane"),
            "param_name" => "type",
            "admin_label" => true,
            "description" => __("Type Of Accordion", "orane"),
            "value" => array( 
                          "Accordion"     => "a-t",
                          "Toggle"        => "a-t-2",
                          ),//will add more
                        "std" => "a-t"
        ),

    ),
) );

/////////////////////////////////////////////////////////////////child elements
vc_map( array(
    "name" => __("Accordion Item", "orane"),
    "base" => "orane_single_accord",
    "content_element" => true,
    "as_child" => array('only' => 'orane_accord'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "description" => __("The Title Of The Accordion", "orane"),
            "value" => __("Accordion Title", 'orane'),
            "admin_label" => true,
        ),

        array(
            "type" => "textarea",
            "holder" => "div",
            "class" => "",
            "heading" => __("Details", 'orane'),
            "param_name" => "content",
            "value" => __("Accordion Details", 'orane'),
            "description" => __("Details", 'orane'),
            
        ),

    )//ends params

) );//ends vc_map

////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Accord extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'title',
        'details' => 'details',
        'type'    => 'a-t'
      ), $atts ) );
     

     $title = lineToSpanColor($title);

      $output = "<div class='col-md-12 {$type}'>
                    <div class='panel-group' id='accordion'>
                      ".do_shortcode($content)."
                    </div>
                </div>";
      
      return $output;
    }


    }//end of container class
} //end if

///////////////////////////////////////////ends container class


if ( class_exists( 'WPBakeryShortCode' ) ) {
class WPBakeryShortCode_Orane_Single_Accord extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title' => 'title',
            'details' => 'details',
          ), $atts ) );
         // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
          $aid = rand();
          $output = "<div class='panel panel-default'>
                        <div class='panel-heading'>
                          <h4 class='panel-title'>
                          <a data-toggle='collapse' data-parent='#accordion' href='#collapse{$aid}' >
                            <i class='fa fa-plus fa-lg'></i> {$title}
                          </a>
                          </h4>
                        </div>
                        <div id='collapse{$aid}' class='panel-collapse collapse'>
                          <div class='panel-body'>
                              {$content}
                          </div>
                        </div>
                  </div>";
          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>