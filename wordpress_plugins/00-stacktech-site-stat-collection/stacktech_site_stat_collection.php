<?php
/*
Plugin Name: 00 stacktech site stat collection
Plugin URI: http://www.etongapp.com
Description: stacktech site stat collection
Version: 1.0
Author: Stacktech
Author URI: http://www.etongapp.com
License: GPL
*/

/**
* 
*/
class StacktechSiteStat {
	
	function load_script(){

		global $post,$blog_id;

		//wp_enqueue_script( 'stacktech-site-stat-jquery', 'https://cdn.bootcss.com/jquery/2.2.1/jquery.min.js' );
		wp_enqueue_script( 'stacktech-site-stat-script', plugin_dir_url( __FILE__ ) . 'site_stat.js', array('jquery') );
		wp_localize_script( 'stacktech-site-stat-script', 'ram_obj', 
			array(
				'pi' => base64_encode($post->ID),
				'bi' => base64_encode($blog_id),
			) );
	}

	function plugin_activation(){

		$con = mysql_connect(DB_HOST_STATS, DB_USER_STATS , DB_PASSWORD_STATS);
		if (!$con)
	  		return;

		$db_selected = mysql_select_db(DB_NAME_STATS,$con);

		$sql = "CREATE TABLE stacktech_stat_page_record  (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                post_id bigint(20) NOT NULL,
                blog_id int(11) NOT NULL,
                ip varchar(30),
                time timestamp,
                PRIMARY KEY  (id,blog_id)
            )";
		mysql_query($sql);

