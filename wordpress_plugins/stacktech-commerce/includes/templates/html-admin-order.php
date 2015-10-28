
<div class="wrap">
<h2>订单记录</h2>
<ul class="subsubsub">
<li class="all"><a href="#"	class="current">全部<span class="count"></span></a></li>
</ul>
<div class="sy-page-actions">
<a href="javascript:void(0)" class="button" status="open" onclick="stacktech_store.toggle_all_order_details(this);">展开/隐藏订单详情</a>
</div>
<table class="widefat fixed">
<thead>
	<tr>
		<th width="10%">
			订单编号
		</th>
		<th width="10%">
			用户名
		</th>
		<th width="10%">
			订单状态
		</th>
		<th width="10%">
			订单类型
		</th>
		<th width="10%">
			下订单时间
		</th>
		<th width="15%">
			支付时间
		</th>
		<th width="10%">
			总价格
		</th>
		<th>
			订单操作
		</th>
	</tr>
</thead>
<tbody>
<?php foreach ( $orders as $order ): ?>
<?php $user_info = get_userdata($order['user_id']); ?>
	<tr>
		<td><?php echo $order['order_no']; ?></td>
		<td><?php echo $user_info->user_login; ?></td>
		<td><?php echo Stacktech_Commerce_Order::get_order_status_text($order['order_status']); ?></td>
		<td><?php echo Stacktech_Commerce_Order::get_order_type_text($order['order_type']); ?></td>
		<td><?php echo $order['create_time']; ?></td>
		<td><?php echo $order['pay_time'] ?  $order['pay_time'] : '无';?></td>
		<td><?php echo $order['total_price']; ?></td>
		<td>
<?php 
if($order['order_status'] == Stacktech_Commerce_Order::$unpay){
?>
	<a href="<?php echo get_admin_url(null, 'admin.php?page=stacktech-store-pay&gateway=alipay&order_id='.$order['order_id']); ?>">马上付款</a>
	<a href="javascript:void(0);" onclick="return stacktech_store.cancel_order(this, <?php echo $order['order_id']; ?>);">取消</a>
<?php
} else {

	if($order['order_status'] == Stacktech_Commerce_Order::$finished && $order['order_type'] == Stacktech_Commerce_Order::$sale_type ){
?>
		<a href="<?php echo admin_url('admin.php?page=ticket-manager&action=add&category=refund&order_id='.$order['order_id']); ?>">申请退款</a>
<?php
	}

}
?>
			<a href="javascript:void(0);" onclick="return stacktech_store.show_order_detail(<?php echo $order['order_id']; ?>);">查看</a>

<?php

	if($order['order_type'] != Stacktech_Commerce_Order::$free_type ){
?>

			<a href="javascript:void(0);" onclick="return stacktech_store.renew_order(this, <?php echo $order['order_id']; ?>);">重新下单</a>
<?php
	}
?>

		</td>
	</tr>
	<tr class="order_detail_row" id="order_detail_row_<?php echo $order['order_id']; ?>">
		<td colspan=8>
			<table class="widefat fixed">
			<thead>
				<tr>
					<th width="30%">名称</th>
					<th width="35%">使用时间</th>
					<th>价格</th>
				</tr>
			</thead>
			<tbody>
<?php 
	if($order['products']){ 
		foreach($order['products'] as $order_product){
?>
		<tr>
		<td><a onclick="stacktech_store.load_product_by_popup(<?php echo $order_product['product_id'];?>)" href="javascript:void(0)"><?php echo $order_product['post_title']; ?></a></td>
			<td>
<?php
			echo Stacktech_Commerce_Order::get_period_text( $order_product['order_product_id'] );

?>
			</td>
			<td>
<?php echo $order_product['total']; ?>
			</td>
		</tr>
			
<?php
		}
	}
?>
			</tbody>

		</table>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
