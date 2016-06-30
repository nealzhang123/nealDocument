<?php

require_once('sdk.class.php');

if ( !defined('WP_PLUGIN_URL') )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins' );                           //  plugin url

define('OSS_BASENAME', plugin_basename(__FILE__));
define('OSS_BASEFOLDER', plugin_basename(dirname(__FILE__)));
define('OSS_FILENAME', str_replace(DFM_BASEFOLDER.'/', '', plugin_basename(__FILE__)));

// 初始化选项
// register_activation_hook(__FILE__, 'oss_set_options');

/**
 * 初始化选项
 */
// function oss_set_options() {
//     $options = array(
//         'bucket' => "",
//         'ak' => "",
//     	'sk' => "",
// 		'host' => "oss.aliyuncs.com",
// 		'nothumb' => "false",
// 		'nolocalsaving' => "false",
// 		'upload_url_path' => "",
		
//     );
    
//     add_option('oss_options', $options, '', 'yes');
// }

/**
 * 服务器运行环境测试
 */
function stacktech_test_server_env() {
	try {
		//实例化存储对象
		$test_ak = 'hello';
		$test_sk = 'world';
		$test_bucket = 'imgs-storage';
		$aliyun_oss = new ALIOSS($test_ak, $test_sk);
		$oss_option = array(ALIOSS::OSS_CONTENT_TYPE => 'text/xml');
		$response = $aliyun_oss->get_bucket_acl($test_bucket, $oss_option);
	} catch(Exception $ex) {
		echo "
			<div id='oss-warning' class='updated fade'><p><strong>注意：</strong>测试结果显示，Aliyun OSS Support插件似乎不能在本服务器上正常运行...</p></div>
			";
	}
}

function stacktech_oss_admin_warnings() {
    $oss_options = get_site_option('oss_options', TRUE);

    $oss_bucket = attribute_escape($oss_options['bucket']);
	if ( !$oss_options['bucket'] && !isset($_POST['submit']) ) {
		function stacktech_oss_warning() {
			echo "
			<div id='oss-warning' class='updated fade'><p><strong>".__('OSS is almost ready.')."</strong> ".sprintf(__('You must <a href="%1$s">enter your OSS Bucket </a> for it to work.'), "options-general.php?page=" . OSS_BASEFOLDER . "/url-edit.php")."</p></div>
			";
			//执行服务器运行环境测试
			stacktech_test_server_env();
		}
		add_action('admin_notices', 'stacktech_oss_warning');
		return;
	} 
}
// stacktech_oss_admin_warnings();

/**
 *上传函数
 *@param $object
 *@param $file
 *@param $opt
 *@return bool
 */
function stacktech_file_upload( $object , $file , $opt = array()){
	//设置超时时间
	//set_time_limit(120);
	
	//如果文件不存在，直接返回FALSE
	if( !@file_exists($file) )
		return FALSE;
		
	//获取WP配置信息
	$oss_options = get_site_option('oss_options', TRUE);
 	// $oss_bucket = attribute_escape($oss_options['bucket']);
	// $oss_ak = attribute_escape($oss_options['ak']);
	// $oss_sk = attribute_escape($oss_options['sk']);
	$oss_bucket = OSS_BUCKET_NAME;
	$oss_ak = OSS_ACCESS_ID;
	$oss_sk = OSS_ACCESS_KEY;
	$oss_host = OSS_ENDPOINT;
	if($oss_host==null || $oss_host == '')
		$oss_host = 'oss.aliyuncs.com';

	if(@file_exists($file)) {
		try {
			//实例化存储对象
			if(!is_object($aliyun_oss))
				$aliyun_oss = new ALIOSS($oss_ak, $oss_sk ,$oss_host);
				//上传原始文件，$opt暂时没有使用
				$resp = $aliyun_oss->upload_file_by_file( $oss_bucket, $object, $file, $opt );

			return TRUE;
			
		} catch(Exception $ex) {
			return FALSE;
		}
		
	} else {
		return FALSE;
	}
}


/**
 * 是否需要删除本地文件
 * @return bool
*/
function stacktech_is_delete_local_file() {
	$oss_options = get_site_option('oss_options', TRUE);
	return (attribute_escape($oss_options['nolocalsaving'])=='true');
}

/**
 * 删除本地文件
 *
 * @param $file 本地文件路径
 * @return bool
 */
