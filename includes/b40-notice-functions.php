<?php
/**
 * Back40 Members Notices Functions
 *
 * Functions for error/message handling and display.
 *
 * @package    b40_members
 * @subpackage b40_members/includes
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add and store a notice.
 *
 * @since 2.1
 * @version 3.9.0
 * @param string $notice_type The name of the notice type - either error, success or info.
 * @param array  $data notice message.
 */
function b40_add_notice( $notice_type, $message ) {


    if (!$_SESSION['b40_notices']) {
        $notices = array(
            'error'   => array(),
            'success' => array(),
            'info'    => array()
        );
    } else {
        $notices = $_SESSION['b40_notices'];
    }

    if (!in_array($message, $notices[$notice_type])) {
        array_push($notices[$notice_type], $message);
    }

    $_SESSION['b40_notices'] = $notices;

}

/**
 * Unset all notices.
 *
 * @since 2.1
 */
function b40_clear_notices() {

    $_SESSION['b40_notices'] = null;

}

/**
 * Prints messages and errors which are stored in the session, then clears them.
 *
 * @since 2.1
 * @param bool $return true to return rather than echo. @since 3.5.0.
 * @return string|null
 */
function b40_print_notices( $return = false ) {

	$notices = isset($_SESSION['b40_notices']) ? $_SESSION['b40_notices'] : '';
    
    $templates = new B40_Members_Template_Loader;

    $templates->set_template_data( $notices, 'notices' );
    $templates->get_template_part( 'account/content', 'notices' );

	b40_clear_notices();

}