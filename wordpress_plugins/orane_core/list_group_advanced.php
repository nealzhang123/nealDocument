<?php  
//Register "container" content element
vc_map( array(
    "name" => __("List Group With Content", "orane"),
    "description" => __("A List With Title and Content", 'orane'),
    "controls" => "full",
    "base" => "orane_list_group_adv",
    "as_parent" => array('only' => 'orane_list_group_adv_single'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/16-217-writtingpad.png', __FILE__),
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
        )
    ),
    "js_view" => 'VcColumnView'
) );

/////////////////////////////////////////////////////////////////child elements
vc_map( array(
    "name" => __("List Item", "orane"),
    "base" => "orane_list_group_adv_single",
    "content_element" => true,
    "as_child" => array('only' => 'orane_list_group_adv'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "admin_label" => true,
            "description" => __("Title", "orane"),
            "value" => __("List Item Title", 'orane')
        ),
        array(
            "type" => "textfield",
            "heading" => __("details", "orane"),
            "param_name" => "content",
            "description" => __("The details under the title", "orane"),
            "value" => __("Lorem ipsum dolor sit amet, consectetur adipiscing elit.", 'orane')
        ),
        array(
              "type"        => "dropdown",
              "heading"     => __("Active?", "orane"),
              "param_name"  => "active",
              "value"       => array(
                                    '0'   => 'Plain',
                                    '1'   => 'Active',
                            ),
              "std"         => 0,
              "description" => __("If active, it will highlight the list item", "orane"),
        ),



    )//ends params

) );//ends vc_map

////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_List_Group_Adv extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'   => 'title'
      ), $atts ) );
     
     $title = lineToSpanColor($title);

      $output = "<div class='lists'>
                        <div class='row'>
                            <div class='col-md-12 list-gap-right'>
                                <h2>{$title}</h2>
                                <ul class='list-group'>
                                  ".do_shortcode($content)."
                                </ul>
                            </div>
                        </div>
                </div>  ";
      
      return $output;
    }


    }//end of container class
} //end if

///////////////////////////////////////////ends container class


if ( class_exists( 'WPBakeryShortCode' ) ) {
class WPBakeryShortCode_Orane_List_Group_Adv_Single extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title'           => '',
            'active'          => '',
          ), $atts ) );
         // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          $addclass = "";
          if($active == 'Active'){
            $addclass = "active";
          }
          
          $output = "<a href='#' class='list-group-item {$addclass}'>
                        <h4 class='list-group-item-heading'>{$title}</h4>
                        <p class='list-group-item-text'>{$content}</p>
                    </a>";
          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>