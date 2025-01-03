<?php
/**
 * Hspg Admin Donations Hooks.
 *
 * Action/filter hooks used for setting up donations in the admin.
 *
 * @package   Hspg/Functions/Admin
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.6.39
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add and remove metaboxes.
 *
 * @see Hs_Donation_Meta_Boxes::add_meta_boxes()
 * @see Hs_Donation_Meta_Boxes::remove_meta_boxes()
 */
add_action( 'add_meta_boxes_' . Hspg::DONATION_POST_TYPE, array( Hs_Donation_Meta_Boxes::get_instance(), 'add_meta_boxes' ) );
add_action( 'add_meta_boxes_' . Hspg::DONATION_POST_TYPE, array( Hs_Donation_Meta_Boxes::get_instance(), 'remove_meta_boxes' ), 20 );

/**
 * Add status changes to donation actions.
 *
 * @see Hs_Donation_Meta_Boxes::add_status_change_donation_actions()
 */
add_action( 'admin_init', array( Hs_Donation_Meta_Boxes::get_instance(), 'register_donation_actions' ) );

/**
 * Save the donation.
 *
 * @see Hs_Donation_Meta_Boxes::save_donation()
 */
add_action( 'save_post_' . Hspg::DONATION_POST_TYPE, array( Hs_Donation_Meta_Boxes::get_instance(), 'save_donation' ), 10, 2 );

/**
 * Maybe prevent emails if we're saving a donation.
 *
 * @see Hs_Donation_Meta_Boxes::maybe_block_new_donation_email()
 * @see Hs_Donation_Meta_Boxes::maybe_block_donation_receipt_email()
 */
add_filter( 'hs_send_' . Hs_Email_New_Donation::get_email_id(), array( Hs_Donation_Meta_Boxes::get_instance(), 'maybe_block_new_donation_email' ), 10, 2 );
add_filter( 'hs_send_' . Hs_Email_Donation_Receipt::get_email_id(), array( Hs_Donation_Meta_Boxes::get_instance(), 'maybe_block_donation_receipt_email' ), 10, 2 );

/**
 * Save the donation.
 *
 * @see Hs_Donation_Meta_Boxes::post_messages()
 */
add_filter( 'post_updated_messages', array( Hs_Donation_Meta_Boxes::get_instance(), 'post_messages' ) );

/**
 * Set the table columns for donations.
 *
 * @see Hs_Donation_List_Table::dashboard_columns()
 */
add_filter( 'manage_edit-donation_columns', array( Hs_Donation_List_Table::get_instance(), 'dashboard_columns' ), 11, 1 );

/**
 * Set the content of each column item.
 *
 * @see Hs_Donation_List_Table::dashboard_column_item()
 */
add_filter( 'manage_donation_posts_custom_column', array( Hs_Donation_List_Table::get_instance(), 'dashboard_column_item' ), 11, 2 );

/**
 * Set which columns can be used to sort results.
 *
 * @see Hs_Donation_List_Table::sortable_columns()
 */
add_filter( 'manage_edit-donation_sortable_columns', array( Hs_Donation_List_Table::get_instance(), 'sortable_columns' ) );

/**
 * Set the primary table column.
 *
 * @see Hs_Donation_List_Table::primary_column()
 */
add_filter( 'list_table_primary_column', array( Hs_Donation_List_Table::get_instance(), 'primary_column' ), 10, 2 );

/**
 * Set the actions that can be taken for individual donations in the table.
 *
 * @see Hs_Donation_List_Table::row_actions()
 */
add_filter( 'post_row_actions', array( Hs_Donation_List_Table::get_instance(), 'row_actions' ), 2, 100 );

/**
 * Set the status views.
 *
 * @see Hs_Donation_List_Table::set_status_views()
 */
add_filter( 'views_edit-donation', array( Hs_Donation_List_Table::get_instance(), 'set_status_views' ) );

/**
 * Set up bulk actions. This changed in WordPress 4.7.
 *
 * >= 4.7
 * @see Hs_Donation_List_Table::custom_bulk_actions()
 * @see Hs_Donation_List_Table::bulk_action_handler()
 *
 * < 4.7
 * @see Hs_Donation_List_Table::remove_bulk_actions()
 * @see Hs_Donation_List_Table::bulk_admin_footer()
 * @see Hs_Donation_List_Table::process_bulk_action()
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7', '>=' ) ) {
	add_filter( 'bulk_actions-edit-donation', array( Hs_Donation_List_Table::get_instance(), 'custom_bulk_actions' ) );
	add_filter( 'handle_bulk_actions-edit-donation', array( Hs_Donation_List_Table::get_instance(), 'bulk_action_handler' ), 10, 3 );
} else {
	add_filter( 'bulk_actions-edit-donation', array( Hs_Donation_List_Table::get_instance(), 'remove_bulk_actions' ) );
	add_action( 'admin_footer', array( Hs_Donation_List_Table::get_instance(), 'bulk_admin_footer' ), 10 );
	add_action( 'load-edit.php', array( Hs_Donation_List_Table::get_instance(), 'process_bulk_action' ) );
}

/**
 * Set up admin messages & notifications displayed based on actions taken.
 *
 * @see Hs_Donation_List_Table::bulk_admin_notices()
 * @see Hs_Donation_List_Table::post_messages()
 * @see Hs_Donation_List_Table::bulk_messages()
 */
add_action( 'admin_notices', array( Hs_Donation_List_Table::get_instance(), 'bulk_admin_notices' ) );
add_filter( 'bulk_post_updated_messages', array( Hs_Donation_List_Table::get_instance(), 'bulk_messages' ), 10, 2 );

/**
 * Don't show the months dropdown option.
 *
 * @see Hs_Donation_List_Table::disable_months_dropdown()
 */
add_filter( 'disable_months_dropdown', array( Hs_Donation_List_Table::get_instance(), 'disable_months_dropdown' ), 10, 2 );

/**
 * Add date-based filters above the donations table.
 *
 * @see Hs_Donation_List_Table::add_filters()
 */
add_action( 'restrict_manage_posts', array( Hs_Donation_List_Table::get_instance(), 'add_filters' ), 99 );

/**
 * Add the export button above the donations table.
 *
 * @see Hs_Donation_List_Table::add_export()
 */
add_action( 'manage_posts_extra_tablenav', array( Hs_Donation_List_Table::get_instance(), 'add_export' ) );

/**
 * Insert modal forms in the footer.
 *
 * @see Hs_Donation_List_Table::modal_forms()
 */
add_action( 'admin_footer', array( Hs_Donation_List_Table::get_instance(), 'modal_forms' ) );

/**
 * Load scripts to include on the donation table.
 *
 * @see Hs_Donation_List_Table::load_scripts()
 */
add_action( 'admin_enqueue_scripts', array( Hs_Donation_List_Table::get_instance(), 'load_scripts' ), 11 );

/**
 * Add custom filters to the query that returns the donations to be displayed.
 *
 * @see Hs_Donation_List_Table::filter_request_query()
 */
add_filter( 'request', array( Hs_Donation_List_Table::get_instance(), 'filter_request_query' ) );

/**
 * Set up sorting for query results.
 *
 * @see Hs_Donation_List_Table::sort_donations()
 */
add_filter( 'posts_clauses', array( Hs_Donation_List_Table::get_instance(), 'sort_donations' ) );
