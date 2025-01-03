<?php
/**
 * Hspg Upgrade Hooks.
 *
 * Action/filter hooks used for Hspg Upgrades.
 *
 * @package   Hspg/Functions/Upgrades
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.3.0
 * @version   1.5.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if there is an upgrade that needs to happen and if so, display a notice to begin upgrading.
 *
 * @see Hs_Upgrade::add_upgrade_notice()
 */
add_action( 'admin_notices', array( Hs_Upgrade::get_instance(), 'add_upgrade_notice' ) );

/**
 * Perform upgrades that don't require a prompt.
 *
 * @see Hs_Upgrade::do_immediate_upgrades()
 */
add_action( 'init', array( Hs_Upgrade::get_instance(), 'do_immediate_upgrades' ), 5 );

/**
 * Register the admin page.
 *
 * @see Hs_Upgrade_Page::register_page()
 */
add_action( 'admin_menu', array( Hs_Upgrade_Page::get_instance(), 'register_page' ) );

/**
 * Hide the admin page from the menu.
 *
 * @see Hs_Upgrade_Page::remove_page_from_menu()
 */
add_action( 'admin_head', array( Hs_Upgrade_Page::get_instance(), 'remove_page_from_menu' ) );

/**
 * Update the upgrade system.
 *
 * @see Hs_Upgrade::update_upgrade_system()
 */
add_action( 'hs_update_upgrade_system', array( Hs_Upgrade::get_instance(), 'update_upgrade_system' ) );

/**
 * Run the upgrade for 1.3.0.
 *
 * @see Hs_Upgrade::upgrade_1_3_0_fix_gmt_dates()
 */
add_action( 'hs_fix_donation_dates', array( Hs_Upgrade::get_instance(), 'fix_donation_dates' ) );

/**
 * Remove duplicate donors.
 *
 * @see Hs_Upgrade::remove_duplicate_donors()
 */
add_action( 'hs_remove_duplicate_donors', array( Hs_Upgrade::get_instance(), 'remove_duplicate_donors' ) );

/**
 * Upgrade the database tables.
 *
 * @see Hs_Upgrade::upgrade_donor_tables()
 */
add_action( 'hs_upgrade_donor_tables', array( Hs_Upgrade::get_instance(), 'upgrade_donor_tables' ) );

/**
 * Fix up donations missing donor IDs.
 *
 * @see Hs_Upgrade::fix_empty_donor_ids()
 */
add_action( 'hs_fix_empty_donor_ids', array( Hs_Upgrade::get_instance(), 'fix_empty_donor_ids' ) );
