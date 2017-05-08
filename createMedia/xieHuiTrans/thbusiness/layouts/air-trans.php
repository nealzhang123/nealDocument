<?php
/**
 * Template Name: 空運模板
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
		<?php echo do_shortcode('[wonderplugin_slider id=1]'); ?>
	</div>

	<div class="air-inside1">
		<h1>空運服務</h1>
		<h2>Air freight service</h2>
	</div>
</div>

<div class="air-content2">
	<img src="<?php echo get_template_directory_uri() . '/images/air-image1.jpg'; ?>" class="air-image1" />
	<span>空運進/出口</span>
</div>

<div class="air-content3">
<div class="air-div3">
	<img src="<?php echo get_template_directory_uri() . '/images/air-image2.jpg'; ?>" class="air-image2" />
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

<div class="air-div4">
	<span class="air-div4-active air-div4-title1">空運出口</span><span class="air-div4-title2">空運進口</span>

</div>

<div class="air-div4-content">
	<div class="air-div4-content1">
	<p>1.東北亞、東南亞、中國各大城市及香港、美國、加拿大、歐洲（南歐、北歐、中歐、東歐）、中/南美、中東各國以及非洲等各主要機場。</p>
	<p>2.三角貿易及第三地出口（第三地出口台灣發單押匯）</p>
	<p>3.空轉空及海轉空一段式服務：提供東南亞，南中國地區及香港來貨空轉空，海轉空一段式清關轉口服務轉運到美國歐洲各大機場，為您解決生產國空運艙位不足的問題。</p>
	<p>4.海空聯運：海運經杜拜（Dubai）轉空運到歐洲各大機場，為您提供比空運更經濟的運費。比海運更快捷的運送。</p>
	<p>5.目的地國家主要城市戶對戶運送：只要您一通電話 我們將您的貨直接送達客戶手中。</p>
	<p>6.轉運中南美：經由美國西岸LAX及東岸Miami轉運 到中南美洲主要機場。</p>
	<p>7.危險物品（Dangerous Goods）出口：本公司定期接受國際航空運輸協會（IATA）訓練，并取得航空運輸危險品處理執照。</p>
	</div>
	<div class="air-div4-content2">
	<p></p>
	<p></p>
	<p></p>
	<p>1.配合全球75家代理，提供您由美/歐/日/航/東南亞<br />各國進口到台灣的空運運送。</p>
	<p></p>
	<p>2.出口地內陸運送</p>
	<p></p>
	<p>3.出口地出口報關</p>
	<p></p>
	<p>4.台灣進口清關</p>
	<p></p>
	<p>5.出口商到進口商戶對戶一段式專業服務</p>
	<p></p><p></p><p></p><p></p><p></p>
	</div>
</div>


</div>
<?php get_footer(); ?>