<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://back40design.com
 * @since             1.0.0
 * @package           B40_Members
 *
 * @wordpress-plugin
 * Plugin Name:       Back40 Members
 * Plugin URI:        https://back40design.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Back40 Design
 * Author URI:        https://back40design.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       b40-members
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'B40_MEMBERS_VERSION', '1.0.0' );

/** Define plugin directory constant */
define( 'B40_MEMBERS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-b40-members-activator.php
 */
function activate_b40_members() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-b40-members-activator.php';
	B40_Members_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-b40-members-deactivator.php
 */
function deactivate_b40_members() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-b40-members-deactivator.php';
	B40_Members_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_b40_members' );
register_deactivation_hook( __FILE__, 'deactivate_b40_members' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-b40-members.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_b40_members() {

	$plugin = new B40_Members();
	$plugin->run();

}
run_b40_members();