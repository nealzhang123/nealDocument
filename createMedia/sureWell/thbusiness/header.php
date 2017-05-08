<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package thbusiness
 */
$current_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$str = array(
	$_SERVER['HTTP_HOST'],
	$_SERVER['HTTP_HOST'] . '/en'
	);

$current_url_hk = str_replace( $str, $_SERVER['HTTP_HOST'], $current_url );
$current_url_en = str_replace( $str, $_SERVER['HTTP_HOST'] . '/en', $current_url_hk );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="header_title">
<header id="masthead" class="site-header" role="banner">
	<div class="container-fluid header_div">
		<div class="header_trans">
			<a href="<?php echo $current_url_en; ?>" class="header_trans_en<?php echo ( ICL_LANGUAGE_CODE == 'en' ) ? ' lang_active':''; ?>">English</a>
			<a href="<?php echo $current_url_hk; ?>" class="header_trans_hk<?php echo ( ICL_LANGUAGE_CODE == 'zh-hant' ) ? ' lang_active':''; ?>">中文</a>
		</div>
		
		<div class="col-md-6 col-xs-12 header_left">
			<a href="<?php echo home_url(); ?>"><img src="<?php bloginfo('template_url');?>/images/logo.png" /></a>
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<a href="#" class="navbutton" id="main-nav-button"><t class="header_nav_menu"></t></a>
		</div>

		<div class="col-md-6 col-xs-12 header_menu">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- #site-navigation -->
		</div><!-- .row -->
		
	</div><!-- container -->
</header><!-- #masthead -->
</div>
<div class="responsive-mainnav">
</div>