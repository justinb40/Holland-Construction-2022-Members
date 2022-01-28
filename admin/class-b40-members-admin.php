<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://back40design.com
 * @since      1.0.0
 *
 * @package    B40_Members
 * @subpackage B40_Members/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    B40_Members
 * @subpackage B40_Members/admin
 * @author     Back40 Design <info@back40design.com>
 */
class B40_Members_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_dependencies();

	}

	/**
	 * Load the required dependencies for the Admin facing functionality.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wppb_Demo_Plugin_Admin_Settings. Registers the admin settings and page.
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * Admin dependencies
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-b40-members-settings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'includes/libraries/class-b40-list-table.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-b40-members-list-table.php';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in B40_Members_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The B40_Members_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/b40-members-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in B40_Members_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The B40_Members_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/b40-members-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add a post display state for special OCMS pages in the page list table.
	 *
	 * @param array   $post_states An array of post display states.
	 * @param WP_Post $post        The current post object.
	 * @since    1.0.0
	 */
	public function b40_display_post_states( $post_states, $post ) {

		$options = get_option('b40_members_page_settings');

		if ( $post->ID == $options['register_page'] ) {
			$post_states['b40_register_page'] = 'Register';
		}

		if ( $post->ID == $options['login_page'] ) {
			$post_states['b40_login_page'] = 'Login';
		}

		if ( $post->ID == $options['account_page'] ) {
			$post_states['b40_account_page'] = 'Account';
		}

		if ( $post->ID == $options['forgot_password_page'] ) {
			$post_states['b40_forgot_password_page'] = 'Forgot Password';
		}

		if ( $post->ID == $options['reset_password_page'] ) {
			$post_states['b40_reset_password_page'] = 'Reset Password';
		}

		return $post_states;
	}

}
