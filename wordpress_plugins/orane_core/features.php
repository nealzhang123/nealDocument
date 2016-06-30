<?php  
//Register "container" content element

vc_map( array(
    "name" => __("Orane Features", "orane"),
    "description" => __("Our Features Section", 'orane'),
    "controls" => "full",
    "base" => "orane_features",
    "as_parent" => array('only' => 'orane_single_feature'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
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
            "value" => __("Our Features", 'js_composer'),
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __("Details", "orane"),
            "param_name" => "details",
            "description" => __("Features Section Details", "orane"),
            "value" => __("Features Section Details", 'orane')
        )
    ),
    "js_view" => 'VcColumnView'
) );

/////////////////////////////////////////////////////////////////child elements
vc_map( array(
    "name" => __("Orane Feature", "orane"),
    "base" => "orane_single_feature",
    "content_element" => true,
    "as_child" => array('only' => 'orane_features'), // Use only|except attributes to limit parent (separate multiple values with comma)
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
            "holder" => "div",
            "class" => "",
            "heading" => __("Font Awesome Icon", 'orane'),
            "param_name" => "icon",
            "value" => __("mobile-phone", 'orane'),
            // "description" => __("Get Font Awesome Icons Code Here: <a target='_blank' href='http://fortawesome.github.io/Font-Awesome/cheatsheet/'>Link</a>, New icons may not work. Leave blank if you want to use the above icon.", 'orane')
        ),


        array(
            "type" => "textarea",
            "holder" => "div",
            "class" => "",
            "heading" => __("Details", 'orane'),
            "param_name" => "content",
            "value" => __("I love this theme, it has tons of features and more.", 'orane'),
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


    )//ends params

) );//ends vc_map

////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Features extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'The Title',
        'details' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt molestias saepe illo voluptatum natus. Dicta mollitia, impedit quis? Doloribus quo non obcaecati modi a eos at molestiae ex cupiditate mollitia?'
      ), $atts ) );
     

     $title = lineToSpanColor($title);

      $output = "<section class='services service-bottom'>
                    <div class='container'>
                      <div class='row'>
                        <h2>{$title}</h2>
                        <p class='tag-heading'>{$details}</p>
                        <div class='service-wrap'>" . do_shortcode($content) . "</div>
                        <div class='clearfix'></div>
                      </div>
                    </div>
                  </section>";
      
      return $output;
    }


    }//end of container class
} //end if

///////////////////////////////////////////ends container class


if ( class_exists( 'WPBakeryShortCode' ) ) {
class WPBakeryShortCode_Orane_Single_Feature extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title' => 'Feature Title',
            'details' => 'Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum.',
            'icon'    => 'icon',
            'link'    => '',
            'custom_icon' => '',
          ), $atts ) );
         // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

          if($custom_icon != ''){
            $icon = $custom_icon;
          }

          $link = vc_build_link($link); //parse the link
          $link_url = $link["url"];
          $link_target = $link["target"];

          if($link == ""){
            $link = "#";
          }
          
          $output = "<div class='col-md-4 service wow fadeIn' data-wow-duration='1s' data-wow-delay='.2s'>
            <div class='row'>
              <div class='col-md-2'>
                <div class='icon'>
                  <i class='fa {$icon} fa-3x'></i>
                </div>
              </div>
            
              <div class='col-md-10'>
                <div class='service-right'>
                  <a class='service-head' href='{$link_url}' target='{$link_target}'>{$title}</a>
                  <p>{$content}</p>
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