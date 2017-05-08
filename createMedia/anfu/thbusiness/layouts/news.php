<?php
/**
 * Template Name: 最新資訊模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();

$cate_id = get_cat_ID( 'news' );
$news_posts = get_posts( array(
		'category' => $cate_id,
		//'numberposts' => 10,
		'orderby' => 'date',
        'order' => 'DESC',
	)	
);
?>

<div class="">
<div class="container news-sort-content">
<?php 
// echo '<pre>';print_r($news_posts);echo '</pre>';
foreach ($news_posts as $item) {
	$post_date = date( 'Y年m月d日',strtotime( $item->post_date ) );
?>
	<div class="row news-sort-items">
		<div class="col-md-3 col-xs-12">
			<div class="news-sort-item-image"><?php echo get_the_post_thumbnail( $item->ID ); ?></div>
		</div>
		<div class="col-md-9 col-xs-12">
			<div class="news-sort-item-title"><h2><?php echo $item->post_title; ?></h2></div>
			<div class="news-sort-item-date"><h5><?php echo $post_date; ?></h5></div>
			<div class="news-sort-item-content"><?php echo $item->post_content; ?></div>
		</div>
	</div>
<?php } ?>
</div>
</div>




<?php get_footer(); ?>