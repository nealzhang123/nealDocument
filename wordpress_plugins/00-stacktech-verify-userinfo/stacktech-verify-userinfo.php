<?php
/*
Plugin Name: 00 stacktech verify userinfo
Plugin URI: http://www.etongapp.com
Description: stacktech verify user info
Version: 1.0
Author: Stacktech
Author URI: http://www.etongapp.com
License: GPL
*/
define( 'STACKTECH_VERIFY_IMG_PATH', WP_CONTENT_DIR . '/uploads/verifyinfo-upload/' );
define( 'STACKTECH_VERIFY_VIEW_PATH', plugin_dir_path(__FILE__) . 'view/' );
define( 'STACKTECH_VERIFY_IMG_URL', content_url('uploads/verifyinfo-upload/') );

include_once( plugin_dir_path(__FILE__) . 'class_verify_userinfo_db.php' );
include_once( plugin_dir_path(__FILE__) . 'class_userinfo_list.php' );

class StacktechVerifyUserInfo {
	public $user_action,$vfu_wb;
	public $per_action = 'personal_submit';
	public $com_action = 'company_submit';
	public $money_action = 'verify_money_submit';
	public $proxy_action = 'verify_proxy';
	
	public $fill_start_status = 'fill_start';
	public $fill_fail_status = 'fill_fail';
	public $verifying_info_status = 'verifying_info';
	public $verify_info_fail_status = 'verify_info_fail';
	public $verify_info_success_status = 'verify_info_success';
	public $fill_bank_status = 'fill_bank';
	public $verify_bank_fail_status = 'verify_bank_fail';
	public $verify_success_status = 'verify_success';

	public $default_style = 'personal';
	public $sms_expired_time = 60;
	public $admin_email_addr = '';
	public $max_verify_money_time = 2;
	public $add_blogs_count = 10;

	public function __construct(){
		$admin_emails = json_decode( get_blog_option( BLOG_ID_CURRENT_SITE ,'admin_verify_setting_email' ) ,true );

		$this->admin_email_addr = explode("\r\n", $admin_emails);
		$this->vfu_wb = new VerifyUserinfoDb();
	}

	public function init(){
		$plugin = new StacktechVerifyUserInfo;

		add_menu_page ( __('实名认证'), __('实名认证'), 'manage_options', 'verify_user', array($plugin,'verify_user_main') );
		add_submenu_page( 'verify_user', __( '开发者认证' ), __( '开发者认证' ), 'manage_options', 'verify_user_developer', array($plugin,'verify_user_developer') );
		add_submenu_page( 'verify_user', __( '代理认证' ), __( '代理认证' ), 'manage_options', 'verify_user_proxy', array($plugin,'verify_user_proxy') );
		
		add_action('wp_before_admin_bar_render', array( $plugin, 'add_user_bar_notice' ) );
	}

	public function verify_user_main(){
		include_once( STACKTECH_VERIFY_VIEW_PATH . "view_verify_user_main.php" );
	}

	public function verify_user_developer(){
		$this->user_action = 2;
		$this->render_page();
	}

	public function verify_user_proxy(){
		$this->user_action = 1;
		$this->render_page();
	}

	public function render_page(){
		$user_id = get_current_user_id();

		$user_verify_info = $this->vfu_wb->get_userinfo($user_id);
		$current_user_action = $user_verify_info['user_action'];

		if( !empty($current_user_action) && $current_user_action != $this->user_action ){
			switch ($current_user_action) {
				case 1:
					$current_user_action = __('代理');
					break;
				case 2:
					$current_user_action = __('开发者');
					break;	
				default:
					# code...
					break;
			}
			include_once( STACKTECH_VERIFY_VIEW_PATH . 'view_user_action_error.php' );
			return;
		}

		if( isset($_POST['_wpnonce']) && wp_verify_nonce( $_POST['_wpnonce'], 'verify_userinfo' ) ){
			$this->update_verify_userinfo();
		}

		if( isset($_GET['action']) &&'modify' == $_GET['action'] ){
			$verify_status = $this->vfu_wb->get_userinfo_meta( $user_id ,'status' );
			if( $this->verify_info_fail_status == $verify_status)
				$this->vfu_wb->update_userinfo( $user_id,array('status'=>$this->fill_fail_status) );
		}
		//$user_verify_info['user_type'] == 1
		$verify_status = $this->vfu_wb->get_userinfo_meta( $user_id ,'status' );
		if( empty($verify_status) )
			$verify_status = $this->fill_start_status;

		if( ($this->verify_info_success_status == $verify_status && $user_verify_info['user_type'] == 1 && $this->user_action == 2) || ($this->verify_success_status == $verify_status && $user_verify_info['user_type'] == 2 && $this->user_action == 1) )
			$verify_status = $this->fill_fail_status;

		if( $this->fill_fail_status == $verify_status){
			$init_step = 3;
		}else{
			$init_step = 1;
		}

		$this->verify_info_page($verify_status);
		$this->verify_content_script();
		$this->verify_content_style();

		wp_localize_script( 'stacktech-verify-userinfo-script', 'verify_obj', array('init_step' => $init_step,'user_action' => $this->user_action) );
	}

