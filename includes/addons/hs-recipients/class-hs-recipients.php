<?php
/**
 * Main class for setting up the Hspg Recipients Addon, which is programatically activated by child themes.
 *
 * @package   Hspg/Classes/Hs_Recipients
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Recipients' ) ) :

	/**
	 * Hs_Recipients
	 *
	 * @since 1.0.0
	 */
	class Hs_Recipients implements Hs_Addon_Interface {

		/**
		 * Responsible for creating class instances.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public static function load() {
			$object = new Hs_Recipients();

			do_action( 'hs_recipients_addon_loaded', $object );
		}

		/**
		 * Create class instance.
		 *
		 * @since 1.0.0
		 */
		private function __construct() {
			$this->load_dependencies();
		}

		/**
		 * Include required files.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		private function load_dependencies() {
			require_once( 'hs-recipients-functions.php' );
			require_once( 'class-hs-recipient-types.php' );
		}

		/**
		 * Activate the addon.
		 *
		 * @since  1.0.0
		 *
		 * @return boolean Whether the add-on was activated.
		 */
		public static function activate() {
			if ( 'hs_activate_addon' !== current_filter() ) {
				return false;
			}

			self::load();

			return true;
		}
	}

endif;
