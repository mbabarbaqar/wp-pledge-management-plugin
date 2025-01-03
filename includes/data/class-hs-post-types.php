<?php
/**
 * The class that defines Hspg's custom post types, taxonomies and post statuses.
 *
 * @package   Hspg/Classes/Hs_Post_Types
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.39
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Post_Types' ) ) :

	/**
	 * Hs_Post_Types
	 *
	 * @since 1.0.0
	 */
	final class Hs_Post_Types {

		/**
		 * The single instance of this class.
		 *
		 * @var     Hs_Post_Types|null
		 */
		private static $instance = null;

		/**
		 * Returns and/or create the single instance of this class.
		 *
		 * @since   1.2.0
		 *
		 * @return  Hs_Post_Types
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
		 * Note that the only way to instantiate an object is with the on_start method,
		 * which can only be called during the start phase. In other words, don't try
		 * to instantiate this object.
		 *
		 * @since   1.0.0
		 */
		private function __construct() {
			add_action( 'init', array( $this, 'register_post_types' ), 5 );
			add_action( 'init', array( $this, 'register_post_statuses' ), 5 );
			add_action( 'init', array( $this, 'register_taxonomies' ), 6 );
		}

		/**
		 * Register plugin post types.
		 *
		 * @hook    init
		 * @since   1.0.0
		 *
		 * @return  void
		 */
		public function register_post_types() {
			/**
			 * Filter the campaign post type definition.
			 *
			 * To change any of the arguments used for the post type, other than the name
			 * of the post type itself, use the 'hs_campaign_post_type' filter.
			 *
			 * @since 1.0.0
			 *
			 * @param array $args Post type arguments.
			 */
			$args = apply_filters(
				'hs_campaign_post_type',
				array(
					'labels'              => array(
						'name'               => __( 'Campaigns', 'hspg' ),
						'singular_name'      => __( 'Campaign', 'hspg' ),
						'menu_name'          => _x( 'Campaigns', 'Admin menu name', 'hspg' ),
						'add_new'            => __( 'Add Campaign', 'hspg' ),
						'add_new_item'       => __( 'Add New Campaign', 'hspg' ),
						'edit'               => __( 'Edit', 'hspg' ),
						'edit_item'          => __( 'Edit Campaign', 'hspg' ),
						'new_item'           => __( 'New Campaign', 'hspg' ),
						'view'               => __( 'View Campaign', 'hspg' ),
						'view_item'          => __( 'View Campaign', 'hspg' ),
						'search_items'       => __( 'Search Campaigns', 'hspg' ),
						'not_found'          => __( 'No Campaigns found', 'hspg' ),
						'not_found_in_trash' => __( 'No Campaigns found in trash', 'hspg' ),
						'parent'             => __( 'Parent Campaign', 'hspg' ),
					),
					'description'         => __( 'This is where you can create new campaigns for people to support.', 'hspg' ),
					'public'              => true,
					'show_ui'             => true,
					'capability_type'     => 'campaign',
					'menu_icon'           => '',
					'map_meta_cap'        => true,
					'publicly_queryable'  => true,
					'exclude_from_search' => false,
					'hierarchical'        => false,
					'rewrite'             => array(
						'slug'       => 'campaigns',
						'with_front' => true,
					),
					'query_var'           => true,
					'supports'            => array( 'title', 'thumbnail', 'comments' ),
					'has_archive'         => false,
					'show_in_nav_menus'   => true,
					'show_in_menu'        => false,
					'show_in_admin_bar'   => true,
				)
			);

			register_post_type( 'campaign', $args );

			/**
			 * Filter the donation post type definition.
			 *
			 * To change any of the arguments used for the post type, other than the name
			 * of the post type itself, use the 'hs_donation_post_type' filter.
			 *
			 * @since 1.0.0
			 *
			 * @param array $args Post type arguments.
			 */
			$args = apply_filters(
				'hs_donation_post_type',
				array(
					'labels'              => array(
						'name'               => __( 'Donations', 'hspg' ),
						'singular_name'      => __( 'Donation', 'hspg' ),
						'menu_name'          => _x( 'Donations', 'Admin menu name', 'hspg' ),
						'add_new'            => __( 'Add Donation', 'hspg' ),
						'add_new_item'       => __( 'Add New Donation', 'hspg' ),
						'edit'               => __( 'Edit', 'hspg' ),
						'edit_item'          => __( 'Donation Details', 'hspg' ),
						'new_item'           => __( 'New Donation', 'hspg' ),
						'view'               => __( 'View Donation', 'hspg' ),
						'view_item'          => __( 'View Donation', 'hspg' ),
						'search_items'       => __( 'Search Donations', 'hspg' ),
						'not_found'          => __( 'No Donations found', 'hspg' ),
						'not_found_in_trash' => __( 'No Donations found in trash', 'hspg' ),
						'parent'             => __( 'Parent Donation', 'hspg' ),
					),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => 'donation',
					'menu_icon'           => '',
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => false,
					'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
					'rewrite'             => false,
					'query_var'           => false,
					'supports'            => array( '' ),
					'has_archive'         => false,
					'show_in_nav_menus'   => false,
					'show_in_menu'        => false,
				)
			);

			register_post_type( 'donation', $args );
		}

		/**
		 * Register custom post statuses.
		 *
		 * @since   1.0.0
		 *
		 * @return  void
		 */
		public function register_post_statuses() {
			register_post_status(
				'hs-pending',
				array(
					'label'                     => _x( 'Pending', 'Pending Donation Status', 'hspg' ),
					/* translators: %s: count */
					'label_count'               => _n_noop( 'Pending (%s)', 'Pending (%s)', 'hspg' ),
					'public'                    => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					'exclude_from_search'       => true,
				)
			);

			register_post_status(
				'hs-completed',
				array(
					'label'                     => _x( 'Paid', 'Paid Donation Status', 'hspg' ),
					/* translators: %s: count */
					'label_count'               => _n_noop( 'Paid (%s)', 'Paid (%s)', 'hspg' ),
					'public'                    => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					'exclude_from_search'       => true,
				)
			);

			register_post_status(
				'hs-failed',
				array(
					'label'                     => _x( 'Failed', 'Failed Donation Status', 'hspg' ),
					/* translators: %s: count */
					'label_count'               => _n_noop( 'Failed (%s)', 'Failed (%s)', 'hspg' ),
					'public'                    => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					'exclude_from_search'       => true,
				)
			);

			register_post_status(
				'hs-cancelled',
				array(
					'label'                     => _x( 'Canceled', 'Canceled Donation Status', 'hspg' ),
					/* translators: %s: count */
					'label_count'               => _n_noop( 'Canceled (%s)', 'Canceled (%s)', 'hspg' ),
					'public'                    => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					'exclude_from_search'       => true,
				)
			);

			register_post_status(
				'hs-refunded',
				array(
					'label'                     => _x( 'Refunded', 'Refunded Donation Status', 'hspg' ),
					/* translators: %s: count */
					'label_count'               => _n_noop( 'Refunded (%s)', 'Refunded (%s)', 'hspg' ),
					'public'                    => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					'exclude_from_search'       => true,
				)
			);

			register_post_status(
				'hs-preapproved',
				array(
					'label'                     => _x( 'Pre Approved', 'Pre Approved Donation Status', 'hspg' ),
					/* translators: %s: count */
					'label_count'               => _n_noop( 'Pre Approved (%s)', 'Pre Approved (%s)', 'hspg' ),
					'public'                    => false,
					'show_in_admin_all_list'    => true,
					'show_in_admin_status_list' => true,
					'exclude_from_search'       => true,
				)
			);
		}

		/**
		 * Register the campaign category taxonomy.
		 *
		 * @since   1.0.0
		 *
		 * @return  void
		 */
		public function register_taxonomies() {
			$labels = array(
				'name'                       => _x( 'Campaign Categories', 'Taxonomy General Name', 'hspg' ),
				'singular_name'              => _x( 'Campaign Category', 'Taxonomy Singular Name', 'hspg' ),
				'menu_name'                  => __( 'Categories', 'hspg' ),
				'all_items'                  => __( 'All Campaign Categories', 'hspg' ),
				'parent_item'                => __( 'Parent Campaign Category', 'hspg' ),
				'parent_item_colon'          => __( 'Parent Campaign Category:', 'hspg' ),
				'new_item_name'              => __( 'New Campaign Category Name', 'hspg' ),
				'add_new_item'               => __( 'Add New Campaign Category', 'hspg' ),
				'edit_item'                  => __( 'Edit Campaign Category', 'hspg' ),
				'update_item'                => __( 'Update Campaign Category', 'hspg' ),
				'view_item'                  => __( 'View Campaign Category', 'hspg' ),
				'separate_items_with_commas' => __( 'Separate campaign categories with commas', 'hspg' ),
				'add_or_remove_items'        => __( 'Add or remove campaign categories', 'hspg' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'hspg' ),
				'popular_items'              => __( 'Popular Campaign Categories', 'hspg' ),
				'search_items'               => __( 'Search Campaign Categories', 'hspg' ),
				'not_found'                  => __( 'Not Found', 'hspg' ),
			);

			$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => true,
				'capabilities'      => array(
					'manage_terms' => 'manage_campaign_terms',
					'edit_terms'   => 'edit_campaign_terms',
					'delete_terms' => 'delete_campaign_terms',
					'assign_terms' => 'assign_campaign_terms',
				),
			);

			register_taxonomy( 'campaign_category', array( 'campaign' ), $args );

			$labels = array(
				'name'                       => _x( 'Campaign Tags', 'Taxonomy General Name', 'hspg' ),
				'singular_name'              => _x( 'Campaign Tag', 'Taxonomy Singular Name', 'hspg' ),
				'menu_name'                  => __( 'Tags', 'hspg' ),
				'all_items'                  => __( 'All Campaign Tags', 'hspg' ),
				'parent_item'                => __( 'Parent Campaign Tag', 'hspg' ),
				'parent_item_colon'          => __( 'Parent Campaign Tag:', 'hspg' ),
				'new_item_name'              => __( 'New Campaign Tag Name', 'hspg' ),
				'add_new_item'               => __( 'Add New Campaign Tag', 'hspg' ),
				'edit_item'                  => __( 'Edit Campaign Tag', 'hspg' ),
				'update_item'                => __( 'Update Campaign Tag', 'hspg' ),
				'view_item'                  => __( 'View Campaign Tag', 'hspg' ),
				'separate_items_with_commas' => __( 'Separate campaign tags with commas', 'hspg' ),
				'add_or_remove_items'        => __( 'Add or remove campaign tags', 'hspg' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'hspg' ),
				'popular_items'              => __( 'Popular Campaign Tags', 'hspg' ),
				'search_items'               => __( 'Search Campaign Tags', 'hspg' ),
				'not_found'                  => __( 'Not Found', 'hspg' ),
			);

			$args = array(
				'labels'            => $labels,
				'hierarchical'      => false,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud'     => true,
				'capabilities'      => array(
					'manage_terms' => 'manage_campaign_terms',
					'edit_terms'   => 'edit_campaign_terms',
					'delete_terms' => 'delete_campaign_terms',
					'assign_terms' => 'assign_campaign_terms',
				),
			);

			register_taxonomy( 'campaign_tag', array( 'campaign' ), $args );

			register_taxonomy_for_object_type( 'campaign_category', 'campaign' );
			register_taxonomy_for_object_type( 'campaign_tag', 'campaign' );
		}
	}

endif;
