<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://back40design.com
 * @since      1.0.0
 *
 * @package    B40_Members
 * @subpackage B40_Members/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    B40_Members
 * @subpackage B40_Members/includes
 * @author     Back40 Design <info@back40design.com>
 */
class B40_Members_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		flush_rewrite_rules();

	}

}
