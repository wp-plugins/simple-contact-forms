<?php

class SCF_Data_Management {

	private $table;
	private $db_verison;

	function __construct() {

		$this->db_version = '1.0';

		$this->table = $wpdb->prefix . "scf_completions"; 

	    global $wpdb;

	}

	private function createTable () {

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $this->table (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  form_id tinytext NOT NULL,
		  data text NOT NULL,
		  url varchar(55) DEFAULT '' NOT NULL,
		  UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

        // Update the option in the database
        update_option( 'scf_db_version', $this->db_version );

	}

	public function deleteTable () {

		// Delete the table

	}

	public function db_check() {

		// Check if the database version matches the one here
	    if ( get_option( 'scf_db_version', '' ) != $this->db_version ) {

	    	// Update the database
	        $this->createTable();

	    }

	}

	public function getData () {

		// Return the data

	}

	public function insertRow ($data = array(), $form_id = 0) {

		// Check the database version and update if needed
		$this->db_check();

		// Insert the row
		$wpdb->insert( 
			$this->table, 
			array( 
				'time' 		=> current_time( 'mysql' ), 
				'form_id' 	=> $form_id, 
				'data' 		=> maybe_serialize($data), 
				'url'		=> get_bloginfo('url') . '/' . $_SERVER[REQUEST_URI],
			) 
		);

	}

}