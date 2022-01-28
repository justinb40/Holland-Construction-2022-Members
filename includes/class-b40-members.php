<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://back40design.com
 * @since      1.0.0
 *
 * @package    B40_Members
 * @subpackage B40_Members/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    B40_Members
 * @subpackage B40_Members/includes
 * @author     Back40 Design <info@back40design.com>
 */
class B40_Members {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      B40_Members_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

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
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'B40_MEMBERS_VERSION' ) ) {
			$this->version = B40_MEMBERS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'b40-members';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - B40_Members_Loader. Orchestrates the hooks of the plugin.
	 * - B40_Members_i18n. Defines internationalization functionality.
	 * - B40_Members_Admin. Defines all hooks for the admin area.
	 * - B40_Members_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-b40-members-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-b40-members-i18n.php';

		 /**
		 * Custom Post Types
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-b40-members-post_types.php';

		 /**
		 * Helper Functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/b40-member-functions.php';

		
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-b40-members-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-b40-members-public.php';

		/**
		 * Shortcodes
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-b40-members-shortcodes.php';

		/**
		 * Notice Functions
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/b40-notice-functions.php';

		/**
		 * Public Form Handler
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-b40-form-handler.php';

		/**
		 * Custom Template Loader
		 */
		if( ! class_exists( 'Gamajo_Template_Loader' ) ) {
			require plugin_dir_path( dirname( __FILE__ ) ). 'includes/libraries/class-gamajo-template-loader.php';
		}

		require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/libraries/class-custom-template-loader.php';

		$this->loader = new B40_Members_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the B40_Members_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new B40_Members_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new B40_Members_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_post_types = new B40_Members_Post_Types();
		$plugin_settings = new B40_Members_Admin_Settings( $this->get_plugin_name(), $this->get_version() );

		// Admin Scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Admin Menu
		$this->loader->add_action( 'admin_menu', $plugin_settings, 'setup_plugin_options_menu' );
		$this->loader->add_action( 'admin_init', $plugin_settings, 'initialize_page_settings' );
		$this->loader->add_filter( 'submenu_file', $plugin_settings, 'b40_set_active_submenu' );

		// Pages View
		$this->loader->add_filter( 'display_post_states', $plugin_admin, 'b40_display_post_states', 10, 2 );

		/**
		 * The problem with the initial activation code is that when the activation hook runs, it's after the init hook has run,
		 * so hooking into init from the activation hook won't do anything.
		 * You don't need to register the CPT within the activation function unless you need rewrite rules to be added
		 * via flush_rewrite_rules() on activation. In that case, you'll want to register the CPT normally, via the
		 * loader on the init hook, and also re-register it within the activation function and
		 * call flush_rewrite_rules() to add the CPT rewrite rules.
		 *
		 * @link https://github.com/DevinVinson/WordPress-Plugin-Boilerplate/issues/261
		 */
		$this->loader->add_action( 'init', $plugin_post_types, 'create_custom_post_type', 999 );
		$this->loader->add_action( 'init', $plugin_post_types, 'create_custom_taxonomy', 999 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new B40_Members_Public( $this->get_plugin_name(), $this->get_version() );
		$plugin_shortcodes = new B40_Members_Shortcodes( $this->get_plugin_name(), $this->get_version() );
		$plugin_form_handler = new B40_Members_Form_Handler( $this->get_plugin_name(), $this->get_version() );

		// Scripts
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Shortcodes
		$this->loader->add_shortcode( 'b40_register', $plugin_shortcodes, 'b40_register_shortcode' );
		$this->loader->add_shortcode( 'b40_login', $plugin_shortcodes, 'b40_login_shortcode' );
		$this->loader->add_shortcode( 'b40_forgot_password', $plugin_shortcodes, 'b40_forgot_password_shortcode' );
		$this->loader->add_shortcode( 'b40_reset_password', $plugin_shortcodes, 'b40_reset_password_shortcode' );
		$this->loader->add_shortcode( 'b40_account', $plugin_shortcodes, 'b40_account_shortcode' );

		// Register Form Submission
		$this->loader->add_action( 'admin_post_nopriv_b40_register_member', $plugin_form_handler, 'b40_register_member' );
		$this->loader->add_action( 'admin_post_b40_register_member', $plugin_form_handler, 'b40_register_member' );
		
		// Login Form Submission
		$this->loader->add_action( 'admin_post_nopriv_b40_login_member', $plugin_form_handler, 'b40_login_member' );
		$this->loader->add_action( 'admin_post_b40_login_member', $plugin_form_handler, 'b40_login_member' );

		// Forgot Password
		$this->loader->add_action( 'login_form_lostpassword', $plugin_public, 'b40_forgot_password_redirect' );
		$this->loader->add_action( 'retrieve_password_message', $plugin_public, 'b40_forgot_password_email', 10, 4 );
		$this->loader->add_action( 'login_form_lostpassword', $plugin_form_handler, 'b40_forgot_password' );
		$this->loader->add_action( 'login_form_rp', $plugin_form_handler, 'b40_reset_password' );
		$this->loader->add_action( 'login_form_resetpass', $plugin_form_handler, 'b40_reset_password' );

		// Template Overrirdes
		$this->loader->add_filter( 'template_include', $plugin_public, 'b40_template_overrides' );

		// Redirects
		$this->loader->add_action( 'template_redirect', $plugin_public, 'b40_members_redirects' );

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
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    B40_Members_Loader    Orchestrates the hooks of the plugin.
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

}
