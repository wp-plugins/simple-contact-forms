<?php

class SCFOptions {


	private $options;
	private $fields;
	private $defaultFields;
	

	function __construct() {

		$this->options = array();

		$this->fields = array(
			'form' 					=> true ,
			'send_to' 				=> '' ,
			'form_title' 			=> 'Enquire now!' ,
			'email_subject' 		=> 'Website Enquiry' ,
			'email_recipients'		=> get_bloginfo('admin_email'),
			'form_styling' 			=> 'bootstrap' ,
			'include_bootstrap' 	=> false ,
			'include_fontawesome' 	=> false ,
			'submit_class' 			=> 'btn-primary' ,
			'success_msg' 			=> '<h2 style="text-align: center;">Thanks for completing the form!</h2><p>We will be in touch shortly.</p>' ,
			'validation_enable' 	=> true ,
			'validation'			=> 'maths' ,
			'display_button' 		=> false ,
			'default_collapse'		=> false ,
			'button_text'			=> 'Get in touch!' ,
			'button_class'			=> 'btn-primary' ,
			'button_icon_side'		=> 'left' ,
			'button_icon'			=> 'fa-comments' ,
			'recaptcha_public'		=> '' ,
			'recaptcha_private'		=> '' ,
		);

		$this->defaultFields = array(
    		'1' => array(
	            'label' => 'Email Address',
	            'type' => 'email',
	            'options' => array(),
	            'required' => 1,
	            'exclude' => false
        	),
		    '2' => array(
	            'label' => 'Enquiry',
	            'type' => 'textarea',
	            'options' => array(),
	            'required' => 1,
	            'exclude' => false
	        )
		);

	}



	private function getif($slug = '', $default = '') {

		if(!get_option( 'scf_' . $slug )) {

			// Set the value for the very first time
			update_option('scf_' . $slug, $default);

		};

		// Get the option from the database
		return get_option( 'scf_' . $slug , $default );

	}



	private function updateif($slug = '', $default = '') {

		// Check if it's been submitted and pass the value or the default (if the field has been removed for some reason)
		$newval = (isset($_POST[$slug]) ? $_POST[$slug] : $default);

		// Make sure it's a valid input and do the checking and setting
		if( array_key_exists($slug, $this->fields) && $newval != $this->getif($slug) && isset($_POST[$slug])) {
			
			update_option('scf_' . $slug, stripslashes(wp_filter_post_kses(addslashes($newval))) );
		}

	}



	public function delete() {

		// For each field above
		foreach($this->fields as $field => $default) {

			delete_option('scf_' . $field);

		};

		// Delete the fields
		delete_option('scf_table_fields');

	}



	public function set() {

		// Set each field that comes back
		foreach($this->fields as $field => $default) {

			$this->updateif($field, $default);

		};

		// Check if the fields were submitted in the form
		if(isset($_POST['fields'])) {

			$fields = array();
			$r = 1;

			// Set the table array
			foreach($_POST['fields'] as $field) {

				$fields[$r]['label'] = $field['label'];

				$fields[$r]['type'] = $field['type'];
				
				$fields[$r]['options'] = (isset($field['options']) ? $field['options'] : array() );
				
				$fields[$r]['required'] = (isset($field['required']) ? true : false);
				
				$fields[$r]['exclude'] = (isset($field['exclude']) ? true : false);

				$r++;

			}

			// Add the table fields to the database
			if( isset($fields) ) {

				update_option('scf_table_fields', maybe_serialize($fields) );

			}

		}

	}



	public function get() {

		// Get each option
		foreach($this->fields as $field => $default) {

			$this->options[$field] = $this->getif( $field, $default );

		}

		// Set the fields if it's the first time
		if( !$this->getif('table_fields') ) {

			update_option('scf_table_fields', maybe_serialize($this->defaultFields) );

		}
			
		// Get the fields
		$this->options['fields'] = maybe_unserialize( $this->getif('table_fields') );

		return $this->options;

	}

	

}