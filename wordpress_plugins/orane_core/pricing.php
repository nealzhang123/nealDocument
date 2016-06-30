<?php  
//Register "container" content element

vc_map( array(
    "name" => __("Pricing Table", "orane"),
    "description" => __("Pricing Tables", 'orane'),
    "controls" => "full",
    "base" => "orane_price",
    "as_parent" => array('only' => 'orane_price_single'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/16-122-paper.png', __FILE__),
    "show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "js_view" => 'VcColumnView',
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "description" => __("The Title Of The Table", "orane"),
            "value" => __("Gold", 'orane'),
            "admin_label" => true,
        ),

        array(
            "type" => "textfield",
            "heading" => __("Price", "orane"),
            "param_name" => "price",
            "description" => __("The Price", "orane"),
            "value" => __("$9.99", 'orane'),
            "admin_label" => true,
        ),

        array(
            "type" => "textfield",
            "heading" => __("Sub Title", "orane"),
            "param_name" => "subtitle",
            "description" => __("Subtitle (Bonus Feature etc)", "orane"),
            "value" => __("*BONUS FEATURE GOES HERE", 'orane'),
            "admin_label" => true,
        ),

        array(
            "type" => "vc_link",
            "holder" => "div",
            "class" => "",
            "heading" => __("Link To The Page", 'orane'),
            "param_name" => "link",
            "description" => __("", 'orane')
        ),

        array(
            "type" => "textfield",
            "heading" => __("Link Text", "orane"),
            "param_name" => "link_text",
            "description" => __("Text For The Link Button", "orane"),
            "value" => __("Request A Quote", 'orane'),
            
        ),


    ),
) );

/////////////////////////////////////////////////////////////////child elements
vc_map( array(
    "name" => __("Pricing Table Feature", "orane"),
    "base" => "orane_price_single",
    "content_element" => true,
    "as_child" => array('only' => 'orane_price'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "description" => __("The Title Of The Feature", "orane"),
            "value" => __("Feature Title", 'orane'),
            "admin_label" => true,
        ),

        array(
            "type" => "dropdown",
            "heading" => __("Type", "orane"),
            "param_name" => "type",
            "description" => __("Feature Available?", "orane"),
            "value" => array( 
                          "Available"     => "fa-check",
                          "Not Available"        => "fa-times",
                          ),//will add more
                        "std" => "fa-check"
        ),



    )//ends params

) );//ends vc_map

////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Price extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'title',
        'subtitle' => 'subtitle',
        'price'    => 'price',
        'link'    => '#',
        'link_text' => '',
      ), $atts ) );
     
      $link = vc_build_link($link); //parse the link
      $link = $link["url"];

     $title = lineToSpanColor($title);

      $output = "<div class='col-md-12'>
                <div class='price-margin-1'>
                <div class='planbg'>
                  <div class='plantitle'>
                    <p class='plantype'>{$title}</p>
                    <p class='planprice'>{$price}</p>
                    <span class='planbonus'>{$subtitle}</span>
                  </div>
                  <ul>
                      ".do_shortcode($content)."
                  </ul>
                  <div class='requestq'>
                    <ul>
                    <li><a href='{$link}'>{$link_text}</a></li>
                    </ul>
                  </div>
                </div>
                </div>
                </div>";
      
      return $output;
    }


    }//end of container class
} //end if

///////////////////////////////////////////ends container class


if ( class_exists( 'WPBakeryShortCode' ) ) {
class WPBakeryShortCode_Orane_Price_Single extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'title' => 'title',
            'type' => 'type',
          ), $atts ) );


          if($type == "fa-times"){
              $type = "fa-times red";
          }elseif($type == "fa-check"){
              $type = "fa-check green";
          }
         
          $aid = rand();
          $output = "<li class='plancolor'><i class='fa {$type}'></i> {$title}</li>";
          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>