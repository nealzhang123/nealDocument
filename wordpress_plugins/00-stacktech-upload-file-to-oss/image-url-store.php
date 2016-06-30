<?php 
	/**
	*the table of upload and edit and delete images url from the media
	*/
	class oss_image_url_model{
		public static $instance;
		/**
		*Tables
		*/
		public $upload_url_table;
		public $delete_url_table;
		/**
		*Database charset and collate
		*/

		private $db_charset_collate = '';

		public static function get_instance(){
			if ( empty( self::$instance ) )
				self::$instance = new oss_image_url_model();
			return self::$instance;
		}

		public function __construct(){
			global $wpdb;
			$this->upload_url_table			= $wpdb->get_blog_prefix(1).'oss_image_upload_url';
			$this->delete_url_table			= $wpdb->get_blog_prefix(1).'oss_image_delete_url';
			//$this->upload_url_table				= 'stacktech_image_upload_url';
			//$this->delete_url_table				= 'stacktech_image_delete_url';
			//get the correct character collate
			if ( !empty($wp->charset) )
				$this->db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( !empty($wp->collate))
				$this->db_charset_collate.="COLLATE $wpdb->collate";
		}

		public function create_tables(){
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

			$this->create_image_upload_table();
			$this->create_image_delete_table();
		} 

		public function create_image_upload_table(){
			global $wpdb;

			if($wpdb->get_var("show tables like '$this->upload_url_table'") != $this->upload_url_table) {  //判断表是否已存在
				//0=waitting; 1= processing; 2=finished
				//INDEX [StatusIndex](status(1)),
				$sql = "CREATE TABLE $this->upload_url_table  (
					ID bigint(20) NOT NULL AUTO_INCREMENT,
					upload_date datetime not null default '0000-00-00 00:00:00',
					image_url varchar(100) not null default '',
					status smallint (2) not null default '0',
					UNIQUE KEY ID (ID)
					)  $this->db_charset_collate;";
				dbDelta($sql);
				$sql1 = "CREATE INDEX status_index ON $this->upload_url_table(`status`);";
				error_log($sql1);
				dbDelta($sql1);
			}
		}

		public function create_image_delete_table(){
			global $wpdb;

			if($wpdb->get_var("show tables like '$this->delete_url_table'") != $this->delete_url_table) {  //判断表是否已存在
				// status 0=waitting; 1= processing; 2=finished
				//INDEX [StatusIndex](status(1)),
				$sql = "CREATE TABLE $this->delete_url_table (
					ID bigint(20) NOT NULL AUTO_INCREMENT,
					delete_date datetime not null default '0000-00-00 00:00:00',
					image_url varchar(100) not null default '',
					status smallint (2) not null default '0',
					UNIQUE KEY ID (ID)
					)  $this->db_charset_collate;";
				dbDelta($sql);
				$sql1 = "CREATE INDEX status_index ON $this->delete_url_table(`status`);";
				error_log($sql1);
				dbDelta($sql1);
			}
		}
	}