<?php  
//Register "container" content element

vc_map( array(
    "name" => __("Orane FAQs", "orane"),
    "description" => __("Our Faqs", 'orane'),
    "controls" => "full",
    "base" => "orane_faqs",
    "as_parent" => array('only' => 'orane_single_faq'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/17-220-file.png', __FILE__),
    //"show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "js_view" => 'VcColumnView'
) );

/////////////////////////////////////////////////////////////////child elements
vc_map( array(
    "name" => __("Orane Faq", "js_composer"),
    "base" => "orane_single_faq",
    "content_element" => true,
    "as_child" => array('only' => 'orane_faqs'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "js_composer"),
            "param_name" => "title",
            "description" => __("If you wish to style particular content element differently .", "js_composer"),
            "value" => __("Faq Title", 'js_composer'),
            "admin_label" => true,
        ),

        array(
            "type" => "textarea",
            "holder" => "div",
            "class" => "",
            "heading" => __("Answer", 'vc_extend'),
            "param_name" => "content",
            "value" => __("I love this theme, it has tons of features and more.", 'vc_extend'),
            "description" => __("Details", 'vc_extend')
        ),
       


    )//ends params

) );//ends vc_map

////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Faqs extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'title',
        'details' => 'details'
      ), $atts ) );
     

     $title = lineToSpanColor($title);

      $output = "<div class='container faqs'><div class='col-md-12 faq-all'>


                  ".do_shortcode($content)."

            
                </div></div>";
      
      return $output;
    }


    }//end of container class
} //end if

///////////////////////////////////////////ends container class


if ( class_exists( 'WPBakeryShortCode' ) ) {
class WPBakeryShortCode_Orane_Single_Faq extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title' => 'title',
            'details' => 'details',
            'icon'    => 'icon'
          ), $atts ) );
         // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
          
          $output = "<div class='faq-q'>

                          <input type='checkbox' id='question1' name='q'  class='questions'>
                            <div class='plus'>+</div>
                            <label for='question1' class='question'>
                              {$title}
                            </label>
                          <div class='answers'>
                            <p>{$content}</p>
                          </div>

                    </div>";
          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>