
			<div class="wrap">
			<h2>订单记录</h2>
			<ul class="subsubsub">
				<li class="all"><a href="#"	class="current">全部<span class="count"></span></a></li>
			</ul>

			<form method="get">
				<input type="hidden" name="post_type" value="stacktech_product" />
				<input type="hidden" name="page" value="stacktech-store-network-order-page" />
				<div class="tablenav top">
					<div class="alignleft actions">
						<select name="filter-by-author">
	<option value="0">全部开发者</option>
	<?php foreach($developers as $developer ) { ?>
	<option <?php selected($args['filter_by_author'], $developer->ID); ?> value="<?php echo $developer->ID; ?>"><?php echo $developer->data->user_nicename; ?></option>
	<?php } ?>
						</select>
						<input type="search" id="order-search-input" placeholder="输入订单编号" name="filter-order-no" value="<?php echo $args['filter_order_no'];?>">
						<input type="submit" id="search-submit" class="button" value="搜索订单">
					</div>
					<div class="sy-page-actions">
					<a href="javascript:void(0)" class="button" status="close" onclick="stacktech_store.toggle_all_order_details(this);">展开/隐藏订单详情</a>
					</div>
				</div>
			</form>
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
						<th width="10%">
							支付时间
						</th>
		<th width="10%">
			总价格
		</th>
						<th width="10%">
							来源站点
						</th>
						<th>
							查看
						</th>
					</tr>
				</thead>
				<tbody>
				<?php if($orders){?>
				<?php foreach ( $orders as $order):?>
				<?php $user_info = stacktech_call_global_func( 'get_userdata', $order['user_id'] ); ?>
					<?php $blog = get_blog_details($order['blog_id']);?>
					<tr>
						<td>
<?php if(isset($order['is_child_order']) && $order['is_child_order']) { ?>

							<?php echo $order['order_no'] . '-'. $order['product_id']; ?>

<?php } else { ?>
						<a href="<?php echo admin_url('edit.php?post_type=stacktech_product&page=stacktech-store-network-order-page&action=edit&order_id=' . $order['order_id']); ?>">
							<?php echo $order['order_no']; ?>
							</a>
<?php } ?>
						</td>
						<td><?php echo $user_info->user_login; ?></td>
						<td><?php echo Stacktech_Commerce_Order::get_order_status_text($order['order_status']); ?></td>
						<td><?php echo Stacktech_Commerce_Order::get_order_type_text($order['order_type']); ?></td>
						<td><?php echo $order['create_time'];?></td>
						<td><?php echo $order['pay_time'] ? $order['pay_time'] : '无'?></td>
		<td><?php echo $order['total_price']; ?></td>
						<td>
							<?php echo $blog->blogname; ?>
						</td>
						<td>
						
			<a href="javascript:void(0);" onclick="return stacktech_store.show_order_detail(<?php echo $order['order_id']; ?>);">订单详情</a>
			<a href="javascript:void(0)" data-order-id="<?php echo $order['order_id']; ?>" class="button load_order_history_btn">查看操作记录</a>
						</td>
						
					</tr>

	<tr class="order_detail_row" style="display:none;" id="order_detail_row_<?php echo $order['order_id']; ?>">
		<td colspan=9>
			<table class="widefat fixed">
			<thead>
				<tr>
					<th width="30%">名称</th>
					<th width="30%"><?php echo Stacktech_Commerce_Order::get_order_type_text($order['order_type']); ?>时间</th>
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
				<?php endforeach;?>
				<?php }else{ ?>
					<tr>
						<td colspan="9">
					没有订单
							</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
</div>
