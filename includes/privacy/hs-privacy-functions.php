<?php
/**
 * Hspg Privacy Functions.
 *
 * @package   Hspg/Functions/Privacy
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.6.2
 * @version   1.6.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check whether the terms and conditions field is active.
 *
 * This returns true when the "terms_conditions" and the "terms_conditions_page"
 * settings are not empty.
 *
 * @since  1.6.2
 *
 * @return boolean
 */
function hs_is_terms_and_conditions_activated() {
	return 0 != hs_get_option( 'terms_conditions_page', 0 )
		&& '' != hs_get_option( 'terms_conditions', __( 'I have read and agree to the website [terms].', 'hspg' ) );
}

/**
 * Check whether the privacy policy is active.
 *
 * This returns true when the "privacy_policy" and the "privacy_policy_page"
 * settings are not empty.
 *
 * @since  1.6.2
 *
 * @return boolean
 */
function hs_is_privacy_policy_activated() {
	return 0 != hs_get_option( 'privacy_policy_page', 0 )
		&& '' != hs_get_option( 'privacy_policy', __( 'Your personal data will be used to process your donation, support your experience throughout this website, and for other purposes described in our [privacy_policy].', 'hspg' ) );
}

/**
 * Check whether the contact consent is active.
 *
 * This returns true when the "contact_consent" and the "contact_consent_label"
 * fields are not empty, and when the upgrade_donor_tables upgrade routine has
 * been run.
 *
 * @since  1.6.2
 *
 * @return boolean
 */
function hs_is_contact_consent_activated() {
	return 0 != hs_get_option( 'contact_consent', 0 )
		&& '' != hs_get_option( 'contact_consent_label', __( 'Yes, I am happy for you to contact me via email or phone.', 'hspg' ) )
		&& Hs_Upgrade::get_instance()->upgrade_has_been_completed( 'upgrade_donor_tables' );
}

/**
 * Returns the full text of the Terms and Conditions.
 *
 * @since  1.6.2
 *
 * @return string
 */
function hs_get_terms_and_conditions() {
	$endpoints = hspg()->endpoints();

	remove_filter( 'the_content', array( $endpoints, 'get_content' ) );

	$content = apply_filters( 'the_content', get_post_field( 'post_content', hs_get_option( 'terms_conditions_page', 0 ), 'display' ) );

	add_filter( 'the_content', array( $endpoints, 'get_content' ) );

	return $content;
}

/**
 * Returns the checkbox label for the Terms and Conditions field.
 *
 * @since  1.6.2
 *
 * @return string
 */
function hs_get_terms_and_conditions_field_label() {
	$url = get_the_permalink( hs_get_option( 'terms_conditions_page', 0 ) );

	if ( ! $url ) {
		return '';
	}

	$text    = hs_get_option( 'terms_conditions', __( 'I have read and agree to the website [terms].', 'hspg' ) );
	$replace = sprintf( '<a href="%s" target="_blank" class="hs-terms-link">%s</a>',
		$url,
		__( 'terms and conditions', 'hspg' )
	);

	return str_replace( '[terms]', $replace, $text );
}

/**
 * Returns the Privacy Policy text.
 *
 * @since  1.6.2
 *
 * @return string
 */
function hs_get_privacy_policy_field_text() {
	$url = get_the_permalink( hs_get_option( 'privacy_policy_page', 0 ) );

	if ( ! $url ) {
		return '';
	}

	$text    = hs_get_option( 'privacy_policy', __( 'Your personal data will be used to process your donation, support your experience throughout this website, and for other purposes described in our [privacy_policy].', 'hspg' ) );
	$replace = sprintf( '<a href="%s" target="_blank" class="hs-privacy-policy-link">%s</a>',
		$url,
		__( 'privacy policy', 'hspg' )
	);

	return str_replace( '[privacy_policy]', $replace, $text );
}
