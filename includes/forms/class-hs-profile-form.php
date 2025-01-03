<?php
/**
 * Class that manages the display and processing of the profile form.
 *
 * @package   Hspg/Classes/Hs_Profile_Form
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.5.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Profile_Form' ) ) :

	/**
	 * Hs_Profile_Form
	 *
	 * @since 1.0.0
	 */
	class Hs_Profile_Form extends Hs_Form {

		/**
		 * Shortcode parameters.
		 *
		 * @var array
		 */
		protected $shortcode_args;

		/**
		 * @var string
		 */
		protected $nonce_action = 'hs_user_profile';

		/**
		 * @var string
		 */
		protected $nonce_name = '_hs_user_profile_nonce';

		/**
		 * Action to be executed upon form submission.
		 *
		 * @var string
		 */
		protected $form_action = 'update_profile';

		/**
		 * The current user.
		 *
		 * @var Hs_User
		 */
		protected $user;

		/**
		 * Create class object.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args User-defined shortcode attributes.
		 */
		public function __construct( $args = array() ) {
			$this->id             = uniqid();
			$this->shortcode_args = $args;

			/* For backwards-compatibility */
			add_action( 'hs_form_field', array( $this, 'render_field' ), 10, 6 );
		}

		/**
		 * Return the current user's Hs_User object.
		 *
		 * @since  1.0.0
		 *
		 * @return Hs_User
		 */
		public function get_user() {
			if ( ! isset( $this->user ) ) {
				$this->user = new Hs_User( wp_get_current_user() );
			}

			return $this->user;
		}

		/**
		 * Returns the value of a particular key.
		 *
		 * @since  1.0.0
		 *
		 * @param  string $key     The key of the data we are searching for.
		 * @param  string $default Optional. The value that will be used if none is set.
		 * @return mixed
		 */
		public function get_user_value( $key, $default = '' ) {
			if ( isset( $_POST[ $key ] ) ) {
				return $_POST[ $key ];
			}

			$value = $this->get_user_prop_or_default( $key, $default );

			/**
			 * Deprecated filter. Use the filter below instead.
			 *
			 * @deprecated 1.8.0
			 *
			 * @since 1.0.0
			 * @since 1.5.7 Deprecated.
			 *
			 * @param string          $value The value.
			 * @param string          $key   The key of the value.
			 * @param Hs_User $user  Instance of `Hs_User`.
			 */
			$value = apply_filters( 'hs_campaign_submission_user_value', $value, $key, $this->get_user() );

			/**
			 * Filter the set value for a particular key.
			 *
			 * @since 1.5.7
			 *
			 * @param string          $value The value.
			 * @param string          $key   The key of the value.
			 * @param Hs_User $user  Instance of `Hs_User`.
			 */
			return apply_filters( 'hs_profile_value', $value, $key, $this->get_user() );
		}

		/**
		 * Return the core user fields.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_user_fields() {
			$user_fields = apply_filters( 'hs_user_fields', array(
				'username'     => array(
					'type'     => 'paragraph',
					'priority' => '',
					'content'  => sprintf(
						/* translators: %s: username */
						__( 'Username: %s.', 'hspg' ),
						$this->get_user()->user_login
					),
				),
				'first_name'   => array(
					'label'    => __( 'First name', 'hspg' ),
					'type'     => 'text',
					'priority' => 4,
					'required' => true,
					'value'    => $this->get_user_value( 'first_name' ),
				),
				'last_name'    => array(
					'label'    => __( 'Last name', 'hspg' ),
					'type'     => 'text',
					'priority' => 6,
					'required' => true,
					'value'    => $this->get_user_value( 'last_name' ),
				),
				'user_email'   => array(
					'label'    => __( 'Email', 'hspg' ),
					'type'     => 'email',
					'required' => true,
					'priority' => 8,
					'value'    => $this->get_user_value( 'user_email' ),
				),
				'organisation' => array(
					'label'    => __( 'Organization', 'hspg' ),
					'type'     => 'text',
					'priority' => 10,
					'required' => false,
					'value'    => $this->get_user_value( 'organisation' ),
				),
				'description'  => array(
					'label'    => __( 'Bio', 'hspg' ),
					'type'     => 'textarea',
					'required' => false,
					'priority' => 12,
					'value'    => $this->get_user_value( 'description' ),
				),
			), $this );

			uasort( $user_fields, 'hs_priority_sort' );

			return $user_fields;
		}

		/**
		 * Return the user's address fields.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_address_fields() {
			/**
			 * Filter the list of user address fields.
			 *
			 * @since 1.0.0
			 *
			 * @param array                   $fields The fields in the form.
			 * @param Hs_Profile_Form $form   The profile form.
			 */
			$address_fields = apply_filters(
				'hs_user_address_fields',
				array(
					'address'   => array(
						'label'    => __( 'Address', 'hspg' ),
						'type'     => 'text',
						'priority' => 22,
						'required' => false,
						'value'    => $this->get_user_value( 'donor_address' ),
					),
					'address_2' => array(
						'label'    => __( 'Address 2', 'hspg' ),
						'type'     => 'text',
						'priority' => 24,
						'required' => false,
						'value'    => $this->get_user_value( 'donor_address_2' ),
					),
					'city'      => array(
						'label'    => __( 'City', 'hspg' ),
						'type'     => 'text',
						'priority' => 26,
						'required' => false,
						'value'    => $this->get_user_value( 'donor_city' ),
					),
					'state'     => array(
						'label'    => __( 'State', 'hspg' ),
						'type'     => 'text',
						'priority' => 28,
						'required' => false,
						'value'    => $this->get_user_value( 'donor_state' ),
					),
					'postcode'  => array(
						'label'    => __( 'Postcode / ZIP code', 'hspg' ),
						'type'     => 'text',
						'priority' => 30,
						'required' => false,
						'value'    => $this->get_user_value( 'donor_postcode' ),
					),
					'country'   => array(
						'label'    => __( 'Country', 'hspg' ),
						'type'     => 'select',
						'options'  => hs_get_location_helper()->get_countries(),
						'priority' => 32,
						'required' => false,
						'value'    => $this->get_user_value( 'donor_country', hs_get_option( 'country' ) ),
					),
					'phone'     => array(
						'label'    => __( 'Phone', 'hspg' ),
						'type'     => 'text',
						'priority' => 34,
						'required' => false,
						'value'    => $this->get_user_value( 'donor_phone' ),
					),
				),
				$this
			);

			uasort( $address_fields, 'hs_priority_sort' );

			return $address_fields;
		}

		/**
		 * Return the social fields.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_social_fields() {
			$social_fields = apply_filters( 'hs_user_social_fields', array(
				'user_url' => array(
					'label'    => __( 'Your Website', 'hspg' ),
					'type'     => 'url',
					'priority' => 42,
					'required' => false,
					'value'    => $this->get_user_value( 'user_url' ),
				),
				'twitter'  => array(
					'label'    => __( 'Twitter', 'hspg' ),
					'type'     => 'text',
					'priority' => 44,
					'required' => false,
					'value'    => $this->get_user_value( 'twitter' ),
				),
				'facebook'  => array(
					'label'    => __( 'Facebook', 'hspg' ),
					'type'     => 'text',
					'priority' => 46,
					'required' => false,
					'value'    => $this->get_user_value( 'facebook' ),
				),
			), $this );

			uasort( $social_fields, 'hs_priority_sort' );

			return $social_fields;
		}

		/**
		 * Maybe add communication preferences fields.
		 *
		 * @since  1.6.2
		 *
		 * @param  array $fields The existing profile form fields.
		 * @return array
		 */
		public function maybe_get_communication_preferences_fields( $fields ) {
			if ( ! hs_is_contact_consent_activated() ) {
				return $fields;
			}

			$donor = $this->get_user()->get_donor();

			if ( array_key_exists( 'contact_consent', $_POST ) ) {
				$consent = $_POST['contact_consent'];
			} elseif ( is_null( $donor ) ) {
				$consent = false;
			} else {
				$consent = $donor->contact_consent;
			}

			/**
			 * Filter the communication preferences fields.
			 *
			 * @since 1.6.2
			 *
			 * @param array                   $communication_fields List of fields.
			 * @param Hs_Profile_Form $form                 Instance of `Hs_Profile_Form`.
			 */
			$communication_fields = apply_filters( 'hs_user_communication_preferences_fields', array(
				'contact_consent' => array(
					'type'     => 'checkbox',
					'label'    => hs_get_option( 'contact_consent_label', __( 'Yes, I am happy for you to contact me via email or phone.', 'hspg' ) ),
					'priority' => 8,
					'required' => false,
					'checked'  => $consent,
				),
			), $this );

			if ( empty( $communication_fields ) ) {
				return $fields;
			}

			uasort( $fields, 'hs_priority_sort' );

			return array_merge( $fields, array(
				'communication_fields' => array(
					'legend'   => __( 'Communication Preferences', 'hspg' ),
					'type'     => 'fieldset',
					'fields'   => $communication_fields,
					'priority' => 60,
				),
			) );
		}

		/**
		 * Profile fields to be displayed.
		 *
		 * @since  1.0.0
		 *
		 * @return array[]
		 */
		public function get_fields() {
			$fields = apply_filters( 'hs_user_profile_fields', array(
				'user_fields'     => array(
					'legend'   => __( 'Your Details', 'hspg' ),
					'type'     => 'fieldset',
					'fields'   => $this->get_user_fields(),
					'priority' => 0,
				),
				'password_fields' => array(
					'legend'   => __( 'Change Your Password', 'hspg' ),
					'type'     => 'fieldset',
					'fields'   => $this->get_password_fields(),
					'priority' => 10,
				),
				'address_fields'  => array(
					'legend'   => __( 'Your Address', 'hspg' ),
					'type'     => 'fieldset',
					'fields'   => $this->get_address_fields(),
					'priority' => 20,
				),
				'social_fields'   => array(
					'legend'   => __( 'Your Social Profiles', 'hspg' ),
					'type'     => 'fieldset',
					'fields'   => $this->get_social_fields(),
					'priority' => 40,
				),
			), $this );

			$fields = $this->maybe_get_communication_preferences_fields( $fields );

			uasort( $fields, 'hs_priority_sort' );

			return $fields;
		}

		/**
		 * Retrieve hidden fields.
		 *
		 * @since  1.6.2
		 *
		 * @return array
		 */
		public function get_hidden_fields() {
			return array_merge( parent::get_hidden_fields(), array(
				'current_email' => $this->get_user()->get_email(),
			) );
		}

		/**
		 * The fields displayed on the password form.
		 *
		 * @since  1.4.0
		 *
		 * @return array[]
		 */
		public function get_password_fields() {
			$password_fields = apply_filters( 'hs_user_profile_password_fields', array(
				'current_pass'     => array(
					'priority' => 2,
					'type'     => 'password',
					'label'    => __( 'Current Password (leave blank to leave unchanged)', 'hspg' ),
					'value'    => '',
					'required' => false,
				),
				'user_pass'        => array(
					'priority' => 4,
					'type'     => 'password',
					'label'    => __( 'New Password (leave blank to leave unchanged)', 'hspg' ),
					'required' => false,
				),
				'user_pass_repeat' => array(
					'priority' => 6,
					'type'     => 'password',
					'label'    => __( 'New Password (again)', 'hspg' ),
					'required' => false,
				),
			), $this );

			uasort( $password_fields, 'hs_priority_sort' );

			return $password_fields;
		}

		/**
		 * Returns all fields as a merged array.
		 *
		 * @since  1.0.0
		 *
		 * @return array[]
		 */
		public function get_merged_fields() {
			$fields = array();

			foreach ( $this->get_fields() as $key => $section ) {

				if ( isset( $section['fields'] ) ) {
					$fields = array_merge( $fields, $section['fields'] );
				} else {
					$fields[ $key ] = $section;
				}
			}

			return $fields;
		}

		/**
		 * Update profile after form submission.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public static function update_profile() {
			$form = new Hs_Profile_Form();

			if ( ! $form->validate_nonce() || ! $form->validate_honeypot() ) {
				hs_get_notices()->add_error( __( 'Unfortunately, we were unable to verify your form submission. Please reload the page and try again.', 'hspg' ) );
				return;
			}

			$user = $form->get_user();

			/* Verify that the user is logged in. */
			if ( 0 == $user->ID ) {
				return;
			}

			$fields = $form->get_merged_fields();

			$submitted = apply_filters( 'hs_profile_update_values', $_POST, $fields, $form );

			/* Remove the current_pass and user_pass_repeat fields, if set. */
			unset(
				$submitted['current_pass'],
				$submitted['user_pass_repeat']
			);

			$valid = $form->check_required_fields( $fields );

			if ( $valid && $form->is_changing_password() ) {
				$valid = $form->validate_password_change();
			}

			if ( $valid && $form->is_changing_email() ) {
				$valid = $form->validate_email_change();
			}

			if ( $valid ) {
				$user->update_profile( $submitted, array_keys( $fields ) );

				hs_get_notices()->add_success( __( 'Your profile has been updated.', 'hspg' ) );

				do_action( 'hs_profile_updated', $submitted, $fields, $form );
			}
		}

		/**
		 * Check whether the password is being changed.
		 *
		 * @since  1.4.0
		 *
		 * @return boolean
		 */
		public function is_changing_password() {
			if ( ! isset( $_POST['user_pass'] ) || empty( $_POST['user_pass'] ) ) {
				return false;
			}

			if ( ! isset( $_POST['current_pass'] ) || empty( $_POST['current_pass'] ) ) {
				return false;
			}

			return true;
		}

		/**
		 * Changes a password if the current password is correct and the repeat matches the new password.
		 *
		 * @since  1.4.0
		 *
		 * @return boolean
		 */
		public function validate_password_change() {
			/* The current password must be correct. */
			if ( false == wp_check_password( $_POST['current_pass'], $this->get_user()->user_pass ) ) {
				hs_get_notices()->add_error( __( 'Current password is incorrect.', 'hspg' ) );
				return false;
			}

			/* The new password must match the repeat (if set). */
			if ( isset( $_POST['user_pass_repeat'] ) && $_POST['user_pass_repeat'] != $_POST['user_pass'] ) {
				hs_get_notices()->add_error( __( 'New passwords did not match.', 'hspg' ) );
				return false;
			}

			return true;
		}

		/**
		 * Check whether the email address is being changed.
		 *
		 * @since  1.6.2
		 *
		 * @return boolean
		 */
		public function is_changing_email() {
			if ( ! isset( $_POST['user_email'] ) || empty( $_POST['user_email'] ) ) {
				return false;
			}

			if ( ! isset( $_POST['current_email'] ) ) {
				return $_POST['user_email'] != $this->get_user()->get_email();
			}

			return $_POST['user_email'] != $_POST['current_email'];
		}

		/**
		 * Validate the email change.
		 *
		 * @since  1.6.2
		 *
		 * @return boolean
		 */
		public function validate_email_change() {
			if ( 0 != hs_get_donor_id_by_email( $_POST['user_email'] ) ) {
				hs_get_notices()->add_error(
					__( 'This email address is already in use.', 'hspg' )
				);
				return false;
			}

			return true;
		}

		/**
		 * Return a user's set value for a particular value, or return the default value.
		 *
		 * @since  1.5.7
		 *
		 * @param  string $key     The property we're getting the value for.
		 * @param  string $default The fallback value.
		 * @return string
		 */
		protected function get_user_prop_or_default( $key, $default ) {
			$user = $this->get_user();

			return $user && $user->has_prop( $key ) ? $user->get( $key ) : $default;
		}

		/**
		 * Add the hs_user_profile_after_fields hook but fire off a deprecated notice.
		 *
		 * @deprecated 1.4.0
		 * @since  1.4.0
		 *
		 * @return void
		 */
		public static function add_deprecated_hs_user_profile_after_fields_hook( $form ) {
			if ( ! has_action( 'hs_user_profile_after_fields' ) ) {
				return;
			}

			hs_get_deprecated()->doing_it_wrong(
				__METHOD__,
				__( 'hs_user_profile_after_fields hook has been removed. Use hs_form_after_fields instead.', 'hspg' ),
				'1.4.0'
			);

			if ( 'Hs_Profile_Form' == get_class( $form ) ) {
				do_action( 'hs_user_profile_after_fields', $form );
			}
		}
	}

endif;
