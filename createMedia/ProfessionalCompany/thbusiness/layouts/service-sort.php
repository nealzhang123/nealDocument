<?php
/**
 * Template Name: 服務種類模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();

$cate_id = get_cat_ID( '服務種類' );
$service_posts = get_posts( array(
		'category' => $cate_id,
		'numberposts' => 4,
		'orderby' => 'date',
        'order' => 'ASC',
	)	
);
?>
<div class="pages-title">
	<div class="container">
		<h1>服務種類</h1>
	</div>
</div>

<div class="server-sort-content">
<div class="container">
<?php 
$i = 0;
foreach ($service_posts as $item) {
	$item->post_content = explode( '。', $item->post_content );
	$item->post_content = $item->post_content[0];
?>
	<div class="row service-sort-items">
		<div class="col-md-3 col-xs-12">
			<div class="service-sort-item-image"><?php echo get_the_post_thumbnail( $item->ID ); ?></div>
		</div>
		<div class="col-md-9 col-xs-12">
			<div class="service-sort-item-title"><h2><?php echo $item->post_title ?></h2></div>
			<div class="service-sort-item-content"><?php echo $item->post_content ?></div>
		</div>
	</div>
<?php } ?>
</div>
</div>




<?php get_footer(); ?>