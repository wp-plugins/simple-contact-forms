<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    simple_contact_forms
 * @subpackage simple_contact_forms/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    simple_contact_forms
 * @subpackage simple_contact_forms/includes
 * @author     Your Name <email@example.com>
 */
class simple_contact_forms {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      simple_contact_forms_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $simple_contact_forms    The string used to uniquely identify this plugin.
	 */
	protected $simple_contact_forms;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->simple_contact_forms = 'simple-contact-forms';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		
        add_shortcode('simple_contact_form', array($this, 'shortcode'));

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - simple_contact_forms_Loader. Orchestrates the hooks of the plugin.
	 * - simple_contact_forms_i18n. Defines internationalization functionality.
	 * - simple_contact_forms_Admin. Defines all hooks for the dashboard.
	 * - simple_contact_forms_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-contact-forms-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-contact-forms-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-simple-contact-forms-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-simple-contact-forms-public.php';

		$this->loader = new simple_contact_forms_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the simple_contact_forms_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new simple_contact_forms_i18n();
		$plugin_i18n->set_domain( $this->get_simple_contact_forms() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new simple_contact_forms_Admin( $this->get_simple_contact_forms(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'jquery_ui_sortable' );
		$this->loader->add_action( 'wp_ajax_update_field_order', $plugin_admin, 'update_field_order' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'simple_contact_forms_menu' );
		//$this->loader->add_action( 'admin_head', $plugin_admin, 'ShowTinyMCE' );

		$this->loader->add_action( 'admin_notices', $plugin_admin, 'create_notice' );
		$this->loader->add_action( 'widgets_init', $plugin_admin, 'registerwidget' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new simple_contact_forms_Public( $this->get_simple_contact_forms(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts',  $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts',  $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_enqueue_scripts',  $plugin_public, 'public_vendors' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_simple_contact_forms() {
		return $this->simple_contact_forms;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    simple_contact_forms_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Initialize the view on the frontend with a shortcode
	 *
	 * @since     1.0.0
	 */
    public function shortcode($sc_options = array())
    {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/simple-contact-forms-public-display.php';
    }

}

/**
 * Initialize the view on the frontend with a function
 *
 * @since     1.0.0
 */
function simple_contact_form($sc_options = array())
{
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/simple-contact-forms-public-display.php';
}