function stacktech_delete_local_file($file){
	try{
	  //文件不存在
		if(!@file_exists($file))
			return TRUE;
		//删除文件
		if(!@unlink($file))
			return FALSE;
		return TRUE;
	}
	catch(Exception $ex){
		return FALSE;
	}
}


/**
 * 在OSS中记录日志信息
 * @param $logpath 日志存放路径
 * @param $content 写入的内容
 * @return bool
 */
function stacktech_logged($logpath,$content) {
	//获取WP配置信息
	$oss_options = get_site_option('oss_options', TRUE);
 //    $oss_bucket = attribute_escape($oss_options['bucket']);
	// $oss_ak = attribute_escape($oss_options['ak']);
	// $oss_sk = attribute_escape($oss_options['sk']);
	// $oss_host = attribute_escape($oss_options['host']);
	$oss_bucket = OSS_BUCKET_NAME;
	$oss_ak = OSS_ACCESS_ID;
	$oss_sk = OSS_ACCESS_KEY;
	$oss_host = OSS_ENDPOINT;
	if($oss_host==null || $oss_host == '')
		$oss_host = 'oss.aliyuncs.com';

	try {
		//实例化存储对象
		if(!is_object($aliyun_oss))
			$aliyun_oss = new ALIOSS($oss_ak, $oss_sk ,$oss_host);
		//上传原始文件，$opt暂时没有使用
		$upload_file_options = array(
			'content' => $content,
			'length' => strlen($content),
			ALIOSS::OSS_HEADERS => array(
				'Expires' => '2012-10-01 08:00:00',
			),
		);
		$aliyun_oss->upload_file_by_content( $oss_bucket, $logpath, $upload_file_options );

		return TRUE;
		
	} catch(Exception $ex) {
		return FALSE;
	}
}

/**
 * 上传附件（包括图片的原图）
 * @param $metadata
 * @return array()
 */
function stacktech_upload_attachments($metadata) {
	$wp_uploads = wp_upload_dir();
	//生成object在OSS中的存储路径
	if(OSS_CDN_UPLOAD_PATH == '.') {
		//如果含有“./”则去除之
		$metadata['file'] = str_replace("./" ,'' ,$metadata['file']);	
	}
	$object = str_replace(get_home_path(), '', $metadata['file']);
	
	//在本地的存储路径
	//$file = $metadata['file'];
	$file = get_home_path().$object;	//向上兼容，较早的WordPress版本上$metadata['file']存放的是相对路径
	
	//设置可选参数
	$opt =array('Content-Type' => $metadata['type']);
	
	//执行上传操作
	stacktech_file_upload ( $object, $file, $opt);
	//stacktech_logged('2upload.txt',"object=$object;file=$file");
	
	//如果不在本地保存，则删除本地文件
	if( stacktech_is_delete_local_file() ){
		stacktech_delete_local_file($file);
	}
	
	return $metadata;
}
//避免上传插件/主题时出现同步到OSS的情况
//if(substr_count($_SERVER['REQUEST_URL'],'/update.php') <= 0)
 	add_filter('wp_handle_upload', 'stacktech_upload_attachments', 50);


/**
 * 上传图片的缩略图
 * @param $metadata
 * @return array
 */
