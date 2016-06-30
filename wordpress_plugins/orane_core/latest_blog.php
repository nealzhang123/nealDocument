<?php  
// Plain Hero, no images and stuff
class Orane_VC_Latest_Blog {

        var $shortcode = 'orane_vc_latest_blog';
        var $title = "Latest From Blog";
        var $details = "Latest From Blog";
        //var $path = "/templates/rating_hero.php";

    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( $this->shortcode, array( $this, 'renderShortcode' ) );

        // Register CSS and JS
        //add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
    }
 
    public function integrateWithVC() {
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }
 
        vc_map( array(
            "name" => __($this->title, 'vc_extend'),
            "description" => __($this->details, 'vc_extend'),
            "base" => $this->shortcode,
            "class" => "",
            "controls" => "full",
            "icon" => plugins_url('assets/icons/13-161-document.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Orane Components', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "js_composer"),
                                    "param_name" => "title",
                                    "description" => __("The Title.", "js_composer"),
                                    "value" => __("Latest From |Blog|", 'js_composer'),
                                    "admin_label" => true,
                            ),

                            array(
                                "type" => "textarea",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Details", 'vc_extend'),
                                "param_name" => "content",
                                "value" => __("Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.", 'vc_extend'),
                                "description" => __("Details", 'vc_extend')
                            ),

                            array(
                                "type" => "attach_image",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Background Pattern Image", 'orane'),
                                "param_name" => "image_bg",
                                //"value" => __("", 'vc_extend'),
                                "description" => __("The pattern in the background", 'orane'),
                                "admin_label" => false,
                            ),


                            array(
                                    "type" => "textfield",
                                    "heading" => __("Read More Text", "orane"),
                                    "param_name" => "readmore",
                                    "description" => __("Read More Text Link", "orane"),
                                    "value" => __("Read More", 'orane'),
                                    "admin_label" => false,
                            ),
           



                    )
        ) );
    }
    

    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'         => 'Title',
        'image_bg'      => 'Image',
        'readmore'      => 'Read More',
      ), $atts ) );
     // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      
      $title = lineToBold($title);

      $strr = " ";

    $img_bg = wp_get_attachment_image_src( $image_bg, 'full' );

    if($image_bg == "Image"){
      $img_bg_src = plugins_url('images/pattern/1.png', __FILE__);
      $img_bg[0] = $img_bg_src;
    }



      $output = "<section class='work work-s'>
                    <div class='container'>
                      <div class='col-md-12 tag-heading'>
                        <h2>{$title}</h2>
                        <p>{$content}</p>
                      </div>
                    </div>
                      <div id='grid-latest-blog' class='full-screen-2' style='background-image:url({$img_bg[0]});'>
                      <div class='container'>
                                <ul>";

      $args = array( 'numberposts' => '6', 'post_type' => 'post',  'post_status' => 'publish',);
      $proj_query = wp_get_recent_posts( $args );
                   
       $item = "";
       $count = 0;
       $addclass = "";

       wp_enqueue_script('orane-portfolio', plugins_url('assets/isotope.pkgd.min.js', __FILE__), array('jquery') );
       wp_enqueue_script('orane-debounce', plugins_url('assets/jquery.debouncedresize.js', __FILE__), array('jquery') );

       foreach($proj_query as $recent){

           $pid =  $recent["ID"];
           $thumbid = get_post_thumbnail_id( $pid );


           if ( has_post_thumbnail($pid) ) {
              $thumb = get_the_post_thumbnail($pid, 'blog-port-size');
            }else{
              $no_img = plugins_url('images/no_image.gif', __FILE__);
              $thumb = "<img src='{$no_img}'>";
            }

           $full = wp_get_attachment_image_src($thumbid, 'full');
           $link = get_permalink($pid);
           $link = esc_url($link);
           $title = lineToSpanColor( get_the_title($pid) );
           $date = get_the_date("M月 d, Y",$pid);
           $post = get_post($pid);
           setup_postdata( $post );
           $post_excerpt = get_the_excerpt($pid);
           wp_reset_postdata();
           //$post = strip_tags(substr($post->post_content, 0, 100));
           $post_link = "...<a href='{$link}' target='_blank'>{$readmore}</a>";
           $comments = wp_count_comments( $pid );
           $comcount = $comments->total_comments;


           $count++;
           $addEle = "";
           $fEle = "";

           if($count != 3){
                $addEle = "<li class='gutter-sizer'></li>";
           }

           if($count == 1){
              $fEle = "<li class='grid-sizer'></li>
                       <li class='gutter-sizer'></li>";
           }

            $item = "{$fEle}<li class='latest-blog-item'>
                        <div class='latest-blog-image'>
                              
                                <a href='{$link}' target='_blank'> {$thumb} </a>
                              </div>
                              <div class='latest-blog-content'>
                                  <a href='{$link}' target='_blank'>{$title}</a>
                                  <div class='latest-blog-about'>
                                      <span class='latest-blog-date'><i class='fa fa-calendar'></i> {$date} </span>
                                      <span class='latest-blog-comment'><i class='fa fa-comments'></i> {$comcount} Comments </span>
                                  </div>
                                  <div class='latest-blog-excerpt'>
                                      {$post_excerpt}{$post_link}
                                  </div>
                             
                        </div>
                    </li>
                    ";
            $output .= $item;       
       }

      $output .= "</ul></div></div></section>";
      return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
      wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
      wp_enqueue_style( 'vc_extend_style' );

      // If you need any javascript files on front end, here is how you can load them.
      //wp_enqueue_script( 'vc_extend_js', plugins_url('assets/vc_extend.js', __FILE__), array('jquery') );
    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function showVcVersionNotice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
        </div>';
    }



}//end of class
?>