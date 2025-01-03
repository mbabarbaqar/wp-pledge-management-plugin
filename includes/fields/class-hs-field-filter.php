<?php
/**
 * A class that is used when filtering a set of fields by a particular property.
 *
 * This is designed to be used in conjunction with array_filter in a PHP 5.2-friendly way.
 * i.e.:
 *
 * array_filter( $fields, array( new Hs_Field_Filter( 'property' ), 'is_true' ) );
 *
 * @package   Hspg/Classes/Hs_Field_Filter
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

if ( ! class_exists( 'Hs_Field_Filter' ) ) :

	/**
	 * Hs_Field_Filter
	 *
	 * @since 1.6.0
	 */
	class Hs_Field_Filter {

		/**
		 * The property to be used for the filter.
		 *
		 * @since 1.6.0
		 *
		 * @var   string
		 */
		protected $property;

		/**
		 * Property value to compare against.
		 *
		 * @since 1.6.0
		 *
		 * @var   mixed
		 */
		protected $value;

		/**
		 * Sets up the filter with the property that will be used for the filter.
		 *
		 * @since 1.6.0
		 *
		 * @param string $property The property to be used for the filter.
		 * @param mixed  $value   A value to compare against.
		 */
		public function __construct( $property, $value = '' ) {
			$this->property = $property;
			$this->value    = $value;
		}

		/**
		 * Returns whether the value of the property for the given field is true.
		 *
		 * @since  1.6.0
		 *
		 * @param  Hs_Field $field Instance of `Hs_Field`.
		 * @return boolean
		 */
		public function is_true( Hs_Field $field ) {
			return (bool) $field->{$this->property};
		}

		/**
		 * Returns whether the value of the property for the given field is not false.
		 *
		 * @since  1.6.0
		 *
		 * @param  Hs_Field $field Instance of `Hs_Field`.
		 * @return boolean
		 */
		public function is_not_false( Hs_Field $field ) {
			return false !== $field->{$this->property};
		}

		/**
		 * Returns whether the value of the property for the given field is equal to the passed value.
		 *
		 * @since  1.6.0
		 *
		 * @param  Hs_Field $field Instance of `Hs_Field`.
		 * @return boolean
		 */
		public function is_equal_to( Hs_Field $field ) {
			return $this->value === $field->{$this->property};
		}
	}

endif;
