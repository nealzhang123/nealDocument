var step = verify_obj.init_step;
var step = parseInt(step);
var user_action = verify_obj.user_action;
var total_step = 4;
jQuery(document).ready(function(){

	//拷贝过来的,用作上传图片预览
	jQuery.fn.extend({
	    uploadPreview: function (opts) {
	        var _self = this,
	            _this = jQuery(this);
	        opts = jQuery.extend({
	            Img: "ImgPr",
	            Width: 100,
	            Height: 100,
	            ImgType: ["gif", "jpeg", "jpg", "bmp", "png"],
	            Callback: function () {}
	        }, opts || {});
	        _self.getObjectURL = function (file) {
	            var url = null;
	            if (window.createObjectURL != undefined) {
	                url = window.createObjectURL(file)
	            } else if (window.URL != undefined) {
	                url = window.URL.createObjectURL(file)
	            } else if (window.webkitURL != undefined) {
	                url = window.webkitURL.createObjectURL(file)
	            }
	            return url
	        };
	        _this.change(function () {
	            if (this.value) {
	                if (!RegExp("\.(" + opts.ImgType.join("|") + ")$", "i").test(this.value.toLowerCase())) {
	                    alert("选择文件错误,图片类型必须是" + opts.ImgType.join("，") + "中的一种");
	                    this.value = "";
	                    return false
	                }
	                if ( /msie/.test(navigator.userAgent.toLowerCase()) ) {
	                    try {
	                        jQuery("#" + opts.Img).attr('src', _self.getObjectURL(this.files[0]))
	                    } catch (e) {
	                        var src = "";
	                        var obj = jQuery("#" + opts.Img);
	                        var div = obj.parent("div")[0];
	                        _self.select();
	                        if (top != self) {
	                            window.parent.document.body.focus()
	                        } else {
	                            _self.blur()
	                        }
	                        src = document.selection.createRange().text;
	                        document.selection.empty();
	                        obj.hide();
	                        obj.parent("div").css({
	                            'filter': 'progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)',
	                            'width': opts.Width + 'px',
	                            'height': opts.Height + 'px'
	                        });
	                        div.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = src
	                    }
	                } else {
	                    jQuery("#" + opts.Img).attr('src', _self.getObjectURL(this.files[0]))
	                }
	                opts.Callback()
	            }
	        })
	    }
	});
	
	//点击下一步的事件
	jQuery('#verify_next_step_button').click(function(){
		var style = jQuery("input[name='verify_choose_style']:checked").val();
		jQuery('#verify_style').val(style);
		jQuery('#action').val(style);
		jQuery('.error_notice').hide();

		var check_result = check_area(step,style);
		if(!check_result)
			return;
		if( 4 == step ){
			jQuery('#verify_prev_step_button').css('background-color','grey').attr('disabled','disabled');
			jQuery('#verify_next_step_button').css('background-color','grey').html('提交&nbsp;&nbsp;<i class="fa fa-spinner fa-pulse fa-1x"></i>').attr('disabled','disabled');
			jQuery('#verify_form').submit();
			return;
		}

		step += 1;
		if( 4 == step){
			jQuery('#verify_prev_step_button').html('修改');
			jQuery('#verify_next_step_button').html('提交');
		}else{
			jQuery('#verify_prev_step_button').html('上一步');
			jQuery('#verify_next_step_button').html('下一步');
		}
		change_bar_class(step);
		display_content(style,step);
	});

	//点击上一步的事件
	jQuery('#verify_prev_step_button').click(function(){
		var style = jQuery("input[name='verify_choose_style']:checked").val();
		step -= 1;
		jQuery('#verify_prev_step_button').html('上一步');
		jQuery('#verify_next_step_button').html('下一步');
		jQuery('.error_notice').hide();
		change_bar_class(step);
		display_content(style,step);
	});

	jQuery('#verify_final_modify').click(function(e){
		e.preventDefault();
		var current_url = window.location.href;
		window.location.href = current_url+'&action=modify';
	});

	//图片预览事件
	jQuery("#verify_user_card_front_image").uploadPreview({ Img: "verify_user_card_front_image_preview" });
	jQuery("#verify_user_card_back_image").uploadPreview({ Img: "verify_user_card_back_image_preview" });
	jQuery("#verify_license_image").uploadPreview({ Img: "verify_license_image_preview" });
	jQuery("#verify_organization_image").uploadPreview({ Img: "verify_organization_image_preview" });
	// jQuery("#verify_organization_back_image").uploadPreview({ Img: "verify_organization_back_image_preview" });
	jQuery("#verify_tax_image").uploadPreview({ Img: "verify_tax_image_preview" });

	jQuery('#verify_money_button').click(function(e){
		e.preventDefault();
		jQuery(this).html('提交&nbsp;&nbsp;<i class="fa fa-spinner fa-pulse fa-1x"></i>').attr('disabled','disabled').css('background-color','grey');
		//jQuery('#verify_money_form').submit();
		jQuery.post(
			ajaxurl, 
			{
				'verify_money': jQuery('#verify_money').val(),
				'action': 'stacktech-user-verify-money-ajax'
			}, 
			function(response){
				response = JSON.parse(response);
				if(response.error == 1){
					jQuery('#verify_money_button').html('提交').css('background-color','#f57403').removeAttr('disabled');
					jQuery('#verify_money_error').html(response.message).show();
				}else{
					window.location.reload();
				}
			}
		);
	});

	jQuery('.verify_card_img').click(function(e){
		jQuery(this).prev().click();
	});

	jQuery('.verify_company_bank_type').click(function(e){
		var bank_type = jQuery("input[name='verify_company_bank_type']:checked").val();
		if( 1 == bank_type ){
			jQuery('.verify_style_company_extend').hide();
			jQuery('#label_company_bank_account').html('支付宝账号');
		}else{
			jQuery('.verify_style_company_extend').show();
			jQuery('#label_company_bank_account').html('公司银行账号');
		}
	});
		
});

