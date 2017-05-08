<?php
$condition_arr = array();

if( $_POST['project_area'] )
	$condition_arr[] = $_POST['project_area'];

if( $_POST['project_design'] )
	$condition_arr[] = $_POST['project_design'];

if( $_POST['project_size'] )
	$condition_arr[] = $_POST['project_size'];

if( $_POST['project_price'] )
	$condition_arr[] = $_POST['project_price'];

if( $_POST['current_cate_id'] )
	$condition_arr[] = $_POST['current_cate_id'];

$query = new WP_Query( 
	array( 
		'category__and' => $condition_arr,
		'post_type' => 'project'
	)
);

$select_posts = $query->posts;
?>
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