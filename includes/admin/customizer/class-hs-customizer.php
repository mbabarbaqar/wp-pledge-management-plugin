<?php
/**
 * Class that sets up the WordPress Customizer integration.
 *
 * @package   Hspg/Classes/Hs_Customizer
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.2.0
 * @version   1.6.44
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Customizer' ) ) :

	/**
	 * Sets up the WordPress customizer.
	 *
	 * @since 1.2.0
	 */
	class Hs_Customizer {

		/**
		 * The single instance of this class.
		 *
		 * @var Hs_Customizer|null
		 */
		private static $instance = null;

		/**
		 * Create object instance.
		 *
		 * @since 1.2.0
		 */
		private function __construct() {
			add_action( 'customize_save_after', array( $this, 'customize_save_after' ) );
			add_action( 'customize_register', array( $this, 'register_customizer_fields' ) );
			add_action( 'customize_preview_init', array( $this, 'load_customizer_script' ) );
		}

		/**
		 * Returns and/or create the single instance of this class.
		 *
		 * @since  1.2.0
		 *
		 * @global WP_Customize_Manager $wp_customize
		 * @return Hs_Customizer
		 */
		public static function start() {
			global $wp_customize;

			if ( ! $wp_customize ) {
				return;
			}

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * After the customizer has finished saving each of the fields, delete the transient.
		 *
		 * @see    customize_save_after hook
		 *
		 * @since  1.2.0
		 *
		 * @return void
		 */
		public function customize_save_after() {
			delete_transient( 'hs_custom_styles' );
		}

		/**
		 * Plugin customization.
		 *
		 * @return void
		 */
		public function register_customizer_fields() {
			$fields = array(
				'title'      => __( 'Hspg', 'hspg' ),
				'priority'   => 1000,
				'capability' => 'manage_hs_settings',
				'sections'   => array(
					'hs_donation_form'        => array(
						'title'    => __( 'Donation Form', 'hspg' ),
						'priority' => 1020,
						'settings' => array(
							'donation_form_display' => array(
								'setting' => array(
									'transport'         => 'refresh',
									'default'           => 'separate_page',
									'sanitize_callback' => array( $this, 'sanitize_donation_form_display_option' ),
								),
								'control' => array(
									'type'     => 'select',
									'label'    => __( 'How do you want a campaign\'s donation form to show?', 'hspg' ),
									'priority' => 1022,
									'choices'  => array(
										'separate_page' => __( 'Show on a Separate Page', 'hspg' ),
										'same_page'     => __( 'Show on the Same Page', 'hspg' ),
										'modal'         => __( 'Reveal in a Modal', 'hspg' ),
									),
								),
							),
							'donation_form_minimal_fields' => array(
								'setting' => array(
									'transport' => 'refresh',
									'default'   => 0,
								),
								'control' => array(
									'type'     => 'radio',
									'label'    => __( 'Only show required fields', 'hspg' ),
									'priority' => 1024,
									'choices'  => array(
										1 => __( 'Yes', 'hspg' ),
										0 => __( 'No', 'hspg' ),
									),
								),
							),
						),
					),
					'hs_privacy'              => array(
						'title'    => __( 'User Privacy', 'hspg' ),
						'priority' => 1030,
						'settings' => array(
							'privacy_policy_page'   => array(
								'setting' => array(
									'transport' => 'refresh',
									'default'   => '',
								),
								'control' => array(
									'type'           => 'dropdown-pages',
									'label'          => __( 'Privacy policy page', 'hspg' ),
									'priority'       => 1032,
									'allow_addition' => true,
								),
							),
							'privacy_policy'        => array(
								'setting' => array(
									'transport'         => 'refresh',
									'default'           => __( 'Your personal data will be used to process your donation, support your experience throughout this website, and for other purposes described in our [privacy_policy].', 'hspg' ),
									'sanitize_callback' => function_exists( 'sanitize_textarea_field' ) ? 'sanitize_textarea_field' : 'sanitize_text_field',
								),
								'control' => array(
									'type'        => 'textarea',
									'label'       => __( 'Privacy policy', 'hspg' ),
									'description' => __( 'Information about your website privacy policy for people to see when they donate, register an account, or manage their profile. Leave empty to disable.', 'hspg' ),
									'priority'    => 1034,
								),
							),
							'contact_consent'       => array(
								'setting' => array(
									'transport' => 'refresh',
									'default'   => 0,
								),
								'control' => array(
									'type'        => 'radio',
									'label'       => __( 'Contact consent field', 'hspg' ),
									'description' => __( 'Display a checkbox asking people for their consent to being contacted when they donate, register an account, or manage their profile.', 'hspg' ),
									'priority'    => 1036,
									'choices'     => array(
										1 => __( 'Yes', 'hspg' ),
										0 => __( 'No', 'hspg' ),
									),
								),
							),
							'contact_consent_label' => array(
								'setting' => array(
									'transport'         => 'refresh',
									'default'           => __( 'Yes, I am happy for you to contact me via email or phone.', 'hspg' ),
									'sanitize_callback' => function_exists( 'sanitize_textarea_field' ) ? 'sanitize_textarea_field' : 'sanitize_text_field',
								),
								'control' => array(
									'type'        => 'textarea',
									'label'       => __( 'Contact consent label', 'hspg' ),
									'priority'    => 1038,
									'description' => __( 'A short statement describing how you would like to contact people.', 'hspg' ),
								),
							),
						),
					),
					'hs_terms_and_conditions' => array(
						'title'    => __( 'Terms & Conditions', 'hspg' ),
						'priority' => 1040,
						'settings' => array(
							'terms_conditions_page' => array(
								'setting' => array(
									'transport' => 'refresh',
									'default'   => '',
								),
								'control' => array(
									'type'           => 'dropdown-pages',
									'label'          => __( 'Terms and conditions page', 'hspg' ),
									'priority'       => 1042,
									'allow_addition' => true,
								),
							),
							'terms_conditions'      => array(
								'setting' => array(
									'transport'         => 'refresh',
									'default'           => __( 'I have read and agree to the website [terms].', 'hspg' ),
									'sanitize_callback' => 'sanitize_text_field',
								),
								'control' => array(
									'type'        => 'textarea',
									'label'       => __( 'Terms and conditions', 'hspg' ),
									'description' => __( 'Display a checkbox asking people to accept the website terms and conditions when they make a donation or register an account. Leave empty to disable.', 'hspg' ),
									'priority'    => 1044,
								),
							),
						),
					),
				),
			);

			/* Remove the contact consent fields if the database upgrade hasn't been completed yet. */
			if ( ! Hs_Upgrade::get_instance()->upgrade_has_been_completed( 'upgrade_donor_tables' ) ) {
				unset(
					$fields['sections']['hs_donation_form']['contact_consent'],
					$fields['sections']['hs_donation_form']['contact_consent_label']
				);
			}

			/**
			 * Set whether to add custom styles.
			 *
			 * @since 1.2.3
			 *
			 * @param boolean Whether to add styles.
			 */
			if ( apply_filters( 'hs_add_custom_styles', true ) ) {

				/**
				 * Filter the default highlight colour.
				 *
				 * @since 1.2.0
				 *
				 * @param string $colour_code HEX color code.
				 */
				$highlight_colour = apply_filters( 'hs_default_highlight_colour', '#f89d35' );

				$fields['sections']['hs_design'] = array(
					'title'    => __( 'Design Options', 'hspg' ),
					'priority' => 1010,
					'settings' => array(
						'highlight_colour' => array(
							'setting' => array(
								'transport'         => 'postMessage',
								'default'           => $highlight_colour,
								'sanitize_callback' => 'sanitize_hex_color',
							),
							'control' => array(
								'control_type' => 'WP_Customize_Color_Control',
								'priority'     => 1110,
								'label'        => __( 'Highlight Color', 'hspg' ),
							),
						),
					),
				);
			}//end if

			/**
			 * Filter the customizer fields.
			 *
			 * @since 1.2.0
			 *
			 * @param array $fields The array of customizer fields.
			 */
			$fields = apply_filters( 'hs_customizer_fields', $fields );

			$this->add_panel( 'hspg', $fields );
		}

		/**
		 * Make sure the donation form display option is valid.
		 *
		 * @since  1.2.0
		 *
		 * @param  string $option Submitted option.
		 * @return string
		 */
		public function sanitize_donation_form_display_option( $option ) {
			if ( ! in_array( $option, array( 'separate_page', 'same_page', 'modal' ) ) ) {
				$option = 'separate_page';
			}

			return $option;
		}

		/**
		 * Adds a panel.
		 *
		 * @since  1.2.0
		 *
		 * @global WP_Customize_Manager $wp_customize
		 * @param  string $panel_id Panel identifier.
		 * @param  array  $panel    Panel definition.
		 * @return void
		 */
		private function add_panel( $panel_id, $panel ) {
			global $wp_customize;

			if ( empty( $panel ) ) {
				return;
			}

			$wp_customize->add_panel( $panel_id, array(
				'title'    => $panel['title'],
				'priority' => $panel['priority'],
			) );

			$this->add_panel_sections( $panel_id, $panel['sections'] );
		}

		/**
		 * Adds sections to a panel.
		 *
		 * @since  1.2.0
		 *
		 * @param  string $panel_id Panel identifier.
		 * @param  array  $sections Array of sections inside panel.
		 * @return void
		 */
		private function add_panel_sections( $panel_id, $sections ) {
			if ( empty( $sections ) ) {
				return;
			}

			foreach ( $sections as $section_id => $section ) {
				$this->add_section( $section_id, $section, $panel_id );
			}
		}

		/**
		 * Adds section & settings
		 *
		 * @since  1.2.0
		 *
		 * @global WP_Customize_Manager $wp_customize
		 * @param  string $section_id Section identifier.
		 * @param  array  $section    Section definition.
		 * @param  string $panel      Panel identifier.
		 * @return void
		 */
		private function add_section( $section_id, $section, $panel ) {
			global $wp_customize;

			if ( empty( $section ) ) {
				return;
			}

			$settings = $section['settings'];

			unset( $section['settings'] );

			$section['panel'] = $panel;

			$wp_customize->add_section( $section_id, $section );

			$this->add_section_settings( $section_id, $settings );
		}


		/**
		 * Adds settings to a given section.
		 *
		 * @since  1.2.0
		 *
		 * @global WP_Customize_Manager $wp_customize
		 * @param  string $section_id Section identifier.
		 * @param  array  $settings   Section definition.
		 * @return void
		 */
		private function add_section_settings( $section_id, $settings ) {
			global $wp_customize;

			if ( empty( $settings ) ) {
				return;
			}

			foreach ( $settings as $setting_id => $setting ) {
				if ( ! isset( $setting['setting']['type'] ) ) {
					$setting['setting']['type'] = 'option';
				}

				$setting_id = "hs_settings[$setting_id]";

				$wp_customize->add_setting( $setting_id, $setting['setting'] );

				$setting_control            = $setting['control'];
				$setting_control['section'] = $section_id;

				if ( isset( $setting_control['control_type'] ) ) {

					$setting_control_type = $setting_control['control_type'];

					unset( $setting_control['control_type'] );

					$wp_customize->add_control( new $setting_control_type( $wp_customize, $setting_id, $setting_control ) );

				} else {

					$wp_customize->add_control( $setting_id, $setting_control );

				}
			}
		}

		/**
		 * Load the theme-customizer.js file.
		 *
		 * @since  1.2.0
		 *
		 * @return void
		 */
		public function load_customizer_script() {
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_register_script(
				'hs-customizer',
				hspg()->get_path( 'assets', false ) . 'js/hs-customizer' . $suffix . '.js',
				array( 'jquery', 'customize-preview' ),
				'1.2.0-beta5',
				true
			);

			wp_enqueue_script( 'hs-customizer' );
		}
	}

endif;
