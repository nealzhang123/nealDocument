<?php
/**
 * Template Name: 媒體報道模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header(); 

$cate_id = get_cat_ID( '媒體報道' );
$media_posts = get_posts( array(
		'category' => $cate_id,
		'numberposts' => 20,
		'orderby' => 'date',
        'order' => 'ASC',
	)	
);
?>
<div class="pages-title">
	<div class="container">
		<h1>媒體報道</h1>
	</div>
</div>

<div class="media-content">
<div class="container">
<div class="row">
<?php 
foreach ($media_posts as $item) {
?>
	<div class="media-items">
		<div class="col-md-3">
			<div class="media-item-image">
				<a href="<?php echo get_the_post_thumbnail_url($item->ID); ?>" rel="prettyPhoto[pp_gal]" title=""><?php echo get_the_post_thumbnail( $item->ID ); ?></a>
			</div>
		</div>
	</div>
<?php } ?>
</div>
</div>
</div>




<?php get_footer(); ?>