	public function verify_info_page($verify_status){
		$bottom_allow_arr = array( $this->fill_start_status ,$this->fill_fail_status );
		if( $this->verify_info_fail_status == $verify_status || $this->verify_bank_fail_status == $verify_status ){
			$verify_bar_complete_class = 'e_bar_f_active';
		}else if( $this->verify_success_status == $verify_status || ($this->verify_info_success_status == $verify_status && $this->user_action == 1 ) ){
			$verify_bar_complete_class = 'e_bar_active';
		}else{
			$verify_bar_complete_class = 'e_bar_unactive';
		}

		$user_id = get_current_user_id();
		$verify_phone = get_user_meta( $user_id ,'verify_phone' ,true );
	 	$verify_type = get_user_meta( $user_id ,'verify_type' ,true );

	 	if( !empty($verify_type) ){
			$verify_phone_button = __('已验证');
			$phone_disabled = 'disabled';
		}else{
			$verify_phone_button = __('发送短信认证');
			$phone_disabled = '';
		}

		if( $this->fill_start_status != $verify_status ){
			$user_verify_info = $this->vfu_wb->get_userinfo($user_id);

			$verify_style = $user_verify_info['verify_style'];
	 		$display_info = ( 'personal' == $verify_style ) ? true : false;
	 		$user_options = $this->mb_unserialize($user_verify_info['option_value']);
	 		$reason = $this->mb_unserialize($user_verify_info['reason']);
		}

		include_once( STACKTECH_VERIFY_VIEW_PATH . 'view_verify_userinfo.php' );
	}

	public function verify_content_script(){
		wp_enqueue_script( 'stacktech-verify-userinfo-script', plugin_dir_url( __FILE__ ) . 'js/verify_userinfo.js' );
		wp_enqueue_script( 'stacktech-verify-img-preview-script', plugin_dir_url( __FILE__ ) . 'js/jquery.uploadPreview.js' );
		wp_enqueue_script( 'stacktech-verify-sms-script', plugin_dir_url( __FILE__ ) . 'js/stacktech_sms.js' );
	}

	public function verify_content_style(){
		wp_enqueue_style( 'stacktech-verify-userinfo-style', plugin_dir_url( __FILE__ ) . 'css/verify_userinfo.css' );
		wp_enqueue_style( 'stacktech-font-awesome-style', 'http://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
	}

	//检查权限
	// public function has_role($role){
	// 	global $current_user;

	// 	$current_user_roles = $current_user->roles;
	// 	$has_role = ( in_array($role, $current_user_roles) ) ? true : false ;
	// 	return $has_role;
	// }

	//插件激活时创建相关表
	public function plugin_activation(){
		global $wpdb;

		$plugin = new StacktechVerifyUserInfo;
		$plugin->vfu_wb->verify_table_setup();

		$mail_queue_table = $wpdb->base_prefix . 'queue_send_mail';

		if( $wpdb->get_var("SHOW TABLES LIKE '" . $mail_queue_table . "'") == false ){
			$sql = "CREATE TABLE " . $mail_queue_table. "(
	        id bigint(20) AUTO_INCREMENT,
	        user_id bigint(20) NOT NULL,
	        option_value longtext,
	        status tinyint(2) NOT NULL DEFAULT '0',
	        time datetime,
	        PRIMARY KEY  (id)
	        );";

			$wpdb->query($sql);
		}
	}


