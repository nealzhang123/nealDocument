<?php
/**
 Template Name: 產品模板
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); 
 
$cloth_posts = get_posts( 
	array(
        'numberposts' => '-1',
        'post_type' => 'cloth',
        'order' => 'ASC',
        'post_status' => 'publish'
	)	
);

// echo '<pre>';print_r($cloth_posts);echo '</pre>';exit();
?>
<div class="top-shadow"></div>

<div class="cloth-image">
	<img src="<?php bloginfo('template_url');?>/images/cloth.jpg" />
</div>


<div class="centered-wrapper">	
	<section>
		<div class="bgtitle"><h2>&nbsp;&nbsp;&nbsp;姊妹裙&nbsp;&nbsp;&nbsp;</h2></div>
		<ul id="portfolio-carousel">
		<?php foreach ( $cloth_posts as $post ) { ?>
			<li>
				<a href="<?php echo get_the_post_thumbnail_url( $post->ID ); ?>" rel="prettyPhoto[pp_gal]" title="<?php echo $post->post_title; ?>">
					<span class="item-on-hover"><span class="hover-image"></span></span>
					<img src="<?php echo get_the_post_thumbnail_url( $post->ID ); ?>" alt=" " />
				</a>
			</li>
		<?php } ?>
		</ul>	
	</section>		
	
	<div class="space"></div>
	
</div><!--end centered-wrapper-->


<div class="clear"></div>
<!-- **Main - End** -->


<?php
get_footer();
?>