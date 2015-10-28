<div style="display:none;">
<div id="store_modal">
	<button class="remodal-close"></button>
	<div id="store_modal_content">
	</div>
</div>
</div>

<script type="text/javascript">
function sc_page_url(param){
	var adminPage = "<?php echo admin_url();?>";
	return adminPage + param;
}
</script>


<script type="text/template" id="cart-template">
<div id="top-cart-list">
<table class="">
<thead>
	<tr>
		<th style="width:290px;">
			产品名称
		</th>
		<th style="width:100px;text-align:center;">
			购买时间
		</th>
		<th style="width:140px;text-align:center;">
			价格
		</th>
		<th style="width:70px;text-align:right;">
			操作
		</th>
	</tr>
</thead>
<tbody id="cart-body">
</tbody>
<tfoot>
<tr>
	<td></td>
	<td></td>
	<td style="text-align:center;"><div id="total-table-row">共计</div></td>
	<td style="text-align:right;"><div class="price"><%=sc_display_money(total)%></div></td>
</tr>
</tfoot>
</table>
	<div id="global_cart_actions">
		<a class="empty-cart-btn" href="#" class="btn btn-default" data-confirm="您确定要清空购物车吗？" id="empty_cart_btn">清空购物车</a>
		<a class="checkout-btn" href="<%=sc_page_url('admin.php?page=stacktech-store-plugin#checkout')%>">去结算</a>
	</div>
	<a id="cart_close_btn" class="cart-close-btn" href="javascript:void(0)"><i class="fa fa-times"></i></a>
</div>
</script>


<script type="text/template" id="emtpy-cart-template">
<div id="top-cart-list">
暂无任何商品!
</div>
	<a id="cart_close_btn" class="cart-close-btn" href="javascript:void(0)"><i class="fa fa-times"></i></a>
</script>

<script type="text/template" id="cart-product-template">
	<td><a href="<%=sc_page_url('admin.php?page=stacktech-store-' + (product_type == ''?'plugin':product_type) + '#product/' + product_id)%>"><%=post_title%></a>

				<%if(!_.isEmpty(price_condition)){%>
					<select class="price_condition_seletor">
						<%for(var key in price_condition){%>
							<option value="<%=key%>" <%=sc_selected(price_condition_key, key)%> ><%=key%></option>
						<%}%>
					</select>
				<%}%>
</td>
	<td style="text-align:center;">

	<% if(allow_purchase_forever == 1){%>
		永久
	<%}else{%>

<%=sc_get_period_options(period)%>
	<%}%>
	</td>
	<td style="text-align:center;">
		<% if(allow_purchase_forever == 1){%>
			<%=sc_display_money(currentPrice)%>
		<%}else{%>
			<%=sc_display_money(currentPrice)%>/每月
		<%}%>
	</td>
	<td style="text-align:right;"><a href="" class="cart-delete-btn">删除</a></td>
</script>


<script type="text/template" id="order-detail-template">
<div id="div_<%=order_id%>">

<table class="widefat fixed">
<thead>
	<tr>
		<th>
			订单编号
		</th>
		<th>
			用户名
		</th>
		<th>
			订单状态
		</th>
		<th>
			订单类型
		</th>
		<th>
			下订单时间
		</th>
		<th>
			支付时间
		</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td><%=order_no%></td>
		<td><%=username%></td>
		<td><%=order_status%></td>
		<td><%=order_type%></td>
		<td><%=create_time%></td>
		<td><%=pay_time%></td>
	</tr>
	<tr>
		<td colspan="6">
			<% if(products.length > 0){%>
			<table class="widefat fixed">
			<thead>
				<tr>
					<th>名称</th>
					<th>使用时间</th>
				</tr>
			</thead>
				<%for(var j in products){%>
				<tr>

		<td><a onclick="stacktech_store.load_product_by_popup(<%=products[j].product_id%>)" href="javascript:void(0)">

					<%=products[j].post_title%>
</a></td>
					<td>

					<%if(products[j].period == 0){%>
					永久
					<%}else{%>
					<%=products[j].period%><%if(order_type == 'trail'){%>天<%}else{%>月<%}%>
					<%}%>
					</td>
				</tr>
				<%}%>
			<tbody>
			</table>
			<%}else{%>
				没有产品
			<%}%>
		</td>
	</tr>
	</tbody>
</table>
</div>
</script>