	//更新开发者申请资料
	public function update_verify_userinfo(){

		$user_id = get_current_user_id();
		$user_email = get_user_option('user_email',$user_id);

		$verify_phone = get_user_meta( $user_id ,'verify_phone' ,true );
		
		$verify_style = $_POST['verify_style'];
		$action = $_POST['action'];

		$user_verify_info = $this->vfu_wb->get_userinfo($user_id);
		//开发者进行代理认证,不需要资料审核
		if( 2 == $user_verify_info['user_type'] && 1 == $this->user_action ){
			$data = array(
				'user_id' => $user_id,
				'user_type' => 3,
				'time' => date('Y-m-d H:i:s')
				);
			$this->vfu_wb->update_userinfo( $user_id ,$data );
			$this->send_email_to_admin( $user_id ,'verify_proxy' );
			$this->admin_send_email( $user_id ,'verify_proxy_success' ,1 );
			$this->create_more_sites($user_id);

	  		$data2 = array(
				'user_id' => $user_id,
				'user_action' => $this->user_action,
				'action' => $this->proxy_action,
				'time' => date('Y-m-d H:i:s')
				);
			$this->vfu_wb->insert_history( $data2 );
			wp_safe_redirect( admin_url( 'admin.php?page=verify_user_proxy') );
			return;
		}

		if( $this->default_style == $action ){
			if( 1 == $this->user_action ){
				$deal_data_arr = array( 'verify_user_card_id' ,'verify_user_name' );
			}elseif( 2 == $this->user_action ){
				$deal_data_arr = array( 'verify_user_card_id' ,'verify_user_name' ,'verify_personal_bank_account');
			}
			
			$deal_image_arr = array( 'verify_user_card_front_image' ,'verify_user_card_back_image');
			$action_history = $this->per_action;
		}else{
			if( 1 == $this->user_action ){
				$deal_data_arr = array( 'verify_user_card_id' ,'verify_company_name' ,'verify_license_number' ,'verify_organization_number' ,'verify_tax_number' ,'verify_owner_name' ,'verify_license_number' );
			}elseif( 2 == $this->user_action ){
				if( 1 == $_POST['verify_company_bank_type']){
					$deal_data_arr = array( 'verify_user_card_id' ,'verify_company_name' ,'verify_license_number' ,'verify_organization_number' ,'verify_tax_number' ,'verify_owner_name' ,'verify_license_number' ,'verify_company_bank_account' ,'verify_company_bank_type' );
				}else{
					$deal_data_arr = array( 'verify_user_card_id' ,'verify_company_name' ,'verify_license_number' ,'verify_organization_number' ,'verify_tax_number' ,'verify_owner_name' ,'verify_license_number' ,'verify_company_bank_account' ,'verify_company_bank_name' , 'verify_company_bank_position','verify_company_bank_type' );
				}
				
			}
			$deal_image_arr = array( 'verify_user_card_front_image' ,'verify_user_card_back_image' ,'verify_license_image' ,'verify_organization_image' ,'verify_tax_image' );
			//remove verify_organization_back_image
			$action_history = $this->com_action;
		}

		$error = array(
				'status' => 0,
				'msg' => array()
			);
		date_default_timezone_set('PRC');


		$data_info_arr = array();
		foreach ($deal_data_arr as $deal_data) {
			$data_info_arr[$deal_data] = ( isset($_POST[$deal_data]) && !empty($_POST[$deal_data]) ) ? $_POST[$deal_data] : '';
		}

		//图片处理
		$image_info_arr = array();
		$last_option_value = $this->vfu_wb->get_userinfo_meta( $user_id ,'option_value' );
		$last_option_value = unserialize($last_option_value);
		foreach ($deal_image_arr as $deal_image) {
			$upload_file_name = '';
			if( isset($_FILES[$deal_image]) ){
				if( empty($_FILES[$deal_image]['tmp_name']) ){
					$image_info_arr[$deal_image] = $last_option_value[$deal_image];
				}else{
					$upload_file = isset($_FILES[$deal_image]['tmp_name']) ? $_FILES[$deal_image]['tmp_name'] : '';
					$upload_file_origin_name = isset($_FILES[$deal_image]['name']) ? $_FILES[$deal_image]['name'] : '';
					$upload_file_ext = substr(strrchr($upload_file_origin_name, '.'), 1);
					//date_default_timezone_set('PRC');
					$upload_file_name = $user_id . '-' . rand(100,999) . '-' . date('YmdHis') . '.' . $upload_file_ext;
					$upload_file_size = isset($_FILES[$deal_image]['size']) ? $_FILES[$deal_image]['size'] : '';
					if ( !is_dir(STACKTECH_VERIFY_IMG_PATH) ) {
				        mkdir(STACKTECH_VERIFY_IMG_PATH,0777,true);
				        $fh = fopen( STACKTECH_VERIFY_IMG_PATH."index.php","w" );
	    				fclose($fh);
				    }
				    move_uploaded_file($upload_file,STACKTECH_VERIFY_IMG_PATH.$upload_file_name);
				    $image_info_arr[$deal_image] = $upload_file_name;
				}
			}else{
				$error['status'] = 1;
				$error['msg'][$deal_image] = 1;
			}
		}

		if ( empty($verify_phone) ){
			$error['status'] = 1;
			$error['msg']['verify_phone'] = 1;
		}

		foreach ($data_info_arr as $key => $data_info) {
			if ( empty($data_info) ){
				$error['status'] = 1;
				$error['msg'][$key] = 1;
			}
			$data_info_arr[$key] = sanitize_text_field($data_info);
		}

		foreach ($image_info_arr as $key => $image_info) {
			if ( empty($image_info) ){
				$error['status'] = 1;
				$error['msg'][$key] = 1;
			}
		}

  		$status = ( 1 == $error['status'] ) ? $this->fill_fail_status : $this->verifying_info_status;

		$option_value = array_merge($data_info_arr,$image_info_arr);
		$option_value['verify_phone'] = $verify_phone;
		
		$data = array(
			'user_id' => $user_id,
			'user_email' => $user_email,
			'verify_style' => $verify_style,
			'user_action' => $this->user_action,
			'option_value' => serialize($option_value),
			'status' => $status,
			'reason' => serialize($error['msg']),
			'time' => date('Y-m-d H:i:s')
			);
		$this->vfu_wb->update_userinfo( $user_id ,$data );

		if( !$error['status'] ){
			update_user_meta( $user_id,'verify_type',$verify_style );
			$this->send_email_to_admin( $user_id ,'verify_info' );
			$this->admin_send_email( $user_id ,'verify_info_submit' ,2 );
		}

		$status_history = ( 1 == $error['status'] ) ? 0 : 1;
  		$data2 = array(
			'user_id' => $user_id,
			'user_action' => $this->user_action,
			'action' => $action_history,
			'status' => $status_history,
			'reason' => serialize($error['msg']),
			'time' => date('Y-m-d H:i:s')
			);
		$this->vfu_wb->insert_history( $data2 );
	}

