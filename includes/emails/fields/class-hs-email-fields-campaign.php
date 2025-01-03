<?php
/**
 * Email Fields Campaign class.
 *
 * @package   Hspg/Classes/Hs_Email_Fields_Campaign
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.6.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Email_Fields_Campaign' ) ) :

	/**
	 * Hs_Email_Fields class.
	 *
	 * @since 1.5.0
	 */
	class Hs_Email_Fields_Campaign implements Hs_Email_Fields_Interface {

		/**
		 * The Hs_Campaign object.
		 *
		 * @since 1.5.0
		 *
		 * @var   Hs_Campaign
		 */
		private $campaign;

		/**
		 * Set up class instance.
		 *
		 * @since 1.5.0
		 *
		 * @param Hs_Email $email   The email object.
		 * @param boolean          $preview Whether this is an email preview.
		 */
		public function __construct( Hs_Email $email, $preview ) {
			$this->email    = $email;
			$this->preview  = $preview;
			$this->campaign = $email->get_campaign();
			$this->fields   = $this->init_fields();
		}

		/**
		 * Get the fields that apply to the current email.
		 *
		 * @since  1.5.0
		 *
		 * @return array
		 */
		public function init_fields() {
			$fields = hspg()->campaign_fields()->get_email_tag_fields();
			$fields = array_map( array( $this, 'parse_campaign_field' ), $fields );
			$fields = array_combine( wp_list_pluck( $fields, 'tag' ), $fields );

			/**
			 * Filter the campaign email fields.
			 *
			 * @since 1.5.0
			 *
			 * @param array               $fields   The default set of fields.
			 * @param Hs_Campaign $campaign Instance of `Hs_Campaign`.
			 * @param Hs_Email    $email    Instance of `Hs_Email`.
			 */
			return apply_filters( 'hs_email_campaign_fields', $fields, $this->campaign, $this->email );
		}

		/**
		 * Return fields.
		 *
		 * @since  1.5.0
		 *
		 * @return array
		 */
		public function get_fields() {
			return $this->fields;
		}

		/**
		 * Checks whether the email has a valid Campaign object set.
		 *
		 * @since  1.5.0
		 *
		 * @return boolean
		 */
		public function has_valid_campaign() {
			return ! is_null( $this->campaign ) && is_a( $this->campaign, 'Hs_Campaign' );
		}

		/**
		 * Display whether the campaign achieved its goal.
		 *
		 * @since  1.5.0
		 *
		 * @param  string $value The content to display in place of the shortcode.
		 * @param  array  $args  Optional set of arguments.
		 * @return string
		 */
		public function get_goal_achieved_message( $value, $args ) {
			$args = wp_parse_args( $args, array(
				'success' => '',
				'failure' => '',
			) );

			return $this->campaign->get_goal_achieved_message( $args['success'], $args['failure'] );
		}

		/**
		 * Return the value for a particular field that is registered as a Hs_Campaign_Field.
		 *
		 * @since  1.6.0
		 *
		 * @param  string $value The content to display in place of the shortcode.
		 * @param  array  $args  Optional set of arguments.
		 * @return string
		 */
		public function get_value_from_campaign_field( $value, $args ) {
			if ( ! array_key_exists( $args['show'], $this->fields ) || ! array_key_exists( 'field', $this->fields[ $args['show'] ] ) ) {
				return '';
			}

			return $this->campaign->get( $this->fields[ $args['show'] ]['field'] );
		}

		/**
		 * Parse a campaign field, returning just the email tag parameters.
		 *
		 * @since  1.6.0
		 *
		 * @param  Hs_Campaign_Field $field A Hs_Campaign_Field instance.
		 * @return array
		 */
		private function parse_campaign_field( Hs_Campaign_Field $field ) {
			$tag_settings          = $field->email_tag;
			$tag_settings['field'] = $field->field;

			if ( method_exists( $this, 'get_' . $field->field ) ) {
				$tag_settings['callback'] = array( $this, 'get_' . $field->field );
			} else {
				$tag_settings['callback'] = array( $this, 'get_value_from_campaign_field' );
			}

			return $tag_settings;
		}
	}

endif;
