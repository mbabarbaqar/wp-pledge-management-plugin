<?php
/**
 * Hspg Privacy Settings UI.
 *
 * @package   Hspg/Classes/Hs_Privacy_Settings
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.6.0
 * @version   1.6.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Privacy_Settings' ) ) :

	/**
	 * Hs_Privacy_Settings
	 *
	 * @since 1.6.0
	 */
	final class Hs_Privacy_Settings {

		/**
		 * The single instance of this class.
		 *
		 * @since  1.6.0
		 *
		 * @var    Hs_Privacy_Settings|null
		 */
		private static $instance = null;

		/**
		 * Create object instance.
		 *
		 * @since   1.6.0
		 */
		private function __construct() {
		}

		/**
		 * Returns and/or create the single instance of this class.
		 *
		 * @since   1.6.0
		 *
		 * @return  Hs_Privacy_Settings
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Add the privacy tab settings fields.
		 *
		 * @since   1.6.0
		 *
		 * @return  array<string,array>
		 */
		public function add_privacy_fields() {
			if ( ! hs_is_settings_view( 'privacy' ) ) {
				return array();
			}

			$data_fields = $this->get_user_donation_field_options();

			return array(
				'section'                       => array(
					'title'    => '',
					'type'     => 'hidden',
					'priority' => 10000,
					'value'    => 'privacy',
				),
				'section_privacy_description'   => array(
					'type'     => 'content',
					'priority' => 20,
					'content'  => '<div class="hs-settings-notice">'
								. '<p>' . __( 'Hspg stores personal data such as donors\' names, email addresses, addresses and phone numbers in your database. Donors may request to have their personal data erased, but you may be legally required to retain some personal data for donations made within a certain time. Below you can control how long personal data is retained for at a minimum, as well as which data fields must be retained.' ) . '</p>'
								. '<p><a href="https://www.wphspg.com/documentation/hs-user-privacy/?utm_source=privacy-page&utm_medium=wordpress-dashboard&utm_campaign=documentation">' . __( 'Read more about Hspg & user privacy', 'hspg' ) . '</a></p>'
								. '</div>',
				),
				'minimum_data_retention_period' => array(
					'label_for' => __( 'Minimum Data Retention Period', 'hspg' ),
					'type'      => 'select',
					'help'      => sprintf(
						/* translators: %1$s: HTML strong tag. %2$s: HTML closing strong tag. %1$s: HTML break tag. */
						__( 'Prevent personal data from being erased for donations made within a certain amount of time.%3$sChoose %1$sNone%2$s to allow the personal data of any donation to be erased.%3$sChoose %1$sForever%2$s to prevent any personal data from being erased from donations, regardless of how long ago they were made.' ),
						'<strong>',
						'</strong>',
						'<br />'
					),
					'priority'  => 25,
					'default'   => 2,
					'options'   => array(
						0         => __( 'None', 'hspg' ),
						1         => __( 'One year', 'hspg' ),
						2         => __( 'Two years', 'hspg' ),
						3         => __( 'Three years', 'hspg' ),
						4         => __( 'Four years', 'hspg' ),
						5         => __( 'Five years', 'hspg' ),
						6         => __( 'Six years', 'hspg' ),
						7         => __( 'Seven years', 'hspg' ),
						8         => __( 'Eight years', 'hspg' ),
						9         => __( 'Nine years', 'hspg' ),
						10        => __( 'Ten years', 'hspg' ),
						'endless' => __( 'Forever', 'hspg' ),
					),
				),
				'data_retention_fields'         => array(
					'label_for' => __( 'Retained Data', 'hspg' ),
					'type'      => 'multi-checkbox',
					'priority'  => 30,
					'default'   => array_keys( $data_fields ),
					'options'   => $data_fields,
					'help'      => __( 'The checked fields will not be erased fields when personal data is erased for a donation made within the Minimum Data Retention Period.', 'hspg' ),
					'attrs'     => array(
						'data-trigger-key'   => '#hs_settings_minimum_data_retention_period',
						'data-trigger-value' => '!0',
					),
				),
			);
		}

		/**
		 * Return the list of user donation field options.
		 *
		 * @since  1.6.0
		 *
		 * @return string[]
		 */
		protected function get_user_donation_field_options() {
			$fields = hspg()->donation_fields()->get_data_type_fields( 'user' );

			return array_combine(
				array_keys( $fields ),
				wp_list_pluck( $fields, 'label' )
			);
		}
	}

endif;
