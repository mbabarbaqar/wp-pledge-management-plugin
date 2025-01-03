<?php
/**
 * Class that sets up the Hspg Admin functionality.
 *
 * @package   Hspg/Classes/Hs_Admin
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

if ( ! class_exists( 'Hs_Admin' ) ) :

	/**
	 * Hs_Admin
	 *
	 * @final
	 * @since 1.0.0
	 */
	final class Hs_Admin {

		/**
		 * The single instance of this class.
		 *
		 * @var Hs_Admin|null
		 */
		private static $instance = null;

		/**
		 * Donation actions class.
		 *
		 * @var Hs_Donation_Admin_Actions
		 */
		private $donation_actions;

		/**
		 * Set up the class.
		 *
		 * Note that the only way to instantiate an object is with the hs_start method,
		 * which can only be called during the start phase. In other words, don't try
		 * to instantiate this object.
		 *
		 * @since  1.0.0
		 */
		protected function __construct() {
			$this->load_dependencies();

			$this->donation_actions = new Hs_Donation_Admin_Actions;

			do_action( 'hs_admin_loaded' );
		}

		/**
		 * Returns and/or create the single instance of this class.
		 *
		 * @since  1.2.0
		 *
		 * @return Hs_Admin
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Include admin-only files.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		private function load_dependencies() {
			$admin_dir = hspg()->get_path( 'includes' ) . 'admin/';

			require_once( $admin_dir . 'hs-core-admin-functions.php' );
			require_once( $admin_dir . 'campaigns/hs-admin-campaign-hooks.php' );
			require_once( $admin_dir . 'dashboard-widgets/hs-dashboard-widgets-hooks.php' );
			require_once( $admin_dir . 'donations/hs-admin-donation-hooks.php' );
			require_once( $admin_dir . 'settings/hs-settings-admin-hooks.php' );
		}

		/**
		 * Get Hs_Donation_Admin_Actions class.
		 *
		 * @since  1.5.0
		 *
		 * @return Hs_Donation_Admin_Actions
		 */
		public function get_donation_actions() {
			return $this->donation_actions;
		}

		/**
		 * Do an admin action.
		 *
		 * @since  1.5.0
		 *
		 * @return boolean|WP_Error WP_Error in case of error. Mixed results if the action was performed.
		 */
		public function maybe_do_admin_action() {
			if ( ! array_key_exists( 'hs_admin_action', $_GET ) ) {
				return false;
			}

			if ( count( array_diff( array( 'action_type', '_nonce', 'object_id' ), array_keys( $_GET ) ) ) ) {
				return new WP_Error( __( 'Action could not be executed.', 'hspg' ) );
			}

			if ( ! wp_verify_nonce( $_GET['_nonce'], 'donation_action' ) ) {
				return new WP_Error( __( 'Action could not be executed. Nonce check failed.', 'hspg' ) );
			}

			if ( 'donation' != $_GET['action_type'] ) {
				return new WP_Error( __( 'Action from an unknown action type executed.', 'hspg' ) );
			}

			return $this->donation_actions->do_action( $_GET['hs_admin_action'], $_GET['object_id'] );
		}

		/**
		 * Loads admin-only scripts and stylesheets.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public function admin_enqueue_scripts() {
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$suffix  = '';
				$version = '';
			} else {
				$suffix  = '.min';
				$version = hspg()->get_version();
			}

			$assets_dir = hspg()->get_path( 'assets', false );

			/* Menu styles are loaded everywhere in the WordPress dashboard. */
			wp_register_style(
				'hs-admin-menu',
				$assets_dir . 'css/hs-admin-menu' . $suffix . '.css',
				array(),
				$version
			);

			wp_enqueue_style( 'hs-admin-menu' );

			/* Admin page styles are registered but only enqueued when necessary. */
			wp_register_style(
				'hs-admin-pages',
				$assets_dir . 'css/hs-admin-pages' . $suffix . '.css',
				array(),
				$version
			);

			/* The following styles are only loaded on Hspg screens. */
			$screen = get_current_screen();

			if ( ! is_null( $screen ) && in_array( $screen->id, $this->get_hs_screens() ) ) {

				wp_register_style(
					'hs-admin',
					$assets_dir . 'css/hs-admin' . $suffix . '.css',
					array(),
					$version
				);

				wp_enqueue_style( 'hs-admin' );

				$dependencies   = array( 'jquery-ui-datepicker', 'jquery-ui-tabs', 'jquery-ui-sortable' );
				$localized_vars = array(
					'suggested_amount_placeholder' => __( 'Amount', 'hspg' ),
					'suggested_amount_description_placeholder' => __( 'Optional Description', 'hspg' ),
				);

				if ( 'donation' == $screen->id ) {
					wp_register_script(
						'accounting',
						$assets_dir . 'js/libraries/accounting'. $suffix . '.js',
						array( 'jquery' ),
						$version,
						true
					);

					$dependencies[] = 'accounting';
					$localized_vars = array_merge(
						$localized_vars,
						array(
							'currency_format_num_decimals' => esc_attr( hs_get_currency_helper()->get_decimals() ),
							'currency_format_decimal_sep'  => esc_attr( hs_get_currency_helper()->get_decimal_separator() ),
							'currency_format_thousand_sep' => esc_attr( hs_get_currency_helper()->get_thousands_separator() ),
							'currency_format'              => esc_attr( hs_get_currency_helper()->get_accounting_js_format() ),
						)
					);
				}

				wp_register_script(
					'hs-admin',
					$assets_dir . 'js/hs-admin' . $suffix . '.js',
					$dependencies,
					$version,
					false
				);

				wp_enqueue_script( 'hs-admin' );

				/**
				 * Filter the admin Javascript vars.
				 *
				 * @since 1.0.0
				 *
				 * @param array $localized_vars The vars.
				 */
				$localized_vars = apply_filters( 'hs_localized_javascript_vars', $localized_vars );

				wp_localize_script( 'hs-admin', 'CHARITABLE', $localized_vars );

			}//end if

			wp_register_script(
				'hs-admin-notice',
				$assets_dir . 'js/hs-admin-notice' . $suffix . '.js',
				array( 'jquery' ),
				$version,
				false
			);

			wp_register_script(
				'hs-admin-media',
				$assets_dir . 'js/hs-admin-media' . $suffix . '.js',
				array( 'jquery' ),
				$version,
				false
			);

			wp_register_script(
				'lean-modal',
				$assets_dir . 'js/libraries/leanModal' . $suffix . '.js',
				array( 'jquery' ),
				$version,
				true
			);

			wp_register_style(
				'lean-modal-css',
				$assets_dir . 'css/modal' . $suffix . '.css',
				array(),
				$version
			);

			wp_register_script(
				'hs-admin-tables',
				$assets_dir . 'js/hs-admin-tables' . $suffix . '.js',
				array( 'jquery', 'lean-modal' ),
				$version,
				true
			);

			wp_register_script(
				'select2',
				$assets_dir . 'js/libraries/select2' . $suffix . '.js',
				array( 'jquery' ),
				'4.0.12',
				true
			);

			wp_register_style(
				'select2-css',
				$assets_dir . 'css/libraries/select2' . $suffix . '.css',
				array(),
				'4.0.12'
			);
		}

		/**
		 * Set admin body classes.
		 *
		 * @since  1.5.0
		 *
		 * @param  string $classes Existing list of classes.
		 * @return string
		 */
		public function set_body_class( $classes ) {
			$screen = get_current_screen();

			if ( 'donation' == $screen->post_type && ( 'add' == $screen->action || isset( $_GET['show_form'] ) ) ) {
				$classes .= ' hs-admin-donation-form';
			}

			return $classes;
		}

		/**
		 * Add notices to the dashboard.
		 *
		 * @since  1.4.0
		 *
		 * @return void
		 */
		public function add_notices() {
			/* Get any version update notices first. */
			$this->add_version_update_notices();

			/* Render notices. */
			hs_get_admin_notices()->render();
		}

		/**
		 * Add version update notices to the dashboard.
		 *
		 * @since  1.4.6
		 *
		 * @return void
		 */
		public function add_version_update_notices() {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			$notices = array(
				/* translators: %s: link */
				'release-150' => sprintf( __( "Hspg 1.5 is packed with new features and improvements. <a href='%s' target='_blank'>Find out what's new</a>.", 'hspg' ),
					'https://www.wphspg.com/hs-1-5-release-notes/?utm_source=notice&utm_medium=wordpress-dashboard&utm_campaign=release-notes&utm_content=release-150'
				),
				/* translators: %s: link */
				'release-160' => sprintf( __( 'Hspg 1.6 introduces important new user privacy features and other improvements. <a href="%s" target="_blank">Find out what\'s new</a>.', 'hspg' ),
					'https://www.wphspg.com/hs-1-6-user-privacy-gdpr-better-refunds-and-a-new-shortcode/?utm_source=notice&utm_medium=wordpress-dashboard&utm_campaign=release-notes&utm_content=release-160'
				),
			);

			$helper = hs_get_admin_notices();

			foreach ( $notices as $notice => $message ) {
				if ( ! get_transient( 'hs_' . $notice . '_notice' ) ) {
					continue;
				}

				$helper->add_version_update( $message, $notice );
			}
		}

		/**
		 * Dismiss a notice.
		 *
		 * @since  1.4.0
		 *
		 * @return void
		 */
		public function dismiss_notice() {
			if ( ! isset( $_POST['notice'] ) ) {
				wp_send_json_error();
			}

			$ret = delete_transient( 'hs_' . $_POST['notice'] . '_notice', true );

			if ( ! $ret ) {
				wp_send_json_error( $ret );
			}

			wp_send_json_success();
		}

		/**
		 * Adds one or more classes to the body tag in the dashboard.
		 *
		 * @since  1.0.0
		 *
		 * @param  string $classes Current body classes.
		 * @return string Altered body classes.
		 */
		public function add_admin_body_class( $classes ) {
			$screen = get_current_screen();

			if ( in_array( $screen->post_type, array( Hspg::DONATION_POST_TYPE, Hspg::CAMPAIGN_POST_TYPE ) ) ) {
				$classes .= ' post-type-hs';
			}

			return $classes;
		}

		/**
		 * Add custom links to the plugin actions.
		 *
		 * @since  1.0.0
		 *
		 * @param  string[] $links Plugin action links.
		 * @return string[]
		 */
		public function add_plugin_action_links( $links ) {
			$links[] = '<a href="' . admin_url( 'admin.php?page=hs-settings' ) . '">' . __( 'Settings', 'hspg' ) . '</a>';
			return $links;
		}

		/**
		 * Add Extensions link to the plugin row meta.
		 *
		 * @since  1.2.0
		 *
		 * @param  string[] $links Plugin action links.
		 * @param  string   $file  The plugin file.
		 * @return string[] $links
		 */
		public function add_plugin_row_meta( $links, $file ) {
			if ( plugin_basename( hspg()->get_path() ) != $file ) {
				return $links;
			}

			$extensions_link = esc_url(
				add_query_arg(
					array(
						'utm_source'   => 'plugins-page',
						'utm_medium'   => 'plugin-row',
						'utm_campaign' => 'admin',
					),
					'https://wphspg.com/extensions/'
				)
			);

			$links[] = '<a href="' . $extensions_link . '">' . __( 'Extensions', 'hspg' ) . '</a>';

			return $links;
		}

		/**
		 * Remove the jQuery UI styles added by Ninja Forms.
		 *
		 * @since  1.2.0
		 *
		 * @param  string $context Media buttons context.
		 * @return string
		 */
		public function remove_jquery_ui_styles_nf( $context ) {
			wp_dequeue_style( 'jquery-smoothness' );
			return $context;
		}

		/**
		 * Export donations.
		 *
		 * @since  1.3.0
		 *
		 * @return false|void Returns false if the export failed. Exits otherwise.
		 */
		public function export_donations() {
			if ( ! wp_verify_nonce( $_GET['_hs_export_nonce'], 'hs_export_donations' ) ) {
				return false;
			}

			/**
			 * Filter the donation export arguments.
			 *
			 * @since 1.3.0
			 *
			 * @param array $args Export arguments.
			 */
			$export_args = apply_filters(
				'hs_donations_export_args',
				array(
					'start_date'  => $_GET['start_date'],
					'end_date'    => $_GET['end_date'],
					'status'      => $_GET['post_status'],
					'campaign_id' => $_GET['campaign_id'],
					'report_type' => $_GET['report_type'],
				)
			);

			/**
			 * Filter the export class name.
			 *
			 * @since 1.3.0
			 *
			 * @param string $report_type The type of report.
			 * @param array  $args        Export arguments.
			 */
			$export_class = apply_filters( 'hs_donations_export_class', 'Hs_Export_Donations', $_GET['report_type'], $export_args );

			new $export_class( $export_args );

			die();
		}

		/**
		 * Export campaigns.
		 *
		 * @since  1.6.0
		 *
		 * @return false|void Returns false if the export failed. Exits otherwise.
		 */
		public function export_campaigns() {
			if ( ! wp_verify_nonce( $_GET['_hs_export_nonce'], 'hs_export_campaigns' ) ) {
				return false;
			}

			/**
			 * Filter the campaign export arguments.
			 *
			 * @since 1.6.0
			 *
			 * @param array $args Export arguments.
			 */
			$export_args = apply_filters(
				'hs_campaigns_export_args',
				array(
					'start_date_from' => $_GET['start_date_from'],
					'start_date_to'   => $_GET['start_date_to'],
					'end_date_from'   => $_GET['end_date_from'],
					'end_date_to'     => $_GET['end_date_to'],
					'status'          => $_GET['status'],
					'report_type'     => $_GET['report_type'],
				)
			);

			/**
			 * Filter the export class name.
			 *
			 * @since 1.6.0
			 *
			 * @param string $report_type The type of report.
			 * @param array  $args        Export arguments.
			 */
			$export_class = apply_filters( 'hs_campaigns_export_class', 'Hs_Export_Campaigns', $_GET['report_type'], $export_args );

			new $export_class( $export_args );

			die();
		}


		/**
		 * Returns an array of screen IDs where the Hspg scripts should be loaded.
		 *
		 * @uses   hs_admin_screens
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_hs_screens() {
			/**
			 * Filter admin screens where Hspg styles & scripts should be loaded.
			 *
			 * @since 1.0.0
			 *
			 * @param string[] $screens List of screen ids.
			 */
			return apply_filters( 'hs_admin_screens', array(
				'campaign',
				'donation',
				'hs_page_hs-settings',
				'edit-campaign',
				'edit-donation',
				'dashboard',
			) );
		}
	}

endif;
