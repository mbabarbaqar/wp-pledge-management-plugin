<?php
/**
 * Hspg Template Functions.
 *
 * Functions used with template hooks.
 *
 * @package   Hspg/Functions/Templates
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.5.14
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// //////////////////////////////
// HEAD OUTPUT
// //////////////////////////////
if ( ! function_exists( 'hs_template_custom_styles' ) ) :

	/**
	 * Add custom styles to the <head> section.
	 *
	 * This is used on the wp_head action.
	 *
	 * @since  1.2.0
	 *
	 * @return void
	 */
	function hs_template_custom_styles() {
		if ( ! apply_filters( 'hs_add_custom_styles', true ) ) {
			return;
		}

		$styles = get_transient( 'hs_custom_styles' );

		if ( false === $styles ) {

			ob_start();

			hs_template( 'custom-styles.css.php' );

			$styles = ob_get_clean();

			$styles = hs_compress_css( $styles );

			set_transient( 'hs_custom_styles', $styles, 0 );
		}

		echo $styles;
	}

endif;

if ( ! function_exists( 'hs_hide_admin_bar' ) ) :

	/**
	 * Hides the admin bar from header.
	 *
	 * This is designed to be used when viewing the campaign widget.
	 *
	 * @since  1.3.0
	 *
	 * @return void
	 */
	function hs_hide_admin_bar() {
		?>
<style type="text/css" media="screen">
html { margin-top: 0 !important; }
* html body { margin-top: 0 !important; }
</style>
		<?php
	}

endif;

// //////////////////////////////
// BODY CLASSES
// //////////////////////////////
if ( ! function_exists( 'hs_add_body_classes' ) ) :

	/**
	 * Adds custom body classes to certain templates.
	 *
	 * @since  1.3.0
	 *
	 * @param  string[] $classes Body classes.
	 * @return string[]
	 */
	function hs_add_body_classes( $classes ) {
		if ( hs_is_page( 'donation_receipt_page' ) ) {
			$classes[] = 'campaign-donation-receipt';
		}

		if ( hs_is_page( 'donation_processing_page' ) ) {
			$classes[] = 'campaign-donation-processing';
		}

		if ( hs_is_page( 'campaign_donation_page' ) ) {
			$classes[] = 'campaign-donation-page';
		}

		if ( hs_is_page( 'campaign_widget_page' ) ) {
			$classes[] = 'campaign-widget';
		}

		if ( hs_is_page( 'email_preview' ) ) {
			$classes[] = 'email-preview';
		}

		return $classes;
	}

endif;

// //////////////////////////////
// SINGLE CAMPAIGN CONTENT
// //////////////////////////////
if ( ! function_exists( 'hs_template_campaign_description' ) ) :

	/**
	 * Display the campaign description before the summary and rest of content.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return void
	 */
	function hs_template_campaign_description( $campaign ) {
		hs_template( 'campaign/description.php', array( 'campaign' => $campaign ) );
	}

endif;

if ( ! function_exists( 'hs_template_campaign_finished_notice' ) ) :

	/**
	 * Display the campaign finished notice.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return void
	 */
	function hs_template_campaign_finished_notice( $campaign ) {
		if ( ! $campaign->has_ended() ) {
			return;
		}

		hs_template( 'campaign/finished-notice.php', array( 'campaign' => $campaign ) );
	}

endif;

if ( ! function_exists( 'hs_template_campaign_percentage_raised' ) ) :

	/**
	 * Display the percentage that the campaign has raised in summary block.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return boolean     True if the template was displayed. False otherwise.
	 */
	function hs_template_campaign_percentage_raised( $campaign ) {
		if ( ! $campaign->has_goal() ) {
			return false;
		}

		hs_template( 'campaign/summary-percentage-raised.php', array( 'campaign' => $campaign ) );

		return true;
	}

endif;

if ( ! function_exists( 'hs_template_campaign_donation_summary' ) ) :

	/**
	 * Display campaign goal in summary block.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return true
	 */
	function hs_template_campaign_donation_summary( $campaign ) {
		hs_template( 'campaign/summary-donations.php', array( 'campaign' => $campaign ) );
		return true;
	}

