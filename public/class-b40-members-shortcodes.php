<?php

/**
 * Class responsible for all shortcode creation.
 *
 * @link       https://back40design.com
 * @since      1.0.0
 *
 * @package    b40_members
 * @subpackage b40_members/public
 */

class B40_Members_Shortcodes {

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
    
	// Shortcode for the register page
	public function b40_register_shortcode( $atts ) { 

		$templates = new B40_Members_Template_Loader;

		ob_start();
		
		$templates->get_template_part( 'account/content', 'register' );

		return ob_get_clean();
	
	}

	// Shortcode for the login page
	public function b40_login_shortcode( $atts ) { 

		$templates = new B40_Members_Template_Loader;

		ob_start();
		
		$templates->get_template_part( 'account/content', 'login' );

		return ob_get_clean();
		
	}

	// Shortcode for the forgot password page
	public function b40_forgot_password_shortcode( $atts ) {

		$templates = new B40_Members_Template_Loader;

		ob_start();
		
		$templates->get_template_part( 'account/content', 'forgot-password' );

		return ob_get_clean();
		
	}

	// Shortcode for the reset password page
	public function b40_reset_password_shortcode( $atts ) { 

		$templates = new B40_Members_Template_Loader;

		ob_start();
		
		$templates->get_template_part( 'account/content', 'reset-password' );

		return ob_get_clean();
		
	}

	// Shortcode for the account page
	public function b40_account_shortcode( $atts ) {

		$templates = new B40_Members_Template_Loader;
		$page = array('page' => 'contact-info');

		ob_start();
		
		$templates->set_template_data( $page, 'page' );
		$templates->get_template_part( 'account/content', 'account' );

		return ob_get_clean();
		
	}

}