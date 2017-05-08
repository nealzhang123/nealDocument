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
	<div>
		<h2>聯繫方式</h2>
		<p>電 話：<a href="tel:85225758155" style="color: #888888">(852) 2575 8155 </a></p>
        <p style="margin-left: 53px;"><a href="tel:85225731112" style="color: #888888">(852) 2573 1112</a></p>
		<p style="padding: 10px 0;">電 郵：daviddavid11158@gmail.com</p>
		<p>地 址：香港灣仔軒尼詩道 381-383號</p>
     	<p style="margin-left: 53px;margin-bottom: 30px;">華軒商業中心20字樓C座</p>
	</div>
	
	<div class="row footer-company">
		<div class="col-md-3 col-xs-6">
			<img src="<?php bloginfo('template_url');?>/images/logo.png" style="width: 28px;height: 20px;" />專業公司
		</div>
		<div class="col-md-3 col-xs-6" style="padding: 0px;">
			<a href="mailto:daviddavid11158@gmail.com"><img src="<?php bloginfo('template_url');?>/images/email.png" style="margin: 0 5px;" /></a>
			<!-- <a href=""><img src="<?php bloginfo('template_url');?>/images/twitter.png" style="margin: 0 5px;" /></a>
			<a href=""><img src="<?php bloginfo('template_url');?>/images/facebook.png" style="margin: 0 5px;" /></a>
			<a href=""><img src="<?php bloginfo('template_url');?>/images/google.png" style="margin: 0 5px;" /></a> -->
		</div>
		<div class="col-md-6 col-xs-12">
			<div style="font-size: 12px;float: right;">
			© <?php echo date('Y'); ?> Professional Company. designed by 創意(國際)傳媒
			</div>
		</div>
	</div>
	</footer><!-- #colophon -->
</div>
</div>

<?php wp_footer(); ?>

</body>
</html>