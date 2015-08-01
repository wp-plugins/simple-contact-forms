<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    simple_contact_forms
 * @subpackage simple_contact_forms/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    simple_contact_forms
 * @subpackage simple_contact_forms/admin
 * @author     Your Name <email@example.com>
 */
class simple_contact_forms_Admin {

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
	 * Admin notices to return
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $notice    The current version of this plugin.
	 */
	public $notice;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $simple_contact_forms       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $simple_contact_forms, $version ) {

		$this->simple_contact_forms = $simple_contact_forms;
		$this->version = $version;
		$this->notice = '';

		var_dump( plugin_dir_path( __FILE__ ) . "partials/scf_completions_table.php");
		include( plugin_dir_path( __FILE__ ) . "partials/scf_completions_table.php" );
		include( plugin_dir_path( __FILE__ ) . "partials/scf_data.php");
		include( plugin_dir_path( __FILE__ ) . "partials/scf_fields_table.php" );
		include( plugin_dir_path( __FILE__ ) . "partials/scf_options.php" );

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in simple_contact_forms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The simple_contact_forms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->simple_contact_forms, plugin_dir_url( __FILE__ ) . 'css/simple-contact-forms-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in simple_contact_forms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The simple_contact_forms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->simple_contact_forms, plugin_dir_url( __FILE__ ) . 'js/simple-contact-forms-admin.js', array( 'jquery', 'jquery-ui-sortable' ), $this->version, false );

	}

	/**
	 * Create a notice to add some fields
	 *
	 * @since    1.0.0
	 */
	public function create_notice() {
		
		// Set the global $post variable
		global $post;

		// Check if we're on a post or page
		if($post) {

			// If this is just a revision, don't send the email.
			if ( wp_is_post_revision( $post->ID ) )
				return;

			// Get the post content
			$content_post = get_post($post->ID);
			$content = $content_post->post_content;

			if( !get_option('scf_form', false) && has_shortcode( $content, 'simple_contact_form') ) {

				// Create a notification
		        echo '<div class="error"> <p>You haven\'t created any form fields for Simple Contact Forms yet. You must do this before the form will be displayed on the page. <a href="' . get_bloginfo('url') . '/wp-admin/options-general.php?page=simple-contact-forms">View settings</a></p></div>';

			}

		}

		return false;

	}

	/**
	 * Load the menu
	 *
	 * @since    1.0.0
	 */
	public function simple_contact_forms_menu() {

		//Our class extends the WP_List_Table class, so we need to make sure that it's there
		if(!class_exists('WP_List_Table')){
		   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
		}

		// Include the required files

		// Create the options page
		add_options_page( 'Simple Contact Forms', 'Simple Contact Forms', 'manage_options', 'simple-contact-forms', 'simple_contact_forms_options' );
	
	}



	public function registerwidget() {

		include ('partials/scf_widget.php');

	}

	public function jquery_ui_sortable() {

		return true;

	}

	public function scf_update_db_check() {

		$scf_db = new SCF_Data_Management();
		$scf_db->db_check();

	}

}

/**
 * Create the tabs
 *
 * @since    1.2.0
 */
function scf_admin_tabs( $current = 'settings' ) {
    $tabs = array( 'settings' => 'Settings', 'forms' => 'Form', 'completions' => 'Completions' );
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=simple-contact-forms&tab=$tab'>$name</a>";
    }
    echo '</h2>';
}


function simple_contact_forms_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include ('views/simple-contact-forms-admin-display.php');
}
