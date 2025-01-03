<?php
/**
 * Functions to improve compatibility with Twenty Seventeen.
 *
 * @package   Hspg/Functions/Compatibility
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.6.22
 * @version   1.6.22
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * In Twenty Seventeen, add a hidden sidebar to avoid a Javascript error.
 *
 * On the donation page, there is no sidebar, and Twenty Seventeen throws
 * an error as a result, which can pause other Javascript processing.
 *
 * @see https://core.trac.wordpress.org/ticket/41050
 *
 * @since  1.6.22
 *
 * @return void
 */
function hs_compat_twentyseventeen_missing_sidebar() {
	if ( hs_is_page( 'campaign_donation', array( 'strict' => true ) ) ) {
		echo '<div id="secondary" class="hs-hidden"></div>';
	}
}

add_action( 'hs_donation_form_after', 'hs_compat_twentyseventeen_missing_sidebar' );
