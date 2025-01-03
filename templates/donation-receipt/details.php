<?php
/**
 * Displays the donation details.
 *
 * Override this template by copying it to yourtheme/hspg/donation-receipt/details.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Donation Receipt
 * @since   1.0.0
 * @version 1.3.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* @var Hs_Donation */
$donation = $view_args['donation'];
$amount   = $donation->get_total_donation_amount();

?>
<h3 class="hs-header"><?php _e( 'Your Donation', 'hspg' ); ?></h3>
<table class="donation-details hs-table">
	<thead>
		<tr>
			<th><?php _e( 'Campaign', 'hspg' ); ?></th>
			<th><?php _e( 'Total', 'hspg' ); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ( $donation->get_campaign_donations() as $campaign_donation ) : ?>
		<tr>
			<td class="campaign-name">
				<?php
					echo $campaign_donation->campaign_name;

					/**
					 * Do something after displaying the campaign name.
					 *
					 * @since 1.3.0
					 *
					 * @param object              $campaign_donation Database record for the campaign donation.
					 * @param Hs_Donation $donation          The Donation object.
					 */
					do_action( 'hs_donation_receipt_after_campaign_name', $campaign_donation, $donation );
				?>
			</td>
			<td class="donation-amount"><?php echo hs_format_money( $campaign_donation->amount ); ?></td>
		</tr>
	<?php endforeach ?>
	</tbody>
	<tfoot>
		<?php
			/**
			 * Do something before displaying the total.
			 *
			 * If you add markup, make sure it's a table row with two cells.
			 *
			 * @since 1.5.0
			 *
			 * @param Hs_Donation $donation The Donation object.
			 */
			do_action( 'hs_donation_receipt_before_donation_total', $donation );
		?>
		<tr>
			<td><?php _e( 'Total', 'hspg' ); ?></td>
			<td>
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
					echo apply_filters( 'hs_donation_receipt_donation_amount', hs_format_money( $amount ), $amount, $donation, 'details' )
				?>
			</td>
		</tr>
		<?php
			/**
			 * Do something after displaying the total.
			 *
			 * If you add markup, make sure it's a table row with two cells.
			 *
			 * @since 1.5.0
			 *
			 * @param Hs_Donation $donation The Donation object.
			 */
			do_action( 'hs_donation_receipt_after_donation_total', $donation );
		?>
	</tfoot>
</table>
