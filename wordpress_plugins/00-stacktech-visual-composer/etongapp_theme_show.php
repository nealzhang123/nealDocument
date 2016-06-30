<?php

add_shortcode('etongapp-theme', 'etongapp_thmeme_show_function');


function etongapp_thmeme_show_function(){
	

	if(wp_is_mobile()){
		$perview=2;
	}else{
		$perview=4;
	}

	$model = nbt_get_model();
	$options = nbt_get_settings();
  	$categories = $model->get_templates_categories();
	$templates[] = $model->get_templates_by_category( $cat_id );
	
	foreach ( $categories as $category ) {
		$template_result = $model->get_templates_by_category( $category['ID'] );
		if( $template_result){
			$tabs[ $category['ID'] ] = $category['name'];
			$templates[] = $template_result;
		}
	}
	$number = 1;
  	

    $output='<div id="contrast">
            <a class="" href="javascript:void(0)" id="btn0" class="default">ALL</a>';
    foreach ( $tabs as $tab_key => $tab_name ){
        $output .='<a href="javascript:void(0)" id="btn'. $number.'" class="">'.$tab_name.'</a>';
        $number++;
    }
    $output .='</div>
            <div class="swiper-container" id="swiper-container-bg">
                <div class="swiper-wrapper">';
    for ($x=0; $x<$number; $x++) {
    $output .='<div class="swiper-slide">
                <div class="swiper-container" id="swiper-container-middle'.$x.'">
                    <div class="swiper-wrapper">';
                        foreach( $templates[$x] as $tkey => $template){
                            $img = ( ! empty( $template['screenshot'] ) ) ? $template['screenshot'] : nbt_get_default_screenshot_url( $template['blog_id'] );
                            $blog_url = get_blogaddress_by_id($template['blog_id']);
                            $a = urlencode($blog_url);
                        $output .='<div class="swiper-slide">
                            <a href="'.network_site_url().'demo/?blog_url='.$a.'&template_id='.$template['ID'].'&template_name='.$template['name'].'" target="_blank">
                                <div class="etongapp_massive_theme_page_preview_img">
                                    <img data-src="'.$img.'" class="swiper-lazy">
                                    <div class="swiper-lazy-preloader"></div>
                                </div>
                            </a>
                        </div>';
                        }
    $output .='       </div>
                </div>
                <div class="swiper-button-next" id="swiper-button-next-middle'. $x.'"></div>
                <div class="swiper-button-prev" id="swiper-button-prev-middle'. $x.'"></div>
            </div>';
        }
    $output .='</div>
    </div>';
    $output .='
	<style>
    .swiper-container {
        width: 100%;
        height: 200px;
        margin: 20px auto;
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        /*background: #fff;
        */
        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    #contrast {
    	/*border-top: 1px solid '.$options["toolbar-border-color"].';*/
        margin-top: 10px;
        padding-top: 10px;
        text-align: center;
    }
    #contrast a {
      background: '.$options["toolbar-color"].';
      color: '.$options["toolbar-text-color"].';
      text-decoration: none;
      padding: 5px 15px;
      border-radius: 4px;
      margin: 0 5px;
      display: inline-block;
      margin-top: 5px;
    }
    .swiper-button-prev, .swiper-container-rtl .swiper-button-next {
	    background-image: url("'.plugins_url( "images/01.png" , __FILE__ ).'");
	    left: 10px;
	    right: auto;
	}
	.swiper-button-next, .swiper-container-rtl .swiper-button-prev {
	    background-image: url("'.plugins_url( "images/02.png", __FILE__ ).'");
	    left: auto;
	    right: 10px;
	}
    .etongapp_massive_theme_page_preview_img img{
        width:250px;
        height:187.82px;
    }
    </style>';
	
    $output .='<script>
    var swiper = new Swiper("#swiper-container-bg",{
       
        direction : "vertical",
    });
    </script>';
    for($i=0; $i<$number; $i++){
    
     $output .='<script>
    var myswiper'.$i.' = new Swiper("#swiper-container-middle'.$i.'",{
        slidesPerView : '.$perview.',//"auto"
        spaceBetween : 20,
        loop:true,
        nextButton: "#swiper-button-next-middle'.$i.'",
        prevButton: "#swiper-button-prev-middle'.$i.'",
        spaceBetween: 30,
        lazyLoading : true,

    });
    jQuery("#btn'.$i.'").click(function(){
    	swiper.slideTo('.$i.', 1000, false);//切换到第一个slide，速度为1秒
    })
    </script>';
    
    }
    return $output;
}

function stacktech_massive_theme_add_styles() {
	if(!is_admin()){
        wp_register_style('swiper_stylesheet',  plugins_url( 'assets/swiper.min.css' , __FILE__ ));
    	wp_enqueue_style('swiper_stylesheet');
    	wp_register_script('swiper_scriptsheet',  plugins_url( 'assets/swiper.min.js' , __FILE__ ));
    	wp_enqueue_script('swiper_scriptsheet');
    }
}

add_action( 'init', 'stacktech_massive_theme_add_styles' );   