	public function send_email_to_admin( $user_id ,$style ){
		$stacktech = new StacktechCommon;
		date_default_timezone_set('PRC');
		
		$userinfo = get_userdata($user_id);
		if( 'verify_info' == $style ){
			$title = __('实名认证-基本信息审核') . date(' Y-m-d H:i:s');
			$content = $userinfo->data->user_email . __('正在申请实名认证');
		}else if( 'verify_bank_success' == $style ){
			$title = __('实名认证-银行账号审核') . date(' Y-m-d H:i:s');
			$content = $userinfo->data->user_email . __('实名认证开发者认证审核通过');
		}else if( 'verify_proxy' == $style ){
			$title = __('实名认证-代理认证审核') . date(' Y-m-d H:i:s');
			$content = $userinfo->data->user_email . __('实名认证代理认证审核通过');
		}
		
		$stacktech->mail( $this->admin_email_addr,$title,$content );
	}

	//发送请求到短信服务商,
	public function stacktech_send_sms_ajax(){

		session_start();
		$verify_phone = $_POST['verify_phone'];

	    include_once('stacktech_sms.php');
	    $random_num = rand(100000,999999);

	    $msg = sendTemplateSMS($verify_phone,array($random_num,'1'),STACKTECH_SMS_TEMPLATE_ID );

	    if( 0 == $msg['error_code'] ){
	    	$return_sms_msg = $random_num;
	    	$_SESSION['stacktech_return_sms_msg'] = $return_sms_msg;
		    $_SESSION['stacktech_sms_start_time'] = time();
	    	$json = array(
		    	'error'=>'0'
		    );
	    }else{
	    	$json = array(
		    	'error'=>'1'
		    );
	    }
		echo json_encode($json);
		exit();
	}

