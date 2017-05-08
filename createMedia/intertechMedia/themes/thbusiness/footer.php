<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package thbusiness
 */
?>
<hr style="margin: 0;" />
<div class="container-fluid">
<div class="row">
	<span class="scrollup-icon"><a href="#" class="scrollup"></a></span>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
		<div class="row">
		<?php if ( is_active_sidebar( 'footer-left' ) || is_active_sidebar( 'footer-mid' ) || is_active_sidebar( 'footer-right' ) ) : ?>
			<div class="footer-widget-area">
				<div class="col-md-4">
					<div class="left-footer">
						<?php get_sidebar( 'footer-left' ); ?>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="mid-footer">
						<?php get_sidebar( 'footer-mid' ); ?>					
					</div>
				</div>

				<div class="col-md-4">
					<div class="right-footer">
						<?php get_sidebar( 'footer-right' ); ?>					
					</div>
				</div>						
			</div><!-- .footer-widget-area -->
		<?php endif; ?>
	</div><!-- .row -->
</div><!-- .container -->		
	<div class="footer-site-info">
		<div class="container">
		<div class="row">
			<div class="footer-details-container">
				<div class="copyright-container">

					<div class="col-xs-12 col-md-7 col-sm-7">
						<?php 
							$footer_copyright_text = get_theme_mod( 'footer_copyright_text', '' );
							if( ! empty( $footer_copyright_text ) ) {
								printf( 'Copyright © %1$s.%2$s.', date( 'Y' ), wp_kses_post( $footer_copyright_text ) );
							} else {
								$site_link = '<a href="' . esc_url( home_url( '/' ) ) .'" title="' . $footer_copyright_text . '" rel="home">' . $footer_copyright_text . '</a>';
								printf( 'Copyright © %1$s.%2$s', date( 'Y' ), wp_kses_post( $site_link ) );
							} ?>
					</div>
					<div class="col-xs-12 col-md-5 col-sm-5 fr" style="text-align: right;">
						地址：尖沙咀山林道21號永勝商業大廈16樓全層
						<!-- <div class="credit-container">
							<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'thbusiness' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'thbusiness' ), 'WordPress' ); ?></a><span class="sep"> | </span><a href="<?php echo esc_url( __( 'http://themezhut.com/themes/thbusiness', 'thbusiness' ) ); ?>" target="_blank" rel="designer"><?php echo esc_html__( 'Theme: THBusiness By ThemezHut', 'THBusiness' ); ?></a>
						</div> -->
					</div>
					
				</div><!-- .footer-details-container -->
			</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- .row -->
</div><!-- .container-fluid -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>