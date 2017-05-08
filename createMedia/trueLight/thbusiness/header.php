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
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="header_title">
<header id="masthead" class="site-header" role="banner">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-xs-12 col-lg-3">
				<div class="row">
					<div class="site-branding">
						<h1 class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">真光</a>工程公司
						</h1>
						<h3 class="site-description">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">True Light </a>Engineering Company
						</h3>
					</div>
				</div>
			</div><!-- .col-md-4 .col-xs-12 .col-lg-4 -->

			<div class="col-md-7 col-xs-12 col-lg-7" style="padding: 0;float: right;">
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				</nav><!-- #site-navigation -->
				<a href="#" class="navbutton" id="main-nav-button">目錄</a>
				<div class="responsive-mainnav"></div>
			</div><!-- .col-md-8 .col-xs-12 .col-lg-8 -->
			
		</div><!-- .row -->
	</div><!-- container -->
</header><!-- #masthead -->
</div>