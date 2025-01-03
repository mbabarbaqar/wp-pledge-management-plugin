<?php
/**
 * Base class for Hspg API routes.
 *
 * @package   Hspg/Classes/Hs_API_Route
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.6.0
 * @version   1.6.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_API_Route' ) ) :

	/**
	 * Hs_API_Route
	 *
	 * @since 1.6.0
	 */
	abstract class Hs_API_Route extends WP_REST_Controller {

		/**
		 * Namespace.
		 *
		 * @since 1.6.0
		 *
		 * @var   string
		 */
		protected $namespace;

		/**
		 * API version.
		 *
		 * @since 1.6.0
		 *
		 * @var   int
		 */
		protected $version;

		/**
		 * Set up API namespace.
		 *
		 * @since 1.6.0
		 */
		public function __construct() {
			$this->version   = 1;
			$this->namespace = 'hspg/v' . $this->version;
		}

		/**
		 * Returns whether the current user can export Hspg reports.
		 *
		 * @since  1.6.0
		 *
		 * @return boolean
		 */
		public function user_can_get_hs_reports() {
			return current_user_can( 'export_hs_reports' );
		}
	}

endif;
