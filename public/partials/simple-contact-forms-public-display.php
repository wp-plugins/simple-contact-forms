<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    simple_contact_forms
 * @subpackage simple_contact_forms/public/partials
 */
?>

<?php 

	// Add the file with the main class
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/classes/formconstructor.php';

	// Create the form constructor class
	$form = new scf_FormConstructor();

	// Start the form constructor class
	$form->init($sc_options);


?>