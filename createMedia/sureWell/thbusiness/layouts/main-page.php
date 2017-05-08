<?php
/**
 * Template Name: 首页模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */

$menu_name = 'primary';
$locations = get_nav_menu_locations();
$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
$menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );

// echo '<pre>';print_r($menuitems);echo '</pre>';
switch ( ICL_LANGUAGE_CODE ) {
	case 'en':
		$home = 'Main';
		break;

	case 'zh-hant':
		$home = '首頁';
		break;
	
	default:
		# code...
		break;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="main_header_div">
	<div class="container">
		<div class="main_header_top">
			<a href="<?php echo site_url(); ?>/en" class="main_header_top_en">English</a>
			<a href="<?php echo site_url(); ?>">中文</a>
		</div>
	</div>

	<div class="main_page_banner">
		<img src="<?php bloginfo('template_url');?>/images/banner.jpg"  />
	</div>

	<div class="container">
		<div class="main_page_menu">
		<div class="row">
			<div class="main_page_menu_item_div_first">
			<div class="col-md-3 col-xs-12 col-sm-6">
				<a href="<?php home_url(); ?>"><?php echo $home; ?></a>
			</div>
			</div>
		<?php 
		$i = 0;
		foreach ( $menuitems as $item ) { 
		?>
			<div class="main_page_menu_item_div">
			<div class="col-md-3 col-xs-12 col-sm-6">
				<a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
			</div>
			</div>
		<?php 
			$i++;
		} 
		?>
		</div>
		</div>

		<div class="main_page_contact">
			<span><img src="<?php bloginfo('template_url');?>/images/tel.png" /> <a href="tel:85221747893">852-2174 7893 </a></span>
			<span><img src="<?php bloginfo('template_url');?>/images/tax.png" /> 852-2174 7669 </span>
		</div>
	</div>
</div><!-- container -->

<div class="footer-div">
<div class="container">
	<span class="scrollup-icon"><a href="#" class="scrollup"></a></span>
</div>

</div>
<?php wp_footer(); ?>

</body>
</html>