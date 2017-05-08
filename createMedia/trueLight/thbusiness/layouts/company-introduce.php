<?php
/**
 * Template Name: 公司簡介模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header(); 

global $post;
?>
<div class="pages-title">
	<div class="container">
		<h1>公司簡介</h1>
	</div>
</div>

<div class="company-content">
<div class="container">
<div class="row">
	<div class="col-md-8 col-xs-12">
		<div class="company-introduce-left">
			<p><?php echo $post->post_content; ?></p>
			<?php echo get_the_post_thumbnail( $post->ID ); ?>
		</div>
	</div>
	<div class="col-md-4 col-xs-12 company-introduce-right">
		<div class="company-map-top">
			<p style="font-weight: bolder;">聯繫方式：</p>
			<p>電話：(852) 9786 6523（賴生）</p>
			<p style="margin-left: 45px;">(852) 6856 8065（賴生）</p>
			<p>電郵：laiwanqiu123@gmail.com</p>
			<p>地址：新界元朗安康街安駿里</p>
			<p style="margin-left: 45px;">怡康大廈9號鋪</p>
		</div>
		<div class="company-map-bottom">
			<div id="googleMap"></div>
	      	<script src="http://maps.google.cn/maps/api/js?language=zh-hk&key=AIzaSyB15d0LCM3U9b1_Orw_oy97ZLN8LwYaE-g">
			</script> 	
	      	<script type="text/javascript">
	      	function initialize()
			{
				var myCenter=new google.maps.LatLng(22.4420244, 114.0235993);
				var content = '新界元朗安康街安駿里怡康大廈9號鋪';
				var mapProp = {
				    center: myCenter,
				    zoom:16,
				    mapTypeId: google.maps.MapTypeId.ROADMAP
				};
			  
			    var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

			    var marker = new google.maps.Marker({
			    	map: map,
				    position: myCenter,
				    title:content
				});

				//Attach click event to the marker.
				var infowindow = new google.maps.InfoWindow({
				    content:content
				});  
	            //google.maps.event.addListener(marker, 'click', function() {
				    infowindow.open(map,marker);
				//});

				marker.setMap(map);
			}

			google.maps.event.addDomListener(window, 'load', initialize);
	      	</script>
		</div>
	</div>
</div>
</div>
</div>




<?php get_footer(); ?>