<?php  
//Register "container" content element
vc_map( array(
    "name" => __("Our Clients", "orane"),
    "description" => __("Clients Section", 'orane'),
    "controls" => "full",
    "base" => "orane_clients",
    "as_parent" => array('only' => 'orane_clients_single'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/23-175-eye.png', __FILE__),
    "show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "js_view" => 'VcColumnView',
                "params" => array(

                                  array(
                                      "type" => "textfield",
                                      "heading" => __("Title", "orane"),
                                      "param_name" => "title",
                                      "description" => __("Title of the clients section", "orane"),
                                      "value" => __("Our Clients", 'orane'),
                                      "admin_label" => true,
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


                  ),
) );

//////////////child elements
vc_map( array(
    "name" => __("Client", "orane"),
    "base" => "orane_clients_single",
    //"icon" => plugins_url('assets/orane_logo_20.png', __FILE__),
    "content_element" => true,
    //"category" => __('Orane Components', 'js_composer'), //no need for this
    "as_child" => array('only' => 'orane_clients'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
                    array(
                        "type" => "attach_image",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Logo", 'orane'),
                        "param_name" => "image",
                        "description" => __("The client's logo", 'orane'),

                    ), 

                    array(
                        "type" => "vc_link",
                        "holder" => "div",
                        "class" => "",
                        "heading" => __("Link To The Site/Page", 'orane'),
                        "param_name" => "link",
                        "description" => __("The Link To The Clinets site/page", 'orane')
                    ),
  
    )//ends params

) );//ends vc_map



////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Clients extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'title',
        'details' => 'details',
      ), $atts ) );


     $title = lineToSpanColor($title);


      $output = "<section class='partners partners-2'>
                        <div class='container'>

                            <div class='col-md-6'>
                                <h2>{$title}</h2>
                                <p>{$details}</p>
                            </div>

                                <div class='col-md-6'>
                                      <div class='row'>
        
                                              ". do_shortcode($content)  . "        

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
class WPBakeryShortCode_Orane_Clients_Single extends WPBakeryShortCode {

        static $count = 1;
        
        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'image' => 'Image',
            'link' => ''
          ), $atts ) );

     
     $counter = self::$count++;  

    $img = wp_get_attachment_image_src( $image, 'full' );

    $link = vc_build_link($link); //parse the link
    $link_url = $link["url"];
    $link_target = $link["target"];

    if($link == ""){
      $link = "#";
    }

        if($counter % 3 == 0){

          $output = "<div class='col-md-4 border-2'>
                          <a href='{$link_url}' target='_blank'><img src='{$img[0]}'></a>
                     </div>";

         }else{
                  $output = "<div class='col-md-4 border-1'>
                          <a href='{$link_url}' target='_blank'><img src='{$img[0]}'></a>
                     </div>";   
         }            



          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>