<?php
/**
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 */
class Stacktech_Commerce_Order {

	// 订单类型
	static $trail_type = 'trail';
	static $sale_type = 'sale';
	static $free_type = 'free';
	// 订单状态
	static $finished = 1;
	static $unpay = 0;
	static $cancel = 2;
	static $refunding = 3;
	static $refunded = 4;



	public static function get_order_status_text ( $order_status ) {
		if ( $order_status == self::$finished ) {
			return '已完成';
		} else if ( $order_status == self::$unpay ) {
			return '待付款';
		} else if ( $order_status == self::$cancel ) {
			return '已取消';
		} else if ( $order_status == self::$refunding ) {
			return '申请退款';
		} else if ( $order_status == self::$refunded ) {
			return '已退款';
		}

		return '';
	}

	public static function get_all_status() {
		$status = array();
		$status[self::$finished] = self::get_order_status_text(self::$finished);
		$status[self::$unpay] = self::get_order_status_text(self::$unpay);
		$status[self::$cancel] = self::get_order_status_text(self::$cancel);
		//$status[self::$refunding] = self::get_order_status_text(self::$refunding);
		$status[self::$refunded] = self::get_order_status_text(self::$refunded);

		return $status;
	}

	public static function get_order_type_text ( $order_type ) {
		if ( $order_type == self::$trail_type ) {
			return '试用';
		} else if ( $order_type == self::$sale_type ) {
			return '购买';
		}else if ( $order_type == self::$free_type ) {
			return '免费使用';
		}
		return '';
	}

	public static function calculate_time( $order_type, $period, $time ) {
		// $time should be unix timestamp
		$time = date( 'Y-m-d H:i:s', $time );

		if($order_type == self::$trail_type){
			$unit = 'day';
		} else {
			$unit = 'month';
		}

		return strtotime( $time . ' ' . $period . ' ' . $unit );
	}

	public static function calculate_date( $order_type, $period, $time ) {
		$time = self::calculate_time( $order_type, $period, $time );

		return date( 'Y-m-d H:i:s', $time );
	}



