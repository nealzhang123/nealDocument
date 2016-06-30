jQuery('.verify_userinfo_button').click(function(e){
	e.preventDefault();
	var status = jQuery(this).attr('status');
	jQuery('#verify_userinfo_status').val(status);
	jQuery('#verify_userinfo_form').submit();
});

jQuery('.confirm_fail_button').click(function(e){
	e.preventDefault();
	jQuery(this).next().show();
});