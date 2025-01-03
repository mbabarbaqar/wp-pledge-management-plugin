<?php
/**
 * This class is responsible for adding the Hspg admin pages.
 *
 * @package   Hspg/Classes/Hs_Admin_Pages
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.39
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Admin_Pages' ) ) :

	/**
	 * Hs_Admin_Pages
	 *
	 * @since 1.0.0
	 */
	final class Hs_Admin_Pages {

		/**
		 * The single instance of this class.
		 *
		 * @var     Hs_Admin_Pages|null
		 */
		private static $instance = null;

		/**
		 * The page to use when registering sections and fields.
		 *
		 * @var     string
		 */
		private $admin_menu_parent_page;

		/**
		 * The capability required to view the admin menu.
		 *
		 * @var     string
		 */
		private $admin_menu_capability;

		/**
		 * Create class object.
		 *
		 * @since  1.0.0
		 */
		private function __construct() {
			/**
			 * The default capability required to view Hspg pages.
			 *
			 * @since 1.0.0
			 *
			 * @param string $cap The capability required.
			 */
			$this->admin_menu_capability  = apply_filters( 'hs_admin_menu_capability', 'view_hs_sensitive_data' );
			$this->admin_menu_parent_page = 'hspg';
		}

		/**
		 * Returns and/or create the single instance of this class.
		 *
		 * @since  1.2.0
		 *
		 * @return Hs_Admin_Pages
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Add Settings menu item under the Campaign menu tab.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public function add_menu() {
			add_menu_page(
				'Pledge Board Management',
				'Pledge Board Management',
				'edit_campaigns',
				$this->admin_menu_parent_page,
				array( $this, 'render_welcome_page' )
			);

			foreach ( $this->get_submenu_pages() as $page ) {
				if ( ! isset( $page['page_title'] )
					|| ! isset( $page['menu_title'] )
					|| ! isset( $page['menu_slug'] ) ) {
					continue;
				}

				$page_title = $page['page_title'];
				$menu_title = $page['menu_title'];
				$capability = isset( $page['capability'] ) ? $page['capability'] : $this->admin_menu_capability;
				$menu_slug  = $page['menu_slug'];
				$function   = isset( $page['function'] ) ? $page['function'] : '';

				add_submenu_page(
					$this->admin_menu_parent_page,
					$page_title,
					$menu_title,
					$capability,
					$menu_slug,
					$function
				);
			}
		}

		/**
		 * Returns an array with all the submenu pages.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		private function get_submenu_pages() {
			$campaign_post_type = get_post_type_object( 'campaign' );
			$donation_post_type = get_post_type_object( 'donation' );

			/**
			 * Filter the list of submenu pages that come
			 * under the Hspg menu tab.
			 *
			 * @since 1.0.0
			 *
			 * @param array $pages Every page is an array with at least a page_title,
			 *                     menu_title and menu_slug set.
			 */
			return apply_filters(
				'hs_submenu_pages',
				array(
					array(
						'page_title' => $campaign_post_type->labels->menu_name,
						'menu_title' => $campaign_post_type->labels->menu_name,
						'menu_slug'  => 'edit.php?post_type=campaign',
						'capability' => 'edit_campaigns',
					),
					array(
						'page_title' => $campaign_post_type->labels->add_new,
						'menu_title' => $campaign_post_type->labels->add_new,
						'menu_slug'  => 'post-new.php?post_type=campaign',
						'capability' => 'edit_campaigns',
					),
					array(
						'page_title' => $donation_post_type->labels->menu_name,
						'menu_title' => $donation_post_type->labels->menu_name,
						'menu_slug'  => 'edit.php?post_type=donation',
						'capability' => 'edit_donations',
					),
					array(
						'page_title' => __( 'Campaign Categories', 'hspg' ),
						'menu_title' => __( 'Categories', 'hspg' ),
						'menu_slug'  => 'edit-tags.php?taxonomy=campaign_category&post_type=campaign',
						'capability' => 'manage_campaign_terms',
					),
					array(
						'page_title' => __( 'Campaign Tags', 'hspg' ),
						'menu_title' => __( 'Tags', 'hspg' ),
						'menu_slug'  => 'edit-tags.php?taxonomy=campaign_tag&post_type=campaign',
						'capability' => 'manage_campaign_terms',
					),
					array(
						'page_title' => __( 'Customize', 'hspg' ),
						'menu_title' => __( 'Customize', 'hspg' ),
						'menu_slug'  => 'customize.php?autofocus[panel]=hspg&url=' . $this->get_customizer_campaign_preview_url(),
						'capability' => 'manage_hs_settings',
					),
					array(
						'page_title' => __( 'Hspg Settings', 'hspg' ),
						'menu_title' => __( 'Settings', 'hspg' ),
						'menu_slug'  => 'hs-settings',
						'function'   => array( $this, 'render_settings_page' ),
						'capability' => 'manage_hs_settings',
					),
				)
			);
		}

		/**
		 * Set up the redirect to the welcome page.
		 *
		 * @since  1.3.0
		 *
		 * @return void
		 */
		public function setup_welcome_redirect() {
			add_action( 'admin_init', array( self::get_instance(), 'redirect_to_welcome' ) );
		}

		/**
		 * Redirect to the welcome page.
		 *
		 * @since  1.3.0
		 *
		 * @return void
		 */
		public function redirect_to_welcome() {
			wp_safe_redirect( admin_url( 'admin.php?page=hspg&install=true' ) );
			exit;
		}

		/**
		 * Display the Hspg settings page.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public function render_settings_page() {
			hs_admin_view( 'settings/settings' );
		}

		/**
		 * Display the Hspg donations page.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 *
		 * @deprecated 1.4.0
		 */
		public function render_donations_page() {
			hs_get_deprecated()->deprecated_function(
				__METHOD__,
				'1.4.0',
				__( 'Donations page now rendered by WordPress default manage_edit-donation_columns', 'hspg' )
			);

			hs_admin_view( 'donations-page/page' );
		}

		/**
		 * Display the Hspg welcome page.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public function render_welcome_page() {
			hs_admin_view( 'welcome-page/page' );
		}

		/**
		 * Return a preview URL for the customizer.
		 *
		 * @since  1.6.0
		 *
		 * @return string
		 */
		private function get_customizer_campaign_preview_url() {
			$campaign = Hs_Campaigns::query(
				array(
					'posts_per_page' => 1,
					'post_status'    => 'publish',
					'fields'         => 'ids',
					'meta_query'     => array(
						'relation' => 'OR',
						array(
							'key'     => '_campaign_end_date',
							'value'   => date( 'Y-m-d H:i:s' ),
							'compare' => '>=',
							'type'    => 'datetime',
						),
						array(
							'key'     => '_campaign_end_date',
							'value'   => 0,
							'compare' => '=',
						),
					),
				)
			);

			if ( $campaign->found_posts ) {
				$url = hs_get_permalink(
					'campaign_donation',
					array(
						'campaign_id' => current( $campaign->posts ),
					)
				);
			}

			if ( ! isset( $url ) || false === $url ) {
				$url = home_url();
			}

			return urlencode( $url );
		}
	}

endif;
