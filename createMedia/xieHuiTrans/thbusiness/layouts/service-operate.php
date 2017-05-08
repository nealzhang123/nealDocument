<?php
/**
 * Template Name: 運營服務模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();

global $post;
?>

<div class="service-content">
<div class="service-div">
	<img src="<?php echo get_the_post_thumbnail_url( $post->ID ); ?>" />
</div>

<div class="service-inside2">
	<h1>運營服務</h1>
</div>

<div class="service-inside1">
	<?php echo $post->post_content; ?>
</div>

</div>

<?php get_footer(); ?>