	public static function activate_order ( $order_id ) {
		// 检查该订单状态是否完成
		$order = Stacktech_Commerce_Data::get_order( $order_id );

		if ( $order['order_status'] != self::$finished ) {
			return;
		}

		// 查找该订单的所有产品，并激活
		$plugins = Stacktech_Commerce_Data::get_order_products( $order_id );

		// 这个我们要检查此订单的产品有没有package
		// 如果有的话，我们把它拆分一下，总之确保拆分之后的数据是单个产品
		foreach ( $plugins as $key => $plugin ) {
			$product_sale_type = get_global_post_meta( $plugin['product_id'], '_product_sale_type', true );
			// 如果是package
			if ($product_sale_type) {
				$product_ids = array_filter( array_map( 'absint', unserialize(get_global_post_meta( $plugin['product_id'], '_package_ids', true )) ) );
				foreach ( $product_ids as $pid ) {
					$plugins[] = array(
						'product_id' => $pid,
						'period' => $plugin['period'],
					);
				}
				unset( $plugins[$key] );
			}
		}
		
		stacktech_write_log(var_export($plugins, true));

		if ( $plugins ) {
			foreach ( $plugins as $plugin ) {
				$service_info = array();
				$service_info['site_id'] = $order['site_id'];
				$service_info['blog_id'] = $order['blog_id'];
				$service_info['start_time'] = $order['pay_time'] ? $order['pay_time'] : $order['create_time'];
				$service_info['end_time'] =  self::calculate_date( $order['order_type'], $plugin['period'], mysql2date( 'U', $service_info['start_time'] ));

				$service_info['product_id'] = $plugin['product_id'];
				$service_info['status'] = Stacktech_Commerce_Service::$running;
				$service_info['last_order_id'] = $order['order_id'];

				$service_origin_info = Stacktech_Commerce_Data::check_service_info( $service_info['blog_id'], $service_info['product_id'] );

				//之前未使用过
				if( is_null($service_origin_info) ){
					$id = Stacktech_Commerce_Data::add_service( $service_info );
					stacktech_write_log("SERVICE ID:$id \n");
					Stacktech_Commerce_Service::activate_service( $id );

				} else {

					$last_order_id = $service_origin_info['last_order_id'];
					$last_order_info = Stacktech_Commerce_Data::get_order( $last_order_id );
					if ( $last_order_info['order_type'] == self::$trail_type ) {
						//将之前的试用订单状态改为停止
						Stacktech_Commerce_Data::update_order(
							array('order_status' => self::$cancel), 
							array('order_id' => $service_origin_info['last_order_id'])
						);

						Stacktech_Commerce_Data::update_service(
							array(
								'last_order_id' => $service_info['last_order_id'],
								'start_time' => $service_info['start_time'],
								'end_time' => $service_info['end_time']
							), 
							array(
								'blog_id' => $service_info['blog_id'],
								'product_id' => $service_info['product_id']
							)
						);

					} else {

						$allow_purchase_forever = get_global_post_meta( $service_info['product_id'], '_allow_purchase_forever', true );
						if ( $allow_purchase_forever == 1 ) {
							Stacktech_Commerce_Data::update_service(
								array(
									'last_order_id' => $service_info['last_order_id'],
									'end_time' => $service_origin_info['start_time'],
									'status' => Stacktech_Commerce_Service::$running
								), 
								array(
									'blog_id' => $service_info['blog_id'],
									'product_id' => $service_info['product_id']
								)
							);

							Stacktech_Commerce_Service::activate_service( $service_origin_info['service_id'] );

							// Go to next product
							continue;
						}

						
						if ( $service_origin_info['status'] == Stacktech_Commerce_Service::$expired ) {

							Stacktech_Commerce_Data::update_service(
								array(
									'last_order_id' => $service_info['last_order_id'],
									'end_time' => $service_info['end_time'],
									'status' => Stacktech_Commerce_Service::$running
								), 
								array(
									'blog_id' => $service_info['blog_id'],
									'product_id' => $service_info['product_id']
								)
							);

							Stacktech_Commerce_Service::activate_service( $service_origin_info['service_id'] );

						} else {
							//$service_info['end_time'] =	gmdate( 'Y-m-d H:i:s', mysql2date( 'U', $service_origin_info['end_time'] ) + ($plugin['period'] *$unit ) );
							$service_info['end_time'] = self::calculate_date( $order['order_type'], $plugin['period'], mysql2date( 'U', $service_origin_info['end_time']) );

							Stacktech_Commerce_Data::update_service(
								array(
									'last_order_id' => $service_info['last_order_id'],
									'end_time' => $service_info['end_time']
								), 
								array(
									'blog_id' => $service_info['blog_id'],
									'product_id' => $service_info['product_id']
								)
							);
						}
					}
				}
			}
		}

	}

