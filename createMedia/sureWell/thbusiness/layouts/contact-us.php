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

switch ( ICL_LANGUAGE_CODE ) {
	case 'zh-hant':
		$address_title = '我們的聯絡方式';
		$howto         = '如何聯繫你';
		$company_name  = '迪偉企業有限公司';
		
		$para_company  = '公司名稱';
		$para_name     = '聯繫人';
		$para_tel      = '電話';
		$para_tax      = '傳真';
		$para_email    = '電郵';
		$para_address  = '地址';
		$para_question = '查詢內容';
		
		$button_reset  = '重&nbsp;&nbsp;置';
		$button_submit = '提&nbsp;&nbsp;交';
		$map_lang      = 'zh-hk';

		break;

	case 'en':
		$address_title = 'Our Address';
		$howto         = 'Contact Us';
		$company_name  = 'SURE WELL ENTERPRISES CO.LIMITED';
		
		$para_company  = 'Company';
		$para_name     = 'Name';
		$para_tel      = 'Telphone';
		$para_tax      = 'Tax';
		$para_email    = 'Email';
		$para_address  = 'Address';
		$para_question = 'Consultation';
		
		$button_reset  = 'Reset';
		$button_submit = 'Submit';
		$map_lang      = 'en';

		break;
	
	default:
		# code...
		break;
}
?>
<script type="text/javascript">
	var map_lang = "<?php echo $map_lang; ?>";
</script>
<div class="contact-div container-fluid">

<div class="col-md-8 col-xs-12">	    
    <div id="googleMap" class="googleMap"></div>
  	<script src="http://maps.google.cn/maps/api/js?language=<?php echo $map_lang; ?>&key=AIzaSyB15d0LCM3U9b1_Orw_oy97ZLN8LwYaE-g">
	</script> 	
  	<script type="text/javascript">
  	function initialize()
	{
		var myCenter=new google.maps.LatLng(22.3581674, 114.1314933);
		var content = '<?php echo $company_name; ?>';
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

<div class="col-md-4 col-xs-12">
    <div class="contact_inside">
    	<h3><?php echo $address_title; ?></h3>
    	<div class="contact-form-line"></div>

    	<div class="contact-content">
    	<?php echo $post->post_content; ?>
    	</div>

    	<div class="contact-form-div">
	    <h3><?php echo $howto; ?></h3>
	    <div class="contact-form-line"></div>
  		<form class="contact-form">
  			<div class="contact-form-item">
				<input type="text" name="company" placeholder="<?php echo $para_company; ?>" />
			</div>
			<div class="contact-form-item">
				<input type="text" name="name" placeholder="<?php echo $para_name; ?>" />
			</div>
			<div class="contact-form-item">
				<input type="text" name="tel" placeholder="<?php echo $para_tel; ?>" />
			</div>
			<div class="contact-form-item">
				<input type="text" name="tax" placeholder="<?php echo $para_tax; ?>" />
			</div>
			<div class="contact-form-item">
				<input type="text" name="email" placeholder="<?php echo $para_email; ?>" />
			</div>
			<div class="contact-form-item">
				<input type="text" name="address" placeholder="<?php echo $para_address; ?>" />
			</div>
			<div class="contact-form-item">
				<textarea name="message" rows="3" cols="30" placeholder="<?php echo $para_question; ?>" ></textarea>
			</div>
			<div style="text-align: center;">
			<button class="btn contact-reset"><?php echo $button_reset; ?></button>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="btn contact-submit"><?php echo $button_submit; ?></button>
			</div>
  		</form>
  		</div>
    </div>
</div>

</div>
<?php get_footer(); ?>