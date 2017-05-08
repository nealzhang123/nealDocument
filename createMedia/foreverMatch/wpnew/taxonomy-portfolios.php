<?php

get_header(); 
 
?>
<div class="top-shadow"></div>
	
	<section class="page-title">
	<div class="page-background">
		<div class="pattern1"></div>
	</div>
	<div class="bottom-shadow" style="top:176px;"></div>
		<div class="title-wrapper">
			<div class="title-bg">
				<div class="title-content">
					<div class="two-third">
						<h2>所有產品</h2>
					</div>
					<div class="one-third column-last">		
					</div>
					<div class="clear"></div>
				</div><!--end title-content-->
			</div>
		</div><!--end title-wrapper-->
	</section>	
    
    <div class="centered-wrapper">	
	
		<ul class="gallery-page">
        
          <?php if ( have_posts() ) :  ?>
<?php while ( have_posts() ) : the_post();
    
    ?>
    
    <li>
    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
				<a href="<?php echo $image[0]; ?>" rel="prettyPhoto[pp_gal]" title="Gallery 10">
					<span class="item-on-hover"><span class="hover-image"></span></span>
					<?php  the_post_thumbnail( ); ?>
				</a>
			</li>				

<?php endwhile; ?>

<?php else : ?>
//另一些HTML
<?php endif; ?>
    
		</ul><!--end gallery-page-->

	<div class="clear"></div>
	</div><!--end centered-wrapper-->
	
	<div class="space"></div>
    
    <div class="clear"></div>
    </div>    






<?php
get_footer();
?>