	// 添加订单
	public static function add_order() {
		// Todo::判断products是否为空
		$order_info = array();
		$order_info['order_type'] = $_REQUEST['order_type'];
		$order_info['site_id'] = SITE_ID_CURRENT_SITE;
		$order_info['blog_id'] = get_current_blog_id();
		$order_info['user_id'] = get_current_user_id();
		$order_info['order_no'] = Stacktech_Commerce_Data::generate_order_no();
		$order_info['order_status'] = $_REQUEST['order_status'];
		$order_info['total_price'] = 0;
		$order_info['create_time'] = current_time( 'mysql' );

		if ( $order_info['order_type'] == 'trail' || $order_info['order_type'] == 'free' ) {
			$order_info['total_price'] = 0;
			// 标记订单完成
			$order_info['order_status'] = Stacktech_Commerce_Order::$finished;
		}

		// Calculate the total price
		if ($order_info['order_type'] == self::$sale_type){
			foreach ( $_REQUEST['products'] as $product ) {
				$order_info['total_price'] += self::calculate_order_product_price( $product['product_id'], $product['period'], $product['price_condition_key'] );
			}
		}

		$order_id = Stacktech_Commerce_Data::add_order( $order_info );

		// 现在开始插入订单产品
		foreach ( $_REQUEST['products'] as $product ) {
			$order_product_info = array();
			$order_product_info['order_id'] = $order_id;
			$order_product_info['product_id'] = $product['product_id'];
			$order_product_info['author_id'] = stacktech_call_global_func( 'get_post_field', 'post_author', $product['product_id'], 'db' );
			$order_product_info['total'] = $product['total'];
			$order_product_info['price_condition_key'] = $product['price_condition_key'];
			// 如果是试用产品，那么试用试用时间，如果不是，则试用用户默认购买时间
			if ( $order_info['order_type'] == self::$trail_type ) {
				$trail_days = get_global_post_meta( $product['product_id'], '_trail_days', true );
				$order_product_info['period'] = $trail_days;
				$order_product_info['price'] = 0;
			} else if ($order_info['order_type'] == self::$free_type ){
				$order_product_info['period'] = 0;
				$order_product_info['price'] = 0;
			} else if ($order_info['order_type'] == self::$sale_type){
				$order_product_info['period'] = $product['period'];
				$order_product_info['price'] = $product['price'];
			}
			Stacktech_Commerce_Data::add_order_product( $order_product_info );
		}

		// 如果不是试用订单，那么清空购物车
		if ( $order_info['order_type'] != 'trail' ) {
			delete_option('stacktech_cart');
		}

		if ($order_info['order_status'] == Stacktech_Commerce_Order::$finished ){
			// 激活一个订单的插件，并开启服务
			Stacktech_Commerce_Order::activate_order( $order_id );
		}
		$order_info['id'] = $order_id;
		echo json_encode($order_info);

		exit;
	}

	public static function mark_order_pay ($order_id ) {
		$order_info = Stacktech_Commerce_Data::get_order( $order_id );
		// We need to go to main site, then back
		$current_blog_id = get_current_blog_id();
		switch_to_blog( BLOG_ID_CURRENT_SITE );

		$order_products = Stacktech_Commerce_Data::get_order_products( $order_id );
		foreach( $order_products as $order_product ){
			$user_id = get_post_field( 'post_author', $order_product['product_id'], 'db');
			// Give developer money
			Stacktech_Commerce_Account_Log::change_user_money( $user_id, $order_product['total'], Stacktech_Commerce_Account_Log::ACT_SALE, '出售订单号['.$order_info['order_no'].'-'.$order_product['product_id'].']'  );
		}
		restore_current_blog( $current_blog_id );

		Stacktech_Commerce_Data::update_order(array(
			'pay_time' => current_time('mysql'),
			'order_status' => self::$finished,
		), array('order_id' => $order_id));


		stacktech_write_log( "\n Update Status Success \n" );

		// 激活
		Stacktech_Commerce_Order::activate_order( $order_id );
	}

	// ajax
	public static function cancel_order() {
		// 获取订单商品并将它放进购物车
		$order_id = $_POST['order_id'];
		$order = Stacktech_Commerce_Data::get_order( $order_id );
		if ( $order['blog_id'] != get_current_blog_id() || $order['order_status'] != self::$unpay ) { exit;}
		Stacktech_Commerce_Data::update_order(
			array('order_status' => self::$cancel), 
			array('order_id' => $order_id)
		);
		exit;
	}


