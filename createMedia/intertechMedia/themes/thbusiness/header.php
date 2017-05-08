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

<div id="page" class="hfeed site">
	<div class="container-fluid header_title">
	<div class="row">
	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-xs-12 col-lg-6">
					<div class="site-branding">
						<?php 
							$site_title_option = get_theme_mod( 'site_title_option', 'text_only' ); 
							$site_logo = get_theme_mod( 'site_logo', '' );
						?>
						<?php if ( $site_title_option == 'logo_only' && ! empty( $site_logo ) ) { ?>
							<!-- <div class="site-logo-image"> -->
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url($site_logo); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="site_logo"></a>
							<!-- </div> -->
						<?php } ?>

						<?php if ( $site_title_option == 'text_only' || $site_title_option == 'display_all' ) { ?>
							<?php if ( $site_title_option == 'display_all' && ! empty( $site_logo ) ) { ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url($site_logo); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="site_logo"></a>
							<?php } ?>
							<h1 class="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							</h1>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						<?php } ?>
					</div>
				</div><!-- .col-md-4 .col-xs-12 .col-lg-4 -->

				<div class="col-md-6 col-xs-12 col-lg-6">
					<nav id="site-navigation" class="main-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					</nav><!-- #site-navigation -->
					<a href="#" class="navbutton" id="main-nav-button">目錄</a>
					<div class="responsive-mainnav"></div>
				</div><!-- .col-md-8 .col-xs-12 .col-lg-8 -->
			</div><!-- .row -->
		</div><!-- container -->
	</header><!-- #masthead -->
	</div><!-- .row -->