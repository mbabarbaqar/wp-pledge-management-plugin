<?php
/**
 * Class that is responsible for generating a CSV export of donations.
 *
 * @package   Hspg/Classes/Hs_Export_Donations
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.25
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Export_Donations' ) ) :

	/**
	 * Hs_Export_Donations
	 *
	 * @since 1.0.0
	 */
	class Hs_Export_Donations extends Hs_Export {

		/* The type of export. */
		const EXPORT_TYPE = 'donations';

		/**
		 * Default arguments.
		 *
		 * @since 1.0.0
		 *
		 * @var   mixed[]
		 */
		protected $defaults;

		/**
		 * List of donation statuses.
		 *
		 * @since 1.0.0
		 *
		 * @var   string[]
		 */
		protected $statuses;

		/**
		 * Exportable donation fields.
		 *
		 * @since 1.5.0
		 *
		 * @var   array
		 */
		protected $fields;

		/**
		 * Set Hs_Donation objects.
		 *
		 * @since 1.5.0
		 *
		 * @var   Hs_Donation[]
		 */
		protected $donations = array();

		/**
		 * Create class object.
		 *
		 * @since 1.0.0
		 *
		 * @param mixed[] $args Arguments for the report.
		 */
		public function __construct( $args ) {
			$this->defaults = array(
				'start_date'  => '',
				'end_date'    => '',
				'campaign_id' => 'all',
				'status'      => 'all',
			);

			$this->statuses = hs_get_valid_donation_statuses();
			$this->fields   = array_map( array( $this, 'get_field_label' ), hspg()->donation_fields()->get_export_fields() );

			parent::__construct( $args );
		}

		/**
		 * Filter the date and time fields.
		 *
		 * @since  1.0.0
		 *
		 * @param  mixed  $value The value to set.
		 * @param  string $key   The key to set.
		 * @param  array  $data  The set of data.
		 * @return mixed
		 */
		public function set_custom_field_data( $value, $key, $data ) {
			if ( array_key_exists( $key, $this->fields ) ) {
				$donation = $this->get_donation( $data['donation_id'] );
				$value    = hs_get_sanitized_donation_field_value( $donation->get( $key ), $key );
			}

			return $value;
		}

		/**
		 * Return the CSV column headers.
		 *
		 * The columns are set as a key=>label array, where the key is used to retrieve the data for that column.
		 *
		 * @since  1.0.0
		 *
		 * @return string[]
		 */
		protected function get_csv_columns() {
			$non_field_columns = array(
				'campaign_id'   => '',
				'campaign_name' => '',
				'amount'        => '',
			);

			$default_columns = array(
				'donation_id'     => __( 'Donation ID', 'hspg' ),
				'campaign_id'     => __( 'Campaign ID', 'hspg' ),
				'campaign_name'   => __( 'Campaign Title', 'hspg' ),
				'first_name'      => __( 'First Name', 'hspg' ),
				'last_name'       => __( 'Last Name', 'hspg' ),
				'email'           => __( 'Email', 'hspg' ),
				'address'         => __( 'Address', 'hspg' ),
				'address_2'       => __( 'Address 2', 'hspg' ),
				'city'            => __( 'City', 'hspg' ),
				'state'           => __( 'State', 'hspg' ),
				'postcode'        => __( 'Postcode', 'hspg' ),
				'country'         => __( 'Country', 'hspg' ),
				'phone'           => __( 'Phone Number', 'hspg' ),
				'donor_address'   => __( 'Address Formatted', 'hspg' ),
				'amount'          => __( 'Donation Amount', 'hspg' ),
				'date'            => __( 'Date of Donation', 'hspg' ),
				'time'            => __( 'Time of Donation', 'hspg' ),
				'status_label'    => __( 'Donation Status', 'hspg' ),
				'gateway_label'   => __( 'Donation Gateway', 'hspg' ),
				'test_mode'       => __( 'Made in Test Mode', 'hspg' ),
				'contact_consent' => __( 'Contact Consent', 'hspg' ),
			);

			/**
			 * Filter the list of columns in the export.
			 *
			 * As of Hspg 1.5, the recommended way to add or remove columns to the
			 * donation export is through the Donation Fields API. This filter is primarily
			 * provided for backwards compatibility and also provides a way to change export
			 * column headers without changing the label for the Donation Field.
			 *
			 * @since 1.0.0
			 *
			 * @param array $columns List of columns.
			 * @param array $args    Export args.
			 */
			$filtered = apply_filters( 'hs_export_donations_columns', $default_columns, $this->args );

			return $this->get_merged_fields( $default_columns, $this->fields, $non_field_columns, $filtered );
		}

		/**
		 * Return a Donation object for the given ID.
		 *
		 * @since  1.5.0
		 *
		 * @param  int $donation_id The donation ID.
		 * @return Hs_Donation
		 */
		protected function get_donation( $donation_id ) {
			if ( ! array_key_exists( $donation_id, $this->donations ) ) {
				$this->donations[ $donation_id ] = hs_get_donation( $donation_id );
			}

			return $this->donations[ $donation_id ];
		}

		/**
		 * Get the data to be exported.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		protected function get_data() {
			$query_args = array();

			if ( strlen( $this->args['start_date'] ) ) {
				$query_args['start_date'] = hs_sanitize_date( $this->args['start_date'], 'Y-m-d 00:00:00' );
			}

			if ( strlen( $this->args['end_date'] ) ) {
				$query_args['end_date'] = hs_sanitize_date( $this->args['end_date'], 'Y-m-d 23:59:59' );
			}

			if ( 'all' != $this->args['campaign_id'] ) {
				$query_args['campaign_id'] = $this->args['campaign_id'];
			}

			if ( 'all' != $this->args['status'] ) {
				$query_args['status'] = $this->args['status'];
			}

			/**
			 * Filter name with misspelling.
			 *
			 * @deprecated 1.7.0
			 *
			 * @since 1.3.5
			 */
			$query_args = apply_filters( 'chairtable_export_donations_query_args', $query_args, $this->args );

			/**
			 * Filter donations query arguments.
			 *
			 * @since 1.3.5
			 *
			 * @param array $query_args The query arguments.
			 * @param array $args       The export arguments.
			 */
			$query_args = apply_filters( 'hs_export_donations_query_args', $query_args, $this->args );

			return hs_get_table( 'campaign_donations' )->get_donations_report( $query_args );
		}

		/**
		 * Return the field label for a registered Donation Field.
		 *
		 * @since  1.5.0
		 *
		 * @param  Hs_Donation_Field $field Instance of `Hs_Donation_Field`.
		 * @return string
		 */
		protected function get_field_label( Hs_Donation_Field $field ) {
			return $field->label;
		}
	}

endif;
