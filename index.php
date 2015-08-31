<?php 
/*
Plugin Name: formtracker
Plugin URI: wordpress url
Description: tracks when a form has been completed and writes it to the db
Author: Lee Zerafa
Version: 1.0
Author URI: nothing.net
*/

class formtracker {

	private $wpdb;

	public function __construct($to, $subject, $headers){
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->to = $to;
		$this->subject = $subject;
		$this->headers = $headers;
		$this->tableName = $this->wpdb->base_prefix.'formtracker';
	}

	protected function checkTableExists(){
		if($this->wpdb->get_var("SHOW TABLES LIKE '$this->tableName'") == $this->tableName){
			return true;
		}
		else{
			return false;
		}
	}

	protected function makeTable(){
		$charset_collate = $this->wpdb->get_charset_collate();
		$sql = "CREATE TABLE $this->tableName (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			recipient varchar(255),
			subject varchar(255),
			headers text,
			time TIMESTAMP,
			UNIQUE KEY id (id)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	public function insertintoDB(){
		if($this->checkTableExists() == false){
			print_r('test');
			$this->makeTable();
		}
		
		$this->wpdb->insert(
			$this->tableName,
			array(
				'recipient'=>$this->to,
				'subject'=>$this->subject,
				'headers'=>$this->headers
			)
		);
		

	}

}







 ?>