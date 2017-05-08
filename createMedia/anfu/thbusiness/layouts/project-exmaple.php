<?php
/**
 * Template Name: 工程案例模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header(); 

global $post;
// $cate_id = get_cat_ID( 'project-exam' );
// $media_posts = get_posts( array(
// 		'category' => $cate_id,
// 		'orderby' => 'date',
//         'order' => 'ASC',
// 	)	
// );

//地區分類
$cate_area = get_category_by_slug( 'area' );
$cate_area_arr = get_categories( array(
    'orderby' => 'name',
    'parent'  => $cate_area->cat_ID
) );

//設計分類
$cate_design = get_category_by_slug( 'design' );
$cate_design_arr = get_categories( array(
    'orderby' => 'name',
    'parent'  => $cate_design->cat_ID
) );

//尺數分類
$cate_size = get_category_by_slug( 'size' );
$cate_size_arr = get_categories( array(
    'orderby' => 'name',
    'parent'  => $cate_size->cat_ID
) );

//做價分類
$cate_price = get_category_by_slug( 'price' );
$cate_price_arr = get_categories( array(
    'orderby' => 'name',
    'parent'  => $cate_price->cat_ID
) );

// echo '<pre>';print_r($post);echo '</pre>';
$current_cate_id = '';

if( isset( $_GET['pid'] ) && $_GET['pid'] > 0 ) {
	$pid = $_GET['pid'];
	$is_single_post = true;

	$single_post = get_post( $pid );

	$image_arr = get_post_meta( $pid, '_multi_img_array', true );
	$image_arr = explode( ',', $image_arr );

	foreach ( $image_arr as $key => $image_id ) {
		$tmpimage_arr[$key] = wp_get_attachment_url( $image_id );
	}
	$image_arr = $tmpimage_arr;
}else{
	$is_single_post = false;

	if( $post->post_parent > 0 ) {
		$post_name = $post->post_title;

		$cate = '';
		$select_posts = array();

		switch ( $post_name ) {
			case '住宅':
				$cate = get_category_by_slug( 'house' );

				break;
			case '商鋪':
				$cate = get_category_by_slug( 'shop' );

				break;
			case '傢私':
				$cate = get_category_by_slug( 'furniture' );

				break;
			
			default:
				# code...
				break;
		}

		if( $cate ) {
			$select_posts = get_posts( 
				array(
					'category' => $cate->cat_ID,
			        'numberposts' => '-1',
			        'post_type' => 'project'
				)	
			);
		}

		$current_cate_id = $cate->cat_ID;
	}else{
		//get posts
		$cate = get_category_by_slug( 'classic' );

		$select_posts = get_posts( 
			array(
				'category' => $cate->cat_ID,
		        'numberposts' => '-1',
		        'post_type' => 'project'
			)	
		);
	}
}

// echo '<pre>';print_r($tmpimage_arr);echo '</pre>';
?>

<div class="project-content">
<div id="current_cate_id" value="<?php echo $current_cate_id; ?>"></div>
<?php if( !$is_single_post ) { ?>

<div class="container project-search">
<div class="row">
	<div class="col-md-3 col-xs-6">
		<select name="project_area" class="project_select">
			<option value="" class="project_select_title"><?php echo $cate_area->name; ?></option>
			<?php foreach ( $cate_area_arr as $item ) { ?>
				<option value="<?php echo $item->cat_ID; ?>"><?php echo $item->name; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="col-md-3 col-xs-6">
		<select name="project_design" class="project_select">
			<option value="" class="project_select_title"><?php echo $cate_design->name; ?></option>
			<?php foreach ( $cate_design_arr as $item ) { ?>
				<option value="<?php echo $item->cat_ID; ?>"><?php echo $item->name; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="col-md-3 col-xs-6">
		<select name="project_size" class="project_select">
			<option value="" class="project_select_title"><?php echo $cate_size->name; ?></option>
			<?php foreach ( $cate_size_arr as $item ) { ?>
				<option value="<?php echo $item->cat_ID; ?>"><?php echo $item->name; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="col-md-3 col-xs-6">
		<select name="project_price" class="project_select">
			<option value="" class="project_select_title"><?php echo $cate_price->name; ?></option>
			<?php foreach ( $cate_price_arr as $item ) { ?>
				<option value="<?php echo $item->cat_ID; ?>"><?php echo $item->name; ?></option>
			<?php } ?>
		</select>
	</div>

</div>
</div>

<div class="project-list">
<div class="container project-items">
<div class="row">
<?php 
if( count( $select_posts ) > 0 ){
	$i = 0;

	foreach ( $select_posts as $post ) { 
		if( $i >0 && $i%3 == 0 ) {
?>
	</div>
	<div class="row">
<?php		
		}
?>
	<div class="col-md-4 col-xs-12">
		<div class="project-item-image">
			<a href="<?php echo site_url('/工程案例/').'?pid=' . $post->ID; ?>"><?php echo get_the_post_thumbnail( $post->ID ); ?>
		</div>

		<div class="project-item-title">
			<p><?php echo $post->post_title; ?></p>
		</div>
	</div>
<?php 
		$i++;
	}
}else{
?>
	<p>沒有找到符合條件的案例.</p>
<?php
}
?>
	
</div>
</div>
</div>
<?php }else{ ?>

<div class="container project-single">
<div class="row">
	<div class="col-md-4 col-xs-12">
		<div class="project-single-title">
			<h3><?php echo $single_post->post_title; ?></h3>
		</div>
		<div class="project-single-content">
			<div class="short_content">
			<?php 
			echo mb_substr($single_post->post_content, 0, 100, 'utf-8');
			?>
			</div>

			<div class="full_content">
			<?php 
				echo $single_post->post_content;
			?>
			</div>

			<?php 
			if( mb_strlen($single_post->post_content) > 100 ) {
				echo '<a class="extra_button">展開</a>';
			} 
			?>
		</div>
	</div>

	<div class="col-md-8 col-xs-12">
		<div class="pc-slide">
			<div class="view">
				<div class="swiper-container">
					<a class="arrow-left" href="#"></a>
					<a class="arrow-right" href="#"></a>
					<div class="swiper-wrapper">
					<?php 
					foreach ( $image_arr as $image_url ) {
					?>
						<div class="swiper-slide">
							<a target="_blank"><img src="<?php echo $image_url; ?>" alt=""></a>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
			<div class="preview">
				<a class="arrow-left" href="#"></a>
				<a class="arrow-right" href="#"></a>
				<div class="swiper-container">
				<!-- active-nav -->
					<div class="swiper-wrapper">
					<?php 
					$j = 0;
					foreach ( $image_arr as $image_url ) {
					?>
						<div class="swiper-slide <?php echo ($j == 0 ) ? 'active-nav':''; ?>">
							<a target="_blank"><img src="<?php echo $image_url; ?>" alt=""></a>
						</div>
					<?php $j++; } ?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
</div>

<?php } ?>


</div> <!-- end of <div class="project-content"> -->

<?php get_footer(); ?>