<?php
/**
 * Donation Form shortcode class.
 *
 * @package   Hspg/Shortcodes/Donation Form
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.5.14
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Donation_Form_Shortcode' ) ) :

	/**
	 * Hs_Donation_Form_Shortcode class.
	 *
	 * @since 1.5.0
	 */
	class Hs_Donation_Form_Shortcode {

		/**
		 * The callback method for the donation form shortcode.
		 *
		 * This receives the user-defined attributes and passes the logic off to the class.
		 *
		 * @since  1.5.0
		 *
		 * @param  array $atts User-defined shortcode attributes.
		 * @return string
		 */
		public static function display( $atts ) {
			$defaults = array(
				'campaign_id' => 0,
			);

			/* Parse incoming $atts into an array and merge it with $defaults. */
			$args = shortcode_atts( $defaults, $atts, 'hs_donation_form' );

			if ( ! hs_campaign_can_receive_donations( $args['campaign_id'] ) ) {
				return '';
			}

			$donation_id = get_query_var( 'donation_id', false );

			/* If a donation ID is included, make sure it belongs to the current user. */
			if ( $donation_id && ! hs_user_can_access_donation( $donation_id ) ) {
				return '';
			}

			ob_start();

			if ( ! wp_script_is( 'hs-script', 'enqueued' ) ) {
				Hs_Public::get_instance()->enqueue_donation_form_scripts();
			}

			$form = hs_get_campaign( $args['campaign_id'] )->get_donation_form();

			do_action( 'hs_donation_form_before', $form );

			$args['form'] = $form;
			$args['campaign'] = $form->get_campaign();

			hs_template( 'donation-form/form-donation.php', $args );

			do_action( 'hs_donation_form_after', $form );

			return ob_get_clean();

		}
	}

endif;
