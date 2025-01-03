<?php
/**
 * Displays the donation summary.
 *
 * Override this template by copying it to yourtheme/hspg/donation-receipt/summary.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Donation Receipt
 * @since   1.0.0
 * @version 1.4.7
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* @var Hs_Donation */
$donation = $view_args['donation'];
$amount   = $donation->get_total_donation_amount();

?>
<dl class="donation-summary">
	<dt class="donation-id"><?php _e( 'Donation Number:', 'hspg' ); ?></dt>
	<dd class="donation-summary-value"><?php echo $donation->get_number(); ?></dd>
	<dt class="donation-date"><?php _e( 'Date:', 'hspg' ); ?></dt>
	<dd class="donation-summary-value"><?php echo $donation->get_date(); ?></dd>
	<dt class="donation-total"> <?php _e( 'Total:', 'hspg' ); ?></dt>
	<dd class="donation-summary-value">
	<?php
		/**
		 * Filter the total donation amount.
		 *
		 * @since  1.5.0
		 *
		 * @param  string              $amount   The default amount to display.
		 * @param  float               $total    The total, unformatted.
		 * @param  Hs_Donation $donation The Donation object.
		 * @param  string              $context  The context in which this is being shown.
		 * @return string
		 */
		echo apply_filters( 'hs_donation_receipt_donation_amount', hs_format_money( $amount ), $amount, $donation, 'summary' )
	?>
	</dd>
	<dt class="donation-method"><?php _e( 'Payment Method:', 'hspg' ); ?></dt>
	<dd class="donation-summary-value"><?php echo $donation->get_gateway_label(); ?></dd>
</dl>
