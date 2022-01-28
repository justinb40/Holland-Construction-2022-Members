<?php
/**
 * B40 Members Functions
 *
 * Functions for retrieving member data
 *
 * @package    b40_members
 * @subpackage b40_members/includes
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get All Members
 */
function b40_get_members() {

    $args = array(
        'role' => 'Member', 
        'numberposts' => -1, 
        'orderby' => 'meta_value', 
        'meta_key' => 'last_name'
    );

    $members = get_users( $args );
    return $members;

}

/**
 * Get Member Page IDs
 *
 * @since 1.0
 * @param string $page     Page Key.
 */
function b40_get_page_id($page) {
    
    $pages = get_option('b40_members_page_settings');

    $page_id = $pages[$page];

    return $page_id;

}

/**
 * Get Member Page Links
 *
 * @since 1.0
 * @param string $page     Page Key.
 */
function b40_get_page_link($page) {
    
    $pages = get_option('b40_members_page_settings');

    $page_link = get_page_link($pages[$page]);

    return $page_link;

}

/**
 * Check if page is a member account page
 *
 * @since 1.0
 * @param string $id     Page ID.
 */
function is_b40_account_page($id) {
    
    $pages = get_option('b40_members_page_settings');
    $current_page = array_search($id, $pages);
    $account_pages = array(
        'account_page'
    );

    if (in_array($current_page, $account_pages) ) {
        return true;
    } else {
        return false;
    }
}
