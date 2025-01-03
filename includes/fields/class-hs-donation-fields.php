<?php
/**
 * Hspg Donation Fields model.
 *
 * @package   Hspg/Classes/Hs_Donation_Fields
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.6.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Donation_Fields' ) ) :

	/**
	 * Hs_Donation_Fields
	 *
	 * @deprecated 1.9.0
	 *
	 * @since 1.5.0
	 * @since 1.6.0 Deprecated. Use Hs_Object_Fields instead.
	 */
	class Hs_Donation_Fields extends Hs_Object_Fields {

		/**
		 * Create class object.
		 *
		 * @deprecated 1.9.0
		 *
		 * @since 1.5.0
		 * @since 1.6.0 Deprecated. Use Hs_Object_Fields instead.
		 *
		 * @param Hs_Field_Registry $registry An instance of `Hs_Field_Registry`.
		 * @param mixed                     $object   The object that will be passed to the value callback.
		 */
		public function __construct( Hs_Field_Registry $registry, $object ) {
			parent::__construct( $registry, $object );

			hs_get_deprecated()->doing_it_wrong(
				'Hs_Donation_Class',
				__( 'Hs_Donation_Fields is deprecated as of Hspg 1.6.0. Use Hs_Object_Fields instead.', 'hspg' ),
				'1.6.0'
			);
		}
	}

endif;
