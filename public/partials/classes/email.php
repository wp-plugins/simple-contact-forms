<?php

class scf_Email {



	private $emailcontent;



	/* 
	 * Constructor functions
	 */
	public function __construct() {

		// Do anything first

	}



	/* 
	 * Add content to the email contents
	 */
	public function addToEmailContents($field) {

        // Set email contents from the value (only used if the form is correct and ready to send)
        $this->emailcontent .= $field['title'].': '.$field['value'].'<br />';

	}



	/* 
	 * Send the email
	 */
	public function sendEmail($fields, $options) {

		// Set the subject line
		$subject = $options['email_subject'];

		// Set senders
        $email_recipients = explode(",", trim($options['email_recipients']));
        foreach( $email_recipients as $email ) {
        	$senders[] = array(
        		'email' => $email
    		);
    	};

        // Set the headers
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Determine the from details. Check for name field, then email field, then default to 'Enquirer'
        foreach($fields as $field) {
        	if( $field['type'] == 'name' && isset($field['value']) ) {
        		$sender_name = $field['value'];
        	}
            if( $field['type'] == 'email' && isset($field['value']) ) {
                $sender_email = $field['value'];
            }
        }

        // Set the from details
        $headers .= 'From: ' . (!empty($sender_name) ? $sender_name : 'Enquirer') . ' <' . (!empty($sender_email) ? $sender_email : '') . '>' . "\r\n";;

        // Set the field content
        foreach($fields as $field) {
        	if($field['slug']!=='maths') $this->addToEmailContents($field);
        }

        // Send the email for each sender
        foreach($senders as $sendingemail) {
            mail(
            	$sendingemail['email'], 
            	$subject, 
            	$this->emailcontent, 
            	$headers
        	);
        };

        // Output success message
	}



} 

?>