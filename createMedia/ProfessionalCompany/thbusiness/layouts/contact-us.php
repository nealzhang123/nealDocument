<?php
/**
 * Template Name: 聯繫我們模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();

?>
<div class="pages-title">
	<div class="container">
		<h1>聯繫我們</h1>
	</div>
</div>

<div class="contact-div">
<div class="container">
<div class="row">
	<div class="col-md-8 col-xs-12">
		<div id="googleMap"></div>
      	<script src="http://maps.google.cn/maps/api/js?language=zh-hk&key=AIzaSyB15d0LCM3U9b1_Orw_oy97ZLN8LwYaE-g">
		</script> 	
      	<script type="text/javascript">
      	function initialize()
		{
			var myCenter=new google.maps.LatLng(22.2791319, 114.1799384);
			var content = '香港灣仔軒尼詩道 381-383號華軒商業中心20字樓C座';
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

  		<div class="contact-form-div">
  		<form class="contact-form">
  			<div class="row contact-form-row">
  				<div class="col-md-6 col-xs-12">
  					Name: ( <a style="color: red;">*必填</a> ) <input type="text" name="name" />
  				</div>
  				<div class="col-md-6 col-xs-12">
  					Email: ( <a style="color: red;">*必填</a> ) <input type="text" name="email" />
  				</div>
  				<div class="col-md-12 col-xs-12">
  					Message: <textarea name="message" rows="5" cols="30" ></textarea>
  				</div>
  				<div class="col-md-12 col-xs-12">
  					<button class="btn btn-primary btn-lg contact-submit" style="background-color: #40bac8;margin: 10px 0;">Submit</button>
  				</div>
  			</div>
  		</form>
  		</div>
	</div>
	<div class="col-md-4 col-xs-12 contact-content">
		<?php the_post_thumbnail(); ?>
		<h3 style="margin: 15px 0;">韓樹榮博士</h3>
		<p style="font-size: 14px;">是中大社工系畢業生，曾在社會福利署先 後任社會工作者、感化官及家庭服務部的 輔導員等；從事22年專業婚姻介紹服務。</p>
		<p></p><p></p>
		<p>聯繫方式： </p>
		<p>電話：<a href="tel:25758155" style="color: #888888">2575 8155</a>；<a href="tel:25731112" style="color: #888888">2573 1112</a></p>
		<p>電郵：daviddavid11158@gmail.com</p>
		<p>地址：香港灣仔軒尼詩道 381-383號 </p>
		<p>華軒商業中心20字樓C座</p>
	</div>
</div>
</div>
</div>




<?php get_footer(); ?>