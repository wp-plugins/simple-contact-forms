<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    simple_contact_forms
 * @subpackage simple_contact_forms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    simple_contact_forms
 * @subpackage simple_contact_forms/public
 * @author     Your Name <email@example.com>
 */
class simple_contact_forms_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $simple_contact_forms    The ID of this plugin.
	 */
	private $simple_contact_forms;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $simple_contact_forms       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $simple_contact_forms, $version ) {

		$this->simple_contact_forms = $simple_contact_forms;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->simple_contact_forms, plugin_dir_url( __FILE__ ) . 'css/simple-contact-forms-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->simple_contact_forms, plugin_dir_url( __FILE__ ) . 'js/simple-contact-forms-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Find out if we need to add the vendor files
	 *
	 * @since    1.0.0
	 */
	public function public_vendors() {
		
		// Include the right file
		include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/classes/content.php';

		// Create the vendor options
		$options = array(
			'include_bootstrap' => get_option('scf_include_bootstrap', false),
			'include_fontawesome' => get_option('scf_include_bootstrap', false),
		);

		// Create the class
		$contentClass = new scf_Content();

		// Enqueue the styles and scripts
		$contentClass->setVendors($options);

		// Destroy the object
		unset($contentClass);

	}

}