endif;

if ( ! function_exists( 'hs_template_campaign_donor_count' ) ) :

	/**
	 * Display number of campaign donors in summary block.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return true
	 */
	function hs_template_campaign_donor_count( $campaign ) {
		hs_template( 'campaign/summary-donors.php', array( 'campaign' => $campaign ) );
		return true;
	}

endif;

if ( ! function_exists( 'hs_template_campaign_time_left' ) ) :

	/**
	 * Display the amount of time left in the campaign in the summary block.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return boolean     True if the template was displayed. False otherwise.
	 */
	function hs_template_campaign_time_left( $campaign ) {
		if ( $campaign->is_endless() ) {
			return false;
		}

		hs_template( 'campaign/summary-time-left.php', array( 'campaign' => $campaign ) );
		return true;
	}

endif;

if ( ! function_exists( 'hs_template_donate_button' ) ) :

	/**
	 * Display donate button or link in the campaign summary.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return boolean     True if the template was displayed. False otherwise.
	 */
	function hs_template_donate_button( $campaign ) {
		if ( ! $campaign->can_receive_donations() ) {
			return false;
		}

		$campaign->donate_button_template();

		return true;
	}

endif;

if ( ! function_exists( 'hs_template_campaign_summary' ) ) :

	/**
	 * Display campaign summary before rest of campaign content.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return void
	 */
	function hs_template_campaign_summary( $campaign ) {
		hs_template( 'campaign/summary.php', array( 'campaign' => $campaign ) );
	}

endif;

if ( ! function_exists( 'hs_template_campaign_progress_bar' ) ) :

	/**
	 * Output the campaign progress bar.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return void
	 */
	function hs_template_campaign_progress_bar( $campaign ) {
		hs_template( 'campaign/progress-bar.php', array( 'campaign' => $campaign ) );
	}

endif;

if ( ! function_exists( 'hs_template_campaign_donate_button' ) ) :

	/**
	 * Output the campaign donate button.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return void
	 */
	function hs_template_campaign_donate_button( $campaign ) {
		hs_template( 'campaign/donate-button.php', array( 'campaign' => $campaign ) );
	}

endif;

if ( ! function_exists( 'hs_template_campaign_donate_link' ) ) :

	/**
	 * Output the campaign donate link.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return void
	 */
	function hs_template_campaign_donate_link( $campaign ) {
		hs_template( 'campaign/donate-link.php', array( 'campaign' => $campaign ) );
	}

endif;

if ( ! function_exists( 'hs_template_campaign_status_tag' ) ) :

	/**
	 * Output the campaign status tag.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return void
	 */
	function hs_template_campaign_status_tag( $campaign ) {
		hs_template( 'campaign/status-tag.php', array( 'campaign' => $campaign ) );
	}

endif;

if ( ! function_exists( 'hs_template_campaign_donation_form_in_page' ) ) :

	/**
	 * Add the donation form straight into the campaign page.
	 *
	 * @since  1.0.0
	 * @since  1.5.0 Function now returns true/false depending
	 *               on whether the template is rendered.
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return boolean
	 */
	function hs_template_campaign_donation_form_in_page( Hs_Campaign $campaign ) {
		if ( $campaign->can_receive_donations() && 'same_page' == hs_get_option( 'donation_form_display', 'separate_page' ) ) {
			$donation_id = get_query_var( 'donation_id', false );

			/* If a donation ID is included, make sure it belongs to the current user. */
			if ( $donation_id && ! hs_user_can_access_donation( $donation_id ) ) {
				return false;
			}

			hs_get_current_donation_form()->render();
			return true;
		}

		return false;
	}

endif;

if ( ! function_exists( 'hs_template_campaign_modal_donation_window' ) ) :

	/**
	 * Adds the modal donation window to a campaign page.
	 *
	 * @since  1.0.0
	 * @since  1.5.0 Function now returns true/false depending
	 *               on whether the template is rendered.
	 *
	 * @global WP_Query $wp_query
	 * @return boolean
	 */
	function hs_template_campaign_modal_donation_window() {
		global $wp_query;

		if ( Hspg::CAMPAIGN_POST_TYPE != get_post_type() ) {
			return false;
		}

		if ( isset( $wp_query->query_vars['donate'] ) ) {
			return false;
		}

		$campaign = hs_get_current_campaign();

		if ( $campaign->can_receive_donations() && 'modal' == hs_get_option( 'donation_form_display', 'separate_page' ) ) {
			hs_template( 'campaign/donate-modal-window.php', array( 'campaign' => $campaign ) );
			return true;
		}

		return false;
	}

