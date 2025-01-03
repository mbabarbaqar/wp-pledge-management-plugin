<?php
/**
 * Class that models the new offline donation email.
 *
 * @version     1.5.0
 * @package     Hspg/Classes/Hs_Email_Offline_Donation_Notification
 * @author     HCS
 * @copyright   Copyright (c) 2020, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Email_Offline_Donation_Notification' ) && class_exists( 'Hs_Email_New_Donation' ) ) {

	/**
	 * New Offline Donation Email
	 *
	 * @since 1.5.0
	 */
	class Hs_Email_Offline_Donation_Notification extends Hs_Email_New_Donation {

		/** Email ID */
		CONST ID = 'offline_donation_notification';

		/**
		 * Array of supported object types (campaigns, donations, donors, etc).
		 *
		 * @var string[]
		 */
		protected $object_types = array( 'donation' );

		/**
		 * Create email object.
		 *
		 * @since 1.5.0
		 *
		 * @param mixed[] $objects
		 */
		public function __construct( $objects = array() ) {
			parent::__construct( $objects );

			/**
			 * Customize the name of the offline donation notification.
			 *
			 * @since 1.5.0
			 *
			 * @param string $name
			 */
			$this->name = apply_filters( 'hs_email_offline_donation_notification_name', __( 'Admin: New Offline Donation Notification', 'hspg' ) );
		}

		/**
		 * Returns the current email's ID.
		 *
		 * @since  1.5.0
		 *
		 * @return string
		 */
		public static function get_email_id() {
			return self::ID;
		}

		/**
		 * Send the email.
		 *
		 * @since  1.5.0
		 *
		 * @param  int $donation_id The donation ID we're sending an email about.
		 * @return boolean
		 */
		public static function send_with_donation_id( $donation_id ) {
			/* Verify that the email is enabled. */
			if ( ! hs_get_helper( 'emails' )->is_enabled_email( Hs_Email_Offline_Donation_Notification::get_email_id() ) ) {
				return false;
			}

			/* If the donation is not pending, stop here. */
			if ( 'hs-pending' != get_post_status( $donation_id ) ) {
				return false;
			}

			/* If the donation was not made with the offline payment option, stop here. */
			if ( 'offline' != get_post_meta( $donation_id, 'donation_gateway', true ) ) {
				return false;
			}

			if ( ! apply_filters( 'hs_send_' . self::get_email_id(), true, $donation_id ) ) {
				return false;
			}

			/* All three of those checks passed, so proceed with sending the email. */
			$email = new Hs_Email_Offline_Donation_Notification( array(
				'donation' => new Hs_Donation( $donation_id )
			) );

			/**
			 * Don't resend the email.
			 */
			if ( $email->is_sent_already( $donation_id ) ) {
				return false;
			}

			$sent = $email->send();

			/**
			 * Log that the email was sent.
			 */
			if ( apply_filters( 'hs_log_email_send', true, self::get_email_id(), $email ) ) {
				$email->log( $donation_id, $sent );
			}

			return true;
		}

		/**
		 * Resend the email.
		 *
		 * @since  1.5.0
		 *
		 * @param  int   $object_id An object ID.
		 * @param  array $args      Mixed set of arguments.
		 * @return boolean
		 */
		public static function resend( $object_id, $args = array() ) {
			$donation = hs_get_donation( $object_id );

			if ( ! is_object( $donation ) || 0 == count( $donation->get_campaign_donations() ) ) {
				return false;
			}

			$email = new Hs_Email_Offline_Donation_Notification( array(
				'donation' => $donation,
			) );

			$success = $email->send();

			/**
			 * Log that the email was sent.
			 */
			if ( apply_filters( 'hs_log_email_send', true, self::get_email_id(), $email ) ) {
				$email->log( $object_id, $success );
			}

			return $success;
		}

		/**
		 * Checks whether an email can be resent.
		 *
		 * @since  1.5.0
		 *
		 * @param  int   $object_id An object ID.
		 * @param  array $args      Mixed set of arguments.
		 * @return boolean
		 */
		public static function can_be_resent( $object_id, $args = array() ) {
			$resendable = 'hs-pending' == get_post_status( $object_id )
				&& 'offline' == get_post_meta( $object_id, 'donation_gateway', true );

			/**
			 * Filter whether the email can be resent.
			 *
			 * @since 1.6.0
			 *
			 * @param boolean $resendable Whether the email can be resent.
			 * @param int     $object_id  The donation ID.
			 * @param array   $args       Mixed set of arguments.
			 */
			return apply_filters( 'hs_can_resend_offline_donation_notification_email', $resendable, $object_id, $args );
		}


		/**
		 * Return the default subject line for the email.
		 *
		 * @since  1.5.0
		 *
		 * @return string
		 */
		protected function get_default_subject() {
			return __( 'You have received a new offline donation', 'hspg' );
		}

		/**
		 * Return the default headline for the email.
		 *
		 * @since  1.5.0
		 *
		 * @return string
		 */
		protected function get_default_headline() {
			/**
			 * Filter the default headline.
			 *
			 * @since 1.5.0
			 *
			 * @param string           $headline The default headline.
			 * @param Hs_Email $email    The Hs_Email object.
			 */
			return apply_filters( 'hs_email_offline_donation_notification_default_headline', __( 'New Offline Donation', 'hspg' ), $this );
		}

		/**
		 * Return the default body for the email.
		 *
		 * @since  1.5.0
		 *
		 * @return string
		 */
		protected function get_default_body() {
			ob_start();
			?>
<p><?php _e( '[hs_email show=donor] ([hs_email show=donor_email]) has just made an offline donation!', 'hspg' ); ?></p>
<p><strong><?php _e( 'Summary', 'hspg' ); ?></strong></p>
<p>[hs_email show=donation_summary]</p>
		<?php
			/**
			 * Filter the default body content.
			 *
			 * @since 1.5.0
			 *
			 * @param string           $body  The body content.
			 * @param Hs_Email $email The Hs_Email object.
			 */
			return apply_filters( 'hs_email_offline_donation_notification_default_body', ob_get_clean(), $this );
		}
	}
}
