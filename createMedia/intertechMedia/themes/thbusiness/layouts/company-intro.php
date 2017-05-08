<?php
/**
 * Template Name: 公司介紹模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header(); 

$post = get_page_by_title( '公司介紹' );

$certif_post = get_page_by_title( '一佰鋁窗玻璃工程公司', OBJECT, 'post' );

$cate_id = get_cat_ID( '證書' );
$certif_posts = get_posts( array(
		'category' => $cate_id,
		'numberposts' => 12,
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
				</div>
				<h3 style="margin: 1.5em 0;color: #1a4b63;font-weight: bold;">公司簡介</h3>
				<div class="main-head-content">
					<?php echo $post->post_content; ?>
				</div>
		    </div>
		    <div class="col-md-6 main-head-image" style="margin-top: 45px;">
		      	<?php echo get_the_post_thumbnail( $post->ID ); ?>
		    </div>
		</div>
	</div>
</div>

</div><!-- .container-fluid -->
	<div class="container-fluid main-whole">
	<div class="container">
	<div class="row">
		<div class="certif-intro-title">
			<?php echo $certif_post->post_title; ?>
		</div>
		<hr />
		<div class="certif-content">
			<?php echo $certif_post->post_content; ?>
		</div>
	</div>

	<div class="row">
	<div class="certif-title">
		公司認證:
	</div>
	<div class="certif-items">
	<?php 
	foreach ($certif_posts as $item) {
	?>
		<div class="col-md-3 col-sm-6 certif-item">
			<div class="main-image-inside"><?php echo get_the_post_thumbnail( $item->ID ); ?></div>
			<div class="certif-item-content"><?php echo $item->post_content ?></div>
		</div>
	<?php } ?>
	</div>
	</div>

	
	</div>
	</div>
</div>
<?php get_footer(); ?>