endif;

// //////////////////////////////
// CAMPAIGN LOOP
// //////////////////////////////
if ( ! function_exists( 'hs_template_campaign_loop' ) ) :

	/**
	 * Display the campaign loop.
	 *
	 * This is used instead of the_content filter.
	 *
	 * @since  1.0.0
	 *
	 * @param  WP_Query $campaigns Query with campaigns.
	 * @param  int      $columns   Number of columns to use for loop.
	 * @return void
	 */
	function hs_template_campaign_loop( $campaigns = false, $columns = 1 ) {
		if ( ! $campaigns ) {
			global $wp_query;
			$campaigns = $wp_query;
		}

		hs_template(
			'campaign-loop.php',
			array(
				'campaigns' => $campaigns,
				'columns'   => $columns,
			)
		);
	}

endif;

if ( ! function_exists( 'hs_template_responsive_styles' ) ) :

	/**
	 * Add responsive styles for the campaign loop.
	 *
	 * @since  1.4.0
	 *
	 * @param  WP_Query $campaigns The campaigns that will be displayed.
	 * @param  array    $args      The view arguments.
	 * @return void
	 */
	function hs_template_responsive_styles( $campaigns, $args ) {
		if ( ! isset( $args['responsive'] ) || ! $args['responsive'] ) {
			return;
		}

		$breakpoint = '768px';

		if ( preg_match( '/[px|em]/', $args['responsive'] ) ) {
			$breakpoint = $args['responsive'];
		}
		?>
<style type="text/css" media="screen">
@media only screen and (max-width: <?php echo $breakpoint; ?>) {
	.campaign-loop.campaign-grid.masonry { -moz-column-count: 1; -webkit-column-count: 1; column-count: 1; }
	.campaign-loop.campaign-grid .campaign,.campaign-loop.campaign-grid .campaign.hentry { width: 100% !important; }
}
</style>
		<?php
	}

endif;

if ( ! function_exists( 'hs_template_campaign_loop_thumbnail' ) ) :

	/**
	 * Output the campaign thumbnail on campaigns displayed within the loop.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return void
	 */
	function hs_template_campaign_loop_thumbnail( $campaign ) {
		hs_template( 'campaign-loop/thumbnail.php', array( 'campaign' => $campaign ) );
	}

endif;

if ( ! function_exists( 'hs_template_campaign_loop_donation_stats' ) ) :

	/**
	 * Output the campaign donation status on campaigns displayed within the loop.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @return void
	 */
	function hs_template_campaign_loop_donation_stats( $campaign ) {
		hs_template( 'campaign-loop/donation-stats.php', array( 'campaign' => $campaign ) );
	}

endif;

if ( ! function_exists( 'hs_template_campaign_loop_donate_link' ) ) :

	/**
	 * Output the campaign donation status on campaigns displayed within the loop.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @param  mixed[]             $args     Optional arguments.
	 * @return void
	 */
	function hs_template_campaign_loop_donate_link( $campaign, $args = array() ) {
		if ( isset( $args['button'] ) && 'donate' != $args['button'] ) {
			return;
		}

		$campaign->donate_button_loop_template();
	}

endif;

if ( ! function_exists( 'hs_template_campaign_loop_more_link' ) ) :

	/**
	 * Output the read more link on campaigns displayed within the loop.
	 *
	 * @since  1.2.3
	 *
	 * @param  Hs_Campaign $campaign The campaign object.
	 * @param  mixed[]             $args     Optional arguments.
	 * @return void
	 */
	function hs_template_campaign_loop_more_link( $campaign, $args = array() ) {
		if ( ! isset( $args['button'] ) || 'details' != $args['button'] ) {
			return;
		}

		hs_template( 'campaign-loop/more-link.php', array( 'campaign' => $campaign ) );
	}

