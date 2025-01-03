<?php
/**
 * Add support for switching between locales.
 *
 * @package   Hspg/Classes/Hs_Locale
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.6.43
 * @version   1.6.43
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Locale' ) ) :

	/**
	 * Hs_Locale
	 *
	 * @since 1.6.43
	 */
	class Hs_Locale {

		/**
		 * The current locale.
		 *
		 * @since 1.6.43
		 *
		 * @var   string
		 */
		private $locale;

		/**
		 * The locale to use for the email being sent.
		 *
		 * @since 1.6.43
		 *
		 * @var   string
		 */
		private $email_locale;

		/**
		 * Create class object.
		 *
		 * @since 1.6.43
		 */
		public function __construct() {
			/**
			 * Boolean flag to decide whether to enable the locale functions.
			 *
			 * @since 1.6.43
			 *
			 * @param boolean $locale_enabled Whether to enable locale functions.
			 */
			if ( ! apply_filters( 'hs_enable_locale_functions', false ) ) {
				return;
			}

			$this->locale = get_locale();

			/**
			 * Add locale as donation and campaign fields.
			 */
			add_filter( 'hs_default_donation_fields', array( $this, 'add_locale_donation_field' ) );
			add_filter( 'hs_default_campaign_fields', array( $this, 'add_locale_campaign_field' ) );

			/**
			 * Store current locale when a donation is made.
			 */
			add_filter( 'hs_donation_meta', array( $this, 'save_donation_locale' ) );

			/**
			 * Before sending an email, start filtering the locale based
			 * on the stored locale for the campaign or donation.
			 */
			add_action( 'hs_before_send_email', array( $this, 'maybe_set_email_locale' ) );
		}

		/**
		 * Add locale donation field.
		 *
		 * @since  1.6.43
		 *
		 * @param  array $fields The default registered fields.
		 * @return array
		 */
		public function add_locale_donation_field( $fields ) {
			$fields['locale'] = array(
				'label'          => __( 'Donor Locale', 'hspg' ),
				'data_type'      => 'meta',
				'donation_form'  => false,
				'admin_form'     => false,
				'show_in_meta'   => true,
				'show_in_export' => true,
				'email_tag'      => false,
			);

			return $fields;
		}

		/**
		 * Add locale campaign field.
		 *
		 * @since  1.6.43
		 *
		 * @param  array $fields The default registered fields.
		 * @return array
		 */
		public function add_locale_campaign_field( $fields ) {
			$fields['locale'] = array(
				'label'          => __( 'Campaign Creator Locale', 'hspg' ),
				'data_type'      => 'meta',
				'campaign_form'  => false,
				'admin_form'     => false,
				'show_in_export' => true,
				'email_tag'      => false,
			);

			return $fields;
		}

		/**
		 * Save the locale that a donor was using when they donated.
		 *
		 * @since  1.6.43
		 *
		 * @param  array $meta_fields The meta fields to be saved.
		 * @return array
		 */
		public function save_donation_locale( $meta_fields ) {
			$meta_fields['locale'] = get_locale();
			return $meta_fields;
		}

		/**
		 * Maybe set a locale for the email.
		 *
		 * @since  1.6.43
		 *
		 * @param  Hs_Email $email The email object.
		 * @return void
		 */
		public function maybe_set_email_locale( Hs_Email $email ) {
			$donation = $email->get( 'donation' );
			$campaign = $email->get( 'campaign' );

			if ( is_a( $donation, 'Hs_Donation' ) ) {
				$this->email_locale = $donation->get( 'locale' );
			} elseif ( is_a( $campaign, 'Hs_Campaign' ) ) {
				$this->email_locale = $campaign->get( 'locale' );
			}

			if ( ! empty( $this->email_locale ) ) {
				add_filter( 'locale', array( $this, 'set_email_locale' ) );
				add_action( 'hs_after_send_email', array( $this, 'turn_off_email_locale_filter' ) );
			}
		}

		/**
		 * Set the locale to use for an email.
		 *
		 * @since  1.6.43
		 *
		 * @return string
		 */
		public function set_email_locale() {
			return $this->email_locale;
		}

		/**
		 * Turn off the email locale filter.
		 *
		 * @since  1.6.43
		 *
		 * @return void
		 */
		public function turn_off_email_locale_filter() {
			remove_filter( 'locale', array( $this, 'set_email_locale' ) );
		}
	}

endif;
