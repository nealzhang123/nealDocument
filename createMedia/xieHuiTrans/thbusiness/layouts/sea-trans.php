<?php
/**
 * Template Name: 海運模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();

global $post;
?>
<div class="container">

<div class="air-content1">
	<div class="air-div1">
		<?php echo do_shortcode('[wonderplugin_slider id=2]'); ?>
	</div>
</div>

<div class="air-content2">
	<img src="<?php echo get_template_directory_uri() . '/images/sea-image1.jpg'; ?>" class="air-image1" />
	<span>香港出口海運併裝船期</span>
</div>

<div class="air-content3">
<div class="air-div3">
	<img src="<?php echo get_template_directory_uri() . '/images/sea-image2.jpg'; ?>" class="air-image2" />
</div>

<div class="air-inside2">
	<div class="air-inside2-table">
		<table>
			<tr>
				<td class="air-td">
					<div>
						<h1>東北亞地區</h1>
						<p>日本/韓國航線</p>
					</div>
				</td>
				<td class="air-td">
					<div>
						<h1>歐洲區</h1>
						<p>歐陸/北歐航線<br />地中海航線</p>
					</div>
				</td>
			</tr>
			<tr>
				<td class="air-td">
					<div>
						<h1>東南亞地區</h1>
						<p>新加坡/馬拉西亞/越南航線<br />印尼/菲律賓/泰國航線</p>
					</div>
				</td>
				<td class="air-td">
					<div>
						<h1>美洲區</h1>
						<p>美國/加拿大航線</p>
					</div>
				</td>
			</tr>
			<tr>
				<td class="air-td">
					<div>
						<h1>中國/香港地區</h1>
						<p>新加坡/馬拉西亞/越南航線<br />中國大陸航線</p>
					</div>
				</td>
				<td class="air-td">
					<div>
						<h1>紐澳非洲中南美洲區</h1>
						<p>紐西蘭/澳洲航線<br />中南美洲/南非航線</p>
					</div>
				</td>
			</tr>
			<tr>
				<td class="air-td">
					<div>
						<h1>中東/印巴地區</h1>
						<p>斯里蘭卡/孟加拉<br />印度/中東航線</p>
					</div>
				</td>
				<td>
				</td>
			</tr>
		</table>
	</div>
</div>
</div>


</div>
<?php get_footer(); ?>