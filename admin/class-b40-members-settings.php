<?php

/**
 * The settings of the plugin.
 *
 * @link       http://back40desigbn.com
 * @since      1.0.0
 *
 * @package    b40_members
 * @subpackage b40_members/admin
 */

class B40_Members_Admin_Settings {

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

	}

	/**
	 * Admin Menus
	 */
	public function setup_plugin_options_menu() {

		add_menu_page(
			__( 'Members', 'b40-members' ),
			'Members',
			'manage_options',
			'b40-members',
			array( $this, 'render_members_page_content'),
			'dashicons-groups',
			20
		);

		// Add the menu to the Plugins set of menu items
		add_submenu_page(
			'b40-members',
			'Settings', 					// The title to be displayed in the browser window for this page.
			'Settings',					// The text to be displayed for this menu item
			'manage_options',					// Which type of users can see this menu item
			'b40_members_settings',			// The unique ID - that is, the slug - for this menu item
			array( $this, 'render_settings_page_content')				// The name of the function to call when rendering this menu's page
		);

	}
		
	/**
	 * Sets the involvement categories submenu active page
	 *
	 * @return array
	 */
	public function b40_set_active_submenu( $submenu_file ) {

		global $parent_file;
		
		if( 'edit-tags.php?taxonomy=involvement-category' == $submenu_file ) {
			$parent_file = 'b40-members';
		} else if( 'edit.php?post_type=member-orders' == $submenu_file ) {
			$parent_file = 'b40-members';
		} else if( 'edit.php?post_type=member-coupons' == $submenu_file ) {
			$parent_file = 'b40-members';
		}

		return $submenu_file;
	}
	
	/**
	 * Renders members table.
	 *
	 * @return array
	 */
	public function render_members_page_content() {

		$user_list_table = new B40_Members_List_Table();

		// query, filter, and sort the data
		$user_list_table->prepare_items();

		$templates = new B40_Members_Template_Loader;

		$member_id = isset($_GET['member_id']) ? $_GET['member_id'] : '';
		$member_info = $member_id != '' ? b40_get_member_info($member_id) : '';
		$template = $member_id != '' ? 'member-detail' : 'members-table';
		$template_data = $member_id != '' ? $member_info : $user_list_table;
		
		ob_start();
		$templates->set_template_data( $template_data );
		$templates->get_template_part( 'admin/content', $template );
		$html = ob_get_contents();
		ob_end_clean();

		echo $html;
	}

	/**
	 * Provides default values for the Display Options.
	 *
	 * @return array
	 */
	public function default_page_settings() {

		$defaults = array(
			'account_page'			=>	'',
			'register_page'			=>	'',
			'login_page'			=>	'',
			'password_page'			=>	'',
            'forgot_password_page'  =>  '',
            'reset_password_page'   =>  ''
		);

		return $defaults;

    }
    
	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function render_settings_page_content( $active_tab = '' ) {
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2><?php _e( 'Back40 Members Settings', 'b40-members' ); ?></h2>
			<?php settings_errors(); ?>

			<?php if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET[ 'tab' ];
			} else {
				$active_tab = 'page_settings';
			} // end if/else ?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=b40_members_settings&tab=page_settings" class="nav-tab <?php echo $active_tab == 'page_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Page Settings', 'b40-members' ); ?></a>
			</h2>

			<form method="post" action="options.php">
				<?php

				if( $active_tab == 'page_settings' ) {

					settings_fields( 'b40_members_page_settings' );
					do_settings_sections( 'b40_members_page_settings' );

				}

				submit_button();

				?>
			</form>

		</div><!-- /.wrap -->
	<?php
	}

	/**
	 * This function provides a simple description for the General Options page.
	 *
	 * It's called from the 'wppb-demo_initialize_theme_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function general_options_callback() {
		$options = get_option('b40_members_page_settings');
		echo '<p>' . __( 'Select which pages the member content should be displayed on.', 'b40-members' ) . '</p>';
	} // end general_options_callback

	/**
	 * Initializes the theme's page settings page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_page_settings() {

		// If the theme options don't exist, create them.
		if( false == get_option( 'b40_members_page_settings' ) ) {
			$default_array = $this->default_page_settings();
			add_option( 'b40_members_page_settings', $default_array );
		}

		add_settings_section(
			'b40_members_page_settings',			            // ID used to identify this section and with which to register options
			__( 'Page Settings', 'b40-members' ),		        // Title to be displayed on the administration page
			array( $this, 'general_options_callback'),	    // Callback used to render the description of the section
			'b40_members_page_settings'		                // Page on which to add this section of options
		);

		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'regsiter_page',						        // ID used to identify the field throughout the plugin
			__( 'Register Page', 'b40-members' ),					// The label to the left of the option interface element
			array( $this, 'select_element_callback'),	// The name of the function responsible for rendering the option interface
			'b40_members_page_settings',	            // The page on which this option will be displayed
			'b40_members_page_settings',			        // The name of the section to which this field belongs
			array(								        // The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display the header.', 'b40-members' ),
			)
		);

		add_settings_field(
			'login_page',						        // ID used to identify the field throughout the plugin
			__( 'Login Page', 'b40-members' ),					// The label to the left of the option interface element
			array( $this, 'login_page_callback'),	// The name of the function responsible for rendering the option interface
			'b40_members_page_settings',	            // The page on which this option will be displayed
			'b40_members_page_settings',			        // The name of the section to which this field belongs
			array(								        // The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display the header.', 'b40-members' ),
			)
		);

		add_settings_field(
			'forgot_password_page',						        // ID used to identify the field throughout the plugin
			__( 'Forgot Password Page', 'b40-members' ),					// The label to the left of the option interface element
			array( $this, 'forgot_password_callback'),	// The name of the function responsible for rendering the option interface
			'b40_members_page_settings',	            // The page on which this option will be displayed
			'b40_members_page_settings',			        // The name of the section to which this field belongs
			array(								        // The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display the header.', 'b40-members' ),
			)
		);

		add_settings_field(
			'reset_password_page',						        // ID used to identify the field throughout the plugin
			__( 'Reset Password Page', 'b40-members' ),					// The label to the left of the option interface element
			array( $this, 'reset_password_callback'),	// The name of the function responsible for rendering the option interface
			'b40_members_page_settings',	            // The page on which this option will be displayed
			'b40_members_page_settings',			        // The name of the section to which this field belongs
			array(								        // The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display the header.', 'b40-members' ),
			)
		);

		add_settings_field(
			'account_page',						        // ID used to identify the field throughout the plugin
			__( 'Account Page', 'b40-members' ),					// The label to the left of the option interface element
			array( $this, 'account_page_callback'),	// The name of the function responsible for rendering the option interface
			'b40_members_page_settings',	            // The page on which this option will be displayed
			'b40_members_page_settings',			        // The name of the section to which this field belongs
			array(								        // The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display the header.', 'b40-members' ),
			)
		);

		// Finally, we register the fields with WordPress
		register_setting(
			'b40_members_page_settings',
			'b40_members_page_settings'
		);

	} // end wppb-demo_initialize_theme_options
    
    public function select_element_callback() {

        $pages = get_pages();
        $options = get_option('b40_members_page_settings');

        $html = '<select id="register_page" name="b40_members_page_settings[register_page]">';
        $html .= '<option value="default">' . __( 'Select a Page...', 'b40-members' ) . '</option>';

        foreach ($pages as $page) {
            
            $html .= '<option value="' . $page->ID . '" ' . ($options['register_page'] == $page->ID ? 'selected' : '') . '>' . $page->post_title . '</option>';
        
        }

        $html .= '</select>';

		echo $html;

	} // end select_element_callback

	public function login_page_callback() {

        $pages = get_pages();
        $options = get_option('b40_members_page_settings');

        $html = '<select id="login_page" name="b40_members_page_settings[login_page]">';
        $html .= '<option value="default">' . __( 'Select a Page...', 'b40-members' ) . '</option>';

        foreach ($pages as $page) {
            
            $html .= '<option value="' . $page->ID . '" ' . ($options['login_page'] == $page->ID ? 'selected' : '') . '>' . $page->post_title . '</option>';
        
        }

        $html .= '</select>';

		echo $html;

	} // end select_element_callback

	public function forgot_password_callback() {

        $pages = get_pages();
        $options = get_option('b40_members_page_settings');

        $html = '<select id="forgot_password_page" name="b40_members_page_settings[forgot_password_page]">';
        $html .= '<option value="default">' . __( 'Select a Page...', 'b40-members' ) . '</option>';

        foreach ($pages as $page) {
            
            $html .= '<option value="' . $page->ID . '" ' . ($options['forgot_password_page'] == $page->ID ? 'selected' : '') . '>' . $page->post_title . '</option>';
        
        }

        $html .= '</select>';

		echo $html;

	} // end select_element_callback

	public function reset_password_callback() {

        $pages = get_pages();
        $options = get_option('b40_members_page_settings');

        $html = '<select id="reset_password_page" name="b40_members_page_settings[reset_password_page]">';
        $html .= '<option value="default">' . __( 'Select a Page...', 'b40-members' ) . '</option>';

        foreach ($pages as $page) {
            
            $html .= '<option value="' . $page->ID . '" ' . ($options['reset_password_page'] == $page->ID ? 'selected' : '') . '>' . $page->post_title . '</option>';
        
        }

        $html .= '</select>';

		echo $html;

	} // end select_element_callback

	public function account_page_callback() {

        $pages = get_pages();
        $options = get_option('b40_members_page_settings');

        $html = '<select id="account_page" name="b40_members_page_settings[account_page]">';
        $html .= '<option value="default">' . __( 'Select a Page...', 'b40-members' ) . '</option>';

        foreach ($pages as $page) {
            
            $html .= '<option value="' . $page->ID . '" ' . ($options['account_page'] == $page->ID ? 'selected' : '') . '>' . $page->post_title . '</option>';
        
        }

        $html .= '</select>';

		echo $html;

	} // end select_element_callback

}