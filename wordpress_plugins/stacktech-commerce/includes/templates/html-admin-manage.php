<div class="wrap">
<h2>启用服务</h2>

<div id="message" class="updated notice notice-success is-dismissible below-h2"><p>主题服务同一时间最多只能启动一个，如果启用新的主题服务，已经启动的将会被暂停。</p></div>
<!-- plugin -->
<table class="widefat fixed">
<thead>
	<h3>插件</h3>
	<tr>
		<th>
			服务名称
		</th>
		<th>
			状态
		</th>
		<th>
			开始时间
		</th>
		<th>
			结束时间
		</th>
		<th>
			操作
		</th>
	</tr>
</thead>
<tbody>
<?php 
foreach ( $services as $service ): 
	if( $service['product_type'] == 'plugin' ){
?>
	<tr>
		<td>
	<a onclick="stacktech_store.load_product_by_popup(<?php echo $service['product_id'];?>)" href="javascript:void(0)"><?php echo $service['post_title']; ?></a>
		</td>
		<td><?php echo Stacktech_Commerce_Service::get_status_text($service['status']); ?></td>
		<td><?php echo $service['start_time']; ?></td>
		<td><?php if($service['start_time'] == $service['end_time']){echo '永久';}else{echo $service['end_time'];} ?></td>
		<td>
<?php
	if($service['status'] == Stacktech_Commerce_Service::$running){
	?>
		<a class="button" href="javascript:void(0)" onclick="return stacktech_store.toggle_service(<?php echo $service['service_id']; ?>, <?php echo $service['status'];?>);">停止</a>
	<?php
	}else if ($service['status'] == Stacktech_Commerce_Service::$stop) {
	?>
	<a class="button" href="javascript:void(0)" onclick="return stacktech_store.toggle_service(<?php echo $service['service_id']; ?>, <?php echo $service['status'];?>);">启动</a>
	<?php
	}else{
?>
	<a class="button" onclick="stacktech_store.load_product_by_popup(<?php echo $service['product_id'];?>)" href="javascript:void(0)">购买</a>
<?php
	}
?>
	<a href="javascript:void(0)" class="button load_history_btn" data-service-id="<?php echo $service['service_id']; ?>">操作历史记录</a>
		</td>
	</tr>
<?php }endforeach; ?>
</tbody>
</table>



<!-- theme -->
<table class="widefat fixed">
<thead>
	<h3>主题</h3>
	<tr>
		<th>
			服务名称
		</th>
		<th>
			状态
		</th>
		<th>
			开始时间
		</th>
		<th>
			结束时间
		</th>
		<th>
			操作
		</th>
	</tr>
</thead>
<tbody>
<?php 
// 先显示默认主题
foreach ( $allowed_themes as $theme => $val) {
	$theme = wp_get_theme( $theme );
?>

	<tr>
	<td><?php echo $theme->get('Name'); ?>[默认安装]</a></td>
		<td>-</td>
		<td>-</td>
		<td>永久</td>
		<td>
<?php
		$t = wp_get_theme();
		// 如果刚好停止的这个主题正在被使用，那么先切换到默认主题
		if ( strtolower($t->get_stylesheet()) != $theme->get_stylesheet() ) {
?>
	<a class="button" href="<?php echo admin_url('customize.php?theme=' . $theme->get_stylesheet()); ?>" target="_blank">预览并切换主题</a>
<?php
		}else{
?>

 <a href="javascript:void(0)" class="button"  disabled>正在使用</a>
<?php
		}
?>

	<a href="javascript:void(0)" class="button load_history_btn" data-service-id="0" data-theme="<?php echo $theme->get_stylesheet();?>">操作历史记录</a>
		</td>
</tr>

<?php
}
foreach ( $services as $service ){
	if( $service['product_type'] == 'theme' ){
?>
	<tr>
		<td><a onclick="stacktech_store.load_product_by_popup(<?php echo $service['product_id'];?>)" href="javascript:void(0)"><?php echo $service['post_title']; ?></a></td>
		<td><?php echo Stacktech_Commerce_Service::get_status_text($service['status'], 'theme'); ?></td>
		<td><?php echo $service['start_time']; ?></td>
		<td><?php if($service['start_time'] == $service['end_time']){echo '永久';}else{echo $service['end_time'];} ?></td>
		<td>


<?php

if($service['status'] == Stacktech_Commerce_Service::$running){
?>
<?php

		$plugin_name = get_global_post_meta( $service['product_id'], '_plugin_name', true );
		$t = wp_get_theme();
		// 如果刚好停止的这个主题正在被使用，那么先切换到默认主题
		if ( strtolower($t->get_stylesheet()) != $plugin_name ) {
?>
	<a class="button" href="<?php echo admin_url('customize.php?theme=' . $plugin_name); ?>" target="_blank">预览并切换主题</a>
<?php
		}else{
?>

 <a href="javascript:void(0)" class="button"  disabled>正在使用</a>
<?php
		}
?>

	<a class="button" href="javascript:void(0)" onclick="return stacktech_store.toggle_service(<?php echo $service['service_id']; ?>, <?php echo $service['status'];?>);">停止</a>
<?php

}else{
?>
<a class="button" href="javascript:void(0)" onclick="return stacktech_store.toggle_service(<?php echo $service['service_id']; ?>, <?php echo $service['status'];?>);">启动</a>
<?php
}
?>
			<a href="javascript:void(0)" class="button load_history_btn" data-service-id="<?php echo $service['service_id']; ?>">操作历史记录</a>
		</td>
	</tr>
<?php }
} ?>
</tbody>
</table>
</div>


<script type="text/template" id="service-log-template">
<tr id="tr_<%=service_id%>">
	<td colspan="5">
				<%if(logs.length > 0){%>
		<table class="widefat">
			<thead>
				<tr>
					<th>
						操作人
					</th>
					<th>
						IP
					</th>
					<th>
						操作时间
					</th>
					<th>
						操作内容
					</th>
				</tr>
			</thead>
			<tbody>
				<%for(var i in logs){%>
					<tr>
					<th>
						<%=logs[i].username%>
					</th>
					<th>
						<%=logs[i].ip%>
					</th>
					<th>
						<%=logs[i].action_time%>
					</th>
					<th>
						<%=logs[i].content%>
					</th>
					</tr>
				<%}%>
			</tbody>
		</table>
				<%}else{%>
					暂时没有任何操作记录
				<%}%>
	</td>
</tr>
</script>



