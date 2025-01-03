<?php
/**
 * Functions to improve compatibility with Ultimate Member.
 *
 * @package     Hspg/Functions/Compatibility
 * @author     HCS
 * @copyright   Copyright (c) 2020, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.6.25
 * @version     1.6.25
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * When a user verifies their email through Ultimate Member's flow,
 * mark them as verified in Hspg too.
 *
 * @since  1.6.25
 *
 * @param  int $user_id The user ID.
 * @return void
 */
function hs_um_after_user_verified_email( $user_id ) {
	if ( ! array_key_exists( 'act', $_REQUEST ) || ! array_key_exists( 'hash', $_REQUEST ) ) {
		return;
	}

	if ( 'activate_via_email' != $_REQUEST['act'] || ! is_string( $_REQUEST['hash'] ) ) {
		return;
	}

	$user = hs_get_user( $user_id );
	$user->mark_as_verified( true );
}

add_action( 'um_after_user_is_approved', 'hs_um_after_user_verified_email' );


/**
 * If the Profile page setting in Hspg is set to the same page
 * as the User page in Ultimate Member, it messes up with our endpoints.
 *
 * Therefore, to correctly catch which endpoint is being shown, we need
 * to check for the um_user query var and see if it's set to a value indicating
 * it's one of our endpoints.
 *
 * @global WP_Query $wp_query;
 * @param  boolean $is_page Whether this is the particular endpoint page.
 * @return boolean
 */
function hs_um_is_page_hs_endpoint( $is_page ) {
	if ( UM()->options()->get( 'core_user' ) != hs_get_option( 'profile_page' ) ) {
		return $is_page;
	}

	global $wp_query;

	switch ( current_filter() ) {
		case 'hs_is_page_email_verification_page':
			return $wp_query->is_main_query()
				&& array_key_exists( 'um_user', $wp_query->query_vars ) && 'email-verification' == $wp_query->query_vars['um_user'];
	}

	return $is_page;
}

add_filter( 'hs_is_page_email_verification_page', 'hs_um_is_page_hs_endpoint' );
