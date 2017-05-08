<?php
/**
 * Template Name: 首页模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();
$post = get_page_by_title( '首頁' );

$service_post = get_page_by_title( '服務範圍', OBJECT, 'post' );

$cate_id = get_cat_ID( '服務範圍' );
$service_posts = get_posts( array(
		'category' => $cate_id,
		'numberposts' => 8,
		'orderby' => 'date',
        'order' => 'ASC',
	)	
);

?>
	<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="main-head-title">
				<p style="font-family: -webkit-pictograph;font-size: 30px;">Call Now : 5546 8412</p>
				<p>免費驗窗,免費到府估價</p>
				<p>提供24小時緊急維修服務</p>
			</div>
			<div class="main-head-content">
				<?php echo $post->post_content; ?>
			</div>
			<div class="main-head-button">
				<button type="button" class="btn btn-primary btn-lg"><a style="color: white;" href="<?php echo site_url('聯絡我們'); ?>">聯絡我們&nbsp;<i class="fa fa-arrow-right fa-lg" aria-hidden="true" style="color: white;"></i></a></button>
			</div>
	    </div>
	    <div class="col-md-6 main-head-image">
	      	<?php echo get_the_post_thumbnail( $post->ID ); ?>
	    </div>
	</div>
	</div>
</div><!-- .container-fluid -->
<div class="container-fluid main-whole">
	<div class="container">
	<div class="row">
		<div class="main-title">
			<?php echo $service_post->post_title; ?>
		</div>
		<div class="main-content">
			<?php echo $service_post->post_content; ?>
		</div>
	</div>

	<div class="row">
	<div class="main-items-top">
	<?php 
	$i = 0;
	foreach ($service_posts as $item) {
		if( $i > 3 ) {
			break;
		}
		$i++;
	?>
		<div class="col-md-3 col-sm-6 main-item main-item-top">
			<div class="main-image-inside"><?php echo get_the_post_thumbnail( $item->ID ); ?></div>
			<div class="main-item-title"><?php echo $item->post_title ?></div>
			<div class="main-item-content"><?php echo $item->post_content ?></div>
		</div>
	<?php } ?>
	</div>
	</div>

	<hr>

	<div class="row">
	<div class="main-items-bottom">
	<?php 
	$j = 0;
	foreach ($service_posts as $item) {
		if( $j < 4 ) {
			$j++;
			continue;
		}
		if( $j > 7 ) {
			break;
		}
		$i++;
	?>
		<div class="col-md-3 col-sm-6 main-item main-item-bottom">
			<div class="main-image-inside"><?php echo get_the_post_thumbnail( $item->ID ); ?></div>
			<div class="main-item-title"><?php echo $item->post_title ?></div>
			<div class="main-item-content"><?php echo $item->post_content ?></div>
		</div>
	<?php } ?>
	</div>
	</div>

	</div>
	</div>
</div>
<?php get_footer(); ?>