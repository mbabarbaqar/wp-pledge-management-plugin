<?php
/**
 * Returns an array of all the default campaign fields.
 *
 * @package   Hspg/Campaign Fields
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.6.0
 * @version   1.6.19
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter the set of default campaign fields.
 *
 * This filter is provided primarily for internal use by Hspg
 * extensions, as it allows us to add to the registered campaign fields
 * as soon as possible.
 *
 * @since 1.6.0
 *
 * @param array $fields The multi-dimensional array of keys in $key => $args format.
 */
return apply_filters(
	'hs_default_campaign_fields',
	array(
		'ID'                       => array(
			'label'          => __( 'Campaign ID', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => 'hs_get_campaign_post_field',
			'admin_form'     => false,
			'email_tag'      => false,
			'show_in_export' => true,
		),
		'description'              => array(
			'label'          => __( 'Description', 'hspg' ),
			'data_type'      => 'meta',
			'admin_form'     => array(
				'section'  => 'campaign-top',
				'type'     => 'textarea',
				'view'     => 'metaboxes/campaign-description',
				'priority' => 4,
			),
			'email_tag'      => false,
			'show_in_export' => true,
		),
		'goal'                     => array(
			'label'          => __( 'Goal', 'hspg' ),
			'data_type'      => 'meta',
			'admin_form'     => array(
				'section'     => 'campaign-top',
				'type'        => 'number',
				'view'        => 'metaboxes/campaign-goal',
				'priority'    => 6,
				'description' => __( 'Leave empty for campaigns without a fundraising goal.', 'hspg' ),
			),
			'email_tag'      => false,
			'show_in_export' => true,
		),
		'monetary_goal'            => array(
			'label'          => __( 'Goal ($)', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'campaign_goal',
				'description' => __( 'Display the campaign\'s fundraising goal', 'hspg' ),
				'preview'     => '$15,000',
			),
			'show_in_export' => false,
		),
		'end_date'                 => array(
			'label'          => __( 'End Date', 'hspg' ),
			'data_type'      => 'meta',
			'admin_form'     => array(
				'section'     => 'campaign-top',
				'type'        => 'date',
				'view'        => 'metaboxes/campaign-end-date',
				'priority'    => 8,
				'description' => __( 'Leave empty for ongoing campaigns.', 'hspg' ),
			),
			'email_tag'      => array(
				'tag'         => 'campaign_end_date',
				'description' => __( 'The end date of the campaign', 'hspg' ),
				'preview'     => date( get_option( 'date_format', 'd/m/Y' ) ),
			),
			'show_in_export' => true,
		),
		'suggested_donations'      => array(
			'label'          => __( 'Suggested Donation Amounts', 'hspg' ),
			'data_type'      => 'meta',
			'admin_form'     => array(
				'section'  => 'campaign-donation-options',
				'type'     => 'array',
				'view'     => 'metaboxes/campaign-donation-options/suggested-amounts',
				'priority' => 4,
			),
			'email_tag'      => false,
			'show_in_export' => false,
		),
		'allow_custom_donations'   => array(
			'label'          => __( 'Allow Custom Donations', 'hspg' ),
			'data_type'      => 'meta',
			'admin_form'     => array(
				'section'  => 'campaign-donation-options',
				'type'     => 'checkbox',
				'priority' => 6,
			),
			'email_tag'      => false,
			'show_in_export' => false,
		),
		'post_title'               => array(
			'label'          => __( 'Title', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => 'hs_get_campaign_post_field',
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'campaign_title',
				'description' => __( 'The title of the campaign', 'hspg' ),
				'preview'     => __( 'Fake Campaign', 'hspg' ),
			),
			'show_in_export' => true,
		),
		'post_date'                => array(
			'label'          => __( 'Date Created', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => 'hs_get_campaign_post_field',
			'admin_form'     => false,
			'email_tag'      => false,
			'show_in_export' => true,
		),
		'post_author'              => array(
			'label'          => __( 'Campaign Creator ID', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => 'hs_get_campaign_post_field',
			'admin_form'     => array(
				'section'  => 'campaign-creator',
				'type'     => 'text',
				'view'     => 'metaboxes/campaign-creator',
				'priority' => 2,
			),
			'email_tag'      => false,
			'show_in_export' => true,
		),
		'post_content'             => array(
			'label'          => __( 'Extended Description', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => 'hs_get_campaign_post_field',
			'admin_form'     => array(
				'section'  => 'campaign-extended-description',
				'type'     => 'text',
				'view'     => 'metaboxes/campaign-extended-description',
				'priority' => 2,
			),
			'email_tag'      => false,
			'show_in_export' => false,
		),
		'image'                    => array(
			'label'          => __( 'Featured Image', 'hspg' ),
			'data_type'      => 'meta',
			'value_callback' => 'hs_get_campaign_featured_image',
			'admin_form'     => false,
			'email_tag'      => false,
			'show_in_export' => false,
		),
		'campaign_creator_name'    => array(
			'label'          => __( 'Campaign Creator', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'campaign_creator',
				'description' => __( 'The name of the campaign creator', 'hspg' ),
				'preview'     => 'Harry Ferguson',
			),
			'show_in_export' => true,
		),
		'campaign_creator_email'   => array(
			'label'          => __( 'Campaign Creator Email', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'description' => __( 'The email address of the campaign creator', 'hspg' ),
				'preview'     => 'harry@example.com',
			),
			'show_in_export' => true,
		),
		'goal_achieved_message'    => array(
			'label'          => __( 'Achieved Goal?', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'campaign_achieved_goal',
				'description' => __( 'Display whether the campaign reached its goal. Add a `success` parameter as the message when the campaign was successful, and a `failure` parameter as the message when the campaign is not successful', 'hspg' ),
				'preview'     => __( 'The campaign achieved its fundraising goal.', 'hspg' ),
			),
			'show_in_export' => false,
		),
		'donated_amount'           => array(
			'label'          => __( 'Amount Donated', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => false,
			'show_in_export' => true,
		),
		'donated_amount_formatted' => array(
			'label'          => __( 'Amount Donated', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'campaign_donated_amount',
				'description' => __( 'Display the total amount donated to the campaign', 'hspg' ),
				'preview'     => '$16,523',
			),
			'show_in_export' => false,
		),
		'percent_donated'          => array(
			'label'          => __( 'Percent Donated', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'campaign_percent_donated',
				'description' => __( 'Display the percentage donated to the campaign', 'hspg' ),
				'preview'     => '34%',
			),
			'show_in_export' => false,
		),
		'percent_donated_raw'      => array(
			'label'          => __( 'Percent Donated', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => false,
			'show_in_export' => true,
		),
		'donor_count'              => array(
			'label'          => __( 'Number of Donors', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'campaign_donor_count',
				'description' => __( 'Display the number of campaign donors', 'hspg' ),
				'preview'     => 23,
			),
			'show_in_export' => true,
		),
		'status'                   => array(
			'label'          => __( 'Campaign Status', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => false,
			'show_in_export' => true,
		),
		'permalink'                => array(
			'label'          => __( 'Campaign Permalink', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'campaign_url',
				'description' => __( 'Display the campaign\'s URL', 'hspg' ),
				'preview'     => 'http://www.example.com/campaigns/fake-campaign',
			),
			'show_in_export' => true,
		),
		'admin_edit_link'          => array(
			'label'          => __( 'Campaign Edit Link', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'campaign_dashboard_url',
				'description' => __( 'Display a link to the campaign in the dashboard', 'hspg' ),
				'preview'     => get_edit_post_link( 1 ),
			),
			'show_in_export' => false,
		),
		'categories'               => array(
			'label'          => __( 'Categories', 'hspg' ),
			'data_type'      => 'taxonomy',
			'value_callback' => 'hs_get_campaign_taxonomy_terms_list',
			'admin_form'     => false,
			'email_tag'      => array(
				'description' => __( 'Display a comma-separated list of campaign categories', 'hspg' ),
				'preview'     => 'Category 1, Category 2',
			),
			'show_in_export' => true,
		),
		'tags'                     => array(
			'label'          => __( 'Tags', 'hspg' ),
			'data_type'      => 'taxonomy',
			'value_callback' => 'hs_get_campaign_taxonomy_terms_list',
			'admin_form'     => false,
			'email_tag'      => array(
				'description' => __( 'Display a comma-separated list of campaign tags', 'hspg' ),
				'preview'     => 'Tag 1, Tag 2, Tag 3',
			),
			'show_in_export' => true,
		),
	)
);
