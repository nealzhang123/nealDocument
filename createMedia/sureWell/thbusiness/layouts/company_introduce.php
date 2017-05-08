<?php
/**
 * Template Name: 公司簡介模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();

$intro_posts = get_posts( 
	array(
        'numberposts' => '-1',
        'post_type' => 'introduce',
        'order' => 'ASC',
        'suppress_filters' => false
	)	
);

?>
<div class="intro-div">
<div class="container">
<div class="row">
<?php 
foreach ($intro_posts as $item) {
?>
	<div class="col-md-4 col-xs-12">
		<?php echo get_the_post_thumbnail( $item->ID ); ?>
		<h2><?php echo $item->post_title; ?></h2>
		<?php echo $item->post_content; ?>
	</div>
<?php } ?>
</div>
</div>
</div>

<?php get_footer(); ?>