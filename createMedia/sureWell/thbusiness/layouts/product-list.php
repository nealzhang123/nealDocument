<?php
/**
 * Template Name: 產品目錄模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header(); 

switch ( ICL_LANGUAGE_CODE ) {
	case 'en':
		$page_url = '/products/';
		$menu = 'Product Category';

		break;

	case 'zh-hant':
		$page_url = '/產品目錄/';
		$menu = '產品分類';

		break;
	
	default:
		# code...
		break;
}

$categories = get_categories( 
	array( 
		'hide_empty'=> 0,
		'orderby' => 'term_id',
		'order'   => 'ASC'
	) 
);
array_shift($categories);
// echo '<pre>';print_r($categories);echo '</pre>';exit();
if( isset( $_GET['cat_id'] ) && $_GET['cat_id'] > 0 ) {
	$cat_id = $_GET['cat_id'];
}else{
	$cat_obj = current($categories);
	$cat_id = $cat_obj->cat_ID;
}
$cat_id = icl_object_id($cat_id, 'category', false);

$product_posts = get_posts( array(
		'category' => $cat_id,
		'numberposts' => -1,
		'orderby' => 'date',
        'order' => 'ASC',
	)	
);

if( isset( $_GET['pid'] ) && $_GET['pid'] > 0 ) {
	$pid = icl_object_id( $_GET['pid'], 'post', false);
	$current_post = get_post( $pid );
}else{
	$current_post = current($product_posts);
}

?>

<div class="container-fluid product-container">

<div class="col-md-2 col-xs-12">
<div class="product-menu-div">
	<ul class="product-menu">
	<?php foreach ( $categories as $categorie ) { ?>
		<li <?php echo ( $categorie->cat_ID == $cat_id ) ? 'class="active"' : ''; ?>>
			<a href="<?php echo home_url() . $page_url . '?cat_id=' . $categorie->cat_ID; ?>"><?php echo $categorie->name; ?></a>
		</li>
	<?php } ?>
	</ul>

	<select class="product-menu-mobile">
	<!-- <option data-href="<?php echo home_url() . $page_url; ?>"><?php echo $menu; ?></option> -->
	<?php foreach ( $categories as $categorie ) { ?>
		<option data-href="<?php echo home_url() . $page_url . '?cat_id=' . $categorie->cat_ID; ?>" <?php echo ( $cat_id == $categorie->cat_ID ) ? ' selected':''; ?>><?php echo $categorie->name; ?></option>
	<?php } ?>
	</select>
</div>
</div>

<div class="col-md-10 col-xs-12">
<div class="product-item">
	<div class="product_inside">
		<img src="<?php echo get_the_post_thumbnail_url( $current_post->ID ); ?>" class="product_inside_image" />
	</div>

	<div class="product_content_div row">
		<div class="col-md-6 col-xs-12">
		</div>
		<div class="col-md-6 col-xs-12 product_content">
			<?php echo $current_post->post_content; ?>
		</div>
	</div>
</div>

<div class="product-item-slider">
	<div class="swiper-container">
        <div class="swiper-wrapper">
        <?php foreach ( $product_posts as $item ) { ?>
        	<div class="swiper-slide <?php echo ( $item->ID == $current_post->ID || $item->ID == icl_object_id($current_post->ID, 'post', false) ) ? ' swiper-slide-active':''; ?>">
        	<img src="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" class="product-list-item" data-id="<?php echo $item->ID; ?>" data-cate="<?php echo $cat_id; ?>"/>
        	</div>
        <?php } ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
</div>

</div>

<?php get_footer(); ?>