<?php
/**
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
						<h2>最新動態</h2>
					</div>
					<div class="one-third column-last">		
					</div>
					<div class="clear"></div>
				</div><!--end title-content-->
			</div>
		</div><!--end title-wrapper-->
	</section>	
    
    <div class="centered-wrapper">	
		<section id="blog-page">
			<div id="posts">
        <?php     
$pagenum	= isset( $_GET['pagenum'] ) ? intval( $_GET['pagenum'] ) : 1;

            $args = array(
	'posts_per_page' => 2,
	'post_type' => 'post',
	'paged' => $pagenum
	
);

$the_query = new WP_Query( $args );
   // 开始循环
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            ?>
    
    <article class="post regular-article">												
					<div class="post-thumbnail">
						<a href="#">
							<span class="item-on-hover"><span class="hover-link"></span></span>
							<?php  the_post_thumbnail( ); ?>
						</a>
					</div><!--end post-thumbnail-->
					<div class="post-content">
						<span class="masonry-post-meta">
							7 Jan 2012 / <a href="#">Articles</a> / <a href="#">3 Comments</a>
						</span>
						<i class="icon-pencil"></i>						
						<div class="clear"></div>
						<h1><a href="#"><?php the_title();?></a></h1>
						
						<p><?php the_content();?></p>
						<a class="button red" href="<?php the_permalink();?>">Read More</a>

					</div><!--end post-content-->
				</article>
		
				</a>
               
					
<?php
    }
    }
	
   

   	 wp_reset_postdata();//不用问为什么，每次都记得写就好

    ?>
 <div class="pagenav">
            <?php
            $tt=$the_query->max_num_pages;

echo paginate_links( array(

	'base' => add_query_arg( 'pagenum', '%#%' ),
	'format' => '?pagenum=%#%',
	'current' => max( 1, $_GET['pagenum'] ),
	'total' =>$tt,
	'prev_text'    => __('« 上一頁'),
	'next_text'    => __('下一頁 »')
) );
?>
            </div>
							
		
			</div><!--end posts-->
           
		</section>


		<aside id="sidebar">
			<div class="widget recent-posts">
				<h3>Recent Posts</h3>
				<div class="sidebar-post">
					<h5><a href="blog-single.html">The Secrets Behind Identity Branding</a></h5>
					<span>23 July 2012 / <a href="#">5 Comments</a></span>					
				</div><!--end sidebar-post-->
				<div class="sidebar-post">
					<h5><a href="blog-single.html">From Inception to IPO: Facebook in 8 Years</a></h5>
					<span>06 May 2012 / <a href="#">3 Comments</a></span>	
				</div><!--end sidebar-post-->
				<div class="sidebar-post">
					<h5><a href="blog-single.html">A/B Testing: What is It?</a></h5>
					<span>12 March 2012 / <a href="#">No Comments</a></span>	
				</div><!--end sidebar-post-->
			</div>
			
			<div class="widget categories ">
				<h3>Categories</h3>
				<ul>
					<li><a href="#">Advertising</a></li>
					<li><a href="#">Marketing</a></li>
					<li><a href="#">Media</a></li>
					<li><a href="#">Small Business</a></li>
					<li><a href="#">Web Applications</a></li>
				</ul>
			</div><!--end widget-->
			
			<div class="widget tags ">
				<h3>Tags</h3>
				<ul>
					<li><a href="#">Design</a></li>
					<li><a href="#">Development</a></li>
					<li><a href="#">Mobile</a></li>
					<li><a href="#">Art</a></li>
					<li><a href="#">Photography</a></li>
					<li><a href="#">YouTube</a></li>
					<li><a href="#">Nikon</a></li>
					<li><a href="#">Twitter</a></li>
				</ul>
			</div><!--end widget-->			
			
			<div class="widget flickr-widget">
				<h3>Flickr Feed</h3>
				<div id="flickr"></div>
			</div>			
		</aside>

		<div class="clear"></div>
	</div><!--end centered-wrapper-->
	
	<div class="space"></div>
  		<?php

?>
<?php
get_footer();
?>