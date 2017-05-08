<?php
/**
 Template Name: contact
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */


get_header(); 

global $post; 
?>
<div class="top-shadow"></div>
    
        <!-- **Container** -->
<div>
    
	<div id="googleMap"></div>
	<script src="http://maps.google.cn/maps/api/js?language=zh-hk&key=AIzaSyB15d0LCM3U9b1_Orw_oy97ZLN8LwYaE-g">
	</script> 	
	<script type="text/javascript">
	function initialize()
	{
		var myCenter=new google.maps.LatLng(22.3112993, 114.2249276);
		var content = '觀塘巧明街119號-121號年運工業大廈4樓D室';
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

    <div class="clear"></div>

    <div class="container contact-div">
    <div class="row">
    	<div class="col-md-6 col-xs-12 contact-form-parent">
    		<div class="contact-form-div">
    		<form class="contact-form">
    			<div class="row contact-form-row">
    				<div class="col-md-12 col-xs-12">
    					<input type="text" name="name" placeholder="聯繫人 :" />
    				</div>
    				<div class="col-md-12 col-xs-12">
    					<input type="text" name="tel" placeholder="電話 :" />
    				</div>
    				<div class="col-md-12 col-xs-12">
    					<input type="text" name="email" placeholder="電郵 :" />
    				</div>
    				<div class="col-md-12 col-xs-12">
    					<textarea name="message" rows="4" cols="30" placeholder="查詢內容 :"></textarea>
    				</div>
    				<div class="col-md-12 col-xs-12" style="text-align: center;">
    					<button class="btn contact-reset" >重&nbsp;&nbsp;&nbsp;&nbsp;置</button>
    					&nbsp;&nbsp;&nbsp;&nbsp;
    					<button class="btn contact-submit" >提&nbsp;&nbsp;&nbsp;&nbsp;交</button>
    				</div>
    			</div>
    		</form>
    		</div>
    	</div>
    	<div class="col-md-6 col-xs-12 contact-post-content">
    		<?php echo $post->post_content; ?>
    	</div>
    </div>
    </div>
</div>    
  <!-- **Main - End** -->







<?php
get_footer();
?>