<?php  
//Register "container" content element
vc_map( array(
    "name" => __("3D Testimonials Slider", "orane"),
    "description" => __("3D Testimonials Slider", 'orane'),
    "controls" => "full",
    "base" => "orane_3dtest",
    "as_parent" => array('only' => 'orane_single_3dtest'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/49-373-3D-glasses.png', __FILE__),
    "show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "js_view" => 'VcColumnView',
    "params"  => array(

                            array(
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("background Image", 'orane'),
                                "param_name" => "image",
                                "description" => __("The large image in the background, leave blank to use the default image", 'orane')
                            ),


        ),
) );

//////////////child elements
vc_map( array(
    "name" => __("Testimonial", "orane"),
    "base" => "orane_single_3dtest",
    //"icon" => plugins_url('assets/orane_logo_20.png', __FILE__),
    "content_element" => true,
    //"category" => __('Orane Components', 'orane'), //no need for this
    "as_child" => array('only' => 'orane_3dtest'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Name", "orane"),
            "param_name" => "name",
            "description" => __("Name Of The Client/User.", "orane"),
            "value" => __("John Doe", 'orane'),
            "admin_label" => true,
        ),
        array(
            "type" => "textarea",
            "holder" => "div",
            "class" => "",
            "heading" => __("Testimonial", 'orane'),
            "param_name" => "content",
            "value" => __("I love this theme, it has tons of features and more.", 'orane'),
            "description" => __("Details", 'vc_extend')
        ),
        array(
            "type" => "attach_image",
            "holder" => "div",
            "class" => "",
            "heading" => __("User Image", 'orane'),
            "param_name" => "image",
            //"value" => __("", 'vc_extend'),
            "description" => __("The User/Client Picture", 'orane')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Company Name", "orane"),
            "param_name" => "company",
            "description" => __("Company they Work For.", "orane"),
            "value" => __("ASDF Designs", 'orane')
        ),        
        array(
            "type" => "textfield",
            "heading" => __("Position in Company", "orane"),
            "param_name" => "position",
            "description" => __("Position in the Company.", "orane"),
            "value" => __("Manager", 'orane')
        ),

        array(
            "type" => "vc_link",
            "holder" => "div",
            "class" => "",
            "heading" => __("Link To The Page", 'orane'),
            "param_name" => "link",
            "description" => __("The Link To The Page.", 'orane')
        ),


        array(
            "type" => "textfield",
            "heading" => __("Facebook Link", "orane"),
            "param_name" => "fb_link",
            "value" => __("http://www.facebook.com", 'orane')
        ), 
        array(
            "type" => "textfield",
            "heading" => __("Twitter Link", "orane"),
            "param_name" => "tw_link",
            "value" => __("http://www.twitter.com", 'orane')
        ), 
        array(
            "type" => "textfield",
            "heading" => __("Skype ID", "orane"),
            "param_name" => "skype_id",
            "value" => __("asdf", 'orane')
        ), 

    )//ends params

) );//ends vc_map

////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_3DTest extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {

      extract( shortcode_atts( array(
        'image' => 'Image',
      ), $atts ) );
     
      $cont = "container";

     // if($width == 'full'){
     //    $cont = "container-fluid";
     // }


       $img = wp_get_attachment_image_src( $image, 'full' );

      if($image == "Image"){
        $imgsrc = plugins_url('images/wood2.jpg', __FILE__);
        $img[0] = $imgsrc;
      }

      wp_enqueue_script('orane-3dgallery', plugins_url('assets/jquery.3dgallery.js', __FILE__), array('jquery') );
     // wp_enqueue_script('orane-skype-js', '//www.skypeassets.com/i/scom/js/skype-uri.js', array('jquery') );

      $output = "<div id='dg-container' class='dg-container' style='background-image:url({$img[0]});'>
                    <div class='{$cont}'>
                      <div class='col-md-12'>
                      <div class='dg-wrapper'>
                        " . do_shortcode($content) . "                      
                      </div>
                      <nav> 
                        <span class='dg-prev'>&lt;</span>
                        <span class='dg-next'>&gt;</span>
                      </nav>
                      </div>
                      </div>
                </div>";
      
      return $output;
    }


    }//end of container class
} //end if

///////////////////////////////////////////ends container class


if ( class_exists( 'WPBakeryShortCode' ) ) {
class WPBakeryShortCode_Orane_Single_3DTest extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
            extract( shortcode_atts( array(
              'name'    => 'name',
              'image'   =>  'Image',
              'position' =>  '',
              'company' =>  '',
              'tw_link'  => '',
              'fb_link'  => '',
              'skype_id'  => '',
              'link'   => '#'
            ), $atts ) );
            $img = wp_get_attachment_image_src( $image, 'full' );
         // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

            //sets the default image  
            if($image == "Image"){
              $imgsrc = plugins_url('images/about/4.png', __FILE__);
              $img[0] = $imgsrc;
            }


            $link = vc_build_link($link); //parse the link
            $link = $link["url"];

            $company_str = " - <span class='testi-company'>{$company}</span>";

            if($company == ""){
                    $company_str = "";
            }


            $position_str = "<span class='testi-position'>{$position}</span>";

            if($position == ""){
                    $position_str = "";
            }

            //social links
            $fb_str = "<i data-url='{$fb_link}' class='fa fa-facebook fa-lg'></i>";
            if($fb_link == ""){
                $fb_str = "";
            }

            $skype_str = "<i data-url='skype:{$skype_id}?call' class='fa fa-skype fa-lg'></i>";
            if($skype_id == ""){
                $skype_str = "";
            }

            $tw_str = "<i data-url='{$tw_link}' class='fa fa-twitter fa-lg'></i>";
            if($tw_link == ""){
                $tw_str = "";
            }

          
          $output = "<a href='{$link}'>
                        <img class='dg-img shadow-1' src='{$img[0]}' alt='{$name}'>
                        <div class='qt'>
                        <span data-url='{$link}' title='{$link}' class='name'>{$name}</span>
                        <p>'{$content}'</p>
                            {$position_str}{$company_str}<br/>
                        {$fb_str}{$skype_str}{$tw_str}
                        </div>
                    </a>";
          return $output;
        }


}//end class

} //end if

/////////////////////////////////////////////////////////////////////////////////////////////

?>