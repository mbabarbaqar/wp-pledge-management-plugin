<?php
/**
 * Returns an array of all the default donation fields.
 *
 * @package   Hspg/Donation Fields
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.6.29
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter the set of default donation fields.
 *
 * This filter is provided primarily for internal use by Hspg
 * extensions, as it allows us to add to the registered donation fields
 * as soon as possible.
 *
 * @since 1.5.0
 *
 * @param array $fields The multi-dimensional array of keys in $key => $args format.
 */
return apply_filters(
	'hs_default_donation_fields',
	array(
		'donation_id'              => array(
			'label'          => __( 'Donation ID', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Hs_Donation::get_donation_id().
			'donation_form'  => false,
			'admin_form'     => false,
			'show_in_meta'   => false,
			'email_tag'      => array(
				'description' => __( 'The donation ID', 'hspg' ),
				'preview'     => 164,
			),
		),
		'first_name'               => array(
			'label'          => __( 'First Name', 'hspg' ),
			'data_type'      => 'user',
			'value_callback' => 'hs_get_donor_meta_value',
			'donation_form'  => array(
				'label'    => __( 'First name', 'hspg' ),
				'priority' => 4,
				'required' => true,
			),
			'admin_form'     => array(
				'required' => false,
			),
			'show_in_meta'   => false,
			'show_in_export' => true,
			'email_tag'      => array(
				'tag'         => 'donor_first_name',
				'description' => __( 'The first name of the donor', 'hspg' ),
				'preview'     => 'John',
			),
		),
		'last_name'                => array(
			'label'          => __( 'Last Name', 'hspg' ),
			'data_type'      => 'user',
			'value_callback' => 'hs_get_donor_meta_value',
			'donation_form'  => array(
				'label'    => __( 'Last name', 'hspg' ),
				'priority' => 6,
				'required' => true,
			),
			'admin_form'     => array(
				'required' => false,
			),
			'show_in_meta'   => false,
			'show_in_export' => true,
			'email_tag'      => array(
				'tag'         => 'donor_last_name',
				'description' => __( 'The last name of the donor', 'hspg' ),
				'preview'     => 'Smith',
			),
		),
		'donor'                    => array(
			'label'          => __( 'Donor', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'donation_form'  => false,
			'admin_form'     => false,
			'show_in_meta'   => true,
			'show_in_export' => false,
			'email_tag'      => array(
				'description' => __( 'The full name of the donor', 'hspg' ),
				'preview'     => 'John Deere',
			),
		),
		'email'                    => array(
			'label'          => __( 'Email', 'hspg' ),
			'data_type'      => 'user',
			'value_callback' => 'hs_get_donor_meta_value',
			'donation_form'  => array(
				'type'     => 'email',
				'label'    => __( 'Email', 'hspg' ),
				'priority' => 8,
				'required' => true,
			),
			'admin_form'     => array(
				'required' => false,
			),
			'email_tag'      => array(
				'tag'         => 'donor_email',
				'description' => __( 'The email address of the donor', 'hspg' ),
				'preview'     => 'john@example.com',
			),
		),
		'donor_address'            => array(
			'label'          => __( 'Address', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Will use Hs_Donation::get_donor_address().
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'description' => __( 'The donor\'s address', 'hspg' ),
				'preview'     => hs_get_location_helper()->get_formatted_address(
					array(
						'first_name' => 'John',
						'last_name'  => 'Deere',
						'company'    => 'Deere & Company',
						'address'    => 'One John Deere Place',
						'city'       => 'Moline',
						'state'      => 'Illinois',
						'postcode'   => '61265',
						'country'    => 'US',
					)
				),
			),
			'show_in_meta'   => true,
			'show_in_export' => true,
		),
		'address'                  => array(
			'label'          => __( 'Address', 'hspg' ),
			'data_type'      => 'user',
			'value_callback' => 'hs_get_donor_meta_value',
			'donation_form'  => array(
				'priority' => 10,
				'required' => false,
			),
			'admin_form'     => true,
			'email_tag'      => false,
			'show_in_meta'   => false,
			'show_in_export' => true,
		),
		'address_2'                => array(
			'label'          => __( 'Address 2', 'hspg' ),
			'data_type'      => 'user',
			'value_callback' => 'hs_get_donor_meta_value',
			'donation_form'  => array(
				'priority' => 12,
				'required' => false,
			),
			'admin_form'     => true,
			'email_tag'      => false,
			'show_in_meta'   => false,
			'show_in_export' => true,
		),
		'city'                     => array(
			'label'          => __( 'City', 'hspg' ),
			'data_type'      => 'user',
			'value_callback' => 'hs_get_donor_meta_value',
			'donation_form'  => array(
				'priority' => 14,
				'required' => false,
			),
			'admin_form'     => true,
			'email_tag'      => false,
			'show_in_meta'   => false,
			'show_in_export' => true,
		),
		'state'                    => array(
			'label'          => __( 'State', 'hspg' ),
			'data_type'      => 'user',
			'value_callback' => 'hs_get_donor_meta_value',
			'donation_form'  => array(
				'priority' => 16,
				'required' => false,
			),
			'admin_form'     => true,
			'email_tag'      => false,
			'show_in_meta'   => false,
			'show_in_export' => true,
		),
		'postcode'                 => array(
			'label'          => __( 'Postcode', 'hspg' ),
			'data_type'      => 'user',
			'value_callback' => 'hs_get_donor_meta_value',
			'donation_form'  => array(
				'priority' => 18,
				'required' => false,
			),
			'admin_form'     => true,
			'email_tag'      => false,
			'show_in_meta'   => false,
			'show_in_export' => true,
		),
		'country'                  => array(
			'label'          => __( 'Country', 'hspg' ),
			'data_type'      => 'user',
			'value_callback' => 'hs_get_donor_meta_value',
			'donation_form'  => array(
				'priority' => 20,
				'required' => false,
				'type'     => 'select',
				'options'  => hs_get_location_helper()->get_countries(),
				'default'  => hs_get_option( 'country' ),
			),
			'admin_form'     => true,
			'email_tag'      => false,
			'show_in_meta'   => false,
			'show_in_export' => true,
		),
		'phone'                    => array(
			'label'          => __( 'Phone Number', 'hspg' ),
			'data_type'      => 'user',
			'value_callback' => 'hs_get_donor_meta_value',
			'donation_form'  => array(
				'priority' => 22,
				'required' => false,
			),
			'admin_form'     => true,
			'email_tag'      => array(
				'tag'         => 'donor_phone',
				'description' => __( 'The donor\'s phone number', 'hspg' ),
				'preview'     => '1300 000 000',
			),
			'show_in_meta'   => true,
			'show_in_export' => true,
		),
		'campaigns'                => array(
			'label'          => __( 'Campaigns', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Will use Hs_Donation::get_campaigns().
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'description' => __( 'The campaigns that were donated to', 'hspg' ),
				'preview'     => __( 'Fake Campaign', 'hspg' ),
			),
			'show_in_meta'   => false,
			'show_in_export' => false,
		),
		'campaign_categories_list' => array(
			'label'          => __( 'Campaign Categories', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Will use Hs_Donation::get_campaign_categories_list().
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'campaign_categories',
				'description' => __( 'The categories of the campaigns that were donated to', 'hspg' ),
				'preview'     => __( 'Fake Category', 'hspg' ),
			),
			'show_in_meta'   => false,
			'show_in_export' => true,
		),
		'amount_formatted'         => array(
			'label'          => __( 'Donation Amount', 'hspg' ),
			'data_type'      => 'core',
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'donation_amount',
				'description' => __( 'The total amount donated', 'hspg' ),
				'preview'     => '$50.00',
			),
			'show_in_meta'   => false,
			'show_in_export' => false,
		),
		'date'                     => array(
			'label'          => __( 'Date of Donation', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Will use Hs_Donation::get_date().
			'donation_form'  => false,
			'admin_form'     => array(
				'type'           => 'datepicker',
				'priority'       => 4,
				'required'       => true,
				'section'        => 'meta',
				'default'        => date_i18n( 'F d, Y' ),
				'value_callback' => 'hs_get_donation_date_for_form_value',
			),
			'email_tag'      => array(
				'tag'         => 'donation_date',
				'description' => __( 'The date the donation was made', 'hspg' ),
				'preview'     => date_i18n( get_option( 'date_format' ) ),
			),
			'show_in_meta'   => false,
			'show_in_export' => true,
		),
		'time'                     => array(
			'label'          => __( 'Time of Donation', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Will use Hs_Donation::get_time().
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => false,
			'show_in_meta'   => false,
			'show_in_export' => true,
		),
		'status'                   => array(
			'label'          => __( 'Donation Status', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Will use Hs_Donation::get_status().
			'donation_form'  => false,
			'admin_form'     => array(
				'type'     => 'select',
				'priority' => 8,
				'required' => true,
				'section'  => 'meta',
				'options'  => hs_get_valid_donation_statuses(),
			),
			'email_tag'      => false,
			'show_in_meta'   => false,
			'show_in_export' => false,
		),
		'status_label'             => array(
			'label'          => __( 'Donation Status', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Will use Hs_Donation::get_status_label().
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'tag'         => 'donation_status',
				'description' => __( 'The status of the donation (pending, paid, etc.)', 'hspg' ),
				'preview'     => __( 'Paid', 'hspg' ),
			),
			'show_in_meta'   => false,
			'show_in_export' => true,
		),
		'donation_gateway'         => array(
			'label'          => __( 'Payment Method', 'hspg' ),
			'data_type'      => 'meta',
			'value_callback' => 'hs_get_donation_meta_value',
			'donation_form'  => false,
			'admin_form'     => array(
				'type'    => 'hidden',
				'section' => 'meta',
			),
			'email_tag'      => false,
			'show_in_meta'   => false,
			'show_in_export' => false,
		),
		'gateway_label'            => array(
			'label'          => __( 'Payment Method', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Will use Hs_Donation::get_gateway_label().
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => false,
			'show_in_meta'   => true,
			'show_in_export' => true,
		),
		'donation_key'             => array(
			'label'          => __( 'Donation Key', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Will use Hs_Donation::get_donation_key().
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => false,
			'show_in_meta'   => true,
			'show_in_export' => false,
		),
		'gateway_transaction_id'   => array(
			'label'          => __( 'Gateway Transaction ID', 'hspg' ),
			'data_type'      => 'meta',
			'value_callback' => false,
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'description' => __( 'The payment gateway\'s transaction ID for the donation', 'hspg' ),
				'preview'     => 'XYZ-2132323',
			),
			'show_in_meta'   => true,
			'show_in_export' => true,
		),
		'test_mode'                => array(
			'label'          => __( 'Donation made in test mode?', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Will use Hs_Donation::get_test_mode_text().
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => false,
			'show_in_meta'   => true,
			'show_in_export' => true,
		),
		'donation_summary'         => array(
			'label'          => __( 'Summary', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false, // Will use Hs_Donation::get_donation_summary().
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'description' => __( 'A summary of the donation', 'hspg' ),
				'preview'     => __( 'Fake Campaign: $50.00', 'hspg' ) . PHP_EOL,
			),
			'show_in_meta'   => false,
			'show_in_export' => false,
		),
		'contact_consent'          => array(
			'label'          => __( 'Contact Consent', 'hspg' ),
			'data_type'      => 'core',
			'value_callback' => false,
			'donation_form'  => false,
			'admin_form'     => false,
			'email_tag'      => array(
				'description' => __( 'Whether the donor gave consent to be contacted', 'hspg' ),
				'preview'     => __( 'Given', 'hspg' ),
			),
			'show_in_meta'   => false,
			'show_in_export' => true,
		),
	)
);
