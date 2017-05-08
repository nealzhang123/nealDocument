<?php
/**
 * Template Name: 首页模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();

global $post;

//防蚊網
$cate = get_category_by_slug( 'type1' );
$project_posts_1 = get_posts( array(
		'category' => $cate->term_id,
		'orderby' => 'date',
        'order' => 'ASC',
        'numberposts' => 4,
        'post_type' => 'project'
	)	
);

//鋁窗工程
$cate = get_category_by_slug( 'type2' );
$project_posts_2 = get_posts( array(
		'category' => $cate->term_id,
		'orderby' => 'date',
        'order' => 'ASC',
        'numberposts' => 4,
        'post_type' => 'project'
	)	
);


// echo '<pre>';print_r($post);echo '</pre>';exit();
?>
<div class="tp-banner-container">
	<img src="<?php bloginfo('template_url');?>/images/banner.jpg" />	
</div>

<div class="main-page-content">
<div class="container">
<div class="row main-items-top">
	<div class="col-md-6 col-xs-12">
		<div class="main-items-prices">
			<?php echo $post->post_content; ?>
		</div>
	</div>
	<div class="col-md-3 col-xs-12">
		<div class="main-items-left">
			<h3 style="text-align: center;">各類蚊網類</h3>
			<div class="swiper-container">
				<div class="swiper-wrapper">
		        <?php foreach ( $project_posts_1 as $item ) { ?>
		        	<div class="swiper-slide"><img src="<?php echo get_the_post_thumbnail_url($item->ID); ?>" /></div>
		        <?php } ?>
		        </div>
		    </div>
		    <div class="main-items-readmore">
		    	<a href="<?php echo home_url() . '/工程案例'; ?>">READ MORE >></a>
		    </div>
		</div>
	</div>
	<div class="col-md-3 col-xs-12">
		<div class="main-items-right">
			<h3 style="text-align: center;">各款蚊網工程</h3>
			<div class="swiper-container2">
				<div class="swiper-wrapper">
		        <?php foreach ( $project_posts_2 as $item ) { ?>
		        	<div class="swiper-slide"><img src="<?php echo get_the_post_thumbnail_url($item->ID); ?>" /></div>
		        <?php } ?>
		        </div>
		    </div>
		    <div class="main-items-readmore">
		    	<a href="<?php echo home_url() . '/工程案例'; ?>">READ MORE >></a>
		    </div>
	    </div>
	</div>

</div>
</div>
</div>


<div class="main-page-company-div">
<div class="container main-page-company">
<div class="row">
	<h1>公司簡介</h1>
	<p><?php echo $post->post_excerpt; ?></p>
</div>
</div>
</div>
<!-- 
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
</div> -->

<?php get_footer(); ?>