function stacktech_upload_thumbs($metadata) {

	//上传所有缩略图
	if (isset($metadata['sizes']) && count($metadata['sizes']) > 0)
	{
		//获取OSS插件的配置信息
		$oss_options = get_site_option('oss_options', TRUE);
		//是否需要上传缩略图
		$nothumb = (attribute_escape($oss_options['nothumb']) == 'true');
		//是否需要删除本地文件
		$is_delete_local_file = (attribute_escape($oss_options['nolocalsaving'])=='true');
		
		//如果禁止上传缩略图，就不用继续执行了
		if( $nothumb ) {
			return $metadata;
		}
		
		//获取上传路径
		$wp_uploads = wp_upload_dir();
		//得到本地文件夹和远端文件夹
		$file_path = $wp_uploads['path'].'/';
		if(OSS_CDN_UPLOAD_PATH == '.') {
			$file_path = str_replace("./" ,'' , $file_path);
		}
		$object_path = str_replace(get_home_path(), '', $file_path);
		//afOGr fix upload image time issue
		$object_path = dirname(dirname($object_path )).'/'.dirname($metadata['file']).'/';
		$file_path = dirname(dirname($file_path )).'/'.dirname($metadata['file']).'/';	
	
		$type = pathinfo($metadata['file'])['extension'];
		$full_size = array(
			'file' => basename($metadata['file']),
			'width' => $metadata['width'],
			'height' => $metadata['height'],
			'mime-type' => 'image/'.$type,
		);

		$metadata['sizes']['full_size'] = $full_size;
		
		
		//there may be duplicated filenames,so ....
		foreach ($metadata['sizes'] as $val)
		{
			//生成object在OSS中的存储路径
			$object = $object_path.$val['file'];
			//生成本地存储路径
			$file = $file_path . $val['file'];
			//设置可选参数
			$opt =array('Content-Type' => $val['mime-type']);
			
			//执行上传操作
			stacktech_file_upload ( $object, $file, $opt );
			//stacktech_logged('2thumb.txt',"object=$object;file=$file");
			
			//如果不在本地保存，则删除
			if($is_delete_local_file)
				stacktech_delete_local_file($file);
		}
	}
	
	return $metadata;
}
//避免上传插件/主题时出现同步到OSS的情况
if(substr_count($_SERVER['REQUEST_URL'],'/update.php') <= 0)
	add_filter('wp_update_attachment_metadata', 'stacktech_upload_thumbs', 100);
	//add_filter('wp_generate_attachment_metadata', 'stacktech_upload_thumbs', 100);
/**
 * 删除远程服务器上的单个文件
 * @static
 * @param $file
 * @return void
 */
function stacktech_delete_remote_file($file)
{	
	
	//获取WP配置信息
	$oss_options = get_site_option('oss_options', TRUE);
 	// $oss_bucket = attribute_escape($oss_options['bucket']);
	// $oss_ak = attribute_escape($oss_options['ak']);
	// $oss_sk = attribute_escape($oss_options['sk']);
	// $oss_host = attribute_escape($oss_options['host']);
	$oss_bucket = OSS_BUCKET_NAME;
	$oss_ak = OSS_ACCESS_ID;
	$oss_sk = OSS_ACCESS_KEY;
	$oss_host = OSS_ENDPOINT;
	if($oss_host==null || $oss_host == '')
		$oss_host = 'oss.aliyuncs.com';
	
	if( !strchr($file,'/app') ){
		$upload_dir = wp_upload_dir();
		$del_file_path = $upload_dir['basedir']."/".$file;
		$del_file_path = str_replace(get_home_path(), '', $del_file_path);
	}else{
		//得到远端路径
		$del_file_path = str_replace(get_home_path(), '', $file);
	}	

	//stacktech_logged('2delete.txt',"del_file_path=$del_file_path");
	try{
		//实例化存储对象
		if(!is_object($aliyun_oss))
			$aliyun_oss = new ALIOSS($oss_ak, $oss_sk, $oss_host);
		//删除文件
		$aliyun_oss->delete_object( $oss_bucket, $del_file_path);
	} catch(Exception $ex){}

	return $file;
}
add_action('wp_delete_file', 'stacktech_delete_remote_file', 100);

/**
 * 当upload_path为根目录时，需要移除URL中出现的“绝对路径”
 */
function stacktech_modefiy_img_url($url, $post_id) {
	$destination_path =  OSS_CDN_UPLOAD_URL_PATH;
	$home_path =  get_site_url();
    $url = str_replace($home_path ,$destination_path ,$url);
	//stacktech_logged('2modify_url.txt',"url=$url");
	return $url;
}
// if(OSS_CDN_UPLOAD_PATH == '.')
if(is_admin()){
	add_filter('wp_get_attachment_url', 'stacktech_modefiy_img_url', 30, 2);
}

function stacktech_oss_plugin_action_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/url-edit.php' ) ) {
		$links[] = '<a href="options-general.php?page=' . OSS_BASEFOLDER . '/url-edit.php">'.__('Settings').'</a>';
	}

	return $links;
}

add_filter( 'plugin_action_links', 'stacktech_oss_plugin_action_links', 10, 2 );

function stacktech_oss_add_setting_page() {
    add_options_page('OSS Setting', 'OSS Setting', 8, __FILE__, 'stackech_oss_setting_page');
}

//add_action('admin_menu', 'stacktech_oss_add_setting_page');

