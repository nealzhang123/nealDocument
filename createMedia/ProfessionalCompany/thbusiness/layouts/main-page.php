<?php
/**
 * Template Name: 首页模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();
// $post = get_page_by_title( '首頁' );

$cate_id = get_cat_ID( '服務種類' );
$service_posts = get_posts( array(
		'category' => $cate_id,
		'numberposts' => 4,
		'orderby' => 'date',
        'order' => 'ASC',
	)	
);

$cate_id = get_cat_ID( '相關證書' );
$book_posts = get_posts( array(
		'category' => $cate_id,
		'numberposts' => 3,
		'orderby' => 'date',
        'order' => 'ASC',
	)	
);
?>
<div class="tp-banner-container">
	<div class="tp-banner">
		<ul>
			<li data-transition="fade" data-slotamount="2" data-masterspeed="300" >
				<img src="<?php bloginfo('template_url');?>/images/banner/banner-1-back.png" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgposition="left top" />

				<div class="tp-caption sft"
					 data-x="0"
					 data-y="0"
					 data-speed="500"
					 data-start="300"
					 data-easing="easeOutExpo"
					 ><img src="<?php bloginfo('template_url');?>/images/banner/banner-1-image1.png" alt="" style="z-index: 1;">
				</div>

				<div class="tp-caption sfb"
					data-x="494"
					data-y="32"
					data-speed="500"
					data-start="800"
					data-easing="easeOutExpo"
					data-endspeed="300"
					style="z-index:2"><img src="<?php bloginfo('template_url');?>/images/banner/banner-1-image3.png" alt="">
				</div>
			</li>


			<li data-transition="fade" data-slotamount="4" data-masterspeed="300" >
				<img src="<?php bloginfo('template_url');?>/images/banner/banner-2-back.png" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgposition="left top" />

				<div class="tp-caption sfb"
					 data-x="500"
					 data-y="25"
					 data-speed="500"
					 data-start="300"
					 data-easing="easeOutExpo"
					 style="z-index: 1;"
					 ><img src="<?php bloginfo('template_url');?>/images/banner/banner-2-image1.png" alt="">
				</div>

				<div class="tp-caption sfb"
					data-x="438"
					data-y="280"
					data-speed="500"
					data-start="800"
					data-easing="easeOutExpo"
					data-endspeed="300"
					style="z-index:2"><img src="<?php bloginfo('template_url');?>/images/banner/banner-2-image4.png" alt="">
				</div>

				<div class="tp-caption sfl"
					data-x="210"
					data-y="75"
					data-speed="500"
					data-start="1200"
					data-easing="easeOutExpo"
					data-endspeed="300"
					style="z-index:3"><img src="<?php bloginfo('template_url');?>/images/banner/banner-2-image2.png" alt="" >
				</div>

				<div class="tp-caption sfr"
					data-x="650"
					data-y="35"
					data-speed="500"
					data-start="1200"
					data-easing="easeOutExpo"
					data-endspeed="300"
					style="z-index:4"><img src="<?php bloginfo('template_url');?>/images/banner/banner-2-image3.png" alt="">
				</div>
			</li>															   
		</ul>

		<div class="tp-bannertimer"></div>
	</div>	
</div>

<div class="main-server-content">
<div class="container">
<div class="row main-items-top">
<?php 
$i = 0;
foreach ($service_posts as $item) {
	$item->post_content = explode( '。', $item->post_content );
	$item->post_content = $item->post_content[0];
?>
	<div class="col-md-3 col-sm-6 col-xs-12">
	<div class="main-item">
		<div class="main-image-inside">
			<a href="<?php echo get_the_post_thumbnail_url($item->ID); ?>" rel="prettyPhoto[pp_gal2]" title="<?php echo $item->post_title ?>"><?php echo get_the_post_thumbnail( $item->ID ); ?></a>
		</div>
		<div class="main-item-title"><?php echo $item->post_title ?></div>
		<div class="main-item-content"><?php echo $item->post_content ?></div>
		<div class="main-item-more"><a href="<?php echo home_url(); ?>/服務種類/" target="_blank">READ MORE >></a></div>
	</div>
	</div>
<?php } ?>
</div>
</div>
</div>


<div class="main-book-content">
<div class="container">
<div class="row main-book-top">
	<div class="col-md-3 col-xs-12">
		<h1>相關證書</h1>
	</div>
<?php 
$i = 0;
foreach ($book_posts as $item) {
?>
	<div class="col-md-3 col-xs-12">
	<div class="main-book-item">
		<div class="main-book-image-inside">
			<a href="<?php echo get_the_post_thumbnail_url($item->ID); ?>" rel="prettyPhoto[pp_gal]" title="<?php echo $item->post_content ?>"><?php echo get_the_post_thumbnail( $item->ID ); ?></a>
		</div>
		<div class="main-item-title"><?php echo $item->post_title ?>
		</div>
		<div class="main-item-content"><?php echo $item->post_content ?></div>
	</div>
	</div>
<?php } ?>
</div>
</div>
</div>

<?php get_footer(); ?>