<?php
/**
 * My Donations shortcode class.
 *
 * @package   Hspg/Shortcodes/My Donations
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.4.0
 * @version   1.5.7
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_My_Donations_Shortcode' ) ) :

	/**
	 * Hs_My_Donations_Shortcode class.
	 *
	 * @since 1.4.0
	 */
	class Hs_My_Donations_Shortcode {

		/**
		 * The callback method for the campaigns shortcode.
		 *
		 * This receives the user-defined attributes and passes the logic off to the class.
		 *
		 * @since  1.4.0
		 *
		 * @param  array $atts User-defined shortcode attributes.
		 * @return string
		 */
		public static function display( $atts ) {
			$defaults = array(
				'hide_login' => false,
			);

			$args = shortcode_atts( $defaults, $atts, 'hs_my_donations' );

			ob_start();

			/* If the user is logged out, show the login form. */
			if ( ! is_user_logged_in() ) {

				if ( false == $args['hide_login'] ) {
					$args['redirect'] = hs_get_current_url();

					echo Hs_Login_Shortcode::display( $args );
				}

				return ob_get_clean();
			}

			/* If the user is logged in, show the my donations template. */
			$user     = hs_get_user( get_current_user_id(), true );
			$donor_id = $user->get_donor_id();

			if ( false === $donor_id ) {
				$donations  = array();
				$query_args = array();
			} else {
				$query_args = array(
					'output'   => 'posts',
					'orderby'  => 'date',
					'order'    => 'DESC',
					'number'   => -1,
					'donor_id' => $donor_id,
				);

				if ( ! $user->is_verified() ) {
					$query_args['user_id'] = $user->ID;

					if ( array_key_exists( 'hs_action', $_GET ) && 'verify_email' == $_GET['hs_action'] ) {
						$redirect = array_key_exists( 'redirect_url', $_GET ) ? $_GET['redirect_url'] : false;
						$message  = sprintf(
							/* translators: %s: email verification link */
							__( 'We have sent you an email to confirm your email address. Haven\'t received the email? <a href="%s">Click here to send it again.</a>', 'hspg' ),
							esc_url_raw( hs_get_email_verification_link( $user, $redirect, true ) )
						);
					} else {
						$message = sprintf(
							/* translators: %s: email verification link */
							__( '<a href="%s">Confirm your email address</a> to access your full donation history.', 'hspg' ),
							esc_url( hs_get_email_verification_link( $user, hs_get_current_url(), true ) )
						);
					}

					hs_get_notices()->add_error( $message );
				}

				$donations = new Hs_Donations_Query( $query_args );
			}

			$args['donations'] = $donations;
			$args['user']      = $user;

			hs_template( 'shortcodes/my-donations.php', $args );

			/**
			 * Filter the output of the shortcode.
			 *
			 * @since 1.4.0
			 *
			 * @param string $output The default output.
			 * @param array  $args   The view arguments.
			 * @param array  $args   The query arguments.
			 */
			return apply_filters( 'hs_my_donations_shortcode', ob_get_clean(), $args, $query_args );
		}
	}

endif;
