<?php

/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    simple_contact_forms
 * @subpackage simple_contact_forms/admin/views
 */

?>

<h2>Simple Contact Forms</h2>
<p class="inner">This plugin is designed to strip all the faff so you can drop in contact forms where you want and how you want.</p>

<?php

// Find the tab
$tab = isset ( $_GET['tab'] ) ? $_GET['tab'] : 'settings';

// Create the tabs
scf_admin_tabs($tab); 

// Load the options
include( plugin_dir_path( __FILE__ ) . "../partials/scf_options.php" );
$options = new SCFOptions();
if( !empty($_POST) ) $options->set();
$vals = $options->get();

?>

<!-- The sidebar description -->
<div class="settings-holder">


	<div class="credits-box">
		<h3 class="hndle">Simple Contact Forms v1.0.1</h3>
		<div class="inside">

			<h4 class="inner">How to use Simple Contact Forms</h4>
			<p class="inner">The contact form can be displayed on your site in three ways:</p>
			<p class="inner">
				1. Shortcode<br />
				2. Function<br />
				3. Widget
			</p>
			<p class="inner">All methods accept options to change some of the default settings.</p>

			<h4 class="inner">Using the shortcode</h4>
			<p class="inner"><em>[simple_contact_form]</em></p>

			<h4 class="inner">Using the PHP Function</h4>
			<p class="inner"><em>simple_contact_form($options = array());</em></p>

			<h4 class="inner">Options</h4>
			<ul class="inner">
				<li><strong>width: </strong><em>String</em> (full-width|narrow)</li>
				<li><strong>button: </strong><em>Boolean</em></li>
				<li><strong>btn_text: </strong><em>String</em></li>
				<li><strong>form_title: </strong><em>String</em></li>
				<li><strong>form_collapse: </strong><em>Boolean</em></li>
				<li><strong>email_subject: </strong><em>String</em></li>
				<li><strong>form_title: </strong><em>String</em></li>
				<li><strong>return: </strong><em>Boolean</em> (echoes if false)</li>
			</ul>

			<p class="inner"><a href="https://github.com/owenr88/Simple-Contact-Forms" target="_blank">View the GitHub page for more uses and options.</a></p>
			<hr>

			<h4 class="inner">Need support?</h4>
			<p class="inner">If you are having problems with this plugin, please talk about them in the <a href="#" target="_blank" title="Support forum">Support forum</a></p>
			
			<hr>
			<h4 class="inner">Do you like this plugin?</h4>
				<p class="inner"><a href="http://wordpress.org/support/view/plugin-reviews/simple-contact-forms" target="_blank" title="Rate it 5">Rate it 5</a> on WordPress.org <br>
			</p>    
			<hr>

			<p class="df-link inner">Created by <a href="http://www.biglemoncreative.co.uk" target="_blank" title="Big Lemon Creative">Big Lemon Creative</a></p>

		</div>
	</div>

	<?php 

	// Go to the right page
	include ( 'admin-page-' . $tab . '.php' );

	?>

</div>