endif;

if ( ! function_exists( 'hs_template_campaign_loop_add_modal' ) ) :

	/**
	 * Checks if the modal option is enabled and hooks the modal template up to wp_footer if it is.
	 *
	 * @since  1.2.3
	 *
	 * @return void
	 */
	function hs_template_campaign_loop_add_modal() {
		if ( 'modal' == hs_get_option( 'donation_form_display', 'separate_page' ) ) {
			add_action( 'wp_footer', 'hs_template_campaign_loop_modal_donation_window' );
		}
	}

endif;

if ( ! function_exists( 'hs_template_campaign_loop_modal_donation_window' ) ) :

	/**
	 * Adds the modal donation window to the campaign loop.
	 *
	 * @since  1.2.3
	 *
	 * @return void
	 */
	function hs_template_campaign_loop_modal_donation_window() {
		hs_template( 'campaign-loop/donate-modal-window.php' );
	}

endif;

// //////////////////////////////
// DONATION RECEIPT
// //////////////////////////////
if ( ! function_exists( 'hs_template_donation_receipt_content' ) ) :

	/**
	 * Display the donation form. This is used with the_content filter.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $content Page content.
	 * @return string
	 */
	function hs_template_donation_receipt_content( $content ) {

		if ( ! in_the_loop() || ! hs_is_page( 'donation_receipt_page' ) ) {
			return $content;
		}

		/* If we are NOT using the automatic option, this is a static page with the shortcode, so don't filter again. */
		if ( 'auto' != hs_get_option( 'donation_receipt_page', 'auto' ) ) {
			return $content;
		}

		return hs_template_donation_receipt_output( $content );

	}

endif;

if ( ! function_exists( 'hs_template_donation_receipt_output' ) ) :

	/**
	 * Render the donation receipt. This can be used by the [donation_receipt] shortcode or through `the_content` filter.
	 *
	 * @since  1.0.0
	 * @since  1.5.0 Added $donation argument.
	 *
	 * @param  string                   $content  Page content.
	 * @param  Hs_Donation|null $donation Optional. Useful when the donation is not the current donation.
	 * @return string
	 */
	function hs_template_donation_receipt_output( $content, $donation = null ) {
		if ( is_null( $donation ) ) {
			$donation = hs_get_current_donation();
		}

		if ( ! $donation || 'simple' != $donation->get_donation_type() ) {
			return $content;
		}

		ob_start();

		if ( ! $donation->is_from_current_user() ) {
			hs_template_from_session(
				'donation-receipt/not-authorized.php',
				array( 'content' => $content ),
				'donation_receipt',
				array( 'donation_id' => $donation->ID )
			);

			return ob_get_clean();
		}

		do_action( 'hs_donation_receipt_page', $donation );

		hs_template(
			'content-donation-receipt.php',
			array(
				'content'  => $content,
				'donation' => $donation,
			)
		);

		$content = ob_get_clean();

		return $content;
	}

endif;

if ( ! function_exists( 'hs_template_donation_receipt_summary' ) ) :

	/**
	 * Display the donation receipt summary.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Donation $donation The Donation object.
	 * @return void
	 */
	function hs_template_donation_receipt_summary( Hs_Donation $donation ) {
		hs_template( 'donation-receipt/summary.php', array( 'donation' => $donation ) );
	}

endif;

if ( ! function_exists( 'hs_template_donation_receipt_offline_payment_instructions' ) ) :

	/**
	 * Display the offline payment instructions, if applicable.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Donation $donation The Donation object.
	 * @return void
	 */
	function hs_template_donation_receipt_offline_payment_instructions( Hs_Donation $donation ) {
		if ( 'offline' != $donation->get_gateway() ) {
			return;
		}

		hs_template( 'donation-receipt/offline-payment-instructions.php', array( 'donation' => $donation ) );
	}

endif;

if ( ! function_exists( 'hs_template_donation_receipt_details' ) ) :

	/**
	 * Display the donation details.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Donation $donation The Donation object.
	 * @return void
	 */
	function hs_template_donation_receipt_details( Hs_Donation $donation ) {
		hs_template( 'donation-receipt/details.php', array( 'donation' => $donation ) );
	}


