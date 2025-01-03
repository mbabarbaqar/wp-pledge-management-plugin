<?php
/**
 * Hspg widgets class.
 *
 * Registers custom widgets for Hspg.
 *
 * @version		1.0.0
 * @package		Hspg/Classes/Hs_Widgets
 * @author 		Eric Daams
 * @copyright 	Copyright (c) 2020, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Widgets' ) ) :

	/**
	 * Hs_Widgets
	 *
	 * @final
	 * @since   1.0.0
	 */
	final class Hs_Widgets {

		/**
		 * The single instance of this class.
		 *
		 * @var     Hs_Widgets|null
		 */
		private static $instance = null;

		/**
		 * Returns and/or create the single instance of this class.
		 *
		 * @since   1.2.0
		 *
		 * @return  Hs_Widgets
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Set up the class. This can only be loaded with the get_instance() method.
		 *
		 * @since   1.0.0
		 */
		private function __construct() {
			add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		}

		/**
		 * Register widgets.
		 *
		 * @see 	widgets_init hook
		 *
		 * @since   1.0.0
		 *
		 * @return 	void
		 */
		public function register_widgets() {
			register_widget( 'Hs_Campaign_Terms_Widget' );
			register_widget( 'Hs_Campaigns_Widget' );
			register_widget( 'Hs_Donors_Widget' );
			register_widget( 'Hs_Donate_Widget' );
			register_widget( 'Hs_Donation_Stats_Widget' );
		}
	}

endif;
