	<input type="hidden" id ="is_edit_product" value="1" />
<?php
global $post;
?>
<table class="form-table">
	<input type="hidden" id="_current_plugin_name" value="<?php echo $plugin_name; ?>" />
	<tbody>

		<tr>
			<th>
			<label for="_product_sale_type">销售方式</label>
			</th>
			<td>
			<input type="radio" name="_product_sale_type" <?php checked( $product_sale_type, 0 ); ?> value="0" />单个产品
			<input type="radio" name="_product_sale_type" <?php checked( $product_sale_type, 1 ); ?> value="1" />打包出售
			<input type="radio" name="_product_sale_type" <?php checked( $product_sale_type, 2 ); ?> value="2" />重复出售
			</td>
		</tr>

		<tr class="single_sale_type_field">
			<th>
			<label for="_product_type">产品类型</label>
			</th>
			<td>
			<?php echo $type_box; ?>
			</td>
		</tr>
		<tr class="single_sale_type_field">
			<th>
			<label for="_plugin_name">可用插件/主题</label>
			</th>
			<td>
			<select name="_plugin_name" id="_plugin_name">
			</select>
			</td>
		</tr>

		
		<tr class="package_sale_type_field">
			<th>
			<label for="">选择产品
			<img class="stacktech_help_tip" data-tip="您可以在这里选择多个产品" src="<?php echo STACKTECH_COMMERCE_PLUGIN_URL; ?>/assets/images/help.png" height="16" width="16" />
			</label>
			</th>
			<td>
					<input type="hidden" class="stacktech-product-search" style="width: 50%;" id="package_ids" name="_package_ids" data-placeholder="搜索一个产品..." data-action="stacktech_json_search_products" data-multiple="true" data-exclude="<?php echo intval( $post->ID ); ?>" data-selected="<?php
						$product_ids = array_filter( array_map( 'absint', (array) get_post_meta( $post->ID, '_package_ids', true ) ) );
						$json_ids    = array();

						foreach ( $product_ids as $product_id ) {
							$product = get_post( $product_id );
							if ( is_object( $product ) ) {
								$json_ids[ $product_id ] = wp_kses_post( html_entity_decode( $product->post_title) ) ;
							}
						}

						echo esc_attr( json_encode( $json_ids ) );
					?>" value="<?php echo implode( ',', array_keys( $json_ids ) ); ?>" />
			</td>
		</tr>

		<tr>
			<th>
			<label for="_allow_purchase_forever">出售方式
			<img class="stacktech_help_tip" data-tip="如果设置成永久出售,那么购买者无需选择购买时间" src="<?php echo STACKTECH_COMMERCE_PLUGIN_URL; ?>/assets/images/help.png" height="16" width="16" />
			</label>
			</th>
			<td>
			<input type="radio" name="_allow_purchase_forever" <?php checked( $allow_purchase_forever, 0 ); ?> value="0" />按月
			<input type="radio" name="_allow_purchase_forever" <?php checked( $allow_purchase_forever, 1 ); ?> value="1" />永久
			<input type="radio" name="_allow_purchase_forever" <?php checked( $allow_purchase_forever, 2 ); ?> value="2" />免费
	
			</td>
		</tr>

		<tr class="sale_price_field">
			<th>
			<label for="_sale_price">销售价格(￥)
			<img class="stacktech_help_tip" data-tip="如果设置成永久出售,此价格为一次性购买价格;否则,就是按月的价格" src="<?php echo STACKTECH_COMMERCE_PLUGIN_URL; ?>/assets/images/help.png" height="16" width="16" />
			</label>
			</th>
			<td>
			<input name="_sale_price" id="_sale_price" type="text" value="<?php echo $sale_price;?>" size="40" adminria-required="true">
			</td>
		</tr>

		 <tr class="repeat_sale_field">
			<th>
				<a href="javascript:void(0);" onclick="return stacktech_store.add_price_condition('', '');">
+ 添加变量
		<input type="hidden" name="_price_condition" value="" />
			</th>
			<td>
			</td>
		</tr>

		<tr class="repeat_sale_field">
			<th>
			</th>
			<td align="left" id="price_condition_container">
				
			</td>
		</tr>


		 <tr class="month_discount_field">
			<th>
				<a href="javascript:void(0);" onclick="return stacktech_store.add_month_discount(0, 0);">
