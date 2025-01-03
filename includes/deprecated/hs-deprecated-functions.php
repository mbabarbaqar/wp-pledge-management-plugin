<?php
/**
 * Hspg Deprecated Functions.
 *
 * @package   Hspg/Functions/Deprecated
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.1
 * @version   1.6.29
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @deprecated 1.0.1
 */
function hs_user_dashboard() {
	hs_get_deprecated()->deprecated_function(
		__FUNCTION__,
		'1.0.1',
		'hs_get_user_dashboard'
	);

	return hs_get_user_dashboard();
}

/**
 * @deprecated 1.4.0
 */
function hs_user_can_access_receipt( Hs_Donation $donation ) {
	hs_get_deprecated()->deprecated_function(
		__FUNCTION__,
		'1.4.0',
		'Hs_Donation::is_from_current_user()'
	);

	return $donation->is_from_current_user();
}

/**
 * @deprecated 1.5.0
 */
if ( ! function_exists( 'hs_template_campaign_content' ) ) :

	function hs_template_campaign_content( $content ) {
		hs_get_deprecated()->deprecated_function(
			__FUNCTION__,
			'1.5.0',
			'Hs_Endpoints::get_content()'
		);

		return hspg()->endpoints()->get_content( $content, 'campaign' );
	}

endif;

/**
 * @deprecated 1.5.0
 */
if ( ! function_exists( 'hs_template_donation_form_content' ) ) :

	function hs_template_donation_form_content( $content ) {
		hs_get_deprecated()->deprecated_function(
			__FUNCTION__,
			'1.5.0',
			'Hs_Endpoints::get_content()'
		);

		return hspg()->endpoints()->get_content( $content, 'campaign_donation' );
	}

endif;

/**
 * @deprecated 1.5.0
 */
if ( ! function_exists( 'hs_template_donation_receipt_content' ) ) :

	function hs_template_donation_receipt_content( $content ) {
		hs_get_deprecated()->deprecated_function(
			__FUNCTION__,
			'1.5.0',
			'Hs_Endpoints::get_content()'
		);

		return hspg()->endpoints()->get_content( $content, 'donation_receipt' );
	}

endif;

/**
 * @deprecated 1.5.0
 */
if ( ! function_exists( 'hs_template_donation_processing_content' ) ) :

	function hs_template_donation_processing_content( $content ) {
		hs_get_deprecated()->deprecated_function(
			__FUNCTION__,
			'1.5.0',
			'Hs_Endpoints::get_content()'
		);
		return hspg()->endpoints()->get_content( $content, 'donation_processing' );

	}

endif;

/**
 * @deprecated 1.5.0
 */
if ( ! function_exists( 'hs_template_forgot_password_content' ) ) :

	function hs_template_forgot_password_content( $content ) {
		hs_get_deprecated()->deprecated_function(
			__FUNCTION__,
			'1.5.0',
			'Hs_Endpoints::get_content()'
		);

		return hspg()->endpoints()->get_content( $content, 'forgot_password' );
	}

endif;

/**
 * @deprecated 1.5.0
 */
if ( ! function_exists( 'hs_template_reset_password_content' ) ) :

	function hs_template_reset_password_content( $content ) {
		hs_get_deprecated()->deprecated_function(
			__FUNCTION__,
			'1.5.0',
			'Hs_Endpoints::get_content()'
		);

		return hspg()->endpoints()->get_content( $content, 'reset_password' );
	}

endif;

/**
 * @deprecated 1.5.0
 */
if ( ! function_exists( 'hs_add_body_classes' ) ) :

	function hs_add_body_classes( $classes ) {
		hs_get_deprecated()->deprecated_function(
			__FUNCTION__,
			'1.5.0',
			'Hs_Endpoints::add_body_classes()'
		);

		return hspg()->endpoints()->add_body_classes( $classes );
	}

endif;

/**
 * Yoast attempts to executes shortcodes from the admin, so we
 * need to make sure these will work properly.
 *
 * @deprecated 2.0.0
 *
 * @since  1.5.4
 * @since  1.6.10 Deprecated.
 *
 * @return void
 */
function hs_wpseo_compat_load_template_files() {
	hs_get_deprecated()->deprecated_function(
		__FUNCTION__,
		'1.6.10',
		'hspg()->load_template_files()'
	);

	hspg()->load_template_files();
}