function stackech_oss_setting_page() {

	$options = array();
	// if($_POST['bucket']) {
	// 	$options['bucket'] = trim(stripslashes($_POST['bucket']));
	// }
	// if($_POST['ak']) {
	// 	$options['ak'] = trim(stripslashes($_POST['ak']));
	// }
	// if($_POST['sk']) {
	// 	$options['sk'] = trim(stripslashes($_POST['sk']));
	// }
	// if($_POST['host']) {
	// 	$options['host'] = trim(stripslashes($_POST['host']));
	// }
	// if($_POST['nothumb']) {
	// 	print_r($_POST);
	// 	$options['nothumb'] = (isset($_POST['nothumb']))?'true':'false';
	// }
	// if($_POST['nolocalsaving']) {
	// 	$options['nolocalsaving'] = (isset($_POST['nolocalsaving']))?'true':'false';
	// }
	// if($_POST['upload_url_path']) {
	// 	//仅用于插件卸载时比较使用
	// 	$options['upload_url_path'] = trim(stripslashes($_POST['upload_url_path']));
	// }
	
	//检查提交的AK/SK是否有管理该bucket的权限
	// $flag = 0;
	// if($_POST['bucket']&&$_POST['ak']&&$_POST['sk']){
	// 	try{
	// 		if(!is_object($aliyun_oss))
	// 			$aliyun_oss = new ALIOSS( $options['ak'], $options['sk'], $options['host']);
	// 		$oss_option = array(ALIOSS::OSS_CONTENT_TYPE => 'text/xml');
	// 		$response = $aliyun_oss->get_bucket_acl($options['bucket'],$oss_option);
	// 		if($response->status == 200) {
	// 			$flag = 1;
	// 			if( preg_match('/<Grant>public-read-write<\/Grant>/i',$response->body) > 0 ) {
	// 				$flag = -11;
	// 			} elseif( preg_match('/<Grant>private<\/Grant>/i',$response->body) > 0 ) {
	// 				$flag = -12;
	// 			}
	// 		} elseif ($response->status == 403 && preg_match('/<Endpoint>/i',$response->body) > 0) {
	// 			$flag = -2;
	// 		}
			
	// 	} catch(Exception $ex){
	// 		$flag = -1;
	// 	}
	// }

	if($options !== array() ){
		//更新数据库
		update_option('oss_options', $options);
		
		// $upload_path = trim(trim(stripslashes($_POST['upload_path'])),'/');
		// $upload_path = ($upload_path == '') ? ('wp-content/uploads') : ($upload_path);
		$upload_path = OSS_CDN_UPLOAD_PATH;
		update_option('upload_path', $upload_path );
		
		// $upload_url_path = trim(trim(stripslashes($_POST['upload_url_path'])),'/');
		$upload_url_path = OSS_CDN_UPLOAD_URL_PATH;
		update_option('upload_url_path', $upload_url_path );
        
?>
<div class="updated"><p><strong>设置已保存！
</strong></p></div>
<?php
    }

    $oss_options = get_site_option('oss_options', TRUE);
	$upload_path = OSS_CDN_UPLOAD_PATH;
	$upload_url_path = OSS_CDN_UPLOAD_URL_PATH;
	
	$oss_nothumb = attribute_escape($oss_options['nothumb']);
	$oss_nothumb = ( $oss_nothumb == 'true' );
	
	$oss_nolocalsaving = attribute_escape($oss_options['nolocalsaving']);
	$oss_nolocalsaving = ( $oss_nolocalsaving == 'true' );
?>
<div class="wrap" style="margin: 10px;">
    <h2>阿里云附件 v2.0 设置</h2>
    <form name="form1" method="post" action="<?php echo wp_nonce_url('./options-general.php?page=' . OSS_BASEFOLDER . '/url-edit.php'); ?>">
		<table class="form-table">
			<tr>
				<th><legend>不上传缩略图</legend></th>
				<td><input type="checkbox" name="nothumb" <?php if($oss_nothumb) echo 'checked="TRUE"';?> /></td>
			</tr>
			<tr>
				<th><legend>不在本地保留备份</legend></th>
				<td><input type="checkbox" name="nolocalsaving" <?php if($oss_nolocalsaving) echo 'checked="TRUE"';?> /></td>
			</tr>
			<tr>
				<th><legend>更新选项</legend></th>
				<td><input type="submit" name="submit" value="更新" /></td>
			</tr>
		</table>
    </form>
</div>
<?php
}
?>
