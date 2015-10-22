<?php
include_once("CCPRestSDK.php");

function sendTemplateSMS($to,$datas,$tempId)
{
	// 初始化REST SDK
	$accountSid = 'aaf98f89506fc2f00150857778eb14ba'; 
	//说明：主账号，登陆云通讯网站后，可在"控制台-应用"中看到开发者主账号ACCOUNT SID。

	$accountToken = '4ca04b7316444558b5e412cde40fcbe2'; 
	//说明：主账号Token，登陆云通讯网站后，可在控制台-应用中看到开发者主账号AUTH TOKEN。

	$appId = '8a48b551506fd26f015085e3abda3e41'; 
	//说明：应用Id，如果是在沙盒环境开发，请配置"控制台-应用-测试DEMO"中的APPID。如切换到生产环境，
	//请使用自己创建应用的APPID。

	$serverIP = 'sandboxapp.cloopen.com'; 
	//说明：请求地址。
	//沙盒环境配置成sandboxapp.cloopen.com，
	//生产环境配置成app.cloopen.com。

	$serverPort = '8883'; 
	//说明：请求端口 ，无论生产环境还是沙盒环境都为8883.

	$softVersion = '2013-12-26';

	$rest = new REST($serverIP,$serverPort,$softVersion); 
	$rest->setAccount($accountSid,$accountToken); 
	$rest->setAppId($appId); 
	$return_arr = array();
	// 发送模板短信
	$content = "Sending TemplateSMS to $to <br/>";

	$result = $rest->sendTemplateSMS($to,$datas,$tempId); 
	if($result == NULL ) {
		$content .= "result error!";
		$return_arr['error_code'] = 1;
		break; 
	}
	if($result->statusCode!=0) {
		$content .= "模板短信发送失败!<br/>";
		$content .= "error code :" . $result->statusCode . "<br>";
		$content .= "error msg :" . $result->statusMsg . "<br>";
		//下面可以自己添加错误处理逻辑
		$return_arr['error_code'] = 2;
		
	}else{
		$content .= "模板短信发送成功!<br/>";
		// 获取返回信息
		$smsmessage = $result->TemplateSMS; 
		$content .= "dateCreated:".$smsmessage->dateCreated."<br/>";
		$content .= "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
		//下面可以自己添加成功处理逻辑
		$return_arr['error_code'] = 0;
	}
	$return_arr['msg'] = $content;
	
	return $return_arr;
}