		$sql = "CREATE TABLE stacktech_stat_process  (
	            id bigint(20) NOT NULL AUTO_INCREMENT,
	            blog_id int(11) NOT NULL,
	            server_addr varchar(30),
	            status smallint NOT NULL DEFAULT 0,
	            data_size decimal(10,2) NOT NULL DEFAULT 0, 
	            PRIMARY KEY  (id,blog_id)
	        )";
		mysql_query($sql);

		mysql_close();

		global $wpdb;

		$sql = "CREATE TABLE stacktech_stat_record (
	        id bigint(20) AUTO_INCREMENT,
	        blog_id int(11) NOT NULL,
	        flow decimal(10,2) NOT NULL DEFAULT 0, 
	        time datetime,
	        server_time datetime,
	        PRIMARY KEY  (id,blog_id)
	        );";

		$wpdb->query($sql);

		return;
	}

	function add_network_setting(){
?>
		<table class="form-table">
			<tr>
				<th><label for="network_max_flow">站点流量限制</label></th>
				<td>
					<input type="number" min="0" style="width: 100px" value="<?php echo get_site_option( 'network_max_flow' ); ?>" name="network_max_flow" id="network_max_flow" /> MB
				</td>
			</tr>
		</table>
<?php
	}

	function update_network_setting(){
		if( !isset($_POST['network_max_flow']) )
			return;

		$network_max_flow = (int)trim($_POST['network_max_flow']);

		if( $network_max_flow < 0 )
			return;

		update_site_option( 'network_max_flow', $network_max_flow );

		return;
	}

	function add_site_setting($site_id){
		$site_max_flow = get_blog_option( $site_id,'site_max_flow' );
		//if( empty($site_max_flow) )
		//	$site_max_flow = get_site_option( 'network_max_flow' );
?>
		<tr class="form-field">
			<th><label for="site_max_flow">站点流量限制</label></th>
			<td><input type="number" min="0" style="width: 100px" value="<?php echo $site_max_flow; ?>" name="site_max_flow" id="site_max_flow" /> MB (网络默认<?php echo get_site_option( 'network_max_flow' ) ?>MB)
			</td>
		</tr>
<?php
	}

	function update_site_setting(){
		if( !isset($_POST['site_max_flow']) )
			return;

		$site_max_flow = (int)trim($_POST['site_max_flow']);

		if( $site_max_flow < 0 )
			return;

		update_option( 'site_max_flow', $site_max_flow );

		return;
	}

	// function load_widget(){
	// 	if( current_user_can('manage_options') ){
	// 		$site_max_flow = get_option('site_max_flow');
	// 		$sum = self::get_current_flow_num();
	// 		$widget_title = '本月当前总流量:'.$sum.'MB(站点流量限制:'.$site_max_flow.'MB)'; 
	// 		wp_add_dashboard_widget( 'site_max_flow_widget', $widget_title, array( 'StacktechSiteStat','add_widget' ) );
	// 	}
	// }

	// function add_widget(){
	// 	$results = self::get_current_flow();
	// 	echo 'hello<pre>';print_r($results);
	// }

	function get_current_flow(){
		global $wpdb,$blog_id;

		$query = "select * from stacktech_stat_record where blog_id=".$blog_id." and time between '".date('Y-m-1')."' and '".date('Y-m-d')."'";

		$results = $wpdb->get_results($query,'ARRAY_A');

		return $results;
	}

	function get_current_flow_num(){
		global $wpdb,$blog_id;

		$query = "select sum(flow) from stacktech_stat_record where blog_id=".$blog_id." and time between '".date('Y-m-1')."' and '".date('Y-m-d')."'";

		$sum = $wpdb->get_var($query);
		if( empty($sum) )
			$sum = 0;

		return $sum;
	}

	// function add_dashboard_count( $items = array() )
	// {
	// 	/* Skip */
 //        if ( ! current_user_can('manage_options') ) {
 //            return $items;
 //        }

 //        $site_max_flow = get_option('site_max_flow');
 //        if( empty($site_max_flow) ){
	// 		$site_max_flow = get_site_option( 'network_max_flow' );
	// 		if( empty($site_max_flow) )
	// 			return;
	// 	}

	// 	$sum = self::get_current_flow_num();
	// 	$per = round($sum*100/$site_max_flow);
	// 	$left = $site_max_flow-$sum;
	// 	if($per>100){
	// 		$per = 100;
	// 		$left = 0;
	// 	}

	// 	/* Right now item */
	// 	$items[] = sprintf(
	// 		'<a href="%s" class="cachify-icon cachify-icon--hdd" title="%s" target="_blank">%s</a>',
	// 		add_query_arg(
	// 			array(
	// 				'page' => 'bandwidth'
	// 			),
	// 			admin_url()
	// 		),
	// 		'本月流量:'.$sum.'MB(剩余'.$left.'MB)',
	// 		$sum.'MB('.$per.'%)流量'
	// 	);

	// 	return $items;
	// }

	function bandwidth_page(){
		wp_enqueue_script( 'stacktech-site-stat-script', plugin_dir_url( __FILE__ ) . 'echarts.min.js' );
		$site_max_flow = get_option('site_max_flow');
		if( empty($site_max_flow) ){
			$site_max_flow = get_site_option( 'network_max_flow' );
			if( empty($site_max_flow) )
				return;
		}


		$sum = self::get_current_flow_num();
		$per = round($sum*100/$site_max_flow,2);
		$left = $site_max_flow-$sum;
		if($per>100){
			$per = 100;
			$left = 0;
		}

		$results = self::get_current_flow();
		$flow_data = array();
		$max_flow = 0;
		foreach ($results as $item) {
			$key = date('d',strtotime($item['time']));
			$flow_data[$key] = $item['flow'];
			if( $item['flow'] >= $max_flow )
				$max_flow = $item['flow'];
		}
		$max_flow = ceil($max_flow);

		//echo '<pre>';print_r($flow_data);exit();
		$date_arr = array();
		$flow_data_arr = array();

		for ($i=1; $i <= date('d'); $i++) { 
			if($i<10){
				$t = '0'.$i;
				
			}else{
				$t = $i;
			}

			$date_arr[] = $t;
			if( !array_key_exists($t, $flow_data) ){
				$flow_data_arr[] = 0;
			}else{
				$flow_data_arr[] = $flow_data[$t];
			}
		}
		$date_arr = implode(',', $date_arr);
		$flow_data_arr = implode(',', $flow_data_arr);

		//echo 'hello<pre>';print_r($flow_data_arr);exit();
?>
		<div id="left" style="width: 100%;height:400px;"></div>
		<div id="right" style="width: 100%;height:500px;"></div>
		<script type="text/javascript">
		// 基于准备好的dom，初始化echarts实例
		jQuery(document).ready(function() { 
			var myChart = echarts.init(document.getElementById('left'));
			var date1 = new Date();
			var month = date1.getMonth()+1;
			option = {
				title : {
			        text: '本月流量图('+month+'月)',
			        x: 'center'
			    },
			    tooltip : {
			        formatter: "{a} <br/>{b} : {c}%"
			    },
			    toolbox: {
			        show : true,
			        feature : {
			            //mark : {show: true},
			            //restore : {show: true},
			            saveAsImage : {show: true}
			        }
			    },
			    series : [
			        {
			            name:'当月流量',
			            type:'gauge',
			            detail : {formatter:'{value}%'},
			            data:[{value: 50, name: '当月流量使用率'}]
			        }
			    ]
			};

	    	option.series[0].data[0].value = <?php echo $per; ?>;
	    	myChart.setOption(option);

	    	var timeData = [<?php echo $date_arr;?>];

			var myChart2 = echarts.init(document.getElementById('right'));
			option2 = {
			    title : {
			        text: '本月流量图('+month+'月) 已使用<?php echo $sum; ?>MB(剩余<?php echo $left; ?>MB)',
			        x: 'center'
			    },
			    tooltip : {
			        // trigger: 'axis',
			        // formatter: function(params) {
			        //     return params[0].name + '<br/>'
			        //         + params[0].seriesName + ' : ' + params[0].value + ' (m^3/s)<br/>';
			        // },
			        // axisPointer: {
			        //     animation: false
			        // }
			    },
			    toolbox: {
			        show : true,
			        feature : {
			            saveAsImage : {show: true}
			        }
			    },
			    legend: {
			        data:['流量'],
			        x: 'left'
			    },
			    // dataZoom: [
			    //     {
			    //         show: true,
			    //         realtime: true,
			    //         start: 30,
			    //         end: 70,
			    //         //xAxisIndex: [0, 1]
			    //     }
			    // ],
			    grid: [{
			        left: 50,
			        right: 50,
			        height: '35%'
			    }],
			    xAxis : [
			        {
			            type : 'category',
			            axisLabel : {
			                formatter: '{value}日'
			            },
			            boundaryGap : false,
			            //axisLine: {onZero: true},
			            data: timeData
			        }
			    ],
			    yAxis : [
			        {
			            name : '流量(MB)',
			            type : 'value',
			            max : <?php echo $max_flow; ?>
			        }
			    ],
			    series : [
			        {
			            name:'流量',
			            type:'line',
			            smooth:true,
			            // symbolSize: 8,
			            // itemStyle: {
			            //     emphasis: {
			            //     }
			            // },
			            //hoverAnimation: false,
			            data:[<?php echo $flow_data_arr;?>]
			        },
			    ]
			};

			myChart2.setOption(option2);
		}); 
		</script>
<?php		
	}

	function add_pages(){
		add_submenu_page( null, __('网站流量'), __('网站流量'), 'manage_options','bandwidth' ,array('StacktechSiteStat', 'bandwidth_page') );
	}

	function add_dashboard_meta(){
		/* Skip */
        if ( ! current_user_can('manage_options') ) {
            return $items;
        }

        $site_max_flow = get_option('site_max_flow');
        if( empty($site_max_flow) ){
			$site_max_flow = get_site_option( 'network_max_flow' );
			if( empty($site_max_flow) )
				return;
		}

		$sum = self::get_current_flow_num();
		$per = round($sum*100/$site_max_flow);
		if($per>100){
			$per = 100;
		}
?>
		<h4 class="mu-storage">网站流量</h4>
		<div class="mu-storage">
		<ul>
			<li class="post-count">
				<a href="<?php echo admin_url('?page=bandwidth');?>" target="_blank" title="网站流量">允许使用<?php echo $site_max_flow;?> MB流量</a>		
			</li>
			<li class="post-count">
				<a href="<?php echo admin_url('?page=bandwidth');?>" target="_blank" title="使用流量">已用<?php echo $sum;?>MB（<?php echo $per;?>%）流量</a>		
			</li>
		</ul>
		</div>
<?php
	}


	function edit_site_table_list_column($list){
		$list['site_stat'] = '网站流量(MB)';
		return $list;
	}

	function edit_site_table_list_column_sort($columns){
		$columns['site_stat'] = 'site_stat';
		return $columns;
	}

	function column_site_stat( $column_name,$blog_id ) {
		if ( $column_name != 'site_stat' ) {
            return;
        }

		switch_to_blog( $blog_id );

		$site_max_flow = get_option('site_max_flow');
        if( empty($site_max_flow) ){
			$site_max_flow = get_site_option( 'network_max_flow' );
			if( empty($site_max_flow) )
				$site_max_flow = 0;
		}

		$sum = self::get_current_flow_num();

		// $left = $site_max_flow-$sum;
		// if($per>100){
		// 	$left = 0;
		// }		
		echo $sum.' (限制流量 '.$site_max_flow.')';

		restore_current_blog();
	}
}
add_action('admin_menu', array( 'StacktechSiteStat', 'add_pages' ) );

register_activation_hook( __FILE__, array( 'StacktechSiteStat', 'plugin_activation' ) );
add_action( 'template_redirect', array('StacktechSiteStat' ,'load_script') );

add_action( 'wpmu_options', array('StacktechSiteStat' ,'add_network_setting') );
add_action( 'update_wpmu_options', array('StacktechSiteStat' ,'update_network_setting') );

add_action( 'wpmueditblogaction', array('StacktechSiteStat' ,'add_site_setting') ,100 ,1 );
add_action( 'wpmu_update_blog_options', array('StacktechSiteStat' ,'update_site_setting') );
//add_action( 'wp_dashboard_setup', array( 'StacktechSiteStat','load_widget' ) );
//add_filter(	'dashboard_glance_items', array( 'StacktechSiteStat','add_dashboard_count' ) );

add_action( 'activity_box_end' ,array( 'StacktechSiteStat','add_dashboard_meta' ) );
add_filter( 'wpmu_blogs_columns', array('StacktechSiteStat','edit_site_table_list_column') );
//add_filter( 'manage_sites-network_sortable_columns', array('StacktechSiteStat','edit_site_table_list_column_sort') );
add_action( 'manage_sites_custom_column', array( 'StacktechSiteStat','column_site_stat' ),20,2 );