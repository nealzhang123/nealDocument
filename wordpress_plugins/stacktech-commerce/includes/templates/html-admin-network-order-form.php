<div class="wrap">
	<h2>编辑订单 <?php echo $order['order_no']; ?></h2>
	<form method="post">
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="create_time">订单日期</label></th>
				<td><input type="text" class="regular-text" value="<?php echo $order['create_time']; ?>" disabled id="create_time" name="create_time"></td>
			</tr>
			<tr>
				<th scope="row"><label for="pay_time">支付时间</label></th>
				<td><input type="text" class="regular-text" value="<?php echo $order['pay_time']; ?>" disabled id="pay_time" name="pay_time"></td>
			</tr>
			<tr>
				<th scope="row"><label>操作人</label></th>
				<td>
					来自<a href="<?php echo $blog->siteurl;?>/wp-admin/"><?php echo $blog->blogname;?></a>的<?php echo $user_info->user_login; ?> 
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="order_status">订单状态</label></th>
				<td>
					<select name="order_status" id="order_status">
						<?php $all_status = Stacktech_Commerce_Order::get_all_status(); ?>
						<?php foreach($all_status as $key => $status) {?>
							<option value="<?php echo $key;?>" <?php selected($order['order_status'], $key) ?> ><?php echo $status;?></option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>产品列表</label></th>
				<td>
					<table class="widefat fixed">
						<thead>
							<tr>
								<th>名称</th>
								<th>购买时间</th>
							</tr>
						</thead>
						<tbody>
<?php
	if($products){ 
		foreach($products as $order_product){
			
			$product_type = get_global_post_meta( $order_product['product_id'], '_product_type', true );
?>
		<tr>
		<!--<td><a href="<?php echo admin_url('admin.php?page=stacktech-store-' . ($product_type? $product_type: 'plugin') . '#product/' . $order_product['product_id']); ?>"><?php echo $order_product['post_title']; ?></a></td>-->
		<td><a onclick="stacktech_store.load_product_by_popup(<?php echo $order_product['product_id'];?>)" href="javascript:void(0)"><?php echo $order_product['post_title']; ?></a></td>
			<td>

<?php
			echo Stacktech_Commerce_Order::get_period_text( $order_product['order_product_id'] );

?>
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
		</tbody>
	</table>
	<input type="hidden" name="action" value="network_edit_order" />
	<p class="submit"><input type="submit" value="保存更改" class="button button-primary" id="submit" name="submit"></p>


	</form>
</div>
