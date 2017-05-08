<?php
/**
 * Template Name: 聯絡我們模板
 *
 * Displays the Test Template of the theme.
 *
 * @package thbusiness
 */
get_header();

global $post;
?>

<div class="contact-div">

	<div id="contact_map" style="position: relative;">
	    <div id="contact_inside">
	    	<div class="contact-image">
	    	<?php the_post_thumbnail(); ?>
	    	</div>

	    	<div class="contact-content">
	    	<?php echo $post->post_content; ?>
	    	</div>

	    	<div class="contact-form-div">
		    <div class="contact-form-title">聯繫方式</div>
		    <div class="contact-form-line"></div>
	  		<form class="contact-form">
				<div class="">
					<input type="text" name="name" placeholder="Name" />
				</div>
				<div class="">
					<input type="text" name="email" placeholder="Email" />
				</div>
				<div class="">
					<input type="text" name="subject" placeholder="Subject" />
				</div>
				<div class="">
					<textarea name="message" rows="3" cols="30" placeholder="Message" ></textarea>
				</div>
				<div class="">
					<button class="btn btn-primary btn-lg contact-submit" style="background-color: #40bac8;">確 定</button>
				</div>
	  		</form>
	  		</div>
	    </div>
		    
	    <div id="googleMap" class="googleMap"></div>
      	<script src="http://maps.google.cn/maps/api/js?language=zh-hk&key=AIzaSyB15d0LCM3U9b1_Orw_oy97ZLN8LwYaE-g">
		</script> 	
      	<script type="text/javascript">
      	function initialize()
		{
			var myCenter=new google.maps.LatLng(22.4475858, 114.1658861);
			var content = '大埔墟寶鄉街41號A2舖 (面向懷義街)';
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




<?php get_footer(); ?>