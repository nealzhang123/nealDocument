<?php
include_once("CCPRestSDK.php");

function sendTemplateSMS($to,$datas,$tempId)
{
	// 初始化REST SDK
	$accountSid = STACKTECH_SMS_ACCOUNT_SID; 
	//说明：主账号，登陆云通讯网站后，可在"控制台-应用"中看到开发者主账号ACCOUNT SID。

	$accountToken = STACKTECH_SMS_ACCOUNT_TOKEN; 
	//说明：主账号Token，登陆云通讯网站后，可在控制台-应用中看到开发者主账号AUTH TOKEN。

	$appId = STACKTECH_SMS_APP_ID; 
	//说明：应用Id，如果是在沙盒环境开发，请配置"控制台-应用-测试DEMO"中的APPID。如切换到生产环境，
	//请使用自己创建应用的APPID。

	$serverIP = STACKTECH_SMS_SERVER_IP; 
	//说明：请求地址。
	//沙盒环境配置成sandboxapp.cloopen.com，
	//生产环境配置成app.cloopen.com。

	$serverPort = STACKTECH_SMS_SERVER_PORT; 
	//说明：请求端口 ，无论生产环境还是沙盒环境都为8883.

	$softVersion = STACKTECH_SMS_SOFT_VERSION;

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