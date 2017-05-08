<?php
/**
 * Template Name: 工程案例模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();
global $paged;

if(!$paged){
	$paged = 1;
}
$per_num = 8;

$post = get_page_by_title( '工程案例' );
$tag_post = get_queried_object();

if( !empty( $tag_post->post_parent ) ) {
	$tag_title = $tag_post->post_title;
}else {
	$tag_title = '玻璃屋案例';
}

$args = array(
    'post_type' => 'post',
    'posts_per_page' => $per_num,
    'paged' => $paged,
    'tax_query' => array(
        array(
            'taxonomy' => 'post_tag',
            'field'    => 'name',
            'terms'    => $tag_title,
        ),
    ),
);

$results = new WP_Query( $args );
//echo '<pre>';print_r($example_posts);echo '</pre>';
$max_post_count = $results->max_num_pages;
$example_posts = $results->posts;
?>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="main-head-title">
					<p style="font-family: -webkit-pictograph;font-size: 30px;">Call Now : 5546 8412</p>
				</div>
				<h3 style="margin: 1.5em 0;color: #1a4b63;font-weight: bold;">工程案例</h3>
				<div class="main-head-content">
					<?php echo $post->post_content; ?>
				</div>
		    </div>
		    <div class="col-md-6 main-head-image" style="margin-top: 45px;" >
		      	<?php echo get_the_post_thumbnail( $post->ID ); ?>
		    </div>
		</div>
	</div>
</div>

</div><!-- .container-fluid -->
	<div class="container-fluid main-whole">
	<div class="container">
	<div class="main-hidden"></div>
	<div class="row">
	<div class="main-items-top">
	<?php 
	if( empty( $example_posts ) ) {
	?>
		<p>沒有找到相關的案例</p>
	<?php
	}
	foreach ($example_posts as $item) {
	?>
		<div class="col-md-3 col-sm-6 main-item example-item">
			<div class="example-item-inside">
			<div class="main-image-inside"><?php echo get_the_post_thumbnail( $item->ID ); ?></div>
			<div class="main-item-title"><?php echo $item->post_title ?></div>
			<div class="main-item-content"><?php echo $item->post_content ?></div>
			</div>
		</div>
	<?php } ?>
	</div>
	</div>

	<?php 
	if( !empty( $example_posts ) ) {
	?>
		<div class="pagenav"><?php par_pagenavi( 4, $max_post_count );?></div>
	<?php
	}
	?>

	</div>
	</div>
</div>
<?php get_footer(); ?>