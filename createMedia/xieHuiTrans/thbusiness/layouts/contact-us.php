<?php
/**
 * Template Name: 聯繫我們模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();


global $post;
?>

<div class="contact-content">
<div class="container">

<div class="contact-map">
	<div id="googleMap"></div>
  	<script src="http://maps.google.cn/maps/api/js?language=zh-hk&key=AIzaSyB15d0LCM3U9b1_Orw_oy97ZLN8LwYaE-g">
	</script> 	
  	<script type="text/javascript">
  	function initialize()
	{
		var myCenter=new google.maps.LatLng(22.2782595,114.1721583);
		var content = '香港灣仔駱克道93-107號利臨大廈18樓1806-8室';
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

<div class="row contact-detail">
	<div class="col-md-6 col-xs-12 contact-introduce-left">
		<div class="contact-content1">
			<?php echo $post->post_content; ?>
		</div>
	</div>

	<div class="col-md-6 col-xs-12">
		<div class="contact-introduce-right">
			<div class="contact-form-div">
	  		<form class="contact-form">
	  			<div class="row contact-form-row">
	  				<div class="col-md-8 col-xs-12">
	  					<input type="text" name="name" placeholder="姓&nbsp;&nbsp;&nbsp;名" />
	  				</div>
	  				<div class="col-md-8 col-xs-12">
	  					<input type="text" name="tel" placeholder="電&nbsp;&nbsp;&nbsp;話" />
	  				</div>
	  				<div class="col-md-8 col-xs-12">
	  					<input type="text" name="email" placeholder="電&nbsp;&nbsp;&nbsp;郵"  />
	  				</div>
	  				<div class="col-md-8 col-xs-12">
	  					<textarea name="message" rows="4" cols="30" placeholder="留&nbsp;&nbsp;&nbsp;言"></textarea>
	  				</div>
	  				<div class="col-md-8 col-xs-12">
	  					<input type="text" name="inputCode" placeholder="驗&nbsp;&nbsp;&nbsp;證&nbsp;&nbsp;&nbsp;碼" id="inputCode" />
	  				</div>
	  				<div class="col-md-8 col-xs-12">
	  					<div class="code" id="checkCode" ></div>
	  				</div>
	  				<div class="col-md-8 col-xs-12">
	  					<button class="btn btn-primary btn-lg contact-submit">提&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;交</button>
	  				</div>
	  			</div>
	  		</form>
	  		</div>
		</div>
		
	</div>
	
</div>

</div>
</div>


<?php get_footer(); ?>