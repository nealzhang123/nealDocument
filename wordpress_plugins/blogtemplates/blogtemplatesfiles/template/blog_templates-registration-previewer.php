<div id="blog_template-selection">
	<h3><?php _e('Select a template', 'blog_templates') ?></h3>

	<?php
	
	register_etongapp_thmeme_show($templates,$settings);
	



function register_etongapp_thmeme_show($templates,$settings){
	if(wp_is_mobile()){
		$perview=2;
	}else{
		$perview=4;
	}

	$model = nbt_get_model();
	$options = nbt_get_settings();
  	$categories = $model->get_templates_categories();
	$template_info[] = $model->get_templates_by_category( $cat_id );

	// $templates['0'] = array($templates);
	foreach ( $categories as $category ) {
		$template_result = $model->get_templates_by_category( $category['ID'] );
		if( $template_result){
			$tabs[ $category['ID'] ] = $category['name'];
			$template_info[] = $template_result;
		}
	}

	$number = 1;
  	?>
  	<div id="contrast">
	    <a class="" href="javascript:void(0)" id="btn0" class="default">ALL</a>
	    <?php foreach ( $tabs as $tab_key => $tab_name ): ?>
	    <a href="javascript:void(0)" id="btn<?php echo $number; ?>" class=""><?php echo $tab_name; ?></a>
	<?php 
	    $number++;
	    endforeach; 
	?>
    </div>
    
	<div class="blog_template-option-register">
		 <div class="swiper-container" id="swiper-container-bg">
	        <div class="swiper-wrapper">
		<?php 
			for ($x=0; $x<$number; $x++) {
		?>
				<div class="swiper-slide">
	                <div class="swiper-container" id="swiper-container-middle<?php echo $x;?>">
	                    <div class="swiper-wrapper">
	                    	<?php
							foreach( $template_info[$x] as $tkey => $template){
								// print_r($template);
								$img = ( ! empty( $template['screenshot'] ) ) ? $template['screenshot'] : nbt_get_default_screenshot_url( $template['blog_id'] );
								$blog_url = get_blogaddress_by_id($template['blog_id']);
								$a = urlencode($blog_url);
								//print_r($img);
							?>
							<div class="swiper-slide">

								<div class = "template-content" id="template-content-<?php echo $template['ID'];?>">
					            	
										<div class="template_preview_img">
											<a href="<?php echo network_site_url();?>demo/?blog_url=<?php echo $a;?>&template_id=<?php echo $template['ID'];?>&template_resource=signup&template_name=<?php echo $template['name']; ?>" target="_blank">
											<img data-src="<?php echo $img;?>" class="swiper-lazy">
											<div class="swiper-lazy-preloader"></div>
												</a>
											<input type="radio" name="blog_template" id="blog-template-radio-<?php echo $template['ID'];?>" value="<?php echo $template['ID'];?>" style="display: none" />
											<input type="hidden" name="blog_template_demo" id="blog-template-radio-demo-<?php echo $template['ID'];?>"  value="<?php echo network_site_url();?>demo/?blog_url=<?php echo $a;?>&template_id=<?php echo $template['ID'];?>&template_resource=signup&template_name=<?php echo $template['name']; ?>"  />
											<input type="hidden" name="blog_template_name" id="blog-template-radio-name-<?php echo $template['ID'];?>"  value="<?php echo $template['name'];?>"  />
											<input type="hidden" name="blog_template_image_url" id="blog-template-radio-image-url-<?php echo $template['ID'];?>"  value="<?php echo $img;?>"  />
											<div class="template-des">
												<div class="template-name">
							          				<button class="select-theme-button-register" data-theme-key="<?php echo $template['ID'];?>"><i class="fa fa-check-circle"></i>选择该主题</button>
							            		</div>
							            	</div>
											
										</div>
									</div>
									 
								
				            </div>
							
				            <?php 
				            }
				            ?>
	                    </div>
	                </div>
	                <div class="swiper-button-next" id="swiper-button-next-middle<?php echo $x;?>"></div>
	                <div class="swiper-button-prev" id="swiper-button-prev-middle<?php echo $x;?>"></div>
	            </div>
		<?php
			}
		?>

			</div>
	    </div>
	</div>
	<input type="hidden" name="blog_template_check" id="blog-template-radio-check" value=""  />
    <div class="selected-theme-content">

    	<div class="theme-pic">
    	
    		
    	</div>
    </div>
    <script type="text/javascript">
		jQuery(document).ready(function($) {
			jQuery(document).on( 'click', '.select-theme-button-register', function(e) {
				e.preventDefault();
				var theme_key = jQuery(this).data('theme-key');
				jQuery('.template-content').removeClass('bg-slider');
				jQuery(this).parents('.template-content').addClass('bg-slider');
				jQuery('input[name=blog_template]').attr('checked',false);
				jQuery(this).parents('.template-content').find('input[name=blog_template]').attr('checked',true);
				jQuery('.select-theme-button-register').removeClass('bg-theme');
				jQuery(this).addClass('bg-theme');
				var blogtemplateimageurl 		= jQuery(this).parents('.template-des').prev().val();
				var blogtemplatename 			= jQuery(this).parents('.template-des').prev().prev().val();
				var blogtemplatedemo 			= jQuery(this).parents('.template-des').prev().prev().prev().val();
				jQuery('#blog-template-radio-check').attr('value',theme_key);
				var pic = "<i class='fa fa-check-square-o'></i>当前选择的主题：<a href='"+blogtemplatedemo+"' target='_blank'><span class='template-image'><img src='"+blogtemplateimageurl+"' width='20px' height='10px'></span>&nbsp;"+blogtemplatename+"</a>";
				jQuery('.theme-pic').html(pic);
			});
			jQuery('.submit').click(function(){
				if(!jQuery('#blog-template-radio-check').val()){
					jQuery('.theme-pic').html('<span class="register-theme-error"><i class="fa fa-exclamation-triangle"></i>请选择主题</span>').show();
					return false;
				}
				
			});
		});
		
		</script>
	  <style>

    body {
        background: #eee;
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        color:#000;
        margin: 0;
        padding: 0;
    }
    .register-theme-error{
    	color:red;
    }
    .select-theme-button-register{
    	font-size:20px;
    	vertical-align: top;
    }
    .selected-theme-content{
		text-align: center;
    }
    .swiper-container {
        width: 100%;
        height: 200px;
        margin: 20px auto;
    }
    .bg-slider{
    	border:5px green solid;
    }
   	.blog_template-option-register ,.selected-theme-content{
   		left: -280px;
	    position: relative;
	    width: 1000px;
   	}
    .swiper-slide {
    	
    	overflow: hidden;
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
    	border-top: 1px solid <?php echo $options['toolbar-border-color']; ?>;
        margin-top: 10px;
        padding-top: 10px;
        text-align: center;
    }
    #contrast a {
      background: <?php echo $options['toolbar-color']; ?>;
      color: <?php echo $options['toolbar-text-color']; ?>;
      text-decoration: none;
      padding: 5px 15px;
      border-radius: 4px;
      margin: 0 5px;
    }
    .swiper-button-prev, .swiper-container-rtl .swiper-button-next {
	    background-image: url("<?php echo plugins_url( 'blogtemplates/blogtemplatesfiles/assets/images/01.png' );?>");
	    left: 10px;
	    right: auto;
	}
	.swiper-button-next, .swiper-container-rtl .swiper-button-prev {
	    background-image: url("<?php echo plugins_url( 'blogtemplates/blogtemplatesfiles/assets/images/02.png' );?>");
	    left: auto;
	    right: 10px;
	}
	.template-content
	{
		-webkit-transition: all 200ms ease-in;
		-webkit-transform-origin: 50% 20%;
		-webkit-transform: scale(1);
		-moz-transition: all 200ms ease-in;
		-moz-transform-origin: 50% 20%;
		-moz-transform: scale(1);
		-ms-transition: all 200ms ease-in;
		-ms-transform-origin: 50% 20%;
		-ms-transform: scale(1);
		transition: all 200ms ease-in;
		transform-origin: 50% 20%;
		transform: scale(1);
		/*width: 100%;
		height: 100%;
		position: absolute;
		z-index: 2;
		left: 0;*/
		display: block;
	} 
	.swiper-lazy{
		width: 280px;
	}

	.template-content.template_preview_img img{
		width: 280px;
		/*height: 150px;*/
	}

	/*.template-content:hover 
	{
		-webkit-transition: all 150ms ease-in;
		-webkit-transform: scale(1.05);
		-moz-transition: all 150ms ease-in;
		-moz-transform: scale(1.05);
		-ms-transition: all 150ms ease-in;
		-ms-transform: scale(1.05);
		transition: all 150ms ease-in;
		transform: scale(1.05);
	}*/


	.template-content:hover .template-des{
		display: block;
		background-color: black;
		filter:alpha(opacity=90);  
		-moz-opacity:0.9;  
		-khtml-opacity: 0.9;  
		opacity: 0.9;
		-webkit-transition: all 500ms ease-in;
		-webkit-transform: scale(1.0);
		-moz-transition: all 500ms ease-in;
		-moz-transform: scale(1.0);
		-ms-transition: all 500ms ease-in;
		-ms-transform: scale(1.0);
		transition: all 500ms ease-in;
		transform: scale(1.0);
	}


	.select-theme-button-register{
		color: #000;
	}
	.template-content .template-des{
		width: 100%;
		padding: 10px;
		bottom: 0;
		position: absolute;
		z-index: 9999;
		text-align: center;
		color: #000;
		font-size: 15px;
		font-weight: 400;
		display: none;
	}
	.bg-theme{
    	color:green;
    }
    .fa-check-circle{
    	margin-right: 8px;
    }
    /*img{
        width:250px;
        height:187.82px;
    }*/
    </style>
	
     <script>
    var swiper = new Swiper('#swiper-container-bg',{
        direction : 'vertical',
    });
    </script>
    <?php 
    for($i=0; $i<$number; $i++){
    ?>
    <script>
    var myswiper<?php echo $i;?> = new Swiper('#swiper-container-middle<?php echo $i;?>',{
        slidesPerView : 4,//'auto'
        spaceBetween : 20,
        loop:true,
        nextButton: '#swiper-button-next-middle<?php echo $i;?>',
        prevButton: '#swiper-button-prev-middle<?php echo $i;?>',
        spaceBetween: 30,
        lazyLoading : true,

    });
    jQuery('#btn<?php echo $i;?>').click(function(){
    	swiper.slideTo(<?php echo $i;?>, 1000, false);//切换到第一个slide，速度为1秒
    })
    </script>
    <?php 
    }
}

