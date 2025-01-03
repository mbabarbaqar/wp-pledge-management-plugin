<?php
/**
 * Hspg Admin Hooks.
 *
 * @package   Hspg/Functions/Admin
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.3.0
 * @version   1.6.40
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Hspg's admin-area scripts & styles.
 *
 * @see Hs_Admin::admin_enqueue_scripts()
 */
add_action( 'admin_enqueue_scripts', array( Hs_Admin::get_instance(), 'admin_enqueue_scripts' ) );

/**
 * Set custom admin body classes.
 *
 * @see Hs_Admin::set_body_class()
 */
add_filter( 'admin_body_class', array( Hs_Admin::get_instance(), 'set_body_class' ) );

/**
 * Do an admin action.
 *
 * @see Hs_Admin::maybe_do_admin_action()
 */
add_action( 'admin_init', array( Hs_Admin::get_instance(), 'maybe_do_admin_action' ), 999 );

/**
 * Check if there are any notices to be displayed in the admin.
 *
 * @see Hs_Admin::add_notices()
 */
add_action( 'admin_notices', array( Hs_Admin::get_instance(), 'add_notices' ) );

/**
 * Dismiss a notice.
 *
 * @see Hs_Admin::dismiss_notice()
 */
add_action( 'wp_ajax_hs_dismiss_notice', array( Hs_Admin::get_instance(), 'dismiss_notice' ) );

/**
 * Add a generic body class to donations page
 *
 * @see Hs_Admin::add_admin_body_class()
 */
add_filter( 'admin_body_class', array( Hs_Admin::get_instance(), 'add_admin_body_class' ) );

/**
 * Remove jQuery UI styles added by Ninja Forms.
 *
 * @see Hs_Admin::remove_jquery_ui_styles_nf()
 */
// add_filter( 'media_buttons_context', array( Hs_Admin::get_instance(), 'remove_jquery_ui_styles_nf' ), 20 );

/**
 * Add action links to the Hspg plugin block.
 *
 * @see Hs_Admin::add_plugin_action_links()
 */
add_filter( 'plugin_action_links_' . plugin_basename( hspg()->get_path() ), array( Hs_Admin::get_instance(), 'add_plugin_action_links' ) );

/**
 * Add a link to the settings page from the Hspg plugin block.
 *
 * @see Hs_Admin::add_plugin_row_meta()
 */
add_filter( 'plugin_row_meta', array( Hs_Admin::get_instance(), 'add_plugin_row_meta' ), 10, 2 );

/**
 * Export handlers.
 *
 * @see Hs_Admin::export_donations()
 * @see Hs_Admin::export_campaigns()
 */
add_action( 'hs_export_donations', array( Hs_Admin::get_instance(), 'export_donations' ) );
add_action( 'hs_export_campaigns', array( Hs_Admin::get_instance(), 'export_campaigns' ) );

/**
 * Add Hspg menu.
 *
 * @see Hs_Admin_Pages::add_menu()
 */
add_action( 'admin_menu', array( Hs_Admin_Pages::get_instance(), 'add_menu' ), 5 );

/**
 * Redirect to welcome page after install.
 *
 * @see Hs_Admin_Pages::redirect_to_welcome()
 */
add_action( 'hs_install', array( Hs_Admin_Pages::get_instance(), 'setup_welcome_redirect' ), 100 );

/**
 * Stash any notices that haven't been displayed.
 *
 * @see Hs_Admin_Notices::shutdown()
 */
add_action( 'shutdown', array( hs_get_admin_notices(), 'shutdown' ) );
