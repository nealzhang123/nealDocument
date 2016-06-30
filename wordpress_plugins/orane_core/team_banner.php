<?php  
//Register "container" content element
vc_map( array(
    "name" => __("Team Banner", "orane"),
    "description" => __("Large banner with background Image and team members", 'orane'),
    "controls" => "full",
    "base" => "orane_team_banner",
    "as_parent" => array('only' => 'orane_team_banner_single'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "icon" => plugins_url('assets/icons/13-319-group.png', __FILE__),
    "show_settings_on_create" => true,
    "category" => __('Orane Components', 'orane'),
    "class" => "container-fluid",
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", "orane"),
            "param_name" => "title",
            "description" => __("Team Title", "orane"),
            "value" => __("Meet Our Team", 'orane'),
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __("Details", "orane"),
            "param_name" => "details",
            "description" => __("Details", "orane"),
            "value" => __("Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui of deserunt mollit anim id est laborum.", 'orane')
        ),
        array(
            "type" => "attach_image",
            "holder" => "div",
            "class" => "",
            "heading" => __("Background Image", 'orane'),
            "param_name" => "image",
            "description" => __("The Image in the background", 'orane'),
        ),



    ),
    "js_view" => 'VcColumnView'
) );

/////////////////////////////////////////////////////////////////child elements
vc_map( array(
    "name" => __("Team Member", "orane"),
    "base" => "orane_team_banner_single",
    "content_element" => true,
    "as_child" => array('only' => 'orane_team_banner'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Name", "orane"),
            "param_name" => "name",
            "admin_label" => true,
            "admin_label" => true,
            "description" => __("Title", "orane"),
            "value" => __("Team Memeber Title", 'orane')
        ),
        array(
            "type" => "textfield",
            "heading" => __("Position", "orane"),
            "param_name" => "position",
            "description" => __("Team Member Position", "orane"),
            "value" => __("CEO", 'orane')
        ),
        array(
            "type" => "attach_image",
            "holder" => "div",
            "class" => "",
            "heading" => __("Position", 'orane'),
            "param_name" => "image",
            "description" => __("The Picture of the Team Member", 'orane')
        ),

        array(
              "type"        => "dropdown",
              "heading"     => __("Show Social Links?", "orane"),
              "param_name"  => "show_social",
              "value"       => array(
                                    '1'   => 'Show',
                                    '0'   => 'Hide',
                            ),
              "std"         => 1,
              "description" => __("Show or hide the social links", "orane"),
        ),



        array(
            "type" => "textfield",
            "heading" => __("Facebook Link", "orane"),
            "param_name" => "facebook",
            "description" => __("", "orane"),
            "value" => __("", 'orane')
        ),

        array(
            "type" => "textfield",
            "heading" => __("Linkedin Link", "orane"),
            "param_name" => "linkedin",
            "description" => __("", "orane"),
            "value" => __("", 'orane')
        ),

        array(
            "type" => "textfield",
            "heading" => __("Skype ID", "orane"),
            "param_name" => "skype",
            "description" => __("", "orane"),
            "value" => __("", 'orane')
        ),

        array(
            "type" => "textfield",
            "heading" => __("External Link", "orane"),
            "param_name" => "ext_link",
            "description" => __("", "orane"),
            "value" => __("", 'orane')
        ),


    )//ends params

) );//ends vc_map

////////////////////////////////////Starts container class
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Orane_Team_Banner extends WPBakeryShortCodesContainer {

    public function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'   => 'title',
        'details' => '',
        'image'   => 'Image'
      ), $atts ) );


      $img = wp_get_attachment_image_src( $image, 'full' );
      $title = lineToSpanColor($title);


      if($image == "Image"){
        $imgsrc = plugins_url('images/i17.jpg', __FILE__);
        $img[0] = $imgsrc;
      }


     
     $title = lineToSpanColor($title);

      $output = "<section class='about' style='background: url({$img[0]}) no-repeat scroll 0 0 / cover  rgba(0, 0, 0, 0)'>
                    <div class='container about-container-2'>
                      <div class='row col-md-12'>
                        <div class='heading-about'>
                          <h1>{$title}</h1>
                          <p>{$details}</p>
                        </div>
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
class WPBakeryShortCode_Orane_Team_Banner_Single extends WPBakeryShortCode {


        public function content( $atts, $content = null ) {
        
          extract( shortcode_atts( array(
            'name'            => 'name',
            'position'        => '',
            'image'           => 'Image',
            'facebook'        => '#',
            'linkedin'        => '#',
            'skype'           => '',
            'show_social'	  => 1,
            'ext_link'      => '#',
          ), $atts ) );
         // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

      $img = wp_get_attachment_image( $image, 'full' );
      

      if($image == "Image"){
        $imgsrc = plugins_url('images/team/1.png', __FILE__);
        $img = "<img src='{$imgsrc}' alt='people'>";
      }

      $social = "";
      if($show_social == "Show"){

  		$social = "<div class='member-social-links'>
                          <a href='{$facebook}'><i class='fa fa-facebook fa'></i></a>
                          <a href='{$linkedin}'><i class='fa fa-linkedin fa'></i></a>
                          <a href='skype:{$skype}?call'><i class='fa fa-skype fa'></i></a>
                          <a href='{$ext_link}'><i class='fa fa-external-link fa'></i></a>
                          
                    </div>";

      }
          
          $output = "<div class='team'>
                        <div class='col-md-3 member'>
                          {$img}
                          <div class='member-intro'>
                            <div class='member-name'>{$name}</div>
                            <div class='member-position'>{$position}</div>

								{$social}

                            <div class='clearfix'></div>
                          </div>
                    </div>";
          return $output;
        }


}//end class

} //end if
?>