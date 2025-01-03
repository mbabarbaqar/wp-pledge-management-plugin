<?php
/**
 * Hspg Donation Hooks.
 *
 * Action/filter hooks used for Hspg donations.
 *
 * @package   Hspg/Functions/Donations
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.34
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Start a donation.
 *
 * In default Hspg, this happens when the donation form is loaded. The
 * donation is not saved to the database yet; it just exists in the user's
 * session.
 *
 * @see Hs_Donation_Processor::add_donation_to_session
 */
add_action( 'hs_start_donation', array( 'Hs_Donation_Processor', 'add_donation_to_session' ) );

/**
 * Make a donation.
 *
 * This is when a donation is saved to the database.
 *
 * @see Hs_Donation_Processor::make_donation
 */
add_action( 'hs_make_donation', array( 'Hs_Donation_Processor', 'process_donation_form_submission' ) );

/**
 * AJAX hook to process a donation.
 *
 * @see Hs_Donation_Processor::ajax_process_donation_form_submission
 */
add_action( 'wp_ajax_make_donation', array( 'Hs_Donation_Processor', 'ajax_process_donation_form_submission' ) );
add_action( 'wp_ajax_nopriv_make_donation', array( 'Hs_Donation_Processor', 'ajax_process_donation_form_submission' ) );

/**
 * Make a streamlined donation.
 *
 * This hook is fired when a form generated by Hs_Donation_Amount_Form
 * is submitted. By default, it just includes the amount to be donated and
 * the campaign.
 *
 * @see Hs_Donation_Processor::make_donation_streamlined
 */
add_action( 'hs_make_donation_streamlined', array( 'Hs_Donation_Processor', 'make_donation_streamlined' ) );

/**
 * Donation update.
 *
 * @see hs_flush_campaigns_donation_cache
 */
add_action( 'save_post_' . Hspg::DONATION_POST_TYPE, 'hs_flush_campaigns_donation_cache' );

/**
 * Sanitize donation meta.
 *
 * @see hs_sanitize_donation_meta
 */
add_filter( 'hs_sanitize_donation_meta', 'hs_sanitize_donation_meta', 10, 2 );

/**
 * Delete a donation.
 *
 * @see Hs_Campaign_Donations_DB::delete_donation()
 */
add_action( 'deleted_post', array( 'Hs_Campaign_Donations_DB', 'delete_donation_records' ) );

/**
 * Post donation hook.
 *
 * @see hs_is_after_donation()
 */
add_action( 'init', 'hs_is_after_donation', 20 );

/**
 * Cancel donation.
 *
 * @see hs_cancel_donation()
 */
add_action( 'template_redirect', 'hs_cancel_donation' );

/**
 * Handle PayPal gateway payments.
 *
 * @see Hs_Gateway_Paypal::validate_donation
 * @see Hs_Gateway_Paypal::process_donation
 * @see Hs_Gateway_Paypal::process_ipn
 * @see Hs_Gateway_Paypal::process_web_accept
 */
add_filter( 'hs_validate_donation_form_submission_gateway', array( 'Hs_Gateway_Paypal', 'validate_donation' ), 10, 3 );
add_filter( 'hs_process_donation_paypal', array( 'Hs_Gateway_Paypal', 'process_donation' ), 10, 3 );
add_action( 'hs_process_ipn_paypal', array( 'Hs_Gateway_Paypal', 'process_ipn' ) );
add_action( 'hs_paypal_web_accept', array( 'Hs_Gateway_Paypal', 'process_web_accept' ), 10, 2 );

/**
 * Handle PayPal refund.
 *
 * @see Hs_Gateway_Paypal::process_refund
 */
add_action( 'hs_process_refund_paypal', array( 'Hs_Gateway_Paypal', 'process_refund' ) );

/**
 * Load hs-donation-form.js before donation form.
 *
 * @see hs_load_donation_form_script()
 */
add_action( 'hs_donation_form_before', 'hs_load_donation_form_script' );

/**
 * Refresh a donation in cache after its status is updated.
 *
 * @see hs_update_cached_donation()
 */
add_action( 'hs_donation_status_changed', 'hs_update_cached_donation' );
add_action( 'hs_recurring_donation_status_changed', 'hs_update_cached_donation' );
