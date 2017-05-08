<?php
/**
 Template Name: 最新優惠模板
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
global $post;

get_header(); 
 
?>
<div class="top-shadow"></div>

<div class="container_fluid coupon_div">
<div class="row">
	<div class="col-md-8 col-xs-12">
		<img src="<?php echo get_the_post_thumbnail_url( $post->ID ); ?>" />
	</div>

	<div class="col-md-4 col-xs-12">
		<?php echo $post->post_content; ?>
	</div>
</div>
</div>
  
    
    
<div class="clear"></div>
  <!-- **Main - End** -->


<?php
get_footer();
?>