function change_bar_class(step){
	for (var i = 2; i <= total_step; i++) {
		if(i == step){
			jQuery('#verify_bar_'+i).removeClass('m_bar_unactive').addClass('m_bar_active');
		}else{
			jQuery('#verify_bar_'+i).removeClass('m_bar_active').addClass('m_bar_unactive');
		}
	}
	if(1 == step){
		jQuery('#verify_bar_1').removeClass('f_bar_unactive').addClass('f_bar_active');
	}else{
		jQuery('#verify_bar_1').removeClass('f_bar_active').addClass('f_bar_unactive');
	}

	if( 1 == step){
		jQuery('#verify_prev_step_button').hide();
	}else{
		jQuery('#verify_prev_step_button').show();
	}
}

//显示/隐藏每一步的内容
function display_content(style,step){
	var currentDiv;
	switch(step)
	{
		case 1:
			currentDiv = 'verify_choose_area';
			break;
		case 2:
			currentDiv = 'verify_agreement_area';
			break;
		case 3:
			currentDiv = 'information_area';
			break;
		case 4:
			currentDiv = 'verify_confirm_area';
			break;
		case 5:
			currentDiv = 'verify_waiting_area';
			break;
		case 6:
			currentDiv = 'verify_final_area';
			break;
		default:
			currentDiv = 'verify_choose_area';
			break;
	}

	if(3 == step){
		if('company' == style){
			jQuery('.verify_style_company').show();
			jQuery('.verify_style_personal').hide();
		}else{
			jQuery('.verify_style_personal').show();
			jQuery('.verify_style_company').hide();
		}
	}

	if(4 == step){
		if('company' == style){
			jQuery('.confirm_field_company').show();
			jQuery('.confirm_field_personal').hide();
		}else{
			jQuery('.confirm_field_personal').show();
			jQuery('.confirm_field_company').hide();
		}
	}

	jQuery('.verify_form_div').hide();
	jQuery('#'+currentDiv).show();

}

//进行下一步时的内容判断
function check_area(step,style){
	var check_result;
	switch(step)
	{
		case 2:
			check_result = choose_area_check();
			break;
		case 3:
			check_result = information_check(style);
			break;
		case 5:
			check_result = waiting_area_check();
			break;
		case 6:
			check_result = verify_final_check();
			break;
		default:
			check_result = true;
			break;
	}
	return check_result;
}

//协议需选中
function choose_area_check(){
	if( jQuery('#verify_agreement').attr('checked') != 'checked'){
		jQuery('#agreement_error').show();
		return false;
	}
	return true;
}

