<?php
/**
 Template Name: 公司簡介模板
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
global $post;

get_header(); 

?>
<div class="top-shadow"></div>

<div class="introduce-image">
	<img src="<?php bloginfo('template_url');?>/images/company-intro.jpg" />
	<div id="contact_inside">
		<h2>關於我們</h2>
		<div class="introduce-line"></div>
		<div class="introduce-content">
			<?php echo $post->post_content; ?>
		</div>
	</div>
</div>


<div class="clear"></div>
<!-- **Main - End** -->


<?php
get_footer();
?>