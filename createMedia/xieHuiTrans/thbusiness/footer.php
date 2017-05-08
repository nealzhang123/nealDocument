<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package thbusiness
 */
?>
<div class="footer-div">
<div class="container">
	<span class="scrollup-icon"><a href="#" class="scrollup"></a></span>
	<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="site-footer-first">
		<div class="row">
		<div class="col-md-6 col-xs-12">
			<img src="<?php echo get_template_directory_uri() . '/images/icon-tel.png'; ?>" />：（852）2866 8218
		</div>
		<div class="col-md-6 col-xs-12">
			<img src="<?php echo get_template_directory_uri() . '/images/icon-home.png'; ?>" />：香港灣仔駱克道93-107號利臨大廈18樓1806-8室
		</div>
		</div>

		<div class="row">
		<div class="col-md-6 col-xs-12">
			<img src="<?php echo get_template_directory_uri() . '/images/icon-tax.png'; ?>" />：（852）2529 2887
		</div>
		<div class="col-md-6 col-xs-12">
			<img src="<?php echo get_template_directory_uri() . '/images/icon-ie.png'; ?>" />：www.pro-translink.iyp.hk/www.protrans.com.tw
		</div>
		</div>

		<div class="row">
		<div class="col-md-6 col-xs-12">
			<img src="<?php echo get_template_directory_uri() . '/images/icon-email.png'; ?>" />：terry@pro-translink.com.hk
		</div>
		</div>
	</div>
	
	<div class="row footer-company">
		Powered by <a href="<?php echo home_url(); ?>">協暉物流</a>&nbsp;&nbsp; Designed by <a href="http://www.c-m.hk" target="_blank">創意國際</a>
	</div>
	</footer><!-- #colophon -->
</div>
</div>

<?php wp_footer(); ?>

</body>
</html>