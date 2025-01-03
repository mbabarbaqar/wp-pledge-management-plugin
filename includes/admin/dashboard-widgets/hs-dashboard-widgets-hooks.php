<?php
/**
 * Hspg Dashboard Widgets Hooks.
 *
 * Action/filter hooks used for Hspg Dashboard Widgets.
 *
 * @package     Hspg/Functions/Admin
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
 * Register dashboard widgets.
 *
 * @see Hs_Donations_Dashboard_Widget::register()
 */
add_action( 'wp_dashboard_setup', array( 'Hs_Donations_Dashboard_Widget', 'register' ) );

/**
 * Get the content for the donations widget.
 *
 * @see Hs_Donations_Dashboard_Widget::get_content()
 */
add_action( 'wp_ajax_hs_load_dashboard_donations_widget', array( 'Hs_Donations_Dashboard_Widget', 'get_content' ) );
