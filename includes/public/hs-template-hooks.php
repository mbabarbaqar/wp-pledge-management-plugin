<?php
/**
 * Hspg Template Hooks.
 *
 * Action/filter hooks used for Hspg functions/templates
 *
 * @package   Hspg/Functions/Templates
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.5.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add custom CSS to the <head>.
 *
 * @see hs_template_custom_styles()
 */
add_filter( 'wp_head', 'hs_template_custom_styles' );

/**
 * Single campaign, before content.
 *
 * @see hs_template_campaign_description()
 * @see hs_template_campaign_summary()
 */
add_action( 'hs_campaign_content_before', 'hs_template_campaign_description', 4 );
add_action( 'hs_campaign_content_before', 'hs_template_campaign_summary', 6 );

/**
 * Single campaign, campaign summary.
 *
 * @see hs_template_campaign_percentage_raised()
 * @see hs_template_campaign_donation_summary()
 * @see hs_template_campaign_donor_count()
 * @see hs_template_campaign_time_left()
 * @see hs_template_donate_button()
 */
add_action( 'hs_campaign_summary', 'hs_template_campaign_percentage_raised', 4 );
add_action( 'hs_campaign_summary', 'hs_template_campaign_donation_summary', 6 );
add_action( 'hs_campaign_summary', 'hs_template_campaign_donor_count', 8 );
add_action( 'hs_campaign_summary', 'hs_template_campaign_time_left', 10 );
add_action( 'hs_campaign_summary', 'hs_template_donate_button', 12 );

/**
 * Single campaign, after content.
 *
 * @see hs_template_campaign_donation_form_in_page()
 */
add_action( 'hs_campaign_content_after', 'hs_template_campaign_donation_form_in_page', 4 );

/**
 * Campaigns loop, right at the start.
 *
 * @see hs_template_campaign_loop_add_modal()
 */
add_action( 'hs_campaign_loop_before', 'hs_template_campaign_loop_add_modal' );
add_action( 'hs_campaign_loop_before', 'hs_template_responsive_styles', 10, 2 );

/**
 * Campaigns loop, before title.
 *
 * @see hs_template_campaign_loop_thumbnail()
 */
add_action( 'hs_campaign_content_loop_before_title', 'hs_template_campaign_loop_thumbnail', 10 );

/**
 * Campaigns loop, after the main title.
 *
 * @see hs_template_campaign_description()
 * @see hs_template_campaign_progress_bar()
 * @see hs_template_campaign_loop_donation_stats()
 * @see hs_template_campaign_donate_link()
 * @see hs_template_campaign_loop_more_link()
 */
add_action( 'hs_campaign_content_loop_after', 'hs_template_campaign_description', 4 );
add_action( 'hs_campaign_content_loop_after', 'hs_template_campaign_progress_bar', 6 );
add_action( 'hs_campaign_content_loop_after', 'hs_template_campaign_loop_donation_stats', 8 );
add_action( 'hs_campaign_content_loop_after', 'hs_template_campaign_loop_donate_link', 10, 2 );
add_action( 'hs_campaign_content_loop_after', 'hs_template_campaign_loop_more_link', 10, 2 );

/**
 * Donation receipt, after the page content (if there is any).
 *
 * @see hs_template_donation_receipt_summary()
 * @see hs_template_donation_receipt_offline_payment_instructions()
 */
add_action( 'hs_donation_receipt', 'hs_template_donation_receipt_summary', 4 );
add_action( 'hs_donation_receipt', 'hs_template_donation_receipt_offline_payment_instructions', 6 );
add_action( 'hs_donation_receipt', 'hs_template_donation_receipt_details', 8 );

/**
 * Footer, right before the closing body tag.
 *
 * @see hs_template_campaign_modal_donation_window()
 */
add_action( 'wp_footer', 'hs_template_campaign_modal_donation_window' );

/**
 * Add the login form before the donation form, outside the <form> tags
 *
 * @see hs_template_donation_form_login()
 */
add_action( 'hs_donation_form_before', 'hs_template_donation_form_login', 4 );

/**
 * Donation form, before the donor fields.
 *
 * @see hs_template_donation_form_donor_details()
 */
add_action( 'hs_donation_form_donor_fields_before', 'hs_template_donation_form_donor_details', 6 );

/**
 * Add a link to the login form after the registration form.
 *
 * @see hs_template_form_login_link()
 */
add_action( 'hs_user_registration_after', 'hs_template_form_login_link' );
