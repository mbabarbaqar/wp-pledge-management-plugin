<?php
/**
 * Hspg AJAX Hooks.
 *
 * Action/filter hooks used for Hspg AJAX setup.
 *
 * @package   Hspg/Functions/AJAX
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.2.3
 * @version   1.6.28
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Retrieve a campaign's donation form via AJAX.
 *
 * @see hs_ajax_get_donation_form
 */
add_action( 'wp_ajax_get_donation_form', 'hs_ajax_get_donation_form' );
add_action( 'wp_ajax_nopriv_get_donation_form', 'hs_ajax_get_donation_form' );

/**
 * Upload an image through pupload uploader.
 *
 * @see hs_plupload_image_upload
 */
add_action( 'wp_ajax_hs_plupload_image_upload', 'hs_plupload_image_upload' );
add_action( 'wp_ajax_nopriv_hs_plupload_image_upload', 'hs_plupload_image_upload' );

/**
 * Retrieve the details for a particular donor.
 *
 * @see hs_ajax_get_donor_data
 */
add_action( 'wp_ajax_hs_get_donor_data', 'hs_ajax_get_donor_data' );

/**
 * Get session content.
 *
 * @see hs_ajax_get_session_content()
 */
add_action( 'wp_ajax_hs_get_session_content', 'hs_ajax_get_session_content' );
add_action( 'wp_ajax_nopriv_hs_get_session_content', 'hs_ajax_get_session_content' );

/**
 * Return the content for particular templates.
 *
 * @see hs_ajax_get_session_donation_receipt
 * @see hs_ajax_get_session_donation_form_amount_field
 * @see hs_ajax_get_session_donation_form_current_amount_text
 * @see hs_ajax_get_session_errors
 * @see hs_ajax_get_session_notices
 */
add_filter( 'hs_session_content_donation_receipt', 'hs_ajax_get_session_donation_receipt', 10, 2 );
add_filter( 'hs_session_content_donation_form_amount_field', 'hs_ajax_get_session_donation_form_amount_field', 10, 2 );
add_filter( 'hs_session_content_donation_form_current_amount_text', 'hs_ajax_get_session_donation_form_current_amount_text', 10, 2 );
add_filter( 'hs_session_content_errors', 'hs_ajax_get_session_errors' );
add_filter( 'hs_session_content_notices', 'hs_ajax_get_session_notices' );
