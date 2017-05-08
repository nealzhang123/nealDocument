<?php   
/*
Plugin Name: cm leave message
Version: 1.0
Author: sherlock
License: GPL
*/
class CM_Message {

	//插件激活时候，建立相关数据表
    function plugin_activation() {
    	global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
    	
		//hos_type 出生队列为1,产前队列为2
		$sql = "CREATE TABLE " . $wpdb->prefix . "cm_message (
			id int(11) NOT NULL AUTO_INCREMENT,
			user_name varchar(50),
			user_email varchar(50),
			user_phone varchar(30),
			user_message text,
			public_date datetime,

			PRIMARY KEY  (id)
		)";

		dbDelta( $sql );
    }

    //列表顯示消息
    function message_list() {
    	$list = new CM_Message_Table();

    	echo '<div class="wrap"><h2>消息列表</h2>'; 

		$list->prepare_items(); 
		$list->display(); 

		echo '</div>'; 
    }
}


add_action( 'admin_menu', 'cm_message_track' );

register_activation_hook( __FILE__, array( 'CM_Message', 'plugin_activation' ) );

function cm_message_track() {  
	$plugin = new CM_Message;

    add_menu_page( __('消息管理'), __('消息管理'), "manage_options", 'cm_message', array( $plugin, 'message_list' ), 'dashicons-welcome-view-site' );
}

include_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class CM_Message_Table extends WP_List_Table {
	function get_columns(){
		$columns = array(
			//'cb' => '<input type="checkbox" />',
			'user_name' => 'Name',
			'user_email' => 'Email',
			'user_phone' => 'Phone',
			'user_message' => 'Message',
			'public_date' => 'Date',
		);
  		return $columns;
	}

	// function get_total_items() {
	// 	global $wpdb;

	// 	$table = $wpdb->prefix . 'cm_message';

	// 	$sql = 'SELECT count(*) FROM ' . $table;

	// 	$count = $wpdb->get_var( $sql );

	// 	return $count;
	// }

	// function get_current_items() {
	// 	global $wpdb;

	// 	$table = $wpdb->prefix . 'cm_message';
		
	// 	$sql = 'SELECT * FROM ' . $table;
        
 //        $current_page = 0;
 //        if( isset( $_GET['paged'] ) && is_numeric( $_GET['paged'] ) ) {
 //            $current_page = $_GET['paged']-1;
 //        }

 //        $per_page = 5;

 //        $start = $per_page * $current_page;

 //        $sql .= ' ORDER BY public_date DESC';
 //        $sql .= ' LIMIT ' . $start . ',' . $per_page;
 //        //echo $sql;

	// 	$results = $wpdb->get_results( $sql, 'ARRAY_A' );
	// 	echo '<pre>hehe';print_r($results);echo '</pre>';

	// 	return $results;
	// }
	
	function prepare_items() {
		global $wpdb;

		$table = $wpdb->prefix . 'cm_message';
		
		$sql = 'SELECT * FROM ' . $table;
        
        $current_page = 0;
        if( isset( $_GET['paged'] ) && is_numeric( $_GET['paged'] ) ) {
            $current_page = $_GET['paged']-1;
        }

        $per_page = 5;

        $start = $per_page * $current_page;

        $sql .= ' ORDER BY public_date DESC';
        $sql .= ' LIMIT ' . $start . ',' . $per_page;
        //echo $sql;

		$current_items = $wpdb->get_results( $sql, 'ARRAY_A' );

		$sql = 'SELECT count(*) FROM ' . $table;
		$total_items = $wpdb->get_var( $sql );


		$per_page = 5;
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = array();

		$this->_column_headers = array($columns, $hidden, $sortable);

		$this->example_data = $current_items;

		$this->total_items = $total_items;

		$this->set_pagination_args( array(
		    'total_items' => $total_items,
		    'per_page'    => $per_page
		  ) );

		//echo '<pre>test';print_r($this->example_data);echo '</pre>';

		$this->items = $current_items;
	}

	function column_default( $item, $column_name ) {
		switch( $column_name ) { 
			case 'user_name':
			case 'user_email':
			case 'user_phone':
			case 'user_message':
			case 'public_date':
			    return $item[ $column_name ];
			default:
			    return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
		}
	}

	// function get_bulk_actions() {
	// 	$actions = array(
	// 		'delete'    => 'Delete'
	// 	);

	// 	return $actions;
	// }

	// function column_cb($item) {
 //        return sprintf(
 //            '<input type="checkbox" name="book[]" value="%s" />', $item['ID']
 //        );    
 //    }


}