//个人与公司认证内容判断
function information_check(style){
	var result = true;
	var bank_type = jQuery("input[name='verify_company_bank_type']:checked").val();

	if( 'personal' == style ){
		if( 2 == user_action ){
			var area = ['user_name','user_card_id','personal_bank_account'];
		}else if( 1 == user_action ){
			var area = ['user_name','user_card_id'];
		}
	}else{
		if( 2 == user_action ){
			if( 1 == bank_type ){
				var area = ['owner_name','user_card_id','company_name','license_number','organization_number','tax_number','company_bank_account',];
			}else{
				var area = ['owner_name','user_card_id','company_name','license_number','organization_number','tax_number','company_bank_account','company_bank_name','company_bank_position'];
			}
			
		}else if( 1 == user_action ){
			var area = ['owner_name','user_card_id','company_name','license_number','organization_number','tax_number'];
		}
	}
	for (var ele in area) {
		var verify_ele = jQuery('#verify_'+area[ele]).val();
		var html_ele = jQuery('#label_'+area[ele]).html();
		var html_ele = html_ele.replace('<div class="error_logo">*<\/div>','');
		if( '' == jQuery.trim(verify_ele) ){
			jQuery('#error_'+area[ele]).html('<i class="fa fa-exclamation-circle"></i> 未输入'+html_ele).show();
			result = false;
		}else{
			if( 'user_card_id' == area[ele]){
				//身份证号码为15位或者18位,15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X  
				var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
				if( reg.test(verify_ele) === false ){
					jQuery('#error_'+area[ele]).html('<i class="fa fa-exclamation-circle"></i> 身份证输入不合法').show();
					result = false;
				}
			}
		}
	}
	if( 'company' == style ){
		var verify_license_image_preview = jQuery('#verify_license_image_preview').attr('src');
		if( '' == jQuery.trim(verify_license_image_preview) ){
			jQuery('#error_license_image').html('<i class="fa fa-exclamation-circle"></i> 未上传公司营业执照').show();
			result = false;
		}

		var verify_organization_image_preview = jQuery('#verify_organization_image_preview').attr('src');
		if( '' == jQuery.trim(verify_organization_image_preview) ){
			jQuery('#error_organization_image').html('<i class="fa fa-exclamation-circle"></i> 未上传公司组织结构代码正面').show();
			result = false;
		}
		
		var verify_tax_image_preview = jQuery('#verify_tax_image_preview').attr('src');
		if( '' == jQuery.trim(verify_tax_image_preview) ){
			jQuery('#error_tax_image').html('<i class="fa fa-exclamation-circle"></i> 未上传公司税务登记证').show();
			result = false;
		}
	}
	
	var verify_user_card_front_image_preview = jQuery('#verify_user_card_front_image_preview').attr('src');
	if( '' == jQuery.trim(verify_user_card_front_image_preview) ){
		jQuery('#error_user_card_front_image').html('<i class="fa fa-exclamation-circle"></i> 未上传身份证正面').show();
		result = false;
	}
	var verify_user_card_back_image_preview = jQuery('#verify_user_card_back_image_preview').attr('src');
	if( '' == jQuery.trim(verify_user_card_back_image_preview) ){
		jQuery('#error_user_card_back_image').html('<i class="fa fa-exclamation-circle"></i> 未上传身份证反面').show();
		result = false;
	}
	if(result)
		confirm_area_fill(style);

	return result;
}

function confirm_area_fill(style){
	var bank_type = jQuery("input[name='verify_company_bank_type']:checked").val();

	if( 'personal' == style ){
		if( 2 == user_action ){
			var area = ['user_name','user_card_id','personal_bank_account'];
		}else if( 1 == user_action ){
			var area = ['user_name','user_card_id'];
		}
	}else{
		if( 2 == user_action ){
			if( 1 == bank_type ){
				var area = ['owner_name','user_card_id','company_name','license_number','organization_number','tax_number','company_bank_account',];
			}else{
				var area = ['owner_name','user_card_id','company_name','license_number','organization_number','tax_number','company_bank_account','company_bank_name','company_bank_position'];
			}
		}else if( 1 == user_action ){
			var area = ['owner_name','user_card_id','company_name','license_number','organization_number','tax_number'];
		}
	}
	
	for (var ele in area) {
		var verify_ele = jQuery('#verify_'+area[ele]).val();
		jQuery('#confirm_'+area[ele]).html(verify_ele);
	}

	if( 'personal' == style ){
		var area = ['user_card_front_image','user_card_back_image'];
	}else{
		var area = ['user_card_front_image','user_card_back_image','license_image','organization_image','organization_back_image','tax_image'];
	}
	
	for (var ele in area) {
		var ele_src = jQuery('#verify_'+area[ele]+'_preview').attr('src');
		jQuery('#confirm_'+area[ele]).attr('src',ele_src);
	}

	jQuery('#confirm_verify_phone').html(jQuery('#verify_phone').val());
}