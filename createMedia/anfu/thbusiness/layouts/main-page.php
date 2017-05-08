<?php
/**
 * Template Name: 首页模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();
?>
<div class="container-fluid main-banners">
	<div class="main-slider">
		<ul>
			<li>
				<img src="<?php bloginfo('template_url');?>/images/banner/banner.jpg"/>
			</li>

			<!-- <li>
				<img src="<?php bloginfo('template_url');?>/images/banner/banner2.jpg"/>
			</li>

			<li>
				<img src="<?php bloginfo('template_url');?>/images/banner/banner3.jpg"/>
			</li>

			<li>
				<img src="<?php bloginfo('template_url');?>/images/banner/banner4.jpg"/>
			</li>

			<li>
				<img src="<?php bloginfo('template_url');?>/images/banner/banner5.jpg"/>
			</li> -->
		</ul>

	</div>	
</div>

<div class="container-fluid main-page-content">
<div class="row">
	<div class="col-md-9 col-xs-12 main-page-foot">
		<h3>
			設計 • 報價 • 裝修 • 一站式服務
		</h3>
		<p>
			安富擁有十多年為客人裝修的經驗，我們一向致力把守著我們的優點，為客人提供價廉物美的服務，我們會以您實際用途出發，為您提供既實用又美觀的裝修，切合你的需要。
		</p>
	</div>
	<div class="col-md-3 col-xs-12">
		<a href="tel:26584088"><img src="<?php bloginfo('template_url');?>/images/telphone.jpg"/></a>
	</div>
</div>
</div>


<?php get_footer(); ?>