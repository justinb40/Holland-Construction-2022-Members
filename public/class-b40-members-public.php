<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://back40design.com
 * @since      1.0.0
 *
 * @package    B40_Members
 * @subpackage B40_Members/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    B40_Members
 * @subpackage B40_Members/public
 * @author     Back40 Design <info@back40design.com>
 */
class B40_Members_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/b40-members-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/b40-members-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add Archive and Single Templates For Our Custom Post Types
	 */
	function b40_template_overrides( $template ) {
  
		// Lessons Archive
		if ( is_post_type_archive( 'lessons' ) ) {

			$theme_files = array( 'archive-lessons.php', 'b40-members/archive-lessons.php' );
			$exists_in_theme = locate_template( $theme_files, false );
			
			if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
			} else {
				return B40_MEMBERS_PLUGIN_DIR . '/templates/lessons/archive-lessons.php';
			}

		}

		// Lesson Single
		if ( is_singular( 'lessons' ) ) {

			$theme_files = array( 'single-lesson.php', 'b40-members/single-lesson.php' );
			$exists_in_theme = locate_template( $theme_files, false );
			
			if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
			} else {
				return B40_MEMBERS_PLUGIN_DIR . '/templates/lessons/single-lesson.php';
			}

		}

		// Webinars Archive
		if ( is_post_type_archive( 'webinars' ) ) {

			$theme_files = array( 'archive-webinars.php', 'b40-members/archive-webinars.php' );
			$exists_in_theme = locate_template( $theme_files, false );
			
			if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
			} else {
				return B40_MEMBERS_PLUGIN_DIR . '/templates/webinars/archive-webinars.php';
			}

		}

		// Webinar Single
		if ( is_singular( 'webinars' ) ) {

			$theme_files = array( 'single-webinar.php', 'b40-members/single-webinar.php' );
			$exists_in_theme = locate_template( $theme_files, false );
			
			if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
			} else {
				return B40_MEMBERS_PLUGIN_DIR . '/templates/webinars/single-webinar.php';
			}

		}

		// Studies Archive
		if ( is_post_type_archive( 'studies' ) ) {

			$theme_files = array( 'archive-studies.php', 'b40-members/archive-studies.php' );
			$exists_in_theme = locate_template( $theme_files, false );
			
			if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
			} else {
				return B40_MEMBERS_PLUGIN_DIR . '/templates/studies/archive-studies.php';
			}

		}

		// Studies Single
		if ( is_singular( 'studies' ) ) {

			$theme_files = array( 'single-study.php', 'b40-members/single-study.php' );
			$exists_in_theme = locate_template($theme_files, false);
			
			if ( $exists_in_theme != '' ) {
				return $exists_in_theme;
			} else {
				return B40_MEMBERS_PLUGIN_DIR . '/templates/studies/single-study.php';
			}

		}
	
	  	return $template;

	}

	/**
	 * Redirects the user to the custom "Forgot your password?" page instead of
	 * wp-login.php?action=lostpassword.
	 */
	public function b40_forgot_password_redirect() {
		if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
			if ( is_user_logged_in() ) {
				$this->redirect_logged_in_user();
				exit;
			}
	
			wp_redirect( b40_get_page_link('forgot_password_page') );
			exit;
		}
	}

	/**
	 * Returns the message body for the password reset mail.
	 * Called through the retrieve_password_message filter.
	 *
	 * @param string  $message    Default mail message.
	 * @param string  $key        The activation key.
	 * @param string  $user_login The username for the user.
	 * @param WP_User $user_data  WP_User object.
	 *
	 * @return string   The mail message to send.
	 */
	public function b40_forgot_password_email( $message, $key, $user_login, $user_data ) {

		// Create new message
		$msg  = __( 'Hello!', 'b40-members' ) . "\r\n\r\n";
		$msg .= sprintf( __( 'You asked us to reset your password for your account using the email address %s.', 'personalize-login' ), $user_data->user_email ) . "\r\n\r\n";
		$msg .= __( "If this was a mistake, or you didn't ask for a password reset, just ignore this email and nothing will happen.", 'personalize-login' ) . "\r\n\r\n";
		$msg .= __( 'To reset your password, visit the following address:', 'b40-members' ) . "\r\n\r\n";
		$msg .= site_url( "/reset-password?key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";
		$msg .= __( 'Thanks!', 'b40-members' ) . "\r\n";
	
		return $msg;

		// You can also send a custom email template and then return false here
	}

	/**
	 * Redirect users away from pages they don't need if logged in
	 */
	public function b40_members_redirects() {

		$id = get_the_ID();
		$logged_in = is_user_logged_in();
		$pages = get_option('b40_members_page_settings');
		$current_page = array_search($id, $pages);
		$auth_pages = array(
			'register_page',
			'login_page',
			'forgot_password_page',
			'reset_password_page'
		);
		$account_pages = array(
			'account_page',
			'purchases_page'
		);

		if ( $logged_in && in_array($current_page, $auth_pages) ) {
			wp_safe_redirect( b40_get_page_link('account_page') );
			exit;
		}

		if ( !$logged_in && in_array($current_page, $account_pages) ) {
			wp_safe_redirect( b40_get_page_link('login_page') );
			exit;
		}

	}

}
