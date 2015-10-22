<?php
/*
Plugin Name: 00 stacktech sms developer
Plugin URI: http://www.etongapp.com
Description: sms verify for developer
Version: 1.0
Author: Stacktech
Author URI: http://www.etongapp.com
License: GPL
*/
class StacktechSmsverify{
	static $sms_expired_time = 60;

	function init(){
		global $user_id;
		
		$is_verify_phone = get_user_meta( $user_id,'is_verify_phone',true );
		$verify_phone = get_user_meta( $user_id,'verify_phone',true );
		
		if( $is_verify_phone ){
			$verify_phone_button = __('已验证');
			$disabled = 'disabled';
		}else{
			$verify_phone_button = __('发送短信认证');
			$disabled = '';
		}

		$html = '<table class="form-table">
				<tr class="user-verify-phone-wrap">
					<th>' . __( '手机号码' ) . '</th>
					<td>
						<span id="verify_phone_span">';
						if($is_verify_phone){
							$html .= $verify_phone;
						}else{
							$html .= '<input type="text" id="verify_phone" name="verify_phone" size="12" maxlength="12" placeholder="'. __('输入手机号码') .'" value="'.$verify_phone.'"/>';
						$html .= '</span>
						<button type="button" id="verify_phone_button" class="button button-secondary wp-generate-pw hide-if-no-js" onClick="get_mobile_code(\'verify_phone\');" '.$disabled.' >' . $verify_phone_button . '</button>';
						if($is_verify_phone){
							$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							$html .= '<button type="button" id="reverify_phone_button" class="button button-secondary wp-generate-pw hide-if-no-js" onClick="reverify_phone_code();">' . __('修改认证手机') . '</button>';
						}
						$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span id="verify_sms_msg_span" style="display: none;">
						<input type="text" id="verify_sms_msg" name="verify_sms_msg" size="10" maxlength="10" placeholder="'. __('输入验证短信') .'"  />
						<button type="button" id="verify_sms_msg_button" class="button button-secondary wp-generate-pw hide-if-no-js" onClick="verify_input_sms_msg();">' . __( '验证短信' ) . '</button>
						</span>
						<span id="sms_error_message" style="color:red;">
						</span>
					</td>
				</tr>
			</table>';
		echo $html;
		wp_enqueue_script( 'stacktech-sms-script', plugin_dir_url( __FILE__ ) . 'stacktech_sms.js' );
		
	}

	public function stacktech_send_sms_ajax(){

		session_start();
		$verify_phone = $_POST['verify_phone'];

	    include_once('stacktech_sms.php');
	    $random_num = rand(100000,999999);

	    $msg = sendTemplateSMS($verify_phone,array($random_num,'1'),1);
	    error_log('test at 57:'.var_export($msg,true));

	    if( 0 == $msg['error_code'] ){
	    	$return_sms_msg = $random_num;
	    	$_SESSION['stacktech_return_sms_msg'] = $return_sms_msg;
		    $_SESSION['stacktech_sms_start_time'] = time();
	    	$json = array(
		    	'error'=>'0',
		    	'return_sms_msg' => $return_sms_msg
		    );
	    }else{
	    	$json = array(
		    	'error'=>'1'
		    );
	    }
		    
		echo json_encode($json);
		exit();
	}

	public function stacktech_verify_sms_ajax(){
		session_start();
		$verify_sms_msg = trim($_POST['verify_sms_msg']);
		$sesstion_end_time = time();
		$sms_expired_time = self::$sms_expired_time;

		if( isset($_SESSION['stacktech_sms_start_time']) && isset($_SESSION['stacktech_return_sms_msg']) && $sesstion_end_time-$_SESSION['stacktech_sms_start_time'] < $sms_expired_time ){
			if( $verify_sms_msg == $_SESSION['stacktech_return_sms_msg'] ){
				$json = array(
		    		'error'=>'0'
		    	);
				$user_id = get_current_user_id();
		    	update_user_meta( $user_id,'is_verify_phone',1 );
		    	update_user_meta( $user_id,'verify_phone',$_POST['verify_phone'] );
			}else{
				$json = array(
		    		'error'=>'2'
		    	);
			}
			
		}else{
			$json = array(
		    	'error'=>'1'
		    );
		}

		echo json_encode($json);
		exit();
	}

	public function update_user_phone(){
		global $user_id;

		if( !isset($_POST['verify_phone']) || empty($_POST['verify_phone']) )
			return;
		$verify_phone = trim($_POST['verify_phone']);
		
		$is_verify_phone = get_user_meta( $user_id,'is_verify_phone',true );

		if( empty($is_verify_phone) ){
			update_user_meta( $user_id,'verify_phone',$verify_phone );
		}
		return true;
	}

}

add_action( 'show_user_profile',array('StacktechSmsverify','init') );
add_action( 'wp_ajax_stacktech-send-sms-ajax', array('StacktechSmsverify','stacktech_send_sms_ajax') );
add_action( 'wp_ajax_stacktech-verify-sms-ajax', array('StacktechSmsverify','stacktech_verify_sms_ajax') );
add_action( 'personal_options_update',array('StacktechSmsverify','update_user_phone') );