<!DOCTYPE html> 
<html lang="en"> 
<head> 
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	
	<!-- mobile meta tag -->		
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title>Forever Match</title> 
	
	<?php wp_head();?>
</head> 

<!--very important: setting a class for homepage -->
<body class="home"> 

<!-- setting a fullscreen image as background:
<img id="bg" src="images/apple.jpg" alt="apple-background" />
-->


<div id="wrapper">
	<header id="header">
		<div class="centered-wrapper">
			<div class="one-third">
				<div class="logo">
					<a href="<?php echo home_url(); ?>"><img src="<?php bloginfo('template_url');?>/images/head-logo.png" /></a>
				</div>
			</div><!--end one-third-->
			
			<div class="two-third column-last">		
				     <?php

$defaults = array(
	'theme_location'  => 'Top Menu Location',
	'menu'            => '',
	'container'       => 'nav',
	'container_class' => '',
	'container_id'    => 'navigation',
	'menu_class'      => '',
	'menu_id'         => 'mainnav',
	'echo'            => true,
	'fallback_cb'     => 'wp_page_menu',
	'before'          => '',
	'after'           => '',
	'link_before'     => '',
	'link_after'      => '',
	'items_wrap'      => '<ul  id="%1$s" class="%2$s">%3$s</ul>',
	'depth'           => 0,
	'walker'          => ''
);

wp_nav_menu( $defaults );

?>
			<!--end navigation-->
				
			</div><!--end two-third-->
			<div class="clear"></div>			
		</div><!--end centered-wrapper-->
	</header>	
