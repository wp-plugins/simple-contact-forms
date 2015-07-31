<?php

class SCF_Data_Management {

	private $wpdb;
	public $table;
	private $db_verison;

	function __construct() {

	    global $wpdb;
	    $this->wpdb = &$wpdb;

		$this->db_version = '1.3';

		$this->table = $this->wpdb->prefix . "scf_completions"; 

	}

	private function createTable () {

		$charset_collate = $this->wpdb->get_charset_collate();

		$sql = "CREATE TABLE $this->table (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  form_id tinytext NOT NULL,
		  data text NOT NULL,
		  location text NOT NULL,
		  UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

        // Update the option in the database
        update_option( 'scf_db_version', $this->db_version );

	}

	public function deleteTable () {

		// Delete the table
		$this->wpdb->query("DROP TABLE IF EXISTS $this->table");

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
		return $wpdb->get_results( 'SELECT * FROM $this->table WHERE form_id = 0', OBJECT );

	}

	public function insertRow ($data = array(), $form_id = 0) {

		// Check the database version and update if needed
		$this->db_check();

		// Insert the row
		$this->wpdb->insert( 
			$this->table, 
			array( 
				'time' 		=> current_time( 'mysql' ), 
				'form_id' 	=> $form_id, 
				'data' 		=> addslashes($data), 
				'location'	=> $_SERVER['REQUEST_URI'],
			) 
		);

	}

}