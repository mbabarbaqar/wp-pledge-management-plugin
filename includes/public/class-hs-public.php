<?php
/**
 * Hspg Public class.
 *
 * @package   Hspg/Classes/Hs_Public
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.44
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Public' ) ) :

	/**
	 * Hspg Public class.
	 *
	 * @since 1.0.0
	 */
	final class Hs_Public {

		/**
		 * The single instance of this class.
		 *
		 * @since 1.2.0
		 *
		 * @var   Hs_Public|null
		 */
		private static $instance = null;

		/**
		 * Returns and/or create the single instance of this class.
		 *
		 * @since  1.2.0
		 *
		 * @return Hs_Public
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Set up the class.
		 *
		 * @since 1.0.0
		 */
		private function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'setup_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue_donation_form_scripts' ), 11 );
			add_action( 'hs_campaign_loop_before', array( $this, 'maybe_enqueue_donation_form_scripts' ) );
			add_filter( 'post_class', array( $this, 'campaign_post_class' ) );

			do_action( 'hs_public_start', $this );
		}

		/**
		 * Loads public facing scripts and stylesheets.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public function setup_scripts() {
			if ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) {
				$suffix  = '';
				$version = '';
			} else {
				$suffix  = '.min';
				$version = hspg()->get_version();
			}

			$assets_dir = hspg()->get_path( 'assets', false );

			/* Main Hspg script. */
			$minimum    = hs_get_minimum_donation_amount();
			$amount_msg = $minimum > 0
				? sprintf(
					/* Translators: %s: minimum donatino amount */
					__( 'You must donate at least %s.', 'hspg' ),
					hs_format_money( $minimum )
				)
				: sprintf(
					/* Translators: %s: minimum donatino amount */
					__( 'You must donate more than %s.', 'hspg' ),
					hs_format_money( $minimum )
				);

			/**
			 * Return whether $0 donations are permitted.
			 *
			 * Note that this filter is also called in Hs_Donation_Form::validate_amount().
			 *
			 * @since 1.2.0
			 *
			 * @param boolean $permitted Whether $0 donations are permitted.
			 */
			$permit_0_donation = apply_filters( 'hs_permit_0_donation', false );

			$currency = hs_get_currency_helper();

			/**
			 * Filter the Javascript vars array.
			 *
			 * @since 1.0.0
			 *
			 * @param array $vars The set of vars.
			 */
			$vars = apply_filters(
				'hs_javascript_vars',
				array(
					'ajaxurl'                      => admin_url( 'admin-ajax.php' ),
					'loading_gif'                  => $assets_dir . '/images/hs-loading.gif',
					'country'                      => hs_get_option( 'country' ),
					'currency'                     => hs_get_currency(),
					'currency_symbol'              => $currency->get_currency_symbol(),
					'currency_format_num_decimals' => esc_attr( $currency->get_decimals() ),
					'currency_format_decimal_sep'  => esc_attr( $currency->get_decimal_separator() ),
					'currency_format_thousand_sep' => esc_attr( $currency->get_thousands_separator() ),
					'currency_format'              => esc_attr( $currency->get_accounting_js_format() ), // For accounting.js.
					'minimum_donation'             => $minimum,
					'permit_0_donation'            => $permit_0_donation,
					'error_invalid_amount'         => $amount_msg,
					'error_required_fields'        => __( 'Please fill out all required fields.', 'hspg' ),
					'error_unknown'                => __( 'Your donation could not be processed. Please reload the page and try again.', 'hspg' ),
					'error_invalid_cc_number'      => __( 'The credit card passed is not valid.', 'hspg' ),
					'error_invalid_cc_expiry'      => __( 'The credit card expiry date is not valid.', 'hspg' ),
					'version'                      => hspg()->get_version(),
					'test_mode'                    => (int) hs_get_option( 'test_mode' ),
				)
			);

			/* Accounting.js */
			wp_register_script(
				'accounting',
				$assets_dir . 'js/libraries/accounting' . $suffix . '.js',
				array( 'jquery' ),
				$version,
				true
			);

			$deps = array( 'accounting', 'jquery' );

			if ( wp_script_is( 'hs-sessions', 'enqueued' ) ) {
				array_unshift( $deps, 'hs-sessions' );
			}

			wp_register_script(
				'hs-script',
				$assets_dir . 'js/hspg' . $suffix . '.js',
				$deps,
				$version,
				true
			);

			wp_localize_script(
				'hs-script',
				'CHARITABLE_VARS',
				$vars
			);

			/* Credit card validation */
			wp_register_script(
				'hs-credit-card',
				$assets_dir . 'js/hs-credit-card' . $suffix . '.js',
				array( 'hs-script' ),
				$version,
				true
			);

			/* URL sanitizer. */
			wp_register_script(
				'hs-url-sanitizer',
				$assets_dir . 'js/hs-url-sanitizer' . $suffix . '.js',
				array( 'jquery' ),
				$version,
				true
			);

			/* General forms scripts. */
			wp_register_script(
				'hs-forms',
				$assets_dir . 'js/hs-forms' . $suffix . '.js',
				array( 'jquery' ),
				$version,
				true
			);

			/* Main styles */
			wp_register_style(
				'hs-styles',
				$assets_dir . 'css/hspg' . $suffix . '.css',
				array(),
				$version
			);

			wp_enqueue_style( 'hs-styles' );

			/* Lean Modal is registered but NOT enqueued yet. */
			if ( 'modal' == hs_get_option( 'donation_form_display', 'separate_page' ) ) {

				wp_register_script(
					'lean-modal',
					$assets_dir . 'js/libraries/leanModal' . $suffix . '.js',
					array( 'jquery' ),
					$version
				);

				wp_register_style(
					'lean-modal-css',
					$assets_dir . 'css/modal' . $suffix . '.css',
					array(),
					$version
				);

			}

			wp_register_style(
				'hs-datepicker',
				$assets_dir . 'css/hs-datepicker' . $suffix . '.css',
				array(),
				$version
			);

			/* pupload Fields is also registered but NOT enqueued. */
			$upload_vars = array(
				'remove_image'            => _x( 'Remove', 'remove image button text', 'hspg' ),
				'max_file_uploads_single' => /* translators: %d: number of files */ __( 'You can only upload %d file', 'hspg' ),
				'max_file_uploads_plural' => __( 'You can only upload a maximum of %d files', 'hspg' ),
				'max_file_size'           => /* translators: %1$s: file name; %2$s: max upload size */ __( '%1$s exceeds the max upload size of %2$s', 'hspg' ),
				'upload_problem'          => /* translators: %s: file name */ __( '%s failed to upload. Please try again.', 'hspg' ),
			);

			wp_register_script(
				'hs-plup-fields',
				$assets_dir . 'js/hs-plupload-fields' . $suffix . '.js',
				array( 'jquery-ui-sortable', 'wp-ajax-response', 'plupload-all' ),
				$version,
				true
			);

			wp_localize_script(
				'hs-plup-fields',
				'CHARITABLE_UPLOAD_VARS',
				$upload_vars
			);

			wp_register_style(
				'hs-plup-styles',
				$assets_dir . 'css/hs-plupload-fields' . $suffix . '.css',
				array(),
				$version
			);
		}

		/**
		 * Conditionally load the donation form scripts if we're viewing the donation form.
		 *
		 * @since  1.4.0
		 *
		 * @return boolean True if scripts were loaded. False otherwise.
		 */
		public function maybe_enqueue_donation_form_scripts() {
			$load = hs_is_page( 'campaign_donation_page' );

			if ( ! $load ) {
				$load = 'hs_campaign_loop_before' == current_action() && 'modal' == hs_get_option( 'donation_form_display', 'separate_page' );
			}

			if ( $load ) {
				$this->enqueue_donation_form_scripts();
			}

			return $load;
		}

		/**
		 * Enqueues the donation form scripts.
		 *
		 * @since  1.4.6
		 *
		 * @return void
		 */
		public function enqueue_donation_form_scripts() {
			wp_enqueue_script( 'hs-script' );

			if ( Hs_Gateways::get_instance()->any_gateway_supports( 'credit-card' ) ) {
				wp_enqueue_script( 'hs-credit-card' );
			}
		}

		/**
		 * Adds custom post classes when viewing campaign.
		 *
		 * @since  1.0.0
		 *
		 * @param  string[] $classes List of classes to be added with post_class().
		 * @return string[]
		 */
		public function campaign_post_class( $classes ) {
			$campaign = hs_get_current_campaign();

			if ( ! $campaign ) {
				return $classes;
			}

			if ( $campaign->has_goal() ) {
				$classes[] = 'campaign-has-goal';
				$classes[] = $campaign->has_achieved_goal() ? 'campaign-has-achieved-goal' : 'campaign-has-not-achieved-goal';
			} else {
				$classes[] = 'campaign-has-no-goal';
			}

			if ( $campaign->is_endless() ) {
				$classes[] = 'campaign-is-endless';
			} else {
				$classes[] = 'campaign-has-end-date';
				$classes[] = $campaign->has_ended() ? 'campaign-has-ended' : 'campaign-has-not-ended';
			}

			return $classes;
		}

		/**
		 * Disable comments on application pages like the donation page.
		 *
		 * @deprecated 2.2.0
		 *
		 * @since  1.3.0
		 * @since  1.6.36 Deprecated. This is now handled in Hs_Endpoints.
		 *
		 * @param  boolean $open Whether comments are open.
		 * @return boolean
		 */
		public function disable_comments_on_application_pages( $open ) {
			/* If open is already false, just hit return. */
			if ( ! $open ) {
				return $open;
			}

			if ( hs_is_page( 'campaign_donation_page', array( 'strict' => true ) )
			|| hs_is_page( 'campaign_widget_page' )
			|| hs_is_page( 'donation_receipt_page' )
			|| hs_is_page( 'donation_processing_page' ) ) {
				$open = false;
			}

			return $open;
		}

		/**
		 * Load the template functions after theme is loaded.
		 *
		 * This gives themes time to override the functions.
		 *
		 * @deprecated 2.0.0
		 *
		 * @since  1.2.3
		 * @since  1.6.10 Deprecated
		 *
		 * @return void
		 */
		public function load_template_files() {
			hs_get_deprecated()->deprecated_function(
				__METHOD__,
				'1.6.10',
				'hspg()->load_template_files()'
			);

			hspg()->load_template_files();
		}
	}

endif;
