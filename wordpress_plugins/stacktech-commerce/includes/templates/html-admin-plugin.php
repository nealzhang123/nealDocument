<!-- <div id="Slider2" class="Dragval"><input type="text" name="" value="" class="Output" /></div> -->
<div class="wrap">
	<h2>APP商城</h2>
	<div class="theme-browser">
	<div class="themes" id="stacktech-store">

	</div>
	</div>
</div>


<input type="hidden" id="init_stacktech_store" value="1" />
<input type="hidden" id="stacktech_pay_url" value="<?php echo get_admin_url(null, 'admin.php?page=stacktech-store-pay'); ?>" />

<!-- 模板 -->

<!-- 产品列表的模板 -->
<script type="text/template" id="product-list-template" >
	<div class="filter-panel">
		<ul class="product_terms">
			<li><a class="product_term selected" href="javascript:void(0)" term-id="0" >全部</a></li>
			<?php if($terms){?>
			<?php foreach ( $terms as $term ) { ?>
			<li><a class="product_term" href="javascript:void(0)" term-id="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a></li>
			<?php } ?>
			<?php } ?>
		</ul>

		<ul class="trail_terms">
			<li><a class="trail_term selected" allow_trail="2" href="javascript:void(0)">全部</a></li>
			<li><a class="trail_term" href="javascript:void(0)" allow_trail="1">允许试用</a></li>
			<li><a class="trail_term" href="javascript:void(0)" allow_trail="0">不允许试用</a></li>
		</ul>

		<ul class="filter_terms clearfix">
			<li><a class="filter_term selected" hide_product_type="0" href="javascript:void(0)">全部</a></li>
			<li><a class="filter_term" hide_product_type="1" href="javascript:void(0)">隐藏正在试用</a></li>
			<li><a class="filter_term" hide_product_type="2" href="javascript:void(0)">隐藏正在使用</a></li>
		</ul>

		<ul class="standard_terms clearfix">
			<li><a class="standard_term selected" allow_purchase_forever="3" href="javascript:void(0)">标准</a></li>
			<li><a class="standard_term" href="javascript:void(0)" allow_purchase_forever="0">按月支付</a></li>
			<li><a class="standard_term" href="javascript:void(0)" allow_purchase_forever="1">永久出售</a></li>
			<li><a class="standard_term" href="javascript:void(0)" allow_purchase_forever="2">免费使用</a></li>
			<li class="stacktech-store-search-box">
				<input type="text" id="stacktech-store-search" value="" placeholder="请输入关键字..." />
			</li>
		</ul>
		


	</div>
	<div class="listings">
		<ul id="product-list-container">
		</ul>
	</div>
</script>
<!-- /产品列表的模板 -->








<!-- 结算页面模板 -->
<script type="text/template" id="checkout-page">
<h2>商品列表</h2>
<table class="widefat fixed">
<thead>
	<tr>
		<th>
			产品名称
		</th>
		<th>
			购买时间
		</th>
		<th>
			价格
		</th>
	</tr>
</thead>
<tbody>
<% for(var i = 0; i < products.length; i ++ ){%>
	<tr>
		<td>
<a href="<%=sc_page_url('admin.php?page=stacktech-store-'  +(products[i]['product_type'] == ''?'plugin':products[i]['product_type'])+ '#product/' + products[i]['product_id'])%>">
<%=products[i]['post_title']%>
</a>
		</td>
		<td>
	<% if(products[i]['allow_purchase_forever'] == 1){%>
		永久
	<%}else{%>
<%=sc_get_period_label(products[i]['period'])%>
<%}%>
		</td>
		<td>
<%=sc_display_money(products[i]['total'])%>
		</td>
	</tr>
<% }%>
</tbody>
<tfoot>
	<tr>
		<td>
		</td>
		<td>
		共计
		</td>
		<td>
		<%=total%>
		</td>
	</tr>
</tfoot>
</table>
<div id="payment_div">
<h2>支付方式</h2>
<div class="payment_row">
<input type="radio" checked/> 支付宝
</div>
</div>
<div style="text-align:right;">
<button class="button" id="goto_pay">去支付</button>
</div>
</script>
<!-- /结算页面模板 -->

<script type="text/template" id="product-template">
	<div class="sc-quick-theme">
	<div class="theme-screenshot">
		<img src="<%=feature_image%>" alt="" width="100%" />
	</div>
	<div class="product-name">
		<%=post_title%>
	</div>
	<div class="product-sale-type product-info-row">
		<span class="product-info-row-title">标准：</span>
		<span class="product-info-row-content">
			<% if(allow_purchase_forever == 1){%>
				永久出售
			<%}else if(allow_purchase_forever == 2){%>
				免费使用
			<%} else{%>
				<%=sc_get_period_options()%>
			<%}%>
		</span>
	</div>
	<div class="product-info-row">
		<% if(allow_purchase_forever != 2){%>
		<span class="product-info-row-title">
			<% if(allow_purchase_forever != 1){%>
每月<% } %>价格：</span>
		<span class="product-info-row-content">
			<% if(use_discount_price){%>
				<span class="total-price price"><%=sc_display_money(sale_discount_price)%></span>
&nbsp;&nbsp;
				<span class="original-price"><%=price%></span>
			<% }else{ %>
				<span class="total-price price"><%=sc_display_money(price)%></span>
			<% }%>
		</span>
		<% }%>
		<span class="product-info-row-content-right">
		<% if(allow_purchase_forever != 2){%>
			<% if(is_purchased == 1){ %>
					<%if(product_service_status == 1){%>
					<a class="button stop_service_btn">停止</a>
					<%}else{%>
					<a class="button start_service_btn">启用</a>
					<%}%>
			<% }else{ %>
				<% if(is_trailing == 1){ %>
					<%if(product_service_status == 1){%>
					<a class="button stop_service_btn">停止</a>
					<%}else{%>
					<a class="button start_service_btn">启用</a>
					<%}%>

				<% }else if( is_trailed == 1){ %>
					<a class="button" disabled>已有试用记录</a>
				<% } else if(allow_trail == 1){  %>
					<a href="#" class="button trail_btn">试用</a>
				<% } %>

				<% if(is_in_cart == 1){ %>
					<a class="button" disabled>已经加入购物车</a>
				<% } else { %>
					<a href="#" class="button add_to_cart_btn">加入购物车</a>
				<% } %>

			<% } %>
		<% }else{ %>
			<% if(is_purchased == 1){ %>
					<%if(product_service_status == 1){%>
					<a class="button stop_service_btn">停止</a>
					<%}else{%>
					<a class="button start_service_btn">启用</a>
					<%}%>
			<%}else{%>
				<a href="#" class="button free_product_btn">开始使用</a>
			<%}%>

		<% } %>
		</span>
	</div>


	<span class="more-details" id="storefront-action">产品详情</span>
	</div>
</script>
<!-- /模板 -->
