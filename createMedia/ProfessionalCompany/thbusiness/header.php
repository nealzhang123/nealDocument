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
					<div class="site-branding col-md-12 col-xs-8">
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
					<div class="col-md-4 col-xs-4 head_link_div">
						<div class="head_link_right">
							<a href="http://www.hk-professional.com/reg.php" target="_blank">網上會員登記</a><br /><a href="http://www.hk-professional.com/bghome.html" target="_blank">資料更新</a>
						</div>
					</div>
				</div>
			</div><!-- .col-md-4 .col-xs-12 .col-lg-4 -->

			<div class="col-md-7 col-xs-12 col-lg-7" style="padding: 0;">
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				</nav><!-- #site-navigation -->
				<a href="#" class="navbutton" id="main-nav-button">目錄</a>
				<div class="responsive-mainnav"></div>
			</div><!-- .col-md-8 .col-xs-12 .col-lg-8 -->

			<div class="col-md-2 col-xs-12 col-lg-2 head_link_div2">
				<div class="head_link">
					<a href="http://www.hk-professional.com/reg.php" target="_blank">網上會員登記</a> | <a href="http://www.hk-professional.com/bghome.html" target="_blank">資料更新</a>
				</div>
			</div><!-- .col-md-8 .col-xs-12 .col-lg-8 -->
		</div><!-- .row -->
	</div><!-- container -->
</header><!-- #masthead -->
</div>