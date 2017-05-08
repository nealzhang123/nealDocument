<?php
/**
 * Template Name: 短片模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();

?>

<div class="short-vedio-content">
	<div>
        <?php echo do_shortcode('[wonderplugin_slider id=1]'); ?>
    </div>
</div>

<?php get_footer(); ?>