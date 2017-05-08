<?php
/**
 * Template Name: 公司簡介模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header(); 

global $post;
?>

<div class="company-content">
<div class="company-div">
	<img src="<?php echo get_the_post_thumbnail_url( $post->ID ); ?>" />
</div>

<div class="company-inside1">
	<div class="company-inside2">
	<h1>關於我們</h1>
	</div>
	<?php echo $post->post_content; ?>
</div>

</div>




<?php get_footer(); ?>