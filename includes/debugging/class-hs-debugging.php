<?php
/**
 * Responsible for helping with debugging.
 *
 * @package   Hspg/Classes/Hs_Debugging
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.6.42
 * @version   1.6.42
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Debugging' ) ) :

	/**
	 * Hs_Debugging
	 *
	 * @since 1.6.42
	 */
	class Hs_Debugging {

		/**
		 * Create class object.
		 *
		 * @since 1.6.42
		 */
		public function __construct() {
			/**
			 * Automatically add Hspg's debugging constants when
			 * using the WP Debugging plugin.
			 */
			add_filter( 'wp_debugging_add_constants', array( $this, 'add_debugging_constants' ) );
		}

		/**
		 * Add debugging constants.
		 *
		 * @since  1.6.42
		 *
		 * @param  array $added_constants Collection of added constants.
		 * @return array
		 */
		public function add_debugging_constants( $added_constants ) {
			return array_merge(
				$added_constants,
				array(
					'hs_debug' => array( 'value' => 'true' )
				)
			);
		}
	}

endif;
