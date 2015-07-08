<?php

class scf_Content {



	public $emailContent;
	public $pageContent;
	private $successMessageReady;
	private $SERVER_URL;



	/* 
	 * Constructor functions
	 */
	public function __construct() {

		// Do anything first
		$this->successMessageReady = false;
		$this->SERVER_URL = 'http://www.google.com/recaptcha/api';

	}



	/* 
	 * Constructor functions
	 */
	public function setVendors($options) {

		// Does it need bootstrap
		if( $options['include_bootstrap'] == 'true' ) {

			// Include Bootstrap styles
			wp_enqueue_style('scf_bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css');

			// Include Bootstrap scripts
			wp_enqueue_script('scf_bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js');

		}

		// Does it need FontAwesome?
		if( $options['include_fontawesome'] == 'true' ) {

			// Include FontAwesome styles
			wp_enqueue_style('scf_fontawesome-css', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');

		}

	}



	/* 
	 * Add the form to the page content
	 */
	public function addForm($options = array(), $fields = array(), $errors = array(), $isresp = false, $formcompleted = false) {

		// Return false if the success message has already been created - we don't need the form!
		if( $this->successMessageReady ) return false;

		// Open the wrapping divs
	    $content = '<div id="colform" class="bs-component collapse' . ($options['form_collapsed'] == true ? '' : ' in' ) . '">';

		    // Open the row
		    $content .= '<div class="row">';

		    	// Print out the errors if there are any
		        foreach($errors as $error) {

		        	// Add the error to the content
		        	$this->addToPageContent('<div class="alert alert-danger" role="alert">'.$error.'</div>');

		        }

		        // Set the styling div around the form
		        $content .= '<div class="'.( $options['form_styling'] != "full-width" ? "col-sm-6 col-sm-offset-3" : "col-xs-12" ).'">';

		        	// Set the form title
		        	$content .= '<h2 class="text-center">'.$options['form_title'].'</h2><br>';

		        	// Open the actual form
		            $content .= '<form class="form-horizontal" name="simple_contact_form" method="post" action="'.$options['send_to_url'].'" id="form-holder" onsubmit="return validateForm()" >';

		            	// Start outputting each field
		                foreach($fields as $item) {

		                	// Continue the loop if 'exclude' is selected
		                	if($item['exclude']) continue;

		                	// Start each field off with a default wrapper and check if it's required
		                    $content .= '<div class="'.($item['required'] ? 'validation' : '').' '.$item['slug'].' '.$options['column_class'].'">';

		                    	// Open the row for each field
		                    	$content .= '<div class="row">';

		                    		// Open the form group
		                    		$content .= '<div class="form-group">';

		                    			// Check if the field is a checkbox and if it uses labels
					                    if($options['labels'] && $item['type'] != 'checkbox') {

					                    	// Set the label
					                        $content .= '<label class="row-item col-md-3" for="'.$item['slug'].'"><span>'.$item['title'].($item['required'] ? ' *' : '').'</span></label>';

					                        // Set the next classes and offsets
					                        $nextclass = 'col-md-9';
					                        $offset = 'col-md-offset-3';

					                    } else {

					                    	// Check if the field is a selectbox
					                        if($item['type'] == 'select') {

					                        	// Open the label
					                            $content .= '<label class="row-item col-md-12" for="'.$item['slug'].'"><span>'.$item['title'].($item['required'] ? ' *' : '').'</span></label>';

					                        } else {

					                        	// Set the next class
					                            $nextclass = 'col-md-12';

					                        }

					                    };

					                    // Are we using placeholders, precious?
					                    $placeholder = ($options['placeholders'] ? ' placeholder="'.$item['title'].($item['required'] ? ' *' : '').'"' : '');

					                    // Is the type a checkbox? Set it's field with a label
					                    if($item['type'] == 'checkbox') {

					                        $content .= '<div class="row-item">';

					                        	$content .= '<label class="row-item '.$nextclass.' '.$offset.' checkbox" for="'.$item['slug'].'">';

					                        		$content .= '<input name="'.$item['slug'].'" id="'.$item['slug'].'" type="checkbox" value="Yes" checked="'.$item['value'].'">';

				                        			$content .= '<span>'.$item['title'].($item['required'] ? ' *' : '').'</span>';

			                        			$content .= '</label>';

		                        			$content .= '</div>';

					                    };

					                    // Open the row item
					                    $content .= '<div class="row-item '.$nextclass.'">';

					                    	// Check what type this is and output the field
				                            if($item['type'] == 'text' || $item['type'] == 'email' || $item['type'] == 'name') {

				                            	// Set this as a text box
				                                $content .= '<input name="'.$item['slug'].'" id="'.$item['slug'].'" class="form-control" type="text" value="'.$item['value'].'"'.$placeholder.'>';

				                            } else if($item['type'] == 'textarea') {

				                            	// Set this as a textarea
				                                $content .= '<textarea name="'.$item['slug'].'" id="'.$item['slug'].'" class="form-control" '.$placeholder.'>'.$item['value'].'</textarea>';

				                            } else if($item['type'] == 'select') {

				                            	// Set this as a select box
				                                $content .= '<select name="'.$item['slug'].'" id="'.$item['slug'].'" class="form-control">';

				                                	// Cycle through each option for the select box
				                                    foreach($item['options'] as $opt) {

				                                		// Add the option to the select box
				                                        $content .= '<option value="'.sanitize_title($opt).'">'.$opt.'</option>';

				                                    }

			                                    // Close the select box
				                                $content .= '</select>';

				                            };

			                            // Close the row item
				                        $content .= '</div>';

				                        // Clear any floats
				                        $content .= '<div class="clearfix"></div>';

			                        // Close the form group
				                    $content .= '</div>';

			                    // Close the row
			                    $content .= '</div>';

		                    // Close the field wrapper
		                    $content .= '</div>';

		                };

		                // Check if we need recaptcha. Maths is already added as a field if it's selected.
		                if($options['validation'] == 'recaptcha') {

		                	// Open the validation wrapper
		                    $content .= '<div class="' . $options['column_class'] . '">';

		                    	// Open the row item
		                    	$content .= '<div id="row-item" class="form-group">';

		                    		// Open the row
		                    		$content .= '<div class="row">';

		                    			// Set the content
		                    			$content .= '<div class="'.$nextclass.' '.$offset.'">'.$this->recaptchacontent($options).'</div>';

	                    			// Close the row
	                    			$content .= '</div>';

	            				// Close the row item
	                			$content .= '</div>';

	        				// Close the validation wrapper
	            			$content .= '</div>';
		                
		                };

		                // Clear the floating for the form so far
		                $content .= '<div class="clearfix"></div>';

		                // Add the hidden items and submit page. Opening the form group
		                $content .= '<div class="form-group">';

	                		// Open the row
	                		$content .= '<div class="row">';

			                	// Opening the column
			                    $content .= '<div class="col-md-6 col-md-offset-3">';

			                		// Set the previous page hidden input
			                        $content .= '<input type="hidden" name="prevpage" value="'.get_permalink().'">';

			                		// Set the email subject hidden input
			                        $content .= '<input type="hidden" name="email_subject" value="'.$options['email_subject'].'">';

			                		// Set the form title hidden input
			                        $content .= '<input type="hidden" name="form_title" value="'.htmlentities($options['form_title']).'">';

			                		// Set the submit button
			                        $content .= '<button type="submit" class="btn btn-primary btn-block">Submit</button>';

		                        // Close the column
			                	$content .= '</div>';

			                	// Clear the floats
			                	$content .= '<div class="clearfix"></div>';

	                		// Close the row
			            	$content .= '</div>';

		            	// Close the form group
		            	$content .= '</div>';

	            	// Close the form
		            $content .= '</form>';

	            // Close the form wrapper
		        $content .= '</div>';

		        // Clear the floats
		        $content .= '<div class="clearfix"></div>';

	        // Close the row
		    $content .= '</div>';

	    // Close the wrapping div
	    $content .= '</div>';

		// Send this content to the page content to be executed
    	$this->addToPageContent($content);
		
	}



	/* 
	 * Add the button to the page content
	 */
	public function addButton($options = array()) {

		// Return false if the success message has already been created
		if( $this->successMessageReady ) return false;

	    // Check if it needs a url to link to or if it collapses
	    if($options['form']) {
	    	$actions = 'data-toggle="collapse" data-target="#colform" href="javascript:void(0);"';
	    } else {
	    	$actions = 'href="'.$options['send_to_url'].'"';
	    }


    	$content = '<a class="btn btn-primary btn-block" '. $actions .'>';

		    // Set the button contents
		    $content .= $options['btn_text'];

		    // Check if the button has a side icon. Set the side and icon if so.
		    if($options['btn_icon_side'] != "none") {
		    	$content .= '<i class="fa '.$options['btn_icon_type'].' pull-'.$options['btn_icon_side'].'"></i>';
		    }

	    $content .= '</a>';

		// Send this content to the page content to be executed
	    $this->addToPageContent($content);


	}



	/* 
	 * Create the validation script for required items
	 */
	public function addValidationScript($items) {
	    $script = '<script>
	        function validateForm() {

	            var submit = true,
	            	$ = jQuery,
	            	form = document.forms["simple_contact_form"];';

	            foreach($items as $item) {
	                if( isset($item['required']) && $item['required'] == true && isset($item['slug']) ) {
	                    $script .= '
	                    $(".validation.'.$item['slug'].'").removeClass( "has-error" );
	                    if (form["'.$item['slug'].'"].value == "") {
	                    	console.log("'.$item['slug'].'", form["'.$item['slug'].'"].value)
	                        $(".validation.'.$item['slug'].'").addClass( "has-error" );
	                        submit = false;
	                    }';
	                };
	            };
	            $script .= '

	            return submit;
	        };
	    </script>
	    ';
	    $this->addToPageContent($script);
	}



	/* 
	 * Create the validation script for required items
	 */
	private function recaptchacontent($options) {
	    $return = '<div class="panel panel-default">
	            <div class="panel-heading">
	              <h3>reCAPTCHA (are you human?)</h3>
	            </div>
	            <div class="panel-body">
	              <form role="form">
	                <div class="">
	                    <div class="captcha">

	                      <div id="recaptcha_image"></div>
	                    </div>
	                </div>
	                <div class="">
	                      <div class="recaptcha_only_if_image">Enter the words above</div>
	                      <div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
	                    <div class="input-group">
	                              <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="form-control input-lg" />
	                              <a class="btn btn-default input-group-addon" href="javascript:Recaptcha.reload()"><span class="glyphicon glyphicon-refresh"></span></a>
	                              <a class="btn btn-default input-group-addon recaptcha_only_if_image" href="javascript:Recaptcha.switch_type(\'audio\')"><span class="glyphicon glyphicon-volume-up"></span></a>
	                              <a class="btn btn-default input-group-addon recaptcha_only_if_audio" href="javascript:Recaptcha.switch_type(\'image\')"><span class="glyphicon glyphicon-picture"></span></a>
	                              <a class="btn btn-default input-group-addon" href="javascript:Recaptcha.showhelp()"><span class="glyphicon glyphicon-info-sign"></span></a>
	                          </div>';
	                        $return .= "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";
	                        $return .= $this->generateRecaptcha($options);
	                $return .= '</div>
	              </div>
	            </div>';
	    return $return;
	}



	/* 
	 * Generate the reCAPTCHA scripts
	 */
	private function generateRecaptcha ($options) {   

		var_dump($options);       
		return '<script type="text/javascript" src="'. $this->SERVER_URL . '/challenge?k=' . $options['public_key'] . '"></script><noscript>
			<iframe src="'. $this->SERVER_URL . '/noscript?k=' . $options['public_key']  . '" height="300" width="500" frameborder="0"></iframe><br/>
			<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
			<input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
			</noscript>';
	}



	/* 
	 * Add the success message to the content
	 */
	public function addSuccessMessage($options) {

		// Let the other bits know the form is successful
		$this->successMessageReady = true;

		// Add the success message to the content
		$this->addToPageContent($options['success_msg']);

	}



	/* 
	 * Add content to the page body
	 */
	public function addToPageContent($content) {

		// Add the new content to the overall page content
		$this->pageContent .= $content;

	}
	


} 

?>