<!-- 产品弹出框详情的模板 -->
<script type="text/template" id="product-detail-template">
	<div class="sc-theme">
		<div class="clearfix">
			<div class="leftside">
				<div id="product_big_image">
					<img src=""/>
				</div>
				<div class="jcarousel-wrapper">
				<div class="jcarousel">
                        <ul>
							<% if(gallery.length > 0){%>
							<%for(var i = 0; i<gallery.length; i++){%>
                            <li class="product_thumb_image" data-src="<%=big_gallery[i]%>"><img src="<%=gallery[i]%>" alt=""></li>
							<%}%>
							<%}%>
                        </ul>
                </div>
 <a href="javascript:void(0)" class="jcarousel-control-prev">&lsaquo;</a>
                <a href="javascript:void(0)" class="jcarousel-control-next">&rsaquo;</a>
				</div>
			</div>
			<div class="rightside">
				<div class="product-name">
					<%=post_title%>
				</div>

				<% if(allow_purchase_forever != 2){%>
				<div class="product-info-price-row">
					<% if(use_discount_price){%>
						<span class="total-price price"><%=sc_display_money(sale_discount_price)%></span>
		&nbsp;&nbsp;
						<span class="original-price"><%=price%></span>
					<% }else{ %>
						<span class="total-price price"><%=sc_display_money(price)%></span>
					<% }%>
				</div>
				<% }%>

				<%if(!_.isEmpty(price_condition)){%>
				<div class="product-price-condition product-info-row">
					<span class="product-info-row-title">选择：</span>
					<span class="product-info-row-content">
						<%for(var key in price_condition){%>
							<a href="javascript:void(0);" class="price-condition-btn price_condition_val" data-key="<%=key%>"><%=key%></a>
						<%}%>
					</span>
				</div>
				<%}%>

				<% if(allow_purchase_forever == 1){%>
				<div class="product-sale-type product-info-row">
					<span class="product-info-row-title">标准：</span>
					<span class="product-info-row-content">
							永久出售
					</span>
				</div>
				<% }else if(allow_purchase_forever == 2){%>
				<div class="product-sale-type product-info-row">
					<span class="product-info-row-title">标准：</span>
					<span class="product-info-row-content">
							免费使用
					</span>
				</div>
				<%}else{%>
					<%if(use_discount_price == 0){%>			
						<div class="product-sale-type product-info-row">
							<span class="product-info-row-title">标准：</span>
							<span class="product-info-row-content">
								<%if(!_.isEmpty(month_discount)){%>
								<%for(var key in month_discount){%>
									<a href="javascript:void(0);" class="period-price-btn" data-period="<%=key%>"><%=sc_get_period_label(key)%></a>
								<%}%>
								<%}else{%>
								按月购买
								<%}%>
							</span>
						</div>
					<%}%>

					<div class="product-info-row">
						<span class="product-info-row-title">购买：</span>
						<span class="product-info-row-content">
							<%=sc_get_period_options()%>
						</span>
					</div>

				<%}%>

				<div class="product-sale-actions product-info-row">
				<% if(allow_purchase_forever != 2){ %>
					<% if(is_purchased == 1){ %>
						<a href="javascript:void(0)" class="sc-button disabled" >已经购买</a>
					<% }else{ %>
						<% if(is_trailing == 1){ %>
							<a class="sc-button trailing" disabled><i class="fa fa-desktop"></i>正在试用</a>
						<% } else if(allow_trail == 1){  %>
							<a href="#" class="sc-button trail_btn"><i class="fa fa-desktop"></i>试用</a>
						<% } %>
						<% if(is_in_cart == 1){ %>
							<a class="sc-button success" disabled>已经加入购物车</a>
						<% } else { %>
							<a href="#" class="sc-button add_to_cart_btn">加入购物车</a>
						<% } %>

					<% } %>
				<% }else{ %>
					<% if(product_service_status == 1){ %>
						<a class="button" disabled>正在使用</a>
					<% } else {%>
						<a href="#" class="button free_product_btn">开始使用</a>
					<% } %>
				<% } %>
				</div>
				
				
				<%if(is_package == 1){%>
				<div class="product-info-row package-product-list">
					<div class="package-product-list-title">打包产品：</div>
					<div class="package-product-list-content clearfix">
						<%for(var i in package_products){%>
							<div class="item">
								<div class="package-product-image">
									<a target="_blank" data-product-id="<%=i%>" href="javascript:void(0);" class="_package_detail_popup">
									<img src="<%=package_products[i]['feature_image']%>" />
									</a>
								</div>
								<div class="package-product-title">
									<a target="_blank" data-product-id="<%=i%>" href="javascript:void(0);" class="_package_detail_popup">
									<%=package_products[i]['post_title']%></a>
								</div>
							</div>
						<%}%>
					</div>
				</div>
				<%}%>
			</div>
		</div>

		<!-- 产品详情 -->
		<div id="sc-product-content">
			<div class="sc-product-tabs">
				<a href="javascript:void(0);" class="sc-button" href="">产品详情</a>
			</div>
			<div>
				<%=post_content%>
			</div>
		</div>
		<!-- /产品详情 -->
	</div>
</script>
<!-- /产品弹出框详情的模板 -->
<script type="text/template" id="account-log-template">
	<div style="padding:0px 20px;" id="account_log_history">
		<table class="widefat fixed">
		<thead>
			<tr>
				<th>操作类型</th>
				<th>操作金额</th>
				<th>操作时间</th>
				<th>操作详情</th>
			</tr>
		</thead>
		<tbody>
	<%if(logs.length > 0){%>
	<%for(var i in logs){%>
		<tr>
			<td>
			<%=logs[i].action_name%>
			</td>
			<td>
				<span class="price"><%=((logs[i].user_money > 0) ? '+' : '-')%><%=logs[i].user_money%></span>
			</td>
			<td>
			<%=logs[i].action_time%>
			</td>
			<td>
			<%=logs[i].action%>
			</td>
		</tr>
	<%}%>
	<%}else{%>
		<tr>
			<td colspan="4">
		暂时没有任何操作记录
			</td>
		</tr>
	<%}%>

		</tbody>
		</table>
	</div>


</script>

<script type="text/template" id="order-log-template">
	<div style="padding:0px 20px;" id="account_log_history">
		<table class="widefat fixed">
		<thead>
			<tr>
				<th>操作详情</th>
				<th>操作时间</th>
				<th>操作人</th>
			</tr>
		</thead>
		<tbody>
	<%if(logs.length > 0){%>
	<%for(var i in logs){%>
		<tr>
			<td>
			<%=logs[i].action%>
			</td>
			<td>
			<%=logs[i].action_time%>
			</td>
			<td>
			<%=logs[i].username%>
			</td>
		</tr>
	<%}%>
	<%}else{%>
		<tr>
			<td colspan="3">
		暂时没有任何操作记录
			</td>
		</tr>
	<%}%>

		</tbody>
		</table>
	</div>


</script>



