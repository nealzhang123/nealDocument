<?php

/*
Template Name:home
*/


get_header(); 

global $post;


$work_posts = get_posts( 
	array(
        'numberposts' => '-1',
        'post_type' => 'work',
        'order' => 'ASC',
        'post_status' => 'publish'
	)	
);

$article_posts = get_posts( 
	array(
        'numberposts' => '-1',
        'post_type' => 'post',
        'order' => 'ASC',
        'post_status' => 'publish'
	)	
);
?>



	<div class="top-shadow"></div>
	
	<?php putRevSlider("slider1"); ?>
	
	<div class="centered-wrapper">	
	
		<section class="intro">
			<?php echo $post->post_content; ?>
		</section>
	
		<section>
			<div class="bgtitle home-work-title"><h2>&nbsp;&nbsp;我們的作品&nbsp;&nbsp;</h2></div>
			<ul id="portfolio-carousel" class="home-work-content">
			<?php foreach ( $work_posts as $item ) { ?>
				<li>
					<a href="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" rel="prettyPhoto[pp_gal]" title="<?php echo $item->post_title; ?>">
						<span class="item-on-hover"><span class="hover-image"></span></span>
						<img src="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" />
					</a>
					<div class="portfolio-carousel-details">
						<h3><?php echo $item->post_title; ?></h3>
						<span><?php echo $item->post_content; ?></span>
					</div>
				</li>
			<?php } ?>	
			</ul>	
		</section>		
		
		<div class="space"></div>
		
		<section>
			<div class="bgtitle home-article-title"><h2>&nbsp;&nbsp;關注我們&nbsp;&nbsp;</h2></div>
			<ul id="homeblog-carousel">
			<?php foreach ( $article_posts as $item ) { ?>
				<li>
					<a class="article-modal" data-pid="<?php echo $item->ID; ?>">
						<span class="item-on-hover"></span>
						<img src="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" id="article-image<?php echo $item->ID; ?>" />
					</a>
					<div class="blog-carousel-details">
						<h2><a class="article-modal" data-pid="<?php echo $item->ID; ?>" id="article-title<?php echo $item->ID; ?>"><?php echo $item->post_title; ?></a></h2>
						<div class="carousel-meta">
							<span class="post-format"><i class="icon-pencil"></i></span><span class="details"><?php echo date('Y/m/d', strtotime( $item->post_date ) ); ?></span>
						</div>
						<p><?php echo mb_substr($item->post_content, 0, 100, 'utf-8');  ?></p>
						<div style="display: none;" id="article-content<?php echo $item->ID; ?>"><p><?php echo $item->post_content; ?></p></div>
					</div>
				</li>
			<?php } ?>	
			</ul>	
		</section>				
		<!-- <div class="article_modal">
			<div class="article_image">
				
			</div>
			<div class="article_content">
				
			</div>
		</div> -->

		<div class="modal fade" tabindex="-1" role="dialog" id="article_modal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h2 class="modal-title article_modal_title"></h2>
		      </div>
		      <div class="modal-body">
		      	<img src="" class="article_modal_image" />
		        <div class="article_modal_content"></div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

	</div><!--end centered-wrapper-->
	
	<div class="space"></div>

	
	
<?php get_footer();?>
	