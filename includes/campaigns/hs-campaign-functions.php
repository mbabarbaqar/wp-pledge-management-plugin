<?php
/**
 * Hspg Campaign Functions.
 *
 * Campaign related functions.
 *
 * @package   Hspg/Functions/Campaign
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.5.14
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the given campaign.
 *
 * @since  1.0.0
 *
 * @param  int $campaign_id The campaign ID.
 * @return Hs_Campaign
 */
function hs_get_campaign( $campaign_id ) {
	return new Hs_Campaign( $campaign_id );
}

/**
 * Create a campaign.
 *
 * @since  1.5.9
 *
 * @param  array $args Values for the campaign.
 * @return int
 */
function hs_create_campaign( array $args ) {
	$processor = new Hs_Campaign_Processor( $args );
	return $processor->save();
}

/**
 * Returns the current campaign.
 *
 * @since  1.0.0
 *
 * @return Hs_Campaign|false Campaign object if we're viewing a campaign
 *                                   within a loop. False otherwise.
 */
function hs_get_current_campaign() {
	return hs_get_request()->get_current_campaign();
}

/**
 * Returns the current campaign ID.
 *
 * @since  1.0.0
 *
 * @return int
 */
function hs_get_current_campaign_id() {
	return hs_get_request()->get_current_campaign_id();
}

/**
 * Returns whether the current user is the creator of the given campaign.
 *
 * @since  1.0.0
 *
 * @param  int $campaign_id The campaign ID.
 * @return boolean
 */
function hs_is_current_campaign_creator( $campaign_id = null ) {
	if ( is_null( $campaign_id ) ) {
		$campaign_id = hs_get_current_campaign_id();
	}

	return get_post_field( 'post_author', $campaign_id ) == get_current_user_id();
}

/**
 * Returns whether the given campaign can receive donations.
 *
 * @since  1.5.14
 *
 * @param  int $campaign_id The campaign ID.
 * @return boolean
 */
function hs_campaign_can_receive_donations( $campaign_id ) {
	if ( Hspg::CAMPAIGN_POST_TYPE !== get_post_type( $campaign_id ) ) {
		return false;
	}

	$campaign = hs_get_campaign( $campaign_id );

	return $campaign && $campaign->can_receive_donations();
}

/**
 * Given a campaign ID and a key, return the post field.
 *
 * @since  1.6.0
 *
 * @param  Hs_Campaign $campaign The campaign object.
 * @param  string              $key      The meta key.
 * @return mixed
 */
function hs_get_campaign_post_field( Hs_Campaign $campaign, $key ) {
	return get_post_field( $key, $campaign->ID );
}

/**
 * Get a particular user field for a campaign's creator.
 *
 * @since  1.6.5
 *
 * @param  Hs_Campaign $campaign The campaign object.
 * @param  string              $key      The meta key.
 * @return string
 */
function hs_get_campaign_creator_field( Hs_Campaign $campaign, $key ) {
	$creator = hs_get_user( $campaign->get_campaign_creator() );
	$key     = str_replace( 'campaign_creator_', '', $key );

	return $creator->get( $key );
}

/**
 * Get a particular taxonomy field for a campaign.
 *
 * @since  1.6.19
 *
 * @param  Hs_Campaign $campaign The campaign object.
 * @param  string              $key      The meta key.
 * @return string
 */
function hs_get_campaign_taxonomy_terms_list( Hs_Campaign $campaign, $key ) {
	$taxonomies = array(
		'categories' => 'campaign_category',
		'tags'       => 'campaign_tag',
	);

	$taxonomy = array_key_exists( $key, $taxonomies ) ? $taxonomies[ $key ] : $key;
	$terms    = wp_get_object_terms( $campaign->ID, $taxonomy, array( 'fields' => 'names' ) );

	if ( is_wp_error( $terms ) ) {
		return '';
	}

	return implode( ', ', $terms );
}

/**
 * Get the featured image for a particular campaign.
 *
 * @since  1.6.25
 *
 * @param  Hs_Campaign $campaign The campaign object.
 * @return string|int
 */
function hs_get_campaign_featured_image( Hs_Campaign $campaign ) {
	return get_post_thumbnail_id( $campaign->ID );
}
