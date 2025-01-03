<?php
/**
 * Hspg Campaign Hooks.
 *
 * @package     Hspg/Functions/Campaigns
 * @version     1.3.0
 * @author     HCS
 * @copyright   Copyright (c) 2020, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize individual campaign meta fields.
 *
 * @see     Hs_Campaign::sanitize_campaign_goal()
 * @see     Hs_Campaign::sanitize_campaign_end_date()
 * @see     Hs_Campaign::sanitize_campaign_suggested_donations()
 * @see     Hs_Campaign::sanitize_custom_donations()
 * @see     Hs_Campaign::sanitize_campaign_description()
 */
add_filter( 'hs_sanitize_campaign_meta_campaign_goal', array( 'Hs_Campaign', 'sanitize_campaign_goal' ) );
add_filter( 'hs_sanitize_campaign_meta_campaign_end_date', array( 'Hs_Campaign', 'sanitize_campaign_end_date' ), 10, 2 );
add_filter( 'hs_sanitize_campaign_meta_campaign_suggested_donations', array( 'Hs_Campaign', 'sanitize_campaign_suggested_donations' ) );
add_filter( 'hs_sanitize_campaign_meta_campaign_allow_custom_donations', array( 'Hs_Campaign', 'sanitize_custom_donations' ), 10, 2 );
add_filter( 'hs_sanitize_campaign_meta_campaign_description', array( 'Hs_Campaign', 'sanitize_campaign_description' ) );