	//判断输入的验证码,是否已经超时,是否与之前发送给客户的一致
	public function stacktech_verify_sms_ajax(){
		session_start();
		$verify_sms_msg = trim($_POST['verify_sms_msg']);
		$sesstion_end_time = time();
		$plugin = new StacktechVerifyUserInfo;
		$sms_expired_time = $plugin->sms_expired_time;

		if( isset($_SESSION['stacktech_sms_start_time']) && isset($_SESSION['stacktech_return_sms_msg']) && $sesstion_end_time-$_SESSION['stacktech_sms_start_time'] < $sms_expired_time ){
			if( $verify_sms_msg == $_SESSION['stacktech_return_sms_msg'] ){
				$json = array(
		    		'error'=>'0'
		    	);
				$user_id = get_current_user_id();
		    	update_user_meta( $user_id,'verify_type','phone' );
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

	//右上开发者认证入口
	// public function add_user_bar_profile() {
 //        global $wp_admin_bar;

 //        if( !$this->has_role('developer') )
 //        	return;
	//     $args = array(
	//         'id'     => 'verify_userinfo_profile',
	//         'title'  => __('实名认证'),
	//         'parent' => 'user-actions',
	//         'href'   => admin_url( 'admin.php?page=verify_user_info')
	//     );
	//     $wp_admin_bar->add_node( $args );
 // 	}

 	//右上开发者认证提示
	public function add_user_bar_notice() {
        global $wp_admin_bar;

        $user_id = get_current_user_id();

		$verify_status = $this->vfu_wb->get_userinfo_meta( $user_id ,'status' );
		if( empty($verify_status) )
        	return;

		switch ($verify_status) {
			case 'fill_start':
				$content = __('(未验证)');
				break;
			case 'fill_fail':
				$content = __('(等待资料提交)');
				break;
			case 'verifying_info':
				$content = __('(等待资料审核)');
				break;
			case 'verify_info_fail':
				$content = __('(资料审核未通过)');
				break;
			case 'verify_info_success':
				$content = __('(资料审核通过)');
				break;
			case 'fill_bank':
				$content = __('(等待账户确认)');
				break;
			case 'verify_bank_fail':
				$content = __('(账户验证失败)');
				break;
			case 'verify_success':
				$content = __('(验证通过)');
				break;

			default:
				# code...
				break;
		}

	    $args = array(
	        'id'     => 'verify_userinfo_notice',
	        'title'  => __('实名认证').$content,
	        'parent'    => 'top-secondary'
	    );
	    $wp_admin_bar->add_menu( $args );
 	}

 	//在网络管理增加导航
 	public function add_admin_bar(){
 		if( is_network_admin() ){
 			$plugin = new StacktechVerifyUserInfo;
 			wp_enqueue_style( 'stacktech-font-awesome-style', 'http://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );

 			add_menu_page( __('实名认证') ,__('实名认证') ,'manage_options' ,'verify_developer' ,array($plugin,'admin_manage_page') );
 			add_submenu_page( 'verify_developer', __( '管理员邮箱设置' ), __( '管理员邮箱设置' ), 'manage_options', 'verifying_admin_setting', array($plugin,'verifying_admin_setting') );
 			add_submenu_page( 'admin.php', __( '实名资料认证' ), __( '实名资料认证' ), 'manage_options', 'verifying_info', array($plugin,'verifying_info_page') );
 		}
 	}

 	function verifying_admin_setting(){
			if(isset($_POST['admin_verify_setting_email']) ) {
				$admin_verify_setting_email = json_encode($_POST['admin_verify_setting_email']);
				$hos_email_status = update_option('admin_verify_setting_email',$admin_verify_setting_email);
			}
		?>
		<div> 
			<?php 
				if( $hos_email_status ){
					?>
					<div class="updated">
						<p>
						邮箱已保存
						<span id="email_dashicons" style="float:right;" class="dashicons dashicons-dismiss"></span>
						</p>
					</div>	
					<?php
				}
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('#email_dashicons').mouseover(function(){
			 			jQuery("#email_dashicons").css("cursor","pointer");
			 			jQuery("#email_dashicons").css("color","red");
					});

					jQuery('#email_dashicons').mouseout(function(){
			 			jQuery("#email_dashicons").css("cursor","default");
			 			jQuery("#email_dashicons").css("color","#444444");
					});

					jQuery('#email_dashicons').click(function(){
						jQuery(this).parent().parent().hide();
					});
				});
			</script>
			<h2> 实名认证管理员邮件设置</h2>
			<form method="post">
				<p>
					</br>
					<label>请输入邮箱(一行一个):</label>
					</br>
					<textarea rows="5" name="admin_verify_setting_email"><?php echo json_decode(get_option('admin_verify_setting_email')); ?></textarea>
					</br>
				</p>
				<input type="submit" value="保存"  class="button-primary"/>  
			</form>
		</div>
		<?php
	}

 	//管理员对开发者资料审核页面
 	public function verifying_info_page(){
 		if( !isset($_GET['user_id']) || empty($_GET['user_id']) ){
 			wp_safe_redirect( network_admin_url( 'admin.php?page=verify_developer') );
 			return;
 		}
 		$user_id = $_GET['user_id'];
 		if ( wp_verify_nonce( $_POST['_wpnonce'], 'admin_verify_userinfo' ) ){
			$this->admin_verify_userinfo();
			wp_safe_redirect( network_admin_url( 'admin.php?page=verify_developer') );
			return;
		}

 		$user_verify_info = $this->vfu_wb->get_userinfo($user_id);
 		$verify_style = $user_verify_info['verify_style'];
 		$display_info = ( 'personal' == $verify_style ) ? true : false;
 		$user_options = $this->mb_unserialize($user_verify_info['option_value']);
 		$verify_phone = get_user_meta( $user_id ,'verify_phone' ,true );
 		$user_action = $user_verify_info['user_action'];
 		switch ($user_action) {
 			case 1:
 				$user_action_content = __('申请代理');
 				break;
 			case 2:
 				$user_action_content = __('申请开发者');
 				break;
 			default:
 				# code...
 				break;
 		}

 		include_once( STACKTECH_VERIFY_VIEW_PATH . 'view_admin_verify_userinfo.php' );
 		wp_enqueue_style( 'stacktech-admin-verify-userinfo-style', plugin_dir_url( __FILE__ ) . 'css/verify_userinfo.css' );
 		wp_enqueue_script( 'stacktech-admin-verify-userinfo-script', plugin_dir_url( __FILE__ ) . 'js/admin_verify_userinfo.js' );
 	}

 	public function transfer_money($user_id){
 		$random_num = rand(1,9)/100;
 		$result = update_user_meta( $user_id,'transfer_money',$random_num );
 		return $result;
 	}

 	//申请代理验证成功后,增加最大站点数量
 	function create_more_sites($user_id){
		$max_blogs_count = get_user_meta($user_id ,'max_blogs_count',true);
		$blogs_count = (int)$max_blogs_count + (int)$this->add_blogs_count;
		
		update_user_meta( $user_id,'max_blogs_count',$blogs_count );
 	}

 	//审核开发者资料,更新申请状态
 	public function admin_verify_userinfo(){
 		if( !isset($_POST['verify_userinfo_status']) && empty($_POST['verify_userinfo_status']) )
 			return;

 		if( !isset($_GET['user_id']) && empty($_GET['user_id']) )
 			return;

 		if( !isset($_POST['verify_style']) && empty($_POST['verify_style']) )
 			return;

 		$status = $_POST['verify_userinfo_status'];
 		$user_id = $_GET['user_id'];
 		$verify_style = $_POST['verify_style'];

 		$userinfo = $this->vfu_wb->get_userinfo($user_id);
 		//error_log(var_export($userinfo,true));
 		if( 'success' == $status ){
 			$template = 'verify_info_success';
 			if( 1 == $userinfo['user_action'] ){ //代理
 				if( 0 == $userinfo['user_type'] ){
 					$user_type = 1;
 				}elseif ( 2 == $userinfo['user_type'] ) {
 					$user_type = 3;
 				}
 				$data = array(
 					'status' => $this->verify_info_success_status,
 					'user_action' => '',
 					'user_type' => $user_type
 				);
 				$this->vfu_wb->update_userinfo($user_id,$data);
 				$this->create_more_sites($user_id);
 				$this->admin_send_email( $user_id,$template,$userinfo['user_action'] );
 				return;
 			}elseif( 2 == $userinfo['user_action'] ){ //开发者
 				$data = array(
	 				'status' => $this->verify_info_success_status
	 				);

	 			$result = $this->transfer_money( $user_id );
	 			if($result){
	 				$data = array(
	 					'status' => $this->fill_bank_status
	 				);
	 			}
	 			update_user_meta( $user_id,'verify_time','' );
 			}
 		}else{
 			$msg_arr = array();
	 		if( 'fail' == $status ){
	 			if( 'personal' == $verify_style ){
	 				$verify_arr = array();
	 				if( 1 == $userinfo['user_action'] ){ //代理
	 					$verify_arr = array('user_name','user_card_id','user_card_image');
	 				}elseif( 2 == $userinfo['user_action'] ){ //开发者
						$verify_arr = array('user_name','user_card_id','user_card_image','personal_bank_account');
	 				}
	 				foreach ($verify_arr as $item) {
	 					$verify_key = 'confirm_' . $item . '_notice';
	 					if( isset($_POST[$verify_key]) && !empty($_POST[$verify_key]) )
	 						$msg_arr['verify_'.$item] = $_POST[$verify_key];
	 				}
	 			}else if( 'company' == $verify_style ){
	 				$verify_arr = array();
	 				if( 1 == $userinfo['user_action'] ){ //代理
	 					$verify_arr = array('user_card_id' ,'company_name' ,'license_number' ,'organization_number' ,'tax_number' ,'owner_name' ,'license_number' ,'user_card_image','license_image','organization_image','tax_image');
	 				}elseif( 2 == $userinfo['user_action'] ){ //开发者
						$verify_arr = array('user_card_id' ,'company_name' ,'license_number' ,'organization_number' ,'tax_number' ,'owner_name' ,'license_number' ,'company_bank_account' ,'company_bank_name' , 'company_bank_position','user_card_image','license_image','organization_image','tax_image');
	 				}
	 				foreach ($verify_arr as $item) {
	 					$verify_key = 'confirm_' . $item . '_notice';
	 					if( isset($_POST[$verify_key]) && !empty($_POST[$verify_key]) )
	 						$msg_arr['verify_'.$item] = $_POST[$verify_key];
	 				}
	 			}
	 		}
	 		$data = array(
 				'status' => $this->verify_info_fail_status,
 				'reason' => serialize($msg_arr)
 				);
	 		$template = 'verify_info_fail';
 		}
 		$this->vfu_wb->update_userinfo($user_id,$data);
 		$this->admin_send_email( $user_id,$template,$userinfo['user_action'] );

 	}

 	public function admin_send_email( $user_id,$template,$user_action ){
 		$stacktech = new StacktechCommon;
 		date_default_timezone_set('PRC');
		
 		$userinfo = get_userdata($user_id);
 		$email = $userinfo->data->user_email;
 		$content = $this->render_email_template( $userinfo ,$template ,$user_action );
 		$title = $content['title'] . date(' Y-m-d H:i:s');
 		
 		$stacktech->mail( array($email),$title,$content['content'] );
 	}

 	public function render_email_template( $userinfo ,$template ,$user_action ){
 		$blogs_of_user = get_blogs_of_user($userinfo->ID);
 		$user_siteurl = '';
		foreach ($blogs_of_user as $key => $blog) {
			if( $blog->userblog_id != BLOG_ID_CURRENT_SITE ){
				$user_siteurl = $blog->siteurl . '/wp-admin/admin.php';
				if( $user_action == 1 ) {
					$user_siteurl.= "?page=verify_user_proxy";
				}else{
					$user_siteurl.= "?page=verify_user_developer";
				}
				break;
			}
		}
 		switch ($template) {
 			case 'verify_info_submit':
 				$title = __('实名验证-信息验证提交成功');
 				$file = 'view_verify_info_submit.php';
 				break;
 			case 'verify_info_success':
 				$title = __('实名验证-信息验证成功');
 				$file = 'view_verify_info_success.php';
 				break;
 			case 'verify_info_fail':
 				$title = __('实名验证-信息验证失败');
 				$file = 'view_verify_info_fail.php';
 				break;
 			case 'verify_bank_success':
 				$title = __('实名验证-银行验证成功');
 				$file = 'view_verify_bank_success.php';
 				break;
 			case 'verify_bank_fail':
 				$title = __('实名验证-银行验证失败');
 				$file = 'view_verify_bank_fail.php';
 				break;
 			case 'verify_proxy_success':
 				$title = __('实名验证-代理认证成功');
 				$file = 'view_verify_proxy_success.php';
 				break;
 			
 			default:
 				# code...
 				break;
 		}
 		ob_start();
 		include_once( STACKTECH_VERIFY_VIEW_PATH . $file );
 		$email_content = ob_get_contents();
 		ob_end_clean();

 		$content['title'] = $title;
 		$content['content'] = $email_content;

 		return $content;
 	}

 	//管理页面,列表所有开发者实名认证申请
 	public function admin_manage_page(){
 		
 		$userinfo_table = new Stacktech_Verify_Userinfo_Table();
 		$userinfo_table->prepare_items();
 		$userinfo_table->display();
 	}

 	function mb_unserialize($serial_str) {
	    $out = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
	    return unserialize($out);
	}

	function stacktech_user_verify_money_ajax(){
		$plugin = new StacktechVerifyUserInfo;

		$user_id = get_current_user_id();
		$userinfo = $plugin->vfu_wb->get_userinfo($user_id);
		$verify_time = get_user_meta( $user_id,'verify_time',true );
		$transfer_money = get_user_meta( $user_id,'transfer_money',true );
		$response = array();

		if( $_POST['verify_money'] == $transfer_money ){
			if( 0 == $userinfo['user_type'] ){
				$user_type = 2;
			}elseif ( 1 == $userinfo['user_type'] ) {
				$user_type = 3;
			}
			$data = array(
				'status' => $plugin->verify_success_status,
				'user_action' => '',
				'user_type' => $user_type,
				'reason' => ''
			);
			
			$data2 = array(
				'user_id' => $user_id,
				'action' => $plugin->money_action,
				'status' => 1,
				'time' => date('Y-m-d H:i:s')
			);
			$response['error'] = 0;
			add_user_to_blog( BLOG_ID_CURRENT_SITE,$user_id,'developer' );
			$plugin->admin_send_email( $user_id,'verify_bank_success',$userinfo['user_action'] );
			$plugin->send_email_to_admin( $user_id ,'verify_bank_success' );
		}else{
			$data = array(
 				'status' => $plugin->verify_bank_fail_status,
 				'reason' => $plugin->verify_bank_fail_status
 			);
			$data2 = array(
				'user_id' => $user_id,
				'action' => $plugin->money_action,
				'status' => 0,
				'reason' => $plugin->verify_bank_fail_status,
				'time' => date('Y-m-d H:i:s')
			);

			$verify_time = $verify_time+1;
			if( $verify_time >= $plugin->max_verify_money_time ){
				$response['error'] = 2;
			}else{
				update_user_meta( $user_id,'verify_time',$verify_time );
				$left_time = $plugin->max_verify_money_time-$verify_time;
				$response['error'] = 1;
				$response['message'] = __('<i class="fa fa-exclamation-circle"></i> 填写金额错误,您还剩下'.$left_time.'次尝试机会');
			}
			$plugin->admin_send_email( $user_id,'verify_bank_fail',$userinfo['user_action'] );
		}
		if( $response['error'] != 1 ){
			$plugin->vfu_wb->update_userinfo($user_id,$data);
			$plugin->vfu_wb->insert_history( $data2 );
		}

		echo json_encode($response);
		exit();
	}
}


add_action( 'admin_menu', array('StacktechVerifyUserInfo' ,'init') ,20 );
add_action( 'network_admin_menu', array('StacktechVerifyUserInfo' ,'add_admin_bar') );

register_activation_hook( __FILE__, array( 'StacktechVerifyUserInfo', 'plugin_activation' ) );
add_action( 'wp_ajax_stacktech-userinfo-send-sms-ajax', array('StacktechVerifyUserInfo','stacktech_send_sms_ajax') );
add_action( 'wp_ajax_stacktech-userinfo-verify-sms-ajax', array('StacktechVerifyUserInfo','stacktech_verify_sms_ajax') );
add_action( 'wp_ajax_stacktech-user-verify-money-ajax', array('StacktechVerifyUserInfo','stacktech_user_verify_money_ajax') );
// add_action('add_admin_bar_menus', array( 'StacktechVerifyUserInfo', 'add_user_bar_profile' ) );
// 