<?php
/**
 * Admin form model class.
 *
 * @package   Hspg/Classes/Hs_Admin_Form
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.5.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Admin_Form' ) ) :

	/**
	 * Hs_Admin_Form
	 *
	 * @since  1.5.0
	 */
	class Hs_Admin_Form extends Hs_Form {

		/**
		 * Fields in the form.
		 *
		 * @since 1.5.0
		 *
		 * @var   array
		 */
		protected $fields = array();

		/**
		 * Return the Form_View object for this form.
		 *
		 * @since  1.5.0
		 *
		 * @return Hs_Form_View_Interface
		 */
		public function view() {
			if ( ! isset( $this->view ) ) {
				$this->view = new Hs_Admin_Form_View( $this );
			}

			return $this->view;
		}

		/**
		 * Returns hidden fields to be added to the form.
		 *
		 * @since  1.5.0
		 *
		 * @return array
		 */
		public function get_hidden_fields() {
			$fields = parent::get_hidden_fields();

			unset(
				$fields['_wp_http_referer'],
				$fields[ $this->nonce_name ]
			);

			return $fields;
		}

		/**
		 * Set the form fields.
		 *
		 * @since  1.5.0
		 *
		 * @param  array $fields An array of fields to be displayed.
		 * @return void
		 */
		public function set_fields( array $fields ) {
			uasort( $fields, 'hs_priority_sort' );
			$this->fields = $fields;
		}

		/**
		 * Return the fields.
		 *
		 * @since  1.5.0
		 *
		 * @return array
		 */
		public function get_fields() {
			return $this->fields;
		}
	}

endif;
