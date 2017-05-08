<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package thbusiness
 */

?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main" style="text-align: center;margin-top: 30px;">

		<section class="error-404 not-found">
			<header class="page-header">
				<img src="<?php bloginfo('template_url');?>/404.png" style="max-width: 100%;" />
			</header><!-- .page-header -->
			<div style="margin-top: 30px;">
				<h2><a href="<?php echo home_url(); ?>" class="btn btn_primary">返回首頁</a></h2>
			</div>
		</section><!-- .error-404 -->

	</main><!-- #main -->
</div><!-- #primary -->
