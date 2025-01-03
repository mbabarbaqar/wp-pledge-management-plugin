<?php
/**
 * Sets up the Donations dashboard widget.
 *
 * @package     Hspg/Classes/Hs_Donations_Dashboard_Widget
 * @version     1.2.0
 * @author     HCS
 * @copyright   Copyright (c) 2020, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Donations_Dashboard_Widget' ) ) :

	/**
	 * Hs_Donations_Dashboard_Widget
	 *
	 * @since   1.2.0
	 */
	class Hs_Donations_Dashboard_Widget {

		/**
		 * The widget ID.
		 */
		const ID = 'hs_dashboard_donations';

		/**
		 * Create class object.
		 *
		 * @since   1.2.0
		 */
		public static function register() {
			if ( ! current_user_can( 'view_hs_sensitive_data' ) ) {
				return;
			}

			wp_add_dashboard_widget( self::ID, __( 'Hspg Donation Statistics', 'hspg' ), array( 'Hs_Donations_Dashboard_Widget', 'display' ) );
		}

		/**
		 * Print the widget contents.
		 *
		 * @since   1.2.0
		 *
		 * @return  void
		 */
		public static function display() {
	?>
			<p class="hide-if-no-js">
				<img src="<?php echo hspg()->get_path( 'assets', false ) ?>/images/hs-loading.gif" width="60" height="60" alt="<?php esc_attr_e( 'Loading&hellip;', 'hspg' ) ?>" />
			</p>
	<?php
		}

		/**
		 * Return the content to display inside the widget.
		 *
		 * @since   1.2.0
		 *
		 * @return  void
		 */
		public static function get_content() {
			hs_admin_view( 'dashboard-widgets/donations-widget' );
			die();
		}
	}

endif;
