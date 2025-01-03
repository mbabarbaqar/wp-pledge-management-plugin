<?php
/**
 * Hspg Uninstall class.
 *
 * The responsibility of this class is to manage the events that need to happen
 * when the plugin is deactivated.
 *
 * @package   Hspg/Hs_Uninstall
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.42
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Uninstall' ) ) :

	/**
	 * Hs_Uninstall
	 *
	 * @since 1.0.0
	 */
	class Hs_Uninstall {

		/**
		 * Uninstall the plugin.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			if ( hspg()->is_deactivation() && hs_get_option( 'delete_data_on_uninstall' ) ) {

				$this->remove_caps();
				$this->remove_post_data();
				$this->remove_tables();
				$this->remove_settings();

				do_action( 'hs_uninstall' );
			}
		}

		/**
		 * Remove plugin-specific roles.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		private function remove_caps() {
			$roles = new Hs_Roles();
			$roles->remove_caps();
		}

		/**
		 * Remove post objects created by Hspg.
		 *
		 * @since  1.0.0
		 *
		 * @global WPDB $wpdb The WordPress database object.
		 * @return void
		 */
		private function remove_post_data() {
			global $wpdb;

			$posts = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE post_type IN ( 'donation', 'campaign' );" );

			foreach ( $posts as $post_id ) {
				wp_delete_post( $post_id, true );
			}
		}

		/**
		 * Remove the custom tables added by Hspg.
		 *
		 * @since  1.0.0
		 *
		 * @global WPDB $wpdb The WordPress database object.
		 * @return void
		 */
		private function remove_tables() {
			global $wpdb;

			$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'hs_campaign_donations' );
			$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'hs_donors' );
			$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'hs_donormeta' );
			$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'hs_benefactors' );

			delete_option( $wpdb->prefix . 'hs_campaign_donations_db_version' );
			delete_option( $wpdb->prefix . 'hs_donors_db_version' );
			delete_option( $wpdb->prefix . 'hs_donormeta_db_version' );
			delete_option( $wpdb->prefix . 'hs_benefactors_db_version' );
		}

		/**
		 * Remove any other options added by Hspg.
		 *
		 * @since  1.6.42
		 *
		 * @return void
		 */
		private function remove_settings() {
			delete_option( 'hs_settings' );
			delete_option( 'hs_version' );
			delete_option( 'hs_upgrade_log' );
			delete_option( 'hs_skipped_donations_with_empty_donor_id' );

			delete_transient( 'hs_notices' );
			delete_transient( 'hs_user_dashboard_objects' );
			delete_transient( 'hs_custom_styles' );

			/* Stop Hspg from re-adding the notices transient. */
			if ( function_exists( 'hs_get_admin_notices' ) ) {
				remove_action( 'shutdown', array( hs_get_admin_notices(), 'shutdown' ) );
			}
		}
	}

endif;