	// Cacalulate the order product price
	public static function calculate_order_product_price( $product_id, $period = 0, $price_condition_key = '' ) {
		$change_price = 0;
		$price_condition = get_global_post_meta( $product_id, '_price_condition', true );
		if($price_condition){$price_condition = json_decode($price_condition, true);};
		if ( $price_condition_key != '' && $price_condition && is_array($price_condition) && isset($price_condition[$price_condition_key])  ) {
			$change_price = (float)$price_condition[$price_condition_key];
		}

		// First we need to check if the params are valid
		// If the product is sold per month, the $period can not be 0
		$allow_purchase_forever = get_global_post_meta( $product_id, '_allow_purchase_forever', true );
		if ( $allow_purchase_forever == Stacktech_Commerce_Product::$sold_month && $period == 0){
			die('You are hacker!!!');
		}

		if ( $allow_purchase_forever == Stacktech_Commerce_Product::$sold_free ){
			return 0;
		}

		// We need to check if this product is using discount of limit period
		if ( Stacktech_Commerce_Product::use_discount_price( $product_id ) ) {
			$price = get_global_post_meta( $product_id, '_sale_discount_price', true );
		} else {
			$price = get_global_post_meta( $product_id, '_sale_price', true );
		}

		if ( $allow_purchase_forever == Stacktech_Commerce_Product::$sold_forever ){
			return $price + $change_price;
		}

		// We need to check if this product is using "Purchase more, Discount More"
		$month_discount = get_global_post_meta( $product_id, '_month_discount', true );
		if($month_discount){$month_discount = json_decode($month_discount, true);};
		if(is_array( $month_discount ) && $month_discount ){
			krsort($month_discount);
			foreach ( $month_discount as $key => $val ) {
				if ( $period < $key ) { continue; }
				$price = $val;
				break;
			}
		}

		return ($price + $change_price) * $period;
	}



	// ajax
	public static function renew_order() {
		// 获取订单商品并将它放进购物车
		$order_id = $_POST['order_id'];
		$order_info = Stacktech_Commerce_Data::get_order( $order_id );
		$order_products = Stacktech_Commerce_Data::get_order_products( $order_id );

		$products = array();
		foreach ( $order_products as $op ) {
			// we just need the product_id of $op
			// everything will use the latest information of the product.
			$temp_product = stacktech_call_global_func( 'get_post', $op['product_id'] );
			$allow_purchase_forever = get_global_post_meta( $op['product_id'], '_allow_purchase_forever', true );
			$month_discount = get_global_post_meta( $op['product_id'], '_month_discount', true );
			if($month_discount){$month_discount = json_decode($month_discount, true);};
			$product_type = get_global_post_meta( $op['product_id'], '_product_type', true );
			$sale_discount_price = get_global_post_meta( $op['product_id'], '_sale_discount_price', true );
			$price = get_global_post_meta( $op['product_id'], '_sale_price', true );
			// If the order is trail order, so the default period will be one month.
			$period = 1;
			if ( $order_info['order_type'] == self::$sale_type ) {
				$period = $op['period'];
			}
			// 判断这个商品是否使用特价
			$use_discount_price = Stacktech_Commerce_Product::use_discount_price( $op['product_id'] );
			$products[$op['product_id']] = array(
				'order_id' => 0,
				'product_id' => $op['product_id'],
				'post_title' => $temp_product->post_title,
				'price' => $price,
				'period' => $period,
				'total' => self::calculate_order_product_price( $op['product_id'], $period, $op['price_condition_key'] ),
				'allow_purchase_forever' => $allow_purchase_forever,
				'month_discount' => $month_discount,
				'product_type' => $product_type,
				'sale_discount_price' => $sale_discount_price,
				'use_discount_price' => $use_discount_price,
			);
		}

		$old_cart = get_option('stacktech_cart');
		if( $old_cart ) { $old_cart = unserialize( $old_cart ); }
		foreach ( $old_cart['products'] as $key => $val ) {
			if( isset($products[$val['product_id']]) ) {
				continue;
			}
			$products[] = $val;
		}

		// 循环这个购物车，计算出总价格
		$data = array();
		$data['total'] = 0;
		$data['products'] = array();
		foreach($products as $product){
			$data['total'] += $product['total'];
			$data['products'][] = $product;
			// 检查该商品是否有依赖包，如果有就判断该依赖包是否已经购买或者已经购物车里，如果没有就添加
			//$products = Stacktech_Commerce_Data::get_dependences( $product['product_id'] );
			//if ( !$products ) { continue; }
		}
		delete_option('stacktech_cart');
		add_option('stacktech_cart', serialize($data));
		exit;
	}


