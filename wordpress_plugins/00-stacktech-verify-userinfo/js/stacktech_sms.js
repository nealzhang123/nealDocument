//ajax 发送请求短信服务器
function get_mobile_code(element){

	var phone_verify = check_phone_effect(element);
	if(!phone_verify){
		jQuery('#sms_error_message').html('请输入正确的手机号').show();
		return;
	}else{
		jQuery('#sms_error_message').hide();
		jQuery('#verify_phone_button').html('正在发送短信认证&nbsp;&nbsp;<i class="fa fa-spinner fa-pulse fa-1x"></i>').attr('disabled','disabled');
	}
		
	jQuery.post(
		ajaxurl, 
		{
			'verify_phone': jQuery('#verify_phone').val(),
			'action': 'stacktech-userinfo-send-sms-ajax'
		}, 
		function(response){
			response = JSON.parse(response);
			if(response.error == 1){
				jQuery('#sms_error_message').html('短信发送失败,请重新发送').show();
				jQuery('#verify_phone_button').html('发送短信认证').removeAttr("disabled");
			}else if(response.error == 0){
				jQuery('#verify_sms_msg_span').show();
				jQuery('#verify_phone_button').html('正在发送短信认证');
				RemainTime(jQuery('#verify_sms_msg_button').html());
			}
			
		}
	);

}

//检查手机号是否有效
function check_phone_effect(element){
	var tel = jQuery("#"+element).val(); //获取手机号
	var telReg = !!tel.match(/^(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/);
	//如果手机号码不能通过验证
	if(telReg == false){
	 	return false;
	}else{
		return true;
	}

}

//ajax 验证输入的验证码,是否与短信内验证码一致,可重复验证
function verify_input_sms_msg(){

	var phone_num = jQuery('#verify_phone').val();
	jQuery('#verify_phone').attr('disabled','disabled');
	jQuery('#sms_error_message').hide();
	jQuery.post(
		ajaxurl, 
		{
			'verify_sms_msg': jQuery('#verify_sms_msg').val(),
			'verify_phone': jQuery('#verify_phone').val(),
			'action': 'stacktech-userinfo-verify-sms-ajax'
		}, 
		function(response){
			response = JSON.parse(response);
			
			if(response.error == 1){
				jQuery('#sms_error_message').html('短信验证已过期');
				jQuery('#verify_phone_button').html('重新发送短信认证').removeAttr("disabled");
				jQuery('#verify_sms_msg_span').hide();
			}else if(response.error == 0){
				jQuery('#sms_error_message').html('短信验证通过').css('color','green');
				jQuery('#verify_phone_button').html('已验证');
				jQuery('#verify_sms_msg_span').hide();
				jQuery('#error_verify_phone').hide();
				clearTimeout(Account);
				
				jQuery('#verify_phone').val(phone_num).attr('disabled','disabled');
			}else if(response.error == 2){
				jQuery('#sms_error_message').html('短信输入错误');
				clearTimeout(Account);
				RemainTime('验证短信');
			}
			jQuery('#sms_error_message').show();
		}
	);
}

var iTime = 60;
var Account;
//验证倒计时
function RemainTime(content){
	
	var content = content;
	var iSecond,sSecond="",sTime="";
	if (iTime >= 0){
		iSecond = parseInt(iTime%60);
		if (iSecond >= 0){
			sSecond = '('+iSecond+')';
		}
		sTime=sSecond;
		if(iTime==0){
			clearTimeout(Account);
			sTime='验证超时';
			iTime = 60;
			jQuery('#sms_error_message').html(sTime).show();
			jQuery('#verify_sms_msg_span').hide();
			jQuery('#verify_phone_button').html('重新发送短信认证').removeAttr("disabled");
			jQuery('#verify_sms_msg_button').html(content);
			jQuery('#verify_phone').removeAttr("disabled");

		}else{
			Account = setTimeout("RemainTime('"+content+"')",1000);
			iTime=iTime-1;
			jQuery('#verify_sms_msg_button').html(content+sTime);
		}
	}else{
		sTime='发生未知错误';
		jQuery('#verify_sms_msg_button').html(content+sTime);
	}
}	