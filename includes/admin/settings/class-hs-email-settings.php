<?php
/**
 * Hspg Email Settings UI.
 *
 * @package   Hspg/Classes/Hs_Email_Settings
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Email_Settings' ) ) :

	/**
	 * Hs_Email_Settings
	 *
	 * @final
	 * @since 1.0.0
	 */
	final class Hs_Email_Settings {

		/**
		 * The single instance of this class.
		 *
		 * @var Hs_Email_Settings|null
		 */
		private static $instance = null;

		/**
		 * Returns and/or create the single instance of this class.
		 *
		 * @since  1.2.0
		 *
		 * @return Hs_Email_Settings
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Create object instance.
		 *
		 * @since 1.0.0
		 */
		private function __construct() {
		}

		/**
		 * Returns all the payment email settings fields.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function add_email_fields() {
			if ( ! hs_is_settings_view( 'emails' ) ) {
				return array();
			}

			return array(
				'section'              => array(
					'title'    => '',
					'type'     => 'hidden',
					'priority' => 10000,
					'value'    => 'emails',
					'save'     => false,
				),
				'section_emails'        => array(
					'title'    => __( 'Available Emails', 'hspg' ),
					'type'     => 'heading',
					'priority' => 5,
				),
				'emails'                => array(
					'title'    => false,
					'callback' => array( $this, 'render_emails_table' ),
					'priority' => 7,
				),
				'section_email_general' => array(
					'title'    => __( 'General Email Settings', 'hspg' ),
					'type'     => 'heading',
					'priority' => 10,
				),
				'email_from_name'       => array(
					'title'    => __( '"From" Name', 'hspg' ),
					'type'     => 'text',
					'help'     => __( 'The name of the email sender.', 'hspg' ),
					'priority' => 12,
					'default'  => get_option( 'blogname' ),
				),
				'email_from_email'      => array(
					'title'    => __( '"From" Email', 'hspg' ),
					'type'     => 'email',
					'help'     => __( 'The email address of the email sender. This will be the address recipients email if they hit "Reply".', 'hspg' ),
					'priority' => 14,
					'default'  => get_option( 'admin_email' ),
				),
			);
		}

		/**
		 * Add settings for each individual email.
		 *
		 * @since  1.0.0
		 *
		 * @param  array $fields Array of settings fields.
		 * @return array[]
		 */
		public function add_individual_email_fields( $fields ) {
			foreach ( hs_get_helper( 'emails' )->get_available_emails() as $email ) {
				$email = new $email;
				$key   = 'emails_' . $email->get_email_id();

				/**
				 * Filter the email fields.
				 *
				 * This filter is primarily useful for adding settings to multiple emails.
				 * If you only want to add fields to one particular email, use this hook instead:
				 *
				 * hs_settings_fields_emails_email_{email_id}
				 *
				 * @see   Hs_Email::email_settings
				 *
				 * @since 1.0.0
				 *
				 * @param array            $settings Email settings.
				 * @param Hs_Email $email    The `Hs_Email` instance.
				 */
				$fields[ $key ] = apply_filters( 'hs_settings_fields_emails_email', $email->email_settings(), $email );
			}

			return $fields;
		}

		/**
		 * Display table with emails.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public function render_emails_table( $args ) {
			hs_admin_view( 'settings/emails', $args );
		}

		/**
		 * Add email keys to the settings groups.
		 *
		 * @deprecated 1.8.0
		 *
		 * @since  1.0.0
		 * @since  1.5.7 Deprecated.
		 *
		 * @param  string[] $groups Array of settings groups.
		 * @return string[]
		 */
		public function add_email_settings_dynamic_groups( $groups ) {
			hs_get_deprecated()->deprecated_function(
				__METHOD__,
				'1.5.7',
				'Hs_Email_Settings::add_individual_email_fields()'
			);

			return $this->add_individual_email_fields( $groups );
		}
	}

endif;