+ 购买越多越优惠 
		<input type="hidden" name="_month_discount" value="" />
			<img class="stacktech_help_tip" id="add_month_discount" data-tip="这里的优惠设置只针对非永久出售的产品" src="<?php echo STACKTECH_COMMERCE_PLUGIN_URL; ?>/assets/images/help.png" height="16" width="16" />
				</a>
			</th>
			<td>
			</td>
		</tr>

		<tr class="month_discount_field">
			<th>
			</th>
			<td align="left" id="month_discount_container">
				
			</td>
		</tr>

		<tr class="allow_discount_price_field">
			<th>
			<label for="_allow_discount_price" id="test_sel" class="tooltip" title="test">是否设置特价</label>
			</th>
			<td>
			<input type="radio" name="_allow_discount_price" <?php checked( $allow_discount_price, 1 ); ?> value="1" />是
			<input type="radio" name="_allow_discount_price" <?php checked( $allow_discount_price, 0 ); ?> value="0" />否
			</td>
		</tr>
		<tr class="discount_field">
			<th>
			<label for="_sale_discount_price">特价价格(￥)
			<img class="stacktech_help_tip" data-tip="如果设置成永久出售,此价格为一次性购买价格;否则,就是按月的价格" src="<?php echo STACKTECH_COMMERCE_PLUGIN_URL; ?>/assets/images/help.png" height="16" width="16" />
			</label>
			</th>
			<td>
			<input name="_sale_discount_price" id="_sale_discount_price" type="text" value="<?php echo $sale_discount_price;?>" size="40" adminria-required="true">
			</td>
		</tr>
		<tr class="discount_field">
			<th>
			<label for="_discount_start_date">特价开始日期
			<img class="stacktech_help_tip" data-tip="如果留空,则一直使用特价" src="<?php echo STACKTECH_COMMERCE_PLUGIN_URL; ?>/assets/images/help.png" height="16" width="16" />

			</label>
			</th>
			<td>
			<input name="_discount_start_date" autocomplete="off" class="stacktech-datepicker" id="_discount_start_date" type="text" value="<?php echo $discount_start_date;?>" size="40" adminria-required="true">
			</td>
		</tr>
		<tr class="discount_field">
			<th>
			<label for="_discount_end_date">特价结束日期
			<img class="stacktech_help_tip" data-tip="如果留空,则一直使用特价" src="<?php echo STACKTECH_COMMERCE_PLUGIN_URL; ?>/assets/images/help.png" height="16" width="16" />
			</label>
			</th>
			<td>
			<input name="_discount_end_date" autocomplete="off" class="stacktech-datepicker" id="_discount_end_date" type="text" value="<?php echo $discount_end_date;?>" size="40" adminria-required="true">
			</td>
		</tr>

		

		<tr class="allow_trail_field">
			<th>
			<label for="_allow_trail">是否允许试用</label>
			</th>
			<td>
			<input name="_allow_trail" type="radio" value="1" <?php checked( $allow_trail, 1 ); ?> >允许
			<input name="_allow_trail" type="radio" value="0" <?php checked( $allow_trail, 0 ); ?> >不允许
			</td>
		</tr>

		<tr class="trail_field">
			<th>
			<label for="_trail_days">试用天数(天)</label>
			</th>
			<td>
			<input name="_trail_days" id="_trail_days" type="text" value="<?php echo $trail_days ? $trail_days : 10;?>" size="40" adminria-required="true">
			</td>
		</tr>

		<tr>
			<th>
				<label>依赖销售
			<img class="stacktech_help_tip" data-tip="用户必须已经购买所依赖的产品，或者将所依赖的产品放入购物车一同购买" src="<?php echo STACKTECH_COMMERCE_PLUGIN_URL; ?>/assets/images/help.png" height="16" width="16" />
				</label>
			</th>
			<td>
						<input type="hidden" class="stacktech-product-search" style="width: 50%;" id="dependence_ids" name="_dependence_ids" data-placeholder="搜索一个产品..." data-action="stacktech_json_search_products" data-multiple="true" data-exclude="<?php echo intval( $post->ID ); ?>" data-selected="<?php
							$product_ids = array_filter( array_map( 'absint', (array) get_post_meta( $post->ID, '_dependence_ids', true ) ) );
							$json_ids    = array();

							foreach ( $product_ids as $product_id ) {
								$product = get_post( $product_id );
								if ( is_object( $product ) ) {
									$json_ids[ $product_id ] = wp_kses_post( html_entity_decode( $product->post_title) ) ;
								}
							}

							echo esc_attr( json_encode( $json_ids ) );
						?>" value="<?php echo implode( ',', array_keys( $json_ids ) ); ?>" />

			</td>
		</tr>
	</tbody>
</table>
<script type="text/javascript">
window._month_discount = <?php echo $month_discount ? $month_discount : '{}'; ?>;
window._price_condition = <?php echo $price_condition ? $price_condition : '{}'; ?>;
</script>

