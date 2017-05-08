<?php
/**
 * Template Name: 關於我們模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();
global $post;

$post_content = $post->post_content;
?>

<div class="about-us-div">
<div class="container">
<div class="row">
	<div class="col-md-4 col-xs-12 about-us-image">
		<?php the_post_thumbnail(); ?>
	</div>
	<div class="col-md-8 col-xs-12 about-us-content">
		<?php echo str_replace( ']]>', ']]&gt;', $post_content ); ?>
	</div>
</div>
</div>
</div>




<?php get_footer(); ?>