<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org/plugins/simple-contact-forms/
 * @since             1.0.0
 * @package           simple_contact_forms
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Contact Forms
 * Plugin URI:        https://wordpress.org/plugins/simple-contact-forms/
 * Description:       Designed to strip all the faff so you can insert contact forms where you want and how you want.
 * Version:           1.2.2
 * Author:            Big Lemon Creative
 * Author URI:        http://www.biglemoncreative.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-contact-forms
 * Domain Path:       /languages
 * Requires at least: 3.8
 * Tested up to: 	  4.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-contact-forms-activator.php
 */
function activate_simple_contact_forms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-contact-forms-activator.php';
	simple_contact_forms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-contact-forms-deactivator.php
 */
function deactivate_simple_contact_forms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-contact-forms-deactivator.php';
	simple_contact_forms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_contact_forms' );
register_deactivation_hook( __FILE__, 'deactivate_simple_contact_forms' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-contact-forms.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_contact_forms() {

	$plugin = new simple_contact_forms();
	$plugin->run();

}
run_simple_contact_forms();
