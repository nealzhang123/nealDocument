jQuery(document).ready(function(){
	jQuery('.submit').click(function(e){
		//e.preventDefault();
		var error = false;
		var user_name = jQuery('#user_name').val();

		if( jQuery('#user_name_check').length > 0 ){
			jQuery('#user_name_check').hide();
		}

		if( user_name.length < 4 ){
			error = true;
			if( jQuery('#user_name_check').length > 0 ){
				jQuery('#user_name_check').html('<i class="fa fa-exclamation-triangle"></i>请输入用户名。').show();
			}else{
				jQuery('#user_name').next().after('<p class="error signup_user_form" id="user_name_check"><i class="fa fa-exclamation-triangle"></i>请输入用户名。</p>');
			}
		}else{
			var reg1 = /^[0-9]*$/;
			if( reg1.test(user_name) === true ){
				error = true;
				if( jQuery('#user_name_check').length > 0 ){
					jQuery('#user_name_check').html('<i class="fa fa-exclamation-triangle"></i>抱歉，用户名必须要有字母。').show();
				}else{
					jQuery('#user_name').next().after('<p class="error signup_user_form" id="user_name_check"><i class="fa fa-exclamation-triangle"></i>抱歉，用户名必须要有字母。</p>');
				}
			}
		}

		var user_email = jQuery('#user_email').val();

		if( jQuery('#user_email_check').length > 0 ){
			jQuery('#user_email_check').hide();
		}

		var reg2 = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if( reg2.test(user_email) === false ){
			error = true;
			if( jQuery('#user_email_check').length > 0 ){
				jQuery('#user_email_check').show();
			}else{
				jQuery('#user_email').next().after('<p class="error signup_user_form" id="user_email_check"><i class="fa fa-exclamation-triangle"></i>请输入正确的电子邮件地址。</p>');
			}
		}

		if( jQuery('#password_1').length > 0 ){
			var password_1 = jQuery('#password_1').val();
			var password_2 = jQuery('#password_2').val();

			if( jQuery('#user_password_check').length > 0 ){
				jQuery('#user_password_check').hide();
			}

			if( password_1 != password_2 ){
				error = true;
				if( jQuery('#user_password_check').length > 0 ){
					jQuery('#user_password_check').show();
				}else{
					jQuery('#password_2').next().after('<p class="error signup_password" id="user_password_check"><i class="fa fa-exclamation-triangle"></i>密码不匹配。</p>');
				}
			}
		}

		if( jQuery('#tos_agree').length > 0 ){
			if( jQuery('#user_agreement_check').length > 0 ){
				jQuery('#user_agreement_check').hide();
			}

			if( !jQuery('#tos_agree').is(':checked') ){
				error = true;
				if( jQuery('#user_agreement_check').length > 0 ){
					jQuery('#user_agreement_check').show();
				}else{
					jQuery('#tos_content').after('<p class="error signup_tos_error" id="user_agreement_check"><i class="fa fa-exclamation-triangle"></i>您必须同意服务条款才能注册。</p>');
				}
			}
		}
		
		if(error){
			return false;
		}
	});
});