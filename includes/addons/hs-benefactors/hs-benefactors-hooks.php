<?php
/**
 * Hspg Benefactors Hooks.
 *
 * Action/filter hooks used for Hspg Benefactors addon.
 *
 * @package     Hspg/Functions/Benefactors
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
 * Register the custom script.
 *
 * @see     Hs_Benefactors::register_script()
 */
add_action( 'admin_enqueue_scripts', array( Hs_Benefactors::get_instance(), 'register_script' ) );

/**
 * Register the custom benefactors table.
 *
 * @see     Hs_Benefactors::register_table()
 */
add_filter( 'hs_db_tables', array( Hs_Benefactors::get_instance(), 'register_table' ) );

/**
 * Save benefactors when saving campaign.
 *
 * @see     Hs_Benefactors::save_benefactors()
 */
add_filter( 'hs_campaign_save', array( Hs_Benefactors::get_instance(), 'save_benefactors' ) );

/**
 * AJAX hook to delete a benefactor.
 *
 * @see     Hs_Benefactors::delete_benefactor()
 */
add_action( 'wp_ajax_hs_delete_benefactor', array( Hs_Benefactors::get_instance(), 'delete_benefactor' ) );

/**
 * AJAX hook to add a new benefactor.
 *
 * @see     Hs_Benefactors::add_benefactor_form()
 */
add_action( 'wp_ajax_hs_add_benefactor', array( Hs_Benefactors::get_instance(), 'add_benefactor_form' ) );

/**
 * Add benefactor meta box and form.
 *
 * @see     Hs_Benefactors::benefactor_meta_box()
 * @see     Hs_Benefactors::benefactor_form()
 */
add_action( 'hs_campaign_benefactor_meta_box', array( Hs_Benefactors::get_instance(), 'benefactor_meta_box' ), 5, 2);
add_action( 'hs_campaign_benefactor_meta_box', array( Hs_Benefactors::get_instance(), 'benefactor_form' ), 10, 2 );

/**
 * Hook to execute when uninstalling Hspg.
 *
 * @see     Hs_Benefactors::uninstall()
 */
add_action( 'hs_uninstall', array( Hs_Benefactors::get_instance(), 'uninstall' ) );