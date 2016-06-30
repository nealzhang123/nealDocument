<?php  
// Plain Hero, no images and stuff
class Orane_VC_Projects_Portfolio {

        var $shortcode = 'orane_vc_projects_portfolio';
        var $title = "Projects Portfolio";
        var $details = "Portfolio On The Home Page";
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
            "icon" => plugins_url('assets/icons/46-100-image-dublicate.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Orane Components', 'orane'),
            //'admin_enqueue_js' => array(plugins_url('admin_assets/hero_star.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            "params" => array(

                            array(
                                    "type" => "textfield",
                                    "heading" => __("Title", "orane"),
                                    "param_name" => "title",
                                    "description" => __("The Title.", "orane"),
                                    "value" => __("RESPONSIVE |DESIGN|", 'orane'),
                                    "admin_label" => true,
                            ),

                            array(
                                "type" => "textarea",
                                "holder" => "div",
                                "class" => "",
                                "heading" => __("Details", 'orane'),
                                "param_name" => "content",
                                "value" => __("Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.", 'orane'),
                                "description" => __("Details", 'orane')
                            )

                    )
        ) );
    }
    

    public function renderShortcode( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title'         => 'Title'
      ), $atts ) );
     // $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      
      $title = lineToBold($title);

      $strr = " ";


      $output = "<section class='work'>
                    <div class='container'>
                        <div class='col-md-12 tag-heading'>
                            <h2>{$title}</h2>
                            <p>{$content}</p>
                        </div>
                    </div>
                    <div id='isoport'>";

        global $query_string;              
       //$proj_query = new WP_Query('post_type=project&posts_per_page=10&meta_key=_projects_mb_feature&meta_value=1');

        $args = array(
          'numberposts' => 10,
          'post_type' => 'project',
          'meta_key' => '_projects_mb_feature',
          'meta_value' => '1'
        );

       $proj_query = new WP_Query( $args );
       $item = "";


       while ( $proj_query->have_posts() ) : $proj_query->the_post();  

           $pid =  get_the_ID();
           //echo get_post_meta(get_the_ID(), '_projects_mb_feature', TRUE);

           $thumbid = get_post_thumbnail_id( $pid );
           $thumb = get_the_post_thumbnail($pid, 'port-size');
           $full = wp_get_attachment_image_src($thumbid, 'full');
           $link = get_post_permalink();
           $title = get_the_title();
          
           wp_enqueue_script('orane-portfolio', plugins_url('assets/isotope.pkgd.min.js', __FILE__), array('jquery') );
           wp_enqueue_script('orane-debounce', plugins_url('assets/jquery.debouncedresize.js', __FILE__), array('jquery') );
           wp_enqueue_script('orane-magnificpopup', plugins_url('assets/jquery.magnific-popup.js', __FILE__), array('jquery') );

            $item = "<div class='orane-portfolio portfolio-slideup'>
                            <div class='port_item port_item-third'>
                                <a href='{$link}' class='itemzoom_outer'>{$thumb}</a>
                                <a href='{$full[0]}' title='{$title}' class='itemzoom item-mag'></a>
                                <div class='mask'>
                                    <h2>{$title}</h2>
                                    
                                    <a href='{$link}' class='info'>Read More</a>
                                </div>
                            </div>
                    </div>
                    ";
            $output .= $item;       
       endwhile;   
       wp_reset_postdata();

      $output .= "</div></section>";
      return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
      wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
      wp_enqueue_style( 'vc_extend_style' );      
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