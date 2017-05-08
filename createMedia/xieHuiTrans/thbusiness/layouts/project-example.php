<?php
/**
 * Template Name: 工程案例模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();

//防蚊網
$cate = get_category_by_slug( 'type1' );
$project_posts_1 = get_posts( array(
		'category' => $cate->term_id,
		'orderby' => 'date',
        'order' => 'ASC',
        'numberposts' => -1,
        'post_type' => 'project'
	)	
);

//鋁窗工程
$cate = get_category_by_slug( 'type2' );
$project_posts_2 = get_posts( array(
		'category' => $cate->term_id,
		'orderby' => 'date',
        'order' => 'ASC',
        'numberposts' => -1,
        'post_type' => 'project'
	)	
);

//陽台防護網
$cate = get_category_by_slug( 'type3' );
$project_posts_3 = get_posts( array(
		'category' => $cate->term_id,
		'orderby' => 'date',
        'order' => 'ASC',
        'numberposts' => -1,
        'post_type' => 'project'
	)	
);

//各式窗花
$cate = get_category_by_slug( 'type4' );
$project_posts_4 = get_posts( array(
		'category' => $cate->term_id,
		'orderby' => 'date',
        'order' => 'ASC',
        'numberposts' => -1,
        'post_type' => 'project'
	)	
);

?>
<div class="pages-title">
	<div class="container">
		<h1>工程案例</h1>
	</div>
</div>

<div class="project-exmaple-div">
<div class="container">

<div class="project_posts_div1">
<div class="row">
	<h4>防蚊網</h4>
<?php 
$i = 0;
foreach ( $project_posts_1 as $item ) {
?>
	<div class="col-md-2 col-xs-6">
	<div class="project_posts_image">
		<div class="project_posts_image_extra">
		<a href="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" rel="prettyPhoto[pp_gal]" title="<?php echo $item->post_title; ?>">
			<img src="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" />
		</a>
		</div>
		<p><?php echo $item->post_title; ?></p>
	</div>
	</div>
<?php } ?>
</div>
</div>

<div class="project_posts_div2">
<div class="row">
	<h4>鋁窗工程</h4>
<?php 
$i = 0;
foreach ( $project_posts_2 as $item ) {
?>
	<div class="col-md-2 col-xs-6">
	<div class="project_posts_image">
		<div class="project_posts_image_extra">
		<a href="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" rel="prettyPhoto[pp_gal2]" title="<?php echo $item->post_title; ?>">
			<img src="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" />
		</a>
		</div>
		<p><?php echo $item->post_title; ?></p>
	</div>
	</div>
<?php } ?>
</div>
</div>

<div class="project_posts_div3">
<div class="row">
	<h4>陽台防護網</h4>
<?php 
$i = 0;
foreach ( $project_posts_3 as $item ) {
?>
	<div class="col-md-2 col-xs-6">
	<div class="project_posts_image">
		<div class="project_posts_image_extra">
		<a href="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" rel="prettyPhoto[pp_gal3]" title="<?php echo $item->post_title; ?>">
			<img src="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" />
		</a>
		</div>
		<p><?php echo $item->post_title; ?></p>
	</div>
	</div>
<?php } ?>
</div>
</div>

<div class="project_posts_div4">
<div class="row">
	<h4>各式窗花</h4>
<?php 
$i = 0;
foreach ( $project_posts_4 as $item ) {
?>
	<div class="col-md-2 col-xs-6">
	<div class="project_posts_image">
		<div class="project_posts_image_extra">
		<a href="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" rel="prettyPhoto[pp_gal4]" title="<?php echo $item->post_title; ?>">
			<img src="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" />
		</a>
		</div>
		<p><?php echo $item->post_title; ?></p>
	</div>
	</div>
<?php } ?>
</div>
</div>

</div>
</div>




<?php get_footer(); ?>