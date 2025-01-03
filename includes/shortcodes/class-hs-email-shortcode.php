<?php
/**
 * Email shortcode class.
 *
 * @package   Hspg/Shortcodes/Email
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

if ( ! class_exists( 'Hs_Email_Shortcode' ) ) :

	/**
	 * Hs_Email_Shortcode class.
	 *
	 * @since 1.5.0
	 */
	class Hs_Email_Shortcode {

		/**
		 * Static object instance.
		 *
		 * @since 1.5.0
		 *
		 * @var   Hs_Email_Shortcode
		 */
		private static $instance;

		/**
		 * The `Hs_Email_Fields` instance.
		 *
		 * @since 1.5.0
		 *
		 * @var   Hs_Email_Fields
		 */
		private $fields;

		/**
		 * Set up class instance.
		 *
		 * @since 1.5.0
		 *
		 * @param Hs_Email_Fields $fields The Hs_Email_Fields instance.
		 */
		private function __construct( Hs_Email_Fields $fields ) {
			$this->fields = $fields;
		}

		/**
		 * Set up the class instance.
		 *
		 * @since  1.5.0
		 *
		 * @param  Hs_Email $email The email object.
		 * @return void
		 */
		public static function init( Hs_Email $email ) {
			$fields         = new Hs_Email_Fields( $email, false );
			self::$instance = new self( $fields );
		}

		/**
		 * Set up the class instance, with preview set to true.
		 *
		 * @since  1.5.0
		 *
		 * @param  Hs_Email $email The email object.
		 * @return void
		 */
		public static function init_preview( Hs_Email $email ) {
			$fields         = new Hs_Email_Fields( $email, true );
			self::$instance = new self( $fields );
		}

		/**
		 * Flush the class instance.
		 *
		 * @since  1.5.0
		 *
		 * @return void
		 */
		public static function flush() {
			self::$instance = null;
		}

		/**
		 * The callback method for the campaigns shortcode.
		 *
		 * This receives the user-defined attributes and passes the logic off to the class.
		 *
		 * @since  1.5.0
		 *
		 * @param  array $atts User-defined shortcode attributes.
		 * @return string
		 */
		public static function display( $atts ) {
			if ( ! isset( self::$instance ) ) {
				hs_get_deprecated()->doing_it_wrong(
					__METHOD__,
					__( '[hs_email] cannot be called until a class instance has been created.', 'hspg' ),
					'1.5.0'
				);
				return;
			}

			$defaults = array(
				'show'    => '',
				'preview' => self::$instance->fields->is_preview(),
			);

			$args = apply_filters( 'hs_email_shortcode_args', wp_parse_args( $atts, $defaults ), $atts, $defaults );

			if ( ! isset( $args['show'] ) ) {
				return '';
			}

			return self::$instance->get( $args['show'], $args );
		}

		/**
		 * Return the value for a particular variable.
		 *
		 * @since  1.5.0
		 *
		 * @param  string $field The field.
		 * @param  array  $args  Mixed arguments.
		 * @return string
		 */
		public function get( $field, $args ) {
			return $this->fields->get_field_value( $field, $args );
		}
	}

endif;
