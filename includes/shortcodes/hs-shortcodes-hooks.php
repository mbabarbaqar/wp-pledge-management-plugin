<?php
/**
 * Hspg Shortcodes Hooks.
 *
 * Action/filter hooks used for Hspg shortcodes
 *
 * @package     Hspg/Functions/Shortcodes
 * @version     1.2.0
 * @author     HCS
 * @copyright   Copyright (c) 2020, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register shortcodes.
 *
 * @see Hs_Campaigns_Shortcode::display()
 * @see Hs_Donors_Shortcode::display()
 * @see Hs_My_Donations_Shortcode::display()
 * @see Hs_Donation_Form_Shortcode::display()
 * @see Hs_Donation_Receipt_Shortcode::display()
 * @see Hs_Login_Shortcode::display()
 * @see Hs_Logout_Shortcode::display()
 * @see Hs_Registration_Shortcode::display()
 * @see Hs_Profile_Shortcode::display()
 * @see Hs_Email_Shortcode::display()
 */
add_shortcode( 'campaigns', array( 'Hs_Campaigns_Shortcode', 'display' ) );
add_shortcode( 'hs_donors', array( 'Hs_Donors_Shortcode', 'display' ) );
add_shortcode( 'hs_donation_form', array( 'Hs_Donation_Form_Shortcode', 'display' ) );
add_shortcode( 'donation_receipt', array( 'Hs_Donation_Receipt_Shortcode', 'display' ) );
add_shortcode( 'hs_my_donations', array( 'Hs_My_Donations_Shortcode', 'display' ) );
add_shortcode( 'hs_login', array( 'Hs_Login_Shortcode', 'display' ) );
add_shortcode( 'hs_logout', array( 'Hs_Logout_Shortcode', 'display' ) );
add_shortcode( 'hs_registration', array( 'Hs_Registration_Shortcode', 'display' ) );
add_shortcode( 'hs_profile', array( 'Hs_Profile_Shortcode', 'display' ) );
add_shortcode( 'hs_stat', array( 'Hs_Stat_Shortcode', 'display' ) );
add_shortcode( 'hs_email', array( 'Hs_Email_Shortcode', 'display' ) );

/**
 * Fingerprint the login form with our hspg=true hidden field.
 *
 * @see Hs_Login_Shortcode::add_hidden_field_to_login_form()
 */
add_filter( 'login_form_bottom', array( 'Hs_Login_Shortcode', 'add_hidden_field_to_login_form' ), 10, 2 );

/**
 * Set the current email before sending or previewing an email.
 *
 * @see Hs_Email_Shortcode::init()
 * @see Hs_Email_Shortcode::init_preview()
 */
add_action( 'hs_before_send_email', array( 'Hs_Email_Shortcode', 'init' ) );
add_action( 'hs_before_preview_email', array( 'Hs_Email_Shortcode', 'init_preview' ) );

/**
 * Flush the `Hs_Email_Shortcode` instance after an email is sent or previewed.
 *
 * @see Hs_Email_Shortcode::flush()
 */
add_action( 'hs_after_send_email', array( 'Hs_Email_Shortcode', 'flush' ) );
add_action( 'hs_after_preview_email', array( 'Hs_Email_Shortcode', 'flush' ) );