endif;

// //////////////////////////////
// DONATION FORM
// //////////////////////////////
if ( ! function_exists( 'hs_template_donation_form_content' ) ) :

	/**
	 * Display the donation form. This is used with the_content filter.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $content Page content.
	 * @return string
	 */
	function hs_template_donation_form_content( $content ) {

		if ( ! hs_is_main_loop() || ! hs_is_page( 'campaign_donation_page' ) ) {
			return $content;
		}

		if ( 'separate_page' != hs_get_option( 'donation_form_display', 'separate_page' )
			&& false === get_query_var( 'donate', false ) ) {
			return $content;
		}

		ob_start();

		hs_template( 'content-donation-form.php' );

		return ob_get_clean();
	}

endif;

if ( ! function_exists( 'hs_template_donation_form_login' ) ) :

	/**
	 * Display a prompt to login at the start of the user fields block.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Donation_Form_Interface $form The donation form object.
	 * @return void
	 */
	function hs_template_donation_form_login( Hs_Donation_Form_Interface $form ) {

		$user = $form->get_user();

		if ( $user ) {
			return;
		}

		hs_template( 'donation-form/donor-fields/login-form.php' );
	}

endif;

if ( ! function_exists( 'hs_template_donation_form_donor_details' ) ) :

	/**
	 * Display the donor's saved details if the user is logged in.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Donation_Form_Interface $form The donation form object.
	 * @return void
	 */
	function hs_template_donation_form_donor_details( Hs_Donation_Form_Interface $form ) {
		/* Verify that the user is logged in and has all required fields filled out */
		if ( ! $form->should_hide_user_fields() ) {
			return;
		}

		hs_template( 'donation-form/donor-fields/donor-details.php', array( 'user' => $form->get_user() ) );
	}

endif;

if ( ! function_exists( 'hs_template_donation_form_donor_fields_hidden_wrapper_start' ) ) :

	/**
	 * If the user is logged in, adds a wrapper around the donor fields that hide them.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Donation_Form_Interface $form The donation form object.
	 * @return void
	 */
	function hs_template_donation_form_donor_fields_hidden_wrapper_start( Hs_Donation_Form_Interface $form ) {
		/* Verify that the user is logged in and has all required fields filled out */
		if ( ! $form->should_hide_user_fields() ) {
			return;
		}

		hs_template( 'donation-form/donor-fields/hidden-fields-wrapper-start.php' );
	}

endif;

if ( ! function_exists( 'hs_template_donation_form_donor_fields_hidden_wrapper_end' ) ) :

	/**
	 * Closes the hidden donor fields wrapper div if the user is logged in.
	 *
	 * @since  1.0.0
	 *
	 * @param  Hs_Donation_Form_Interface $form The donation form object.
	 * @return void
	 */
	function hs_template_donation_form_donor_fields_hidden_wrapper_end( Hs_Donation_Form_Interface $form ) {
		/* Verify that the user is logged in and has all required fields filled out */
		if ( ! $form->should_hide_user_fields() ) {
			return;
		}

		hs_template( 'donation-form/donor-fields/hidden-fields-wrapper-end.php' );
	}

endif;

if ( ! function_exists( 'hs_template_donation_form_current_amount_text' ) ) :

	/**
	 * Display the amount currently selected to donate.
	 *
	 * @since  1.5.0
	 *
	 * @param  int|float $amount      The current donation amount.
	 * @param  string    $form_id     The current form ID.
	 * @param  string    $campaign_id The current campaign ID.
	 * @return string
	 */
	function hs_template_donation_form_current_amount_text( $amount, $form_id, $campaign_id ) {
		if ( ! $amount ) {
			return '';
		}

		/**
		 * Format the donation amount.
		 *
		 * @since 1.4.14
		 * @since 1.5.0 Third parameter has been changed from an instance of
		 *              `Hs_Donation_Form` to a campaign ID.
		 *
		 * @param string    $amount_formatted The formatted amount.
		 * @param int|float $amount           The raw amount.
		 * @param int       $campaign_id      Campaign ID.
		 */
		$amount_formatted = apply_filters( 'hs_session_donation_amount_formatted', hs_format_money( $amount ), $amount, $campaign_id );

		$content = '<p>';
		/* translators: %s: donation amount */
		$content .= sprintf( __( 'Your Donation Amount: %s.', 'hspg' ), '<strong>' . $amount_formatted . '</strong>' );
		$content .= '&nbsp;<a href="#" class="change-donation" data-hs-toggle="hs-donation-options-' . esc_attr( $form_id ) . '">' . __( 'Change', 'hspg' ) . '</a>';
		$content .= '</p>';

		return $content;
	}

