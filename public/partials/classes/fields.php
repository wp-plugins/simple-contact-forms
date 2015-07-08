<?php

class scf_Fields {



	/* 
	 * Constructor functions
	 */
	public function __construct() {

		// Do anything first

	}



	/* 
	 * Constructor functions
	 */
	public static function getSCFFields($data = array(), $options = array(), $ignorevalues = false) {

		$i = 0;

		// Make it an empty array if no array is passed.
		if(!is_array($data)) $data = array();

		// Cycle through the fields
	    foreach($data as $item) {

    		// Create a slug
	        $newslug = sanitize_title( $item['label'] );

	        // Set a different slug if it's a name
	        if($newslug === 'name') {
	            $newslug = 'fullname';
	        }

	        // Set the new array
	        $allitemarray[$i] = array(
	            'slug'          => $newslug,
	            'title'         => $item['label'],
	            'required'      => $item['required'],
	            'exclude'       => $item['exclude'],
	            'type'          => $item['type'],
	            'options'       => $item['options'],
	            'value'         => (isset($_POST[$newslug]) && !$ignorevalues ? $_POST[$newslug] : '')
	        );

	        $i++;
	    };

	    // Add the maths field to the array if maths is selected
	    if($options['validation'] == 'maths') {

	    	$allitemarray[] = array(
	            'slug'          => 'maths',
	            'title'			=> '4 + 2 = ? (human check)',
	            'error_title'   => 'Maths',
	            'required'      => true,
	            'exclude'       => false,
	            'type'          => 'text',
	            'options'       => 0,
	            'value'         => (isset($_POST['maths']) && !$ignorevalues ? $_POST['maths'] : ''),
	        );

	    }

	    // Return the final array
	    return $allitemarray;

	}



} 

?>