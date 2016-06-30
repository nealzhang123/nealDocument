var stacktech_ajax = stacktech_obj.admin_ajax;
jQuery(document).ready(function(){
	jQuery('.submit').click(function(e){
		var error = false;
		//console.log(stacktech_obj);
		var blog_title = jQuery('#blog_title').val();

		if( jQuery('#blog_title_check').length > 0 ){
			jQuery('#blog_title_check').hide();
		}

		if( blog_title < 1 ){
			error = true;
			if( jQuery('#blog_title_check').length > 0 ){
				jQuery('#blog_title_check').show();
			}else{
				jQuery('#blog_title').after('<p class="error signup_blog_form" id="blog_title_check"><i class="fa fa-exclamation-triangle"></i>请输入站点标题。</p>');
			}
		}
		
		var blogname = jQuery('#blogname').val();

		if( jQuery('#blogname_check').length > 0 ){
			jQuery('#blogname_check').hide();
		}

		if( blogname < 1 ){
			error = true;
			if( jQuery('#blogname_check').length > 0 ){
				jQuery('#blogname_check').html('<i class="fa fa-exclamation-triangle"></i>请输入站点名称。').show();
			}else{
				jQuery('#blogname').next().next().after('<p class="error signup_blog_form" id="blogname_check"><i class="fa fa-exclamation-triangle"></i>请输入站点名称。</p>');
			}
		}else{
			jQuery.ajax({
				url : stacktech_ajax,
				async : false,
				data : {
					blogname : blogname,
					action : 'stacktech-verify-blogname-ajax',
				},
				type : "POST",
				success : function(response) {  
		            if( response != '' ){
						error = true;
						if( jQuery('#blogname_check').length > 0 ){
							jQuery('#blogname_check').html('<i class="fa fa-exclamation-triangle"></i>'+response).show();
						}else{
							jQuery('#blogname').next().next().after('<p class="error signup_blog_form" id="blogname_check"><i class="fa fa-exclamation-triangle">'+response+'</p>');
						}
					} 
		        }  
			});
		}

		if(error){
			return false;
		}
	});
});