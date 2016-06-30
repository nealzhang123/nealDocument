<?php
/**
* 
*/
class VerifyUserinfoDb {
	private $vfu_wb;
	private $userinfo_table;
	private $history_table;
	
	function __construct(){
		$this->vfu_wb = new wpdb( DB_USER_USERINFO, DB_PASSWORD_USERINFO, DB_NAME_USERINFO, DB_HOST_USERINFO );
		$this->userinfo_table = 'stacktech_verify_userinfo';
		$this->history_table = 'stacktech_verify_history';
	}

	public function get_userinfo_meta($user_id,$meta){

		$meta_value = $this->vfu_wb->get_var( $this->vfu_wb->prepare("SELECT " . $meta . " FROM " . $this->userinfo_table . " WHERE user_id = %d" ,$user_id) );
		return $meta_value;
	}

	public function get_userinfos( $per_page = 10 ,$page = 1 ) {

		$sql = "SELECT * FROM " . $this->userinfo_table;

		if ( !empty( $_REQUEST['orderby'] ) ) {
			$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
			$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}else{
			$sql .= ' ORDER BY time DESC';
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page - 1 ) * $per_page;

		$result = $this->vfu_wb->get_results( $sql, 'ARRAY_A' );

		return $result;
	}

	public function get_userinfo( $user_id ) {

		$sql = "SELECT * FROM " . $this->userinfo_table . " WHERE user_id=" . $user_id;

		$result = $this->vfu_wb->get_row( $sql, 'ARRAY_A' );

		return $result;
	}

	public function get_userinfos_count() {
		$sql = "SELECT COUNT(*) FROM " . $this->userinfo_table;

		return $this->vfu_wb->get_var( $sql );
	}

	public function verify_table_setup(){
		if($this->vfu_wb->get_var("SHOW TABLES LIKE '" . $this->userinfo_table . "'") == false){
			$type_comment = "COMMENT '0是用户,1是代理,2是开发者,3是代理+开发者'";
			$action_comment = "COMMENT '1是申请代理,2是申请开发者'";
			$sql = "CREATE TABLE " . $this->userinfo_table. "(
	        id bigint(20) AUTO_INCREMENT,
	        user_id bigint(20) NOT NULL,
	        user_email varchar(255) NOT NULL,
	        verify_style varchar(20) NOT NULL,
	        user_type int NOT NULL DEFAULT '0' $type_comment ,
	        user_action int $action_comment,
	        option_value longtext,
	        status varchar(30),
	        reason text,
	        time datetime,
	        PRIMARY KEY  (id)
	        );";

			$this->vfu_wb->query($sql);
		}

		if($this->vfu_wb->get_var("SHOW TABLES LIKE '" . $this->history_table . "'") == false){
			$sql = "CREATE TABLE " . $this->history_table. "(
	        id bigint(20) AUTO_INCREMENT,
	        user_id bigint(20) NOT NULL,
	        user_action int,
	        action varchar(20) NOT NULL,
	        status tinyint(2) NOT NULL DEFAULT '0',
	        reason text,
	        time datetime,
	        PRIMARY KEY  (id)
	        );";

			$this->vfu_wb->query($sql);
		}
	}

	//更新用户申请入数据库
	public function update_userinfo( $user_id, $data ){

		$key = $this->vfu_wb->get_var( $this->vfu_wb->prepare("SELECT id FROM " . $this->userinfo_table . " WHERE user_id = %s", $user_id) );

		if( $key > 0 ) {
			$this->vfu_wb->update( $this->userinfo_table ,$data ,array('user_id'=>$user_id) );
		}else{
			$this->vfu_wb->insert( $this->userinfo_table ,$data );
		}
	}

	//增加管理记录入数据库
	public function insert_history( $data ){
		$this->vfu_wb->insert( $this->history_table ,$data );
	}
}
?>