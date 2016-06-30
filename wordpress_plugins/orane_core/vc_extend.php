<?php
/*
Plugin Name: Orane Core
Plugin URI: http://wpbakery.com/vc
Description: Orane Theme Core Components
Version: 1.6.4
Author: Jamal Khan
Author URI: http://redhawk-studio.com
License: GPLv2 or later
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');




function orane_admin_notice() {
    ?>
    <div class="vc_notfound updated">
        <p><?php _e( 'Visual Composer Needs To Be Activated For Orane Core To Work.', 'orane' ); ?></p>
    </div>
    <?php
}







//check if visual composer installed:
if ( ! defined( 'WPB_VC_VERSION' ) ) {
        add_action('admin_notices', 'orane_admin_notice' );
        return;
}else{//if vc installed:





//remove default templates:
add_filter( 'vc_load_default_templates', 'orane_vc_remove_templates' );
function orane_vc_remove_templates($data) {
    return array(); // This will remove all default templates
}
    
//add a blank component:
add_action('vc_load_default_templates_action','orane_template_for_vc');
function orane_template_for_vc() {




    //home page 1 template
    $home_template = '[vc_row][vc_column width="1/1"][rev_slider_vc alias="slider1"][/vc_column][/vc_row][vc_row][vc_column width="1/1"][rating_hero title="We Are |ORANE|, And We Deserve |5 Star Rating|." details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum dolore eu fugiat nulla pariatur."][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_features details="Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum." title="| Our | Features"][orane_single_feature title="HTML5 &amp; CSS3" icon="fa-file-code-o" details="Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum."]Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum.[/orane_single_feature][orane_single_feature title="RESPONSIVE" details="Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum." icon="fa-arrows-alt"]Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum.[/orane_single_feature][orane_single_feature title="W3C VALIDATED" details="Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum." icon="fa-check-square-o"]Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum.[/orane_single_feature][orane_single_feature title="COMPLETE PACK" details="Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum." icon="fa-suitcase"]Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum.[/orane_single_feature][orane_single_feature title="MADE WITH LOVE" icon="fa-heart-o" details="Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum."]Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum.[/orane_single_feature][orane_single_feature title="CUSTOMER SUPPORT" icon="fa-life-ring" details="Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum."]Lorem ipsum dolor sit amet, consectetur adipisc elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum.[/orane_single_feature][/orane_features][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_welcome_banner title="|ADORABLE| &amp; |UNIQUE| CONCEPT" details="Orane is a unique and stylish template and everybody loves it. Overall designing is a good example of awesome designing. Orane gives you the feeling of love towards web designing. GO GO and Buy This Template!"][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_services][orane_single_service title="DESIGNING" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat."][orane_single_service title="CODING" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat."][orane_single_service title="SUPPORT" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugia."][/orane_services][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_fact_bar title="WE HAVE IDEAS FOR EVERYONE" link="url:http%3A%2F%2Flocalhost%2Fword%2F%3Fpage_id%3D2|title:Sample%20Page|" bgimage="996"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt. Curabitur non quam facilisis, rhoncus ligula ac, pellentesque augue ipsum. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.[/orane_fact_bar][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_special title="OUR |SPECIALITIES|" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum dolore eu fugiat nulla pariatur esse cillum dolore eu fugiat nulla pariatur."][orane_single_special title="Photoshop" details="90"][orane_single_special title="Illustrator" details="85"][orane_single_special title="Indesign" details="75"][orane_single_special title="Dreamweaver" details="75"][/orane_special][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_gtstarted_banner title="GROW |BUSINESS|" link="url:%23asd|title:ASD|"]Orane comes up with ultimate design concept that everyone can use this. The design is unique and eye catching. Different versions of the design are available. Orane comes up with ultimate design concept that everyone can use this. The design is unique and eye catching. Different versions of the design are available. Orane comes up with ultimate design concept that everyone can use this. The design is unique and eye catching. Different versions of the design are available.[/orane_vc_gtstarted_banner][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_projects_portfolio title="Our |Featured| Work"]Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.[/orane_vc_projects_portfolio][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_banner_side_image title="SEO Ready |Coding|"]Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.[/orane_vc_banner_side_image][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_features_bgimage subtitle="Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur." feature1l="Most Powerful Concept" icon1l="fa-empire" feature2l="3D Testimonial Slider" icon2l="fa-cube" feature3l="Font Awesome 4.1" icon3l="fa-leaf" feature4l="Unique Design" icon4l="fa-paper-plane" feature1r="Most Powerful Support" icon1r="fa-life-saver" feature2r="Eye Catching Design" icon2r="fa-eye" feature3r="Google Web Font" icon3r="fa-text-height" feature4r="HTML5/CSS3" icon4r="fa-html5" title="Say Hello To |The Most| Unique |HTML5| Template"]Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.[/orane_vc_features_bgimage][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_features_big_image title="SEO Ready |Coding|" feature1="Get Support From High Class Professionals" feature2="24/7 Supporting Team" feature3="Best In Class Communication" feature4="Advanced Troubleshooting" link="url:%23||"]Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit.[/orane_vc_features_big_image][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_features_small_image title="RESPONSIVE |DESIGN|"]Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.[/orane_vc_features_small_image][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_latest_blog title="Latest From |Blog|"]Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.[/orane_vc_latest_blog][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_3dtest][orane_single_3dtest name="John Doe" image="871" company="ASDF Designs" position="Manager"]Extremely User-friendly, Easy to learn, and tons of Features.[/orane_single_3dtest][orane_single_3dtest name="Jane Schimdt" image="872" company="ASDF Designs" position="Manager"]I love this theme, it has tons of features and more.[/orane_single_3dtest][orane_single_3dtest name="John Smith" image="873" company="ASDF Designs" position="Manager"]I love this theme, it has tons of features and more.[/orane_single_3dtest][/orane_3dtest][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_newsletter title="SUBSCRIBE TO OUR |NEWSLETTER|"]Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil
molestiae consequatur, vel illum qui dolorem. Lorem ipsum dolor sit amet,
consectetur adipiscing elit. Fusce scelerisque nibh et neque
faucibus suscipit. Sed auctor ipsum ut tellus.[/orane_vc_newsletter][/vc_column][/vc_row]';

    $data               = array();
    $data['name']       = __( 'Orane Home 1', 'orane' );
    $data['image_path'] = preg_replace( '/\s/', '%20', plugins_url( 'images/screenshot.png', __FILE__ ) ); // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'Orane Template';
    $data['content']    = $home_template;
 
    vc_add_default_templates( $data );
    //ends home page 1 template



    //home page 2 template
    $home_template = '[vc_row][vc_column width="1/1"][orane_vc_parallax title=" WE ARE ORANE."][/vc_column][/vc_row][vc_row][vc_column width="1/1"][rating_hero title="|We Are ORANE, And We Deserve 5 Star Rating.|" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum dolore eu fugiat nulla pariatur."][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_features title="Our Features" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui of deserunt mollit anim id est laborum dolore eu fugiat nulla pariatur esse cillum dolore eu fugiat nulla pariatur."][orane_single_feature title="HTML5 &amp; CSS3" icon="fa-file-code-o"]I love this theme, it has tons of features and more.[/orane_single_feature][orane_single_feature title="RESPONSIVE" icon="fa-arrows-alt"]The award winning customer support. We care for our customers so we are always available for support. Feel free to reach us.[/orane_single_feature][orane_single_feature title="W3C VALIDATED" icon="fa-check-square-o"]The award winning customer support. We care for our customers so we are always available for support. Feel free to reach us.[/orane_single_feature][orane_single_feature title="COMPLETE PACK" icon="fa-suitcase"]The award winning customer support. We care for our customers so we are always available for support. Feel free to reach us.[/orane_single_feature][orane_single_feature title="MADE WITH LOVE" icon="fa-heart-o"]The award winning customer support. We care for our customers so we are always available for support. Feel free to reach us.[/orane_single_feature][orane_single_feature title="CUSTOMER SUPPORT" icon="fa-life-ring"]The award winning customer support. We care for our customers so we are always available for support. Feel free to reach us.[/orane_single_feature][/orane_features][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_projects_portfolio title="Our Featured Work"]Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.[/orane_vc_projects_portfolio][/vc_column][/vc_row]';

    $data               = array();
    $data['name']       = __( 'Orane Home 2', 'orane' );
    $data['image_path'] = preg_replace( '/\s/', '%20', plugins_url( 'images/screenshot.png', __FILE__ ) ); // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'Orane Template';
    $data['content']    = $home_template;
 
    vc_add_default_templates( $data );
    //ends home page 2 template




    //home page 3 template
    $home_template = '[vc_row][vc_column width="1/1"][rev_slider_vc alias="slider3"][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_magical title="|Some Facts About Us|"][orane_single_magical title="Photoshop Desgins" details="180"][orane_single_magical title="Illustrations" details="94"][orane_single_magical title="Websites Developed" details="450"][/orane_magical][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_page_title title="Our Skills"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt1.[/orane_page_title][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_progress][orane_single_progress title="WordPress" percent="90"][orane_single_progress title="Adobe Photoshop" percent="95"][orane_single_progress title="Adobe Illustrator" percent="80"][orane_single_progress title="Design" percent="90"][/orane_progress][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_space height="40"][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_projects_portfolio title="Our Recent |Projects|"]Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.[/orane_vc_projects_portfolio][/vc_column][/vc_row]';

    $data               = array();
    $data['name']       = __( 'Orane Home 3', 'orane' );
    $data['image_path'] = preg_replace( '/\s/', '%20', plugins_url( 'images/screenshot.png', __FILE__ ) ); // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'Orane Template';
    $data['content']    = $home_template;
 
    vc_add_default_templates( $data );
    //ends home page 3 template




    //home page 4 template
    $home_template = '[vc_row][vc_column width="1/1"][rev_slider_vc alias="slider3"][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_features_vertical title=" WHY |ORANE ?|" details="Some reasons why you should choose Orane for your new project."][orane_single_feature_vertical title="Optimized Code" feature_icon="fa-gears" details="Fully optimized code with proper indention. Easy to understand."][orane_single_feature_vertical title="Font-Awesome Integration" feature_icon="fa-flag-o"]Font Awesome gives you scalable vector icons experience.[/orane_single_feature_vertical][orane_single_feature_vertical title="Easy Customization" feature_icon="fa-sliders" details="Easy customization due to sweet code."]Easy customization due to sweet code.[/orane_single_feature_vertical][orane_single_feature_vertical title=" Font-Awesome Integration" feature_icon="fa-flag-o" details="Font Awesome gives you scalable vector icons experience."]Integrated with fresh CSS3 animations.[/orane_single_feature_vertical][orane_single_feature_vertical title="Feature Title" feature_icon="fa-gears" details="Integrated with fresh CSS3 animations."][/orane_features_vertical][/vc_column][/vc_row]';

    $data               = array();
    $data['name']       = __( 'Orane Home 4', 'orane' );
    $data['image_path'] = preg_replace( '/\s/', '%20', plugins_url( 'images/screenshot.png', __FILE__ ) ); // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'Orane Template';
    $data['content']    = $home_template;
 
    vc_add_default_templates( $data );
    //ends home page 4 template





    //home page 5 template
    $home_template = '[vc_row][vc_column width="1/1"][rev_slider_vc alias="Slider4"][/vc_column][/vc_row][vc_row][vc_column width="1/1"][rating_hero title="We Are |ORANE|, And We Deserve 5 |Star Rating|." details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum dolore eu fugiat nulla pariatur."][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_features title="Our Features" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui of deserunt mollit anim id est laborum dolore eu fugiat nulla pariatur esse cillum dolore eu fugiat nulla pariatur."][orane_single_feature title="HTML5 & CSS3" icon="fa-file-code-o"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum. [/orane_single_feature][orane_single_feature title="RESPONSIVE" icon="fa-arrows-alt"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum. [/orane_single_feature][orane_single_feature title="W3C VALIDATED" icon="fa-check-square-o"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum. [/orane_single_feature][orane_single_feature title="COMPLETE PACK" icon="fa-suitcase"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum. [/orane_single_feature][orane_single_feature title="MADE WITH LOVE" icon="fa-heart-o"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum. [/orane_single_feature][orane_single_feature title="CUSTOMER SUPPORT" icon="fa-life-ring"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit nulla pariatur cillum. [/orane_single_feature][/orane_features][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_latest_blog title="Latest From |Blog|"]Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.[/orane_vc_latest_blog][/vc_column][/vc_row][vc_row][vc_column width="1/1"][orane_vc_newsletter title="SUBSCRIBE TO OUR |NEWSLETTER|"]Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu.
Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
Fusce scelerisque nibh et neque faucibus suscipit. [/orane_vc_newsletter][/vc_column][/vc_row]';

    $data               = array();
    $data['name']       = __( 'Orane Home 5', 'orane' );
    $data['image_path'] = preg_replace( '/\s/', '%20', plugins_url( 'images/screenshot.png', __FILE__ ) ); // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'Orane Template';
    $data['content']    = $home_template;
 
    vc_add_default_templates( $data );
    //ends home page 5 template



    //Restaurant Template
    $home_template = '[vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][orane_order_now details="Details For The Hero Component..." title1a="OUR TASTY" title1b="ON |YOUR DOORS|" title2a="CALL US" title2b="+0067 977 765 433" link="url:http%3A%2F%2Flocalhost%2Forane2%2F%3Fp%3D1|title:ORDER%20NOW|" bgcolor="#fa7c6e"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][orane_parallax_about title="ABOUT |RESTAURANT|" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt. Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt." bgcolor="#eff0f2"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][orane_restaurant_menu title="|OUR| MENU" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt." color="#333333"][orane_restaurant_menu_single title="Hot Coffee" details="Suger, Cream, Coffee" price="$10"][orane_restaurant_menu_single title="Coffee" details="Onions, Cheese" price="$2"][orane_restaurant_menu_single title="Platter" details="Onions, Cheese" price="$13"][orane_restaurant_menu_single title="Pizza" details="Onions, Cheese" price="$10"][orane_restaurant_menu_single title="Pizza" details="Onions, Cheese" price="$10"][orane_restaurant_menu_single title="Pizza" details="Onions, Cheese" price="$10"][/orane_restaurant_menu][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][orane_custom_portfolio title="Our Food |Gallery|" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt."][orane_custom_portfolio_single title="Item Title" details="Item Details"][orane_custom_portfolio_single title="Item Title" details="Item Details"][orane_custom_portfolio_single title="Coffee" details="Item Details"][orane_custom_portfolio_single title="Coffee" details="Item Details"][orane_custom_portfolio_single title="Coffee" details="Item Details"][orane_custom_portfolio_single title="Coffee" details="Item Details"][orane_custom_portfolio_single title="Coffee" details="Item Details"][orane_custom_portfolio_single title="Coffee" details="Item Details"][/orane_custom_portfolio][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][orane_reservation_form title="|RESERVE| YOUR SEAT NOW" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt." id="``1955``" shortcode="1955"][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][orane_vc_newsletter title="SUBSCRIBE TO OUR NEWSLETTER" image="1916" color="#ffffff" title_color="#fa7c6e"]Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce scelerisque nibh et neque faucibus suscipit. Sed auctor ipsum ut tellus faucibus tincidunt.[/orane_vc_newsletter][/vc_column][/vc_row][vc_row full_width="" parallax="" parallax_image=""][vc_column width="1/1"][orane_simple_testimonials title="WHAT |CUSTOMERS| SAY?"][orane_simple_testimonials_single title="John Doe - Doe Designs" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Exce suscipit. Sed auctor ipsum ut tellus faucibus tincidunt."][orane_simple_testimonials_single title="John Doe - Doe Designs" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Exce suscipit. Sed auctor ipsum ut tellus faucibus tincidunt."][orane_simple_testimonials_single title="John Doe - Doe Designs" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Exce suscipit. Sed auctor ipsum ut tellus faucibus tincidunt."][orane_simple_testimonials_single title="John Doe - Doe Designs" details="Duis aute irure dolor in reprehenderit in voluptate velit esse cillumdolo eu fugiat nulla pariatur. Exce suscipit. Sed auctor ipsum ut tellus faucibus tincidunt."][/orane_simple_testimonials][/vc_column][/vc_row]';

    $data               = array();
    $data['name']       = __( 'Restaurant', 'orane' );
    $data['image_path'] = preg_replace( '/\s/', '%20', plugins_url( 'images/restaurant.png', __FILE__ ) ); // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'Orane Template';
    $data['content']    = $home_template;
 
    vc_add_default_templates( $data );




}


// register new params
include "params/fontawesome.php";

//custom parameters
include "lib/params.php";

//helper functions
include "helper.php";


// includes
include "rating_hero.php";
include "features.php";
include "welcome_banner.php";
include "services.php";
include "fact_bar.php";
include "specialities.php";
include "get_started_banner.php";
include "banner_side_image.php";
include "features_with_bgimage.php";
include "features_big_image.php";
include "small_feature_image.php";
include "projects_portfolio.php";
include "latest_blog.php";
include "testimonials3d.php";
include "page_title.php";
include "space.php";
include "faqs.php";
include "numbers.php";
include "construct.php";
include "accordions.php";
include "parallax.php";
include "progress.php";
include "newsletter.php";
include "features-vertical.php";
include "list_group.php";
include "list_group_advanced.php";
include "alerts.php";
include "team_banner.php";
include "hero.php";
include "pricing.php";
include "hero_blank.php";
include "specialities_general.php";
include "parallax_highlight.php";
include "clients.php";
include "order_now.php";
include "restaurant_about.php";
include "restaurant_menu.php";
include "custom_portfolio.php";
include "reservation.php";
include "simple_testimonials.php";

//inti
new Orane_VC_Rating_Hero();
new Orane_VC_Welcome_Banner();
new Orane_VC_Fact_Bar();
new Orane_VC_GetStarted_Banner();
new Orane_VC_Banner_Side_Image();
new Orane_VC_Features_BGImage();
new Orane_VC_Features_Big_Image();
new Orane_VC_Features_Small_Image();
new Orane_VC_Projects_Portfolio();
new Orane_VC_Latest_Blog();
new Orane_VC_Page_Title();
new Orane_VC_Space();
new Orane_VC_Construct();
new Orane_VC_Parallax();
new Orane_VC_Newsletter();
new Orane_VC_Alerts();
new Orane_VC_Plain_Hero();
new Orane_VC_Blank_Hero();
new Orane_Parallax_Highlight();
new Orane_Order_Now();
new Orane_Restaurant_About();
new Orane_Reservation_Form();







//Projects Custom Post
add_action( 'init', 'register_cpt_project' );

function register_cpt_project() {

    $labels = array( 
        'name' => _x( 'Projects', 'project' ),
        'singular_name' => _x( 'Project', 'project' ),
        'add_new' => _x( 'Add New', 'project' ),
        'add_new_item' => _x( 'Add New Project', 'project' ),
        'edit_item' => _x( 'Edit Project', 'project' ),
        'new_item' => _x( 'New Project', 'project' ),
        'view_item' => _x( 'View Project', 'project' ),
        'search_items' => _x( 'Search Projects', 'project' ),
        'not_found' => _x( 'No projects found', 'project' ),
        'not_found_in_trash' => _x( 'No projects found in Trash', 'project' ),
        'parent_item_colon' => _x( 'Parent Project:', 'project' ),
        'menu_name' => _x( 'Projects', 'project' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'The Projects We Have Worked On.',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', 'comments' ),
        'taxonomies' => array( 'Featured Projects' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-hammer',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'project', $args );
}



//custom texonomies for projects
add_action( 'init', 'orane_projects_taxonomy', 0 );
function orane_projects_taxonomy() {
    register_taxonomy(
        'orane_project_types',
        'project',
        array(
            'labels' => array(
                'name' => 'Types',
                'add_new_item' => 'Add New Type',
                'new_item_name' => "New Type"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );
}





// custom post: our clients
add_action( 'init', 'orane_custom_clients' );
function orane_custom_clients() {

    $labels = array( 
        'name' => __( 'Our Clients', 'orane' ),
        'singular_name' => __( 'Client', 'orane' ),
        'add_new' => __( 'Add New', 'orane' ),
        'add_new_item' => __( 'Add New Client', 'orane' ),
        'edit_item' => __( 'Edit Client', 'orane' ),
        'new_item' => __( 'New Client', 'orane' ),
        'view_item' => __( 'View Client', 'orane' ),
        'search_items' => __( 'Search Our Clients', 'orane' ),
        'not_found' => __( 'No our clients found', 'orane' ),
        'not_found_in_trash' => __( 'No our clients found in Trash', 'orane' ),
        'parent_item_colon' => __( 'Parent Client:', 'orane' ),
        'menu_name' => __( 'Our Clients', 'orane' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon' => 'dashicons-groups',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'client', $args );
}
// ends custom post: our clients






}//ends visual composer installed


//if(is_online()){
    require_once('theme-update-checker.php');
    $orane_update_checker = new ThemeUpdateChecker(
        'orane_core',
        'http://redhawk-studio.com/themes/updates/?action=get_metadata&slug=orane_core'
    );
//}




//check if offline
function is_online($sCheckHost = 'www.google.com')
{
return (bool) @fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
}




//new parameter for visual composer to allow shortcodes to be entered and sanitized properly
// add_shortcode_param( 'orane_shortcode', 'orane_define_shortcode' );
// function orane_define_shortcode( $settings, $value ) {
//    return '<div class="orane_shortcode_block">'
//              .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
//              esc_attr( $settings['param_name'] ) . ' ' .
//              esc_attr( $settings['type'] ) . '_field" type="text" value="' .  $value  . '" />'
//          .'</div>';
// }





?>