<div class="wrap">
<h3>结算选项</h3>
<form method="POST">
<table class="form-table">
<tbody>
	<tr valign="top">
		<th scope="row">
			<label for="sc_enable_alipay_gateway">支付宝</label>
		</th>
		<td>
		<input class="" type="checkbox" name="sc_enable_alipay_gateway" id="sc_enable_alipay_gateway" style="" <?php checked(1, $sc_enable_alipay_gateway); ?> value="1"> 启用
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label for="sc_alipay_partner">合作身份者ID</label>
		</th>
		<td>
		<input class="" type="input" name="sc_alipay_partner" id="sc_alipay_partner" value="<?php echo $sc_alipay_partner; ?>">
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label for="sc_alipay_key">安全校验码</label>
		</th>
		<td>
		<input class="" type="input" name="sc_alipay_key" id="sc_alipay_key" value="<?php echo $sc_alipay_key;?>">
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">
			<label for="sc_alipay_seller_email">支付宝收款账号</label>
		</th>
		<td>
		<input class="" type="input" name="sc_alipay_seller_email" id="sc_alipay_seller_email" value="<?php echo $sc_alipay_seller_email; ?>">
		</td>
	</tr>
</tbody>
</table>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="保存更改"></p>
</form>
</div>
