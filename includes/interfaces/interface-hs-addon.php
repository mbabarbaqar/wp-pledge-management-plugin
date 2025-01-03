<?php
/**
 * Addon interface.
 *
 * This defines a strict interface that all Core Addons must implement
 *
 * @version   1.0.0
 * @package   Hspg/Interfaces/Hs_Addon_Interface
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( 'Hs_Addon_Interface' ) ) :

	/**
	 * Hs_Addon_Interface interface.
	 *
	 * @since 1.0.0
	 */
	interface Hs_Addon_Interface {

		/**
		 * Activate the addon.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public static function activate();

		/**
		 * Load the addon.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public static function load();
	}

endif;
