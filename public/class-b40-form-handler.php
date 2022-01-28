<?php
/**
 * Class responsible for handling all frontend form submissions
 *
 * @link       https://back40design.com
 * @since      1.0.0
 *
 * @package    b40_members
 * @subpackage b40_members/public
 */

class B40_Members_Form_Handler {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $b40_members    The ID of this plugin.
	 */
	private $b40_members;

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
	 * @param      string    $b40_members       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $b40_members, $version ) {

		$this->b40_members = $b40_members;
		$this->version = $version;

    }

    // Create new WordPress User when registration form is submitted
	public function b40_register_member() {

		$nonce = isset($_REQUEST['b40_register_member_nonce']) ? $_REQUEST['b40_register_member_nonce'] : '';

		if (!wp_verify_nonce($nonce, 'b40_register_member') ) {
			exit;
		}
    
		$first_name = sanitize_text_field($_POST['first_name']);
		$last_name = sanitize_text_field($_POST['last_name']);
		$email = sanitize_text_field($_POST['email']);
		$password = sanitize_text_field($_POST['password']);

        // Create User
		$user_data = array(
			'user_pass'	 => $password,
			'user_login' => $email,
			'user_email' => $email,
			'first_name' => $first_name,
			'last_name'	 => $last_name,
			'role' => 'member',
		);

		$user_id = wp_insert_user($user_data);

        // Get Page Links for Redirects
		$page_settings = get_option('b40_members_page_settings');
		$account_link = get_page_link($page_settings['account_page']);
		$register_link = get_page_link($page_settings['register_page']);

		// Validate Register Form
		if ( !is_wp_error( $user_id ) ) {

			// Log the user in and redirect to the account page
			$credentials = array(
				'user_login' 	=> $email, 
				'user_password' => $password,
			);
	
			$user = wp_signon($credentials, is_ssl());

			wp_safe_redirect($account_link);

		} else {

			b40_add_notice('error', $user_id->get_error_message());
			wp_safe_redirect($register_link);
			exit;
		
		}

	}

	// Login form handler
	public function b40_login_member() {

		$nonce = isset($_REQUEST['b40_login_member_nonce']) ? $_REQUEST['b40_login_member_nonce'] : '';

		if (!wp_verify_nonce($nonce, 'b40_login_member') ) {
			exit;
		}
		
		$email = sanitize_text_field($_POST['email']);
		$password = sanitize_text_field($_POST['password']);
		$remember_me = isset($_POST['remember_me']) ? true : false;

		$credentials = array(
			'user_login' 	=> $email, 
			'user_password' => $password,
			'remember'		=> $remember_me
		);

		$user = wp_signon($credentials, is_ssl());
		$page_settings = get_option('b40_members_page_settings');
		$account_link = get_page_link($page_settings['account_page']);
		$login_link = get_page_link($page_settings['login_page']);

		if ( !is_wp_error( $user ) ) {
			$redirect_link = $account_link;
		} else {
			$redirect_link = $login_link;
			b40_add_notice('error', $user->get_error_message());
		}

		wp_safe_redirect($redirect_link);
		exit;

	}

	// Forgot Password Form Handler
	function b40_forgot_password() {
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			$errors = retrieve_password();

			if ( is_wp_error( $errors ) ) {

				$messages = $errors->get_error_messages();

				foreach ($messages as $message) {
					b40_add_notice('error', $message);
				}

				// Errors found
				$redirect_url = b40_get_page_link('forgot_password_page');

			} else {
				
				// Email sent
				$redirect_url = b40_get_page_link('login_page');
				b40_add_notice('success', 'Check your email for a link to reset your password.');
			
			}
		
			wp_redirect( $redirect_url );
			exit;
		}
	}
	
	/**
	 * Resets the user's password if the password reset form was submitted.
	 */
	public function b40_reset_password() {

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {

			$rp_key = $_POST['rp_key'];
			$rp_login = $_POST['rp_login'];
	
			$user = check_password_reset_key( $rp_key, $rp_login );
	
			if ( ! $user || is_wp_error( $user ) ) {
				
				b40_add_notice('error', 'Invalid or expired key.');
				wp_redirect( b40_get_page_link('reset_password_page') );
				exit;

			}
	
			if ( isset( $_POST['pass1'] ) ) {

				if ( $_POST['pass1'] != $_POST['pass2'] ) {
					// Passwords don't match
					b40_add_notice('error', 'Passwords don\'t match');
					wp_redirect( b40_get_page_link('reset_password_page') );
					exit;
				}

				if ( empty( $_POST['pass1'] ) ) {

					// Password is empty
					b40_add_notice('error', 'Password is empty.');
					wp_redirect( b40_get_page_link('reset_password_page') );
					exit;
				
				}
	
				// Parameter checks OK, reset password
				reset_password( $user, $_POST['pass1'] );
				b40_add_notice('success', 'Password changed.');
				wp_redirect( b40_get_page_link('login_page') );

			} else {
				echo "Invalid request.";
			}
	
			exit;
		}

	}

}