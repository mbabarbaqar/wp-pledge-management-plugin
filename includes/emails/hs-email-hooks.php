<?php
/**
 * Hspg Email Hooks.
 *
 * Action/filter hooks used for Hspg emails.
 *
 * @package   Hspg/Functions/Emails
 * @version   1.5.0
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Hspg emails.
 *
 * @see Hs_Emails::register_emails()
 */
add_action( 'init', array( Hs_Emails::get_instance(), 'register_emails' ) );

/**
 * Register admin actions for Hspg emails.
 *
 * @see Hs_Emails::register_email_admin_actions()
 */
add_action( 'admin_init', array( Hs_Emails::get_instance(), 'register_admin_actions' ) );

/**
 * Send the Donation Receipt and Donation Notification emails.
 *
 * Both of these emails are sent immediately a donation has been completed.
 *
 * @see Hs_Email_Donation_Receipt::send_with_donation_id()
 * @see Hs_Email_New_Donation::send_with_donation_id()
 * @see Hs_Email_Offline_Donation_Receipt::send_with_donation_id()
 * @see Hs_Email_Offline_Donation_Notification::send_with_donation_id()
 */
add_action( 'hs_after_save_donation', array( 'Hs_Email_Donation_Receipt', 'send_with_donation_id' ) );
add_action( 'hs_after_save_donation', array( 'Hs_Email_New_Donation', 'send_with_donation_id' ) );
add_action( 'hs_after_save_donation', array( 'Hs_Email_Offline_Donation_Receipt', 'send_with_donation_id' ) );
add_action( 'hs_after_save_donation', array( 'Hs_Email_Offline_Donation_Notification', 'send_with_donation_id' ) );

foreach ( hs_get_approval_statuses() as $status ) {
	add_action( $status . '_' . Hspg::DONATION_POST_TYPE, array( 'Hs_Email_Donation_Receipt', 'send_with_donation_id' ) );
	add_action( $status . '_' . Hspg::DONATION_POST_TYPE, array( 'Hs_Email_New_Donation', 'send_with_donation_id' ) );
}

/**
 * Send the Campaign Ended email.
 *
 * This email can be sent to any recipients, within 24 hours after a campaign has reached its end date.
 *
 * @see Hs_Email_Campaign_End::send_with_campaign_id()
 */
add_action( 'hs_campaign_end', array( 'Hs_Email_Campaign_End', 'send_with_campaign_id' ) );

/**
 * Enable & disable emails.
 *
 * @see Hs_Emails::handle_email_settings_request()
 */
add_action( 'hs_enable_email', array( Hs_Emails::get_instance(), 'handle_email_settings_request' ) );
add_action( 'hs_disable_email', array( Hs_Emails::get_instance(), 'handle_email_settings_request' ) );