	public static function deactivate_order( $order_id ) {
		// 检查该订单所有的服务，如果是永久的服务，则直接关闭，否则减去相应的时间，然后更改service的last_order_id
		$order_info = Stacktech_Commerce_Data::get_order( $order_id );
		$products = Stacktech_Commerce_Data::get_order_products( $order_id );

		// 这个我们要检查此订单的产品有没有package
		// 如果有的话，我们把它拆分一下，总之确保拆分之后的数据是单个产品
		foreach ( $products as $key => $plugin ) {
			$product_sale_type = get_global_post_meta( $plugin['product_id'], '_product_sale_type', true );
			// 如果是package
			if ($product_sale_type) {
				$product_ids = array_filter( array_map( 'absint', unserialize(get_global_post_meta( $plugin['product_id'], '_package_ids', true )) ) );
				foreach ( $product_ids as $pid ) {
					$products[] = array(
						'product_id' => $pid,
						'period' => $plugin['period'],
					);
				}
				unset( $products[$key] );
			}
		}


		foreach ( $products as $product ) {
			$s = Stacktech_Commerce_Data::get_service_by_product( $product['product_id'], $order_info['blog_id'] );
			$end_service = false;
			if ( Stacktech_Commerce_Service::is_permanent_service( $s ) ) {
				// 如果是永久的服务
				$end_service = true;
			} else {
				// 减去相应时间
				$end_time = self::calculate_time( $order_info['order_type'], (-1)*((int)$product['period']), mysql2date( 'U', $s['end_time'] ));

				if ( $end_time <= current_time( 'timestamp' ) ) {
					$end_service = true;
				} else {
					$last_order = Stacktech_Commerce_Data::get_last_order_by_service( $s );
					if ( $last_order === null ) {
						$end_service = true;
					}
				}
			}

			if ( $end_service ) {
				Stacktech_Commerce_Service::unactivate_service( $s['service_id'] );
				Stacktech_Commerce_Service::close_service( $s['service_id'] );
			} else {
				Stacktech_Commerce_Data::update_service(array('end_time' =>gmdate( 'Y-m-d H:i:s', $end_time ), 'last_order_id' => $last_order['order_id'] ), array('service_id' => $service_id));
			}
		}
	}

	// ajax
	public static function load_order_detail() {
		$order_info = Stacktech_Commerce_Data::get_order( $_GET['order_id'] );
		$order_info['products'] = Stacktech_Commerce_Data::get_order_products($order_info['order_id']);
		$user_info = get_userdata($order_info['user_id']);
		$order_info['username'] = $user_info->user_login;
		$order_info['order_status'] = Stacktech_Commerce_Order::get_order_status_text($order_info['order_status']);
		$order_info['order_type'] = Stacktech_Commerce_Order::get_order_type_text($order_info['order_type']);
		$order_info['pay_time'] = $order_info['pay_time'] ?  $order_info['pay_time'] : '无';
		foreach ($order_info['products'] as &$order_product) {
			$order_product['allow_purchase_forever'] = get_global_post_meta( $order_product['product_id'], '_allow_purchase_forever', true );
			$order_product['product_type'] = get_global_post_meta( $order_product['product_id'], '_product_type', true );
		}
		echo json_encode($order_info);
		exit;
	}


	//　对每个订单里面的商品的使用期限生成相应的text
	public static function get_period_text( $order_product_id ) {
		//
		$order_product = Stacktech_Commerce_Data::get_order_product( $order_product_id );
		$order = Stacktech_Commerce_Data::get_order( $order_product['order_id'] );
		// 如果是来自试用订单，那么单位是天，时间就是period字段值
		// 如果是购买订单，那么分两种，如果是按月出售，时间就是period值，单位是月，如果是永久出售，那么就是永久使用
		// 如果是免费订单，那么就是永久使用

		if( $order['order_type'] == self::$trail_type ) {
			return $order_product['period'] . '天';
		} else if ( $order['order_type'] == self::$sale_type ){
			$allow_purchase_forever = get_global_post_meta( $order_product['product_id'], '_allow_purchase_forever', true );
			if ( $allow_purchase_forever == 0 ) {
				return $order_product['period'] . '月';
			}
			return '永久';
		} else if ( $order['order_type'] == self::$free_type ){
			return '永久';
		}
	}
}

