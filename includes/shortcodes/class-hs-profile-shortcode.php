<?php
/**
 * Profile shortcode class.
 *
 * @package   Hspg/Shortcodes/Profile
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.5.7
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Profile_Shortcode' ) ) :

	/**
	 * Hs_Profile_Shortcode class.
	 *
	 * @since   1.0.0
	 */
	class Hs_Profile_Shortcode {

		/**
		 * The callback method for the campaigns shortcode.
		 *
		 * This receives the user-defined attributes and passes the logic off to the class.
		 *
		 * @since   1.0.0
		 *
		 * @param   array $atts User-defined shortcode attributes.
		 * @return  string
		 */
		public static function display( $atts ) {
			$defaults = array(
				'hide_login' => false,
			);

			$args = shortcode_atts( $defaults, $atts, 'hs_profile' );

			ob_start();

			/* If the user is logged out, show the login form. */
			if ( ! is_user_logged_in() ) {

				if ( false == $args['hide_login'] ) {
					$args['redirect'] = hs_get_current_url();

					echo Hs_Login_Shortcode::display( $args );
				}

				return ob_get_clean();
			}

			$args['form'] = new Hs_Profile_Form( $args );

			/* If the user is logged in, show the profile template. */
			hs_template( 'shortcodes/profile.php', $args );

			return apply_filters( 'hs_profile_shortcode', ob_get_clean() );
		}
	}

endif;
