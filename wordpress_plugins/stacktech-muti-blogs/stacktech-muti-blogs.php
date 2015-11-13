<?php
/*
Plugin Name: stacktech muti blogs
Plugin URI: 
Description: Adds setting for max blogs regedit
Version: 1.0
Author: stacktech
Author URI: http://stacktech.com/
Network: true
*/
class Stacktech_Muti_Blogs {

    static function init() {
    	add_action('wpmu_options', array('Stacktech_Muti_Blogs','add_option_muti_blogs') );
    	add_action( 'update_wpmu_options', array('Stacktech_Muti_Blogs','update_wpmu_muti_blogs') );

    	add_action( 'edit_user_profile', array('Stacktech_Muti_Blogs','add_option_muti_blogs') );
    	add_action( 'edit_user_profile_update', array('Stacktech_Muti_Blogs','update_user_muti_blogs') );

    	add_filter( 'manage_users_columns', array('Stacktech_Muti_Blogs','add_users_column_muti') );
    	add_action( 'manage_users_custom_column', array('Stacktech_Muti_Blogs','add_users_muti_rows'), 10, 3 );

    	add_filter( 'manage_users-network_columns', array('Stacktech_Muti_Blogs','add_users_column_muti') );
    	//add_action( 'wpmu_validate_blog_signup',array('Stacktech_Muti_Blogs','check_muti_blogs') );
    	add_action( 'signup_hidden_fields',array('Stacktech_Muti_Blogs','check_muti_blogs') );
    }

    //在网络设置和用户编辑界面,增加可以修改'站点申请最多数量''
    static function add_option_muti_blogs(){

    	if( isset($_GET['user_id']) && $_GET['user_id'] > 0 ){
    		$max_blogs_count = get_user_meta($_GET['user_id'] ,'max_blogs_count',true);
    	}else{
    		$max_blogs_count = get_site_option( 'max_blogs_count' );
    	}
    	echo '<table class="form-table">
				<tr>
					<th scope="row">' . __( '站点申请最多数量','Stacktech_Muti_Blogs') . '
					</th>
					<td>
						<input type="text" size="10" name="max_blogs_count" id="max_blogs_count" value="' . $max_blogs_count . '" />
					</td>
				</tr>
			</table>';
    }

    static function update_wpmu_muti_blogs(){
    	if( isset($_POST['max_blogs_count']) && intval($_POST['max_blogs_count']) &&  intval($_POST['max_blogs_count']) > 0 ) {
			update_site_option( 'max_blogs_count', intval($_POST['max_blogs_count']) );
    	}
    }

    static function update_user_muti_blogs($user_id = 0){
    	if( $user_id > 0 && isset($_POST['max_blogs_count']) && intval($_POST['max_blogs_count']) &&  intval($_POST['max_blogs_count']) > 0 ) {
			update_user_meta( $user_id, 'max_blogs_count', intval($_POST['max_blogs_count']) );
    	}
    }

    //在用户列表中增加一栏'最多站点数量'
    static function add_users_column_muti($columns) {
	    $columns['user_max_blogs_count'] = __('最多站点数量','Stacktech_Muti_Blogs');
	    return $columns;
	}

	static function add_users_muti_rows($value, $column_name, $user_id) {
	    $max_blogs_count = get_user_meta($user_id ,'max_blogs_count',true);
	    if( empty($max_blogs_count) && !is_super_admin($user_id) )
	    	$max_blogs_count = get_site_option( 'max_blogs_count' );
		if ( 'user_max_blogs_count' == $column_name )
			return $max_blogs_count;
	    return $value;
	}

	//在用户申请新的站点时候,检查其已经拥有的私人站点
	static function	check_muti_blogs($result){
		global $user_ID;
		$user = get_user_meta( $user_ID);
		
		if( is_super_admin($user_ID) ){
			return $result;
		}

		$current_blogs_count = 0;
		$current_blogs = array();

		if( is_array($user) && count($user) > 0 ){
			foreach ($user as $meta_key => $meta_value) {
				preg_match('/stacktech_(\d+)_capabilities/', $meta_key, $matches);
				if(count($matches)>0){
					$current_blogs[] = $matches[1];
					$role_array = unserialize($meta_value[0]);
					if( 1 == $role_array['administrator'] )
						$current_blogs_count++;
				}
			}
		}
		
		$max_blogs_count = get_user_meta($user_ID ,'max_blogs_count',true);
	    if( empty($max_blogs_count) )
	    	$max_blogs_count = get_site_option( 'max_blogs_count' );
		
		if( $max_blogs_count <= $current_blogs_count ){
			$error_message = __('已达到创建站点上限,请与管理员联系,<a href="'.$first_blog_url.'/wp-admin/admin.php?page=ticket-manager&action=add&cat
				egory=apply_sites" style="color:#0073aa;">申请更多站点.</a>','Stacktech_Muti_Blogs');
			echo '<p class="error">' . $error_message . '</p>';
			echo '</form>
				</div>
				</div>';
			do_action( 'after_signup_form' );
			get_footer();
			exit();
		}
	}

}

add_action('init', array('Stacktech_Muti_Blogs','init'), 1 );