<?php
/**
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Commerce_Gateway_Alipay {

	public function __construct() {
		$this->id                 = 'alipay';
	}

	public function send_request() {
		require_once(STACKTECH_COMMERCE_PLUGIN_PATH . "includes/vendor/alipay/alipay.config.php");
		require_once(STACKTECH_COMMERCE_PLUGIN_PATH . "includes/vendor/alipay/lib/alipay_submit.class.php");
		$order = Stacktech_Commerce_Data::get_order( $_GET['order_id'] );

		/**************************请求参数**************************/
		$order = Stacktech_Commerce_Data::get_order( $_GET['order_id'] );
        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = stacktech_public_url('pay-notify_' . $this->id);
        //需http://格式的完整路径，不能加?id=123这类自定义参数
        //页面跳转同步通知页面路径
        $return_url = stacktech_public_url('pay-return_'. $this->id);
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        //商户订单号
        $out_trade_no = $order['order_no'] . '_' . $_GET['order_id'];
        //商户网站订单系统中唯一订单号，必填
        //订单名称
        $subject = '购买插件';
        //必填
        //付款金额
        $total_fee = 0.01;
        //必填
        //订单描述
        $body = '在万锦新科的APP商城购买插件';
        //商品展示地址
        $show_url = '';
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数
        //客户端的IP地址
        $exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1


		/************************************************************/
		//构造要请求的参数数组，无需改动
		$parameter = array(
			"service" => "create_direct_pay_by_user",
			"partner" => trim($alipay_config['partner']),
			"seller_email" => trim($alipay_config['seller_email']),
			"payment_type"	=> $payment_type,
			"notify_url"	=> $notify_url,
			"return_url"	=> $return_url,
			"out_trade_no"	=> $out_trade_no,
			"subject"	=> $subject,
			"total_fee"	=> $total_fee,
			"body"	=> $body,
			"show_url"	=> $show_url,
			"anti_phishing_key"	=> $anti_phishing_key,
			"exter_invoke_ip"	=> $exter_invoke_ip,
			"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$url = $alipaySubmit->buildRequestUrl($parameter);

		// 跳转页面
		header("Location:$url");
		exit;
	}

	public function handle_response() {
		require_once(STACKTECH_COMMERCE_PLUGIN_PATH . "includes/vendor/alipay/alipay.config.php");
		require_once(STACKTECH_COMMERCE_PLUGIN_PATH . "includes/vendor/alipay/lib/alipay_notify.class.php");

		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		if($verify_result) {//验证成功
			//商户订单号
			$out_trade_no = explode( '_',  $_POST['out_trade_no'] );
			$order_id = intval($out_trade_no[count($out_trade_no) - 1]);
			//交易状态
			$trade_status = $_POST['trade_status'];


			if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
				$order = Stacktech_Commerce_Data::get_order( $order_id );
				if ( $order['order_status'] != Stacktech_Commerce_Order::$unpay ){
					// 有错误........
				}else{
					stacktech_write_log( "\n Success \n" );
					Stacktech_Commerce_Order::mark_order_pay( $order_id );
					echo 'success';
					return true;
				}

				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
			}
			else {
				stacktech_write_log( "\n status failed \n" );
			}
		}

		stacktech_write_log( "\n verify failed \n" );
		return false;
	}

}