endif;



// //////////////////////////////
// DONATION PROCESSING PAGE
// //////////////////////////////
if ( ! function_exists( 'hs_template_donation_processing_content' ) ) :

	/**
	 * Render the content of the donation processing page.
	 *
	 * @since  1.2.0
	 *
	 * @param  string $content Default content to be rendered.
	 * @return string
	 */
	function hs_template_donation_processing_content( $content ) {
		if ( ! hs_is_page( 'donation_processing_page' ) ) {
			return $content;
		}

		$donation = hs_get_current_donation();

		if ( ! $donation ) {
			return $content;
		}

		$content = apply_filters( 'hs_processing_donation_' . $donation->get_gateway(), $content, $donation );

		return $content;
	}

endif;

// //////////////////////////////
// ACCOUNT PAGES
// //////////////////////////////
if ( ! function_exists( 'hs_template_forgot_password_content' ) ) :

	/**
	 * Render the content of the forgot password page.
	 *
	 * @since  1.4.0
	 *
	 * @param  string $content Default content to be rendered.
	 * @return string
	 */
	function hs_template_forgot_password_content( $content = '' ) {
		if ( ! hs_is_page( 'forgot_password_page' ) ) {
			return $content;
		}

		ob_start();

		if ( isset( $_GET['email_sent'] ) ) {

			hs_template( 'account/forgot-password-sent.php' );

		} else {

			hs_template( 'account/forgot-password.php', array(
				'form' => new Hs_Forgot_Password_Form(),
			) );

		}

		$content = ob_get_clean();

		return $content;
	}

endif;

if ( ! function_exists( 'hs_template_reset_password_content' ) ) :

	/**
	 * Render the content of the reset password page.
	 *
	 * @since  1.4.0
	 *
	 * @param  string $content Default content to be rendered.
	 * @return string
	 */
	function hs_template_reset_password_content( $content = '' ) {
		if ( ! hs_is_page( 'reset_password_page' ) ) {
			return $content;
		}

		ob_start();

		hs_template( 'account/reset-password.php', array(
			'form' => new Hs_Reset_Password_Form(),
		) );

		$content = ob_get_clean();

		return $content;
	}

endif;

if ( ! function_exists( 'hs_template_form_login_link' ) ) :

	/**
	 * Display a link to the login form.
	 *
	 * @since  1.4.2
	 *
	 * @param  Hs_Registration_Form|null $form Instance of `Hs_Registration_Form`, or
	 *                                                 null in previous versions of Hspg.
	 * @return void
	 */
	function hs_template_form_login_link( $form = null ) {
		/**
		 * For backwards compatibility, since previously the
		 * Form object was not passed to the hook.
		 */
		if ( is_null( $form ) ) {
			return;
		}

		if ( ! $form->get_login_link() ) {
			return;
		}

		printf( '<p>%s</p>', $form->get_login_link() );
	}

endif;

// //////////////////////////////
// NOTICES
// //////////////////////////////
if ( ! function_exists( 'hs_template_notices' ) ) :

	/**
	 * Render any notices.
	 *
	 * @since  1.4.0
	 *
	 * @param  array $notices Optional. Notices to be rendered.
	 * @return void
	 */
	function hs_template_notices( $notices = array() ) {
		if ( empty( $notices ) ) {
			$notices = hs_get_notices()->get_notices();
		}

		hs_template_from_session(
			'form-fields/notices.php',
			array(
				'notices' => $notices,
			),
			'notices'
		);
	}

endif;
