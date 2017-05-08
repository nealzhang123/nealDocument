<?php
/**
 * Template Name: 服務定價模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();

$cate_id = get_cat_ID( '服務定價' );
$service_posts = get_posts( array(
		'category' => $cate_id,
		'numberposts' => 4,
		'orderby' => 'date',
        'order' => 'ASC',
	)	
);

$cate_id = get_cat_ID( '銀行' );
$bank_posts = get_posts( array(
		'category' => $cate_id,
		'numberposts' => 4,
		'orderby' => 'date',
        'order' => 'ASC',
	)	
);
?>
<div class="pages-title">
	<div class="container">
		<h1>服務定價</h1>
	</div>
</div>

<div class="server-sort-content">
<div class="container">
<?php 
$i = 0;
foreach ($service_posts as $item) {
	if( wp_is_mobile() ) {
		$item->post_content = preg_replace('|．{1,}|','FFFFFF',$item->post_content);
		$item->post_content = preg_replace('|(FFFFFF){1,}|','<br />',$item->post_content);
	}
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

<div class="server-bank-content">
<div class="container">
	<div>
		<h2>請繳交款項到以下任何一間銀行:</h2>
	</div>
	<div class="service-bank-items row">
	<?php 
	$i = 0;
	foreach ($bank_posts as $item) {
	?>
		<div class="col-md-6 col-xs-12 service-bank-item">
			<div class="row">
			<div class="col-md-3"><?php echo get_the_post_thumbnail( $item->ID ); ?></div>
			<div class="col-md-9">
				<h2><?php echo $item->post_title ?></h2>
				<?php echo $item->post_content ?>
				<p></p>
			</div>
			</div>
		</div>
	<?php 
		$i++;
	} 
	?>
	</div>
</div>
</div>
<?php get_footer(); ?>