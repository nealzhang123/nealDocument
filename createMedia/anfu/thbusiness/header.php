<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package thbusiness
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="header_title">
<header id="masthead" class="site-header" role="banner">
	<div class="container-fluid header_div">
		<div class="nodisplay_mobile header_logos">
			<a href="https://www.facebook.com/onfu.hk/?fref=ts" target="_blank"><img src="<?php bloginfo('template_url');?>/images/logo-facebook.png" />&nbsp;&nbsp;</a>
			<a href="tel:26584088"><img src="<?php bloginfo('template_url');?>/images/logo-telphone.png" />&nbsp;&nbsp;</a>
			<a href="mailto:info@onfu.hk"><img src="<?php bloginfo('template_url');?>/images/logo-mail.png" /></a>
		</div>
		<div class="nodisplay_mobile">
			<a href="<?php echo home_url(); ?>"><img src="<?php bloginfo('template_url');?>/images/logo.jpg" /></a>
		</div>

		<div class="header_menu">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- #site-navigation -->
			<div class="header_nav_line nodisplay_mobile"></div>
			<a href="#" class="navbutton" id="main-nav-button"><t class="header_nav_menu">安富裝飾材料裝修工程</t></a>
			<div class="responsive-mainnav"></div>
		</div><!-- .row -->
	</div><!-- container -->
</header><!-- #masthead -->
</div>