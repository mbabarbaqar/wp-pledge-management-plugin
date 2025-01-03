<?php
/**
 * Hspg User Management Hooks
 *
 * @package   Hspg/User Management/User Management
 * @author    Rafe Colton
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.4.0
 * @version   1.4.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fire off the password reset request.
 *
 * @see Hs_Forgot_Password_Form::retrieve_password()
 */
add_action( 'hs_retrieve_password', array( 'Hs_Forgot_Password_Form', 'retrieve_password' ) );

/**
 * Reset a user's password.
 *
 * @see Hs_Reset_Password_Form::reset_password()
 */
add_action( 'hs_reset_password', array( 'Hs_Reset_Password_Form', 'reset_password' ) );

/**
 * Save a profile.
 *
 * @see Hs_Profile_Form::update_profile()
 */
add_action( 'hs_update_profile', array( 'Hs_Profile_Form', 'update_profile' ) );

/**
 * Save a user after registration.
 *
 * @see Hs_Registration_Form::save_registration()
 */
add_action( 'hs_save_registration', array( 'Hs_Registration_Form', 'save_registration' ) );

/**
 * Display any notices before the login, profile and donation history pages.
 *
 * @see hs_template_notices
 */
add_action( 'hs_login_form_before', 'hs_template_notices', 10, 0 );
add_action( 'hs_my_donations_before', 'hs_template_notices', 10, 0 );

/**
 * Add support for deprecated `hs_user_profile_after_fields` hook.
 *
 * @see Hs_Profile_Form::add_deprecated_hs_user_profile_after_fields_hook()
 */
add_action( 'hs_form_after_fields', array( 'Hs_Profile_Form', 'add_deprecated_hs_user_profile_after_fields_hook' ) );

/**
 * Redirect the user to the password reset page with the query string removed.
 *
 * @see Hs_User_Management::maybe_redirect_to_password_reset()
 */
add_action( 'template_redirect', array( Hs_User_Management::get_instance(), 'maybe_redirect_to_password_reset' ) );

/**
 * Hides the WP Admin bar if the current user is not allowed to view it.
 *
 * @see Hs_User_Management::remove_admin_bar()
 */
add_action( 'after_setup_theme', array( Hs_User_Management::get_instance(), 'maybe_remove_admin_bar' ) );

/**
 * Redirects the user away from /wp-admin if they are not authorized to access it.
 *
 * @see Hs_User_Management::maybe_redirect_away_from_admin()
 */
add_action( 'admin_init', array( Hs_User_Management::get_instance(), 'maybe_redirect_away_from_admin' ) );

/**
 * If desired, all access to wp-login.php can be redirected to the Hspg login page.
 *
 * This is switched off by default. To enable this option, you need to set a Hspg
 * login page and also return true for the filter:
 *
 * add_filter( 'hs_disable_wp_login', '__return_true' );
 *
 * @see Hs_User_Management::redirect_to_hs_login()
 */
add_action( 'login_form_login', array( Hs_User_Management::get_instance(), 'maybe_redirect_to_hs_login' ) );

/**
 * If hiding all access to wp-login.php using the hs_disable_wp_login
 * filter, capture login error messages and display them on the Hspg
 * login page
 *
 * @see Hs_User_Management::maybe_redirect_at_authenticate()
 */
add_filter( 'authenticate', array( Hs_User_Management::get_instance(), 'maybe_redirect_at_authenticate' ), 101, 2 );

/**
 * If hiding all access to wp-login.php using the hs_disable_wp_login
 * filter, redirect user to custom forgot password page if they try to directly
 * access /wp-login.php?action=lostpassword
 *
 * @see Hs_User_Management::maybe_redirect_to_custom_lostpassword()
 */
add_action( 'login_form_lostpassword', array( Hs_User_Management::get_instance(), 'maybe_redirect_to_custom_lostpassword' ) );

/**
 * If hiding all access to wp-login.php using the hs_disable_wp_login
 * filter, redirect user to custom reset password page if they try to directly
 * access /wp-login.php?action=rp or /wp-login.php?action=resetpass
 *
 * @see Hs_User_Management::maybe_redirect_to_custom_password_reset_page()
 */
add_action( 'login_form_rp', array( Hs_User_Management::get_instance(), 'maybe_redirect_to_custom_password_reset_page' ) );
add_action( 'login_form_resetpass', array( Hs_User_Management::get_instance(), 'maybe_redirect_to_custom_password_reset_page' ) );

/**
 * Send a user verification email.
 *
 * @see Hs_User_Management::send_verification_email()
 */
add_action( 'hs_verify_email', array( Hs_User_Management::get_instance(), 'send_verification_email' ) );
