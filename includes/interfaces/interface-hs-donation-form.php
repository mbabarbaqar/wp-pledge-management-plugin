<?php
/**
 * Donation form interface.
 *
 * This defines a strict interface that donation forms must implement.
 *
 * @package   Hspg/Interfaces/Hs_Donation_Form_Interface
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( 'Hs_Donation_Form_Interface' ) ) :

	/**
	 * Hs_Donation_Form_Interface interface.
	 *
	 * @since 1.0.0
	 */
	interface Hs_Donation_Form_Interface {

		/**
		 * Render the donation form.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public function render();

		/**
		 * Validate the submitted values.
		 *
		 * @since  1.0.0
		 *
		 * @return boolean
		 */
		public function validate_submission();

		/**
		 * Return the donation values.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_donation_values();

		/**
		 * Return whether user fields should be hidden.
		 *
		 * @since  1.6.0
		 *
		 * @return boolean
		 */
		public function should_hide_user_fields();
	}

endif;
