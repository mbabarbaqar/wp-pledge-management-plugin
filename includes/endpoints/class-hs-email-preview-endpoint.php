<?php
/**
 * Email preview endpoint.
 *
 * @package   Hspg/Classes/Hs_Email_Preview_Endpoint
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Email_Preview_Endpoint' ) ) :

	/**
	 * Hs_Email_Preview_Endpoint
	 *
	 * @since  1.5.0
	 */
	class Hs_Email_Preview_Endpoint extends Hs_Endpoint {

		/** Endpoint ID. */
		const ID = 'email_preview';

		/**
		 * Return the endpoint ID.
		 *
		 * @since  1.5.0
		 *
		 * @return string
		 */
		public static function get_endpoint_id() {
			return self::ID;
		}

		/**
		 * Return the endpoint URL.
		 *
		 * @since  1.5.0
		 *
		 * @param  array $args Mixed arguments.
		 * @return string
		 */
		public function get_page_url( $args = array() ) {
			if ( ! array_key_exists( 'email_id', $args ) ) {
				hs_get_deprecated()->doing_it_wrong(
					__METHOD__,
					__( 'Missing email_id in args for email preview endpoint URL.', 'hspg' ),
					'1.5.0'
				);

				return '';
			}

			return esc_url_raw(
				add_query_arg(
					array(
						'hs_action' => 'preview_email',
						'email_id'          => $args['email_id'],
					),
					home_url()
				)
			);
		}

		/**
		 * Return whether we are currently viewing the endpoint.
		 *
		 * @since  1.5.0
		 *
		 * @param  array $args Mixed arguments.
		 * @return boolean
		 */
		public function is_page( $args = array() ) {
			return array_key_exists( 'hs_action', $_GET ) && 'preview_email' == $_GET['hs_action'];
		}

		/**
		 * Return the template to display for this endpoint.
		 *
		 * @since  1.5.0
		 *
		 * @param  string $template The default template.
		 * @return string
		 */
		public function get_template( $template ) {
			do_action( 'hs_email_preview' );

			return 'emails/preview.php';
		}
	}

endif;
