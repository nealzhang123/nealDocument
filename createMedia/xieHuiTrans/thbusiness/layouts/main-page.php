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

?>
<div class="main-page-content">
<div class="main-banner-div">
	<img src="<?php echo get_template_directory_uri() . '/images/banner1.jpg'; ?>" class="main-banner main-banner1" />
	<img src="<?php echo get_template_directory_uri() . '/images/banner2.jpg'; ?>" class="main-banner main-banner2" />
	<img src="<?php echo get_template_directory_uri() . '/images/banner3.jpg'; ?>" class="main-banner main-banner3" />
	<img src="<?php echo get_template_directory_uri() . '/images/banner4.jpg'; ?>" class="main-banner main-banner4" />
</div>

<div class="main-inside1">
	<h1><?php bloginfo( 'name' ); ?></h1>
	<h2><?php bloginfo( 'description' ); ?></h2>
</div>

<div class="main-inside2">
	<div class="container main-inside2-container">
		<div class="col-md-3 col-xs-3 preview-image preview-active" data-index="1">
			<a href="<?php echo home_url(); ?>/空運/"><img src="<?php echo get_template_directory_uri() . '/images/banner1-preview.png'; ?>" /></a>
		</div>
		<div class="col-md-3 col-xs-3 preview-image" data-index="2">
			<a href="<?php echo home_url(); ?>/海運/"><img src="<?php echo get_template_directory_uri() . '/images/banner2-preview.png'; ?>" /></a>
		</div>
		<div class="col-md-3 col-xs-3 preview-image" data-index="3">
			<a href="<?php echo home_url(); ?>/運輸車隊/"><img src="<?php echo get_template_directory_uri() . '/images/banner3-preview.png'; ?>" /></a>
		</div>
		<div class="col-md-3 col-xs-3 preview-image" data-index="4">
			<a href="<?php echo home_url(); ?>/倉庫管理/"><img src="<?php echo get_template_directory_uri() . '/images/banner4-preview.png'; ?>" /></a>
		</div>
	</div>
</div>
</div>


<?php get_footer(); ?>