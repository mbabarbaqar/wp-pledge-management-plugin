<?php
/**
 * Functions to improve compatibility with W3TC.
 *
 * @package     Hspg/Functions/Compatibility
 * @version     1.4.18
 * @author     HCS
 * @copyright   Copyright (c) 2020, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Clear the campaign page cache after a donation is received.
 *
 * @since   1.4.18
 *
 * @param   int $campaign_id The campaign ID.
 * @return  void
 */
function hs_compat_w3tc_clear_campaign_cache( $campaign_id ) {
	if ( function_exists( 'w3tc_flush_post' ) ) {
		w3tc_flush_post( $campaign_id );
	}
}

add_action( 'hs_flush_campaign_cache', 'hs_compat_w3tc_clear_campaign_cache' );

/**
 * When W3TC database caching is turned on, notices can be
 * triggered during donation processing.
 *
 * DONOTCACHEDB is a constant which will, by default, prevent
 * database caching.
 *
 * @see    https://github.com/Hspg/Hspg/issues/347
 *
 * @since  1.4.18
 *
 * @return void
 */
function hs_compat_w3tc_turn_off_donation_cache() {
	if ( ! defined( 'DONOTCACHEDB' ) ) {
		define( 'DONOTCACHEDB', true );
	}
}

add_action( 'hs_before_save_donation', 'hs_compat_w3tc_turn_off_donation_cache' );
