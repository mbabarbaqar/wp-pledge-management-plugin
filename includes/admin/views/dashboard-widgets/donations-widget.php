<?php
/**
 * Display the donations widget on the dashboard.
 *
 * @author  Studio 164a
 * @package Hspg/Admin View/Dashboard Widgets
 * @since   1.2.0
 */

$statuses = hs_get_valid_donation_statuses();

$donations = get_posts( array(
	'post_type'      => Hspg::DONATION_POST_TYPE,
	'posts_per_page' => 5,
	'post_status'    => array_keys( $statuses ),
	'fields'         => 'ids',
) );

$table = hs_get_table( 'campaign_donations' );

$today      = $table->get_donations_summary_by_period( date( 'Y-m-d%' ) );
$this_month = $table->get_donations_summary_by_period( date( 'Y-m%' ) );
$last_month = $table->get_donations_summary_by_period( date( 'Y-m%', strtotime( '-1 month' ) ) );
$this_year  = $table->get_donations_summary_by_period( date( 'Y-%' ) );

?>
<div class="hs-donation-statistics">
	<div class="cell">
		<h3 class="amount">
			<?php echo hs_format_money( $today->amount ); ?>
		</h3>
		<p class="summary">
			<?php
				printf(
					/* translators: %d: number of donations */
					_n( '%d donation <span class="time-period">today</span>', '%d donations <span class="time-period">today</span>', $today->count, 'hspg' ),
					$today->count
				);
			?>
		</p>
	</div>
	<div class="cell">
		<h3 class="amount">
			<?php echo hs_format_money( $this_month->amount ); ?>
		</h3>
		<p class="summary">
			<?php
				printf(
					/* translators: %d: number of donations */
					_n( '%d donation <span class="time-period">this month</span>', '%d donations <span class="time-period">this month</span>', $this_month->count, 'hspg' ),
					$this_month->count
				);
			?>
		</p>
	</div>
	<div class="cell">
		<h3 class="amount">
			<?php echo hs_format_money( $last_month->amount ); ?>
		</h3>
		<p class="summary">
			<?php
				printf(
					/* translators: %d: number of donations */
					_n( '%d donation <span class="time-period">last month</span>', '%d donations <span class="time-period">last month</span>', $last_month->count, 'hspg' ),
					$last_month->count
				);
			?>
		</p>
	</div>
	<div class="cell">
		<h3 class="amount">
			<?php echo hs_format_money( $this_year->amount ); ?>
		</h3>
		<p class="summary">
			<?php
				printf(
					/* translators: %d: number of donations */
					_n( '%d donation <span class="time-period">this year</span>', '%d donations <span class="time-period">this year</span>', $this_year->count, 'hspg' ),
					$this_year->count
				);
			?>
		</p>
	</div>
</div>
<?php if ( count( $donations ) ) : ?>
	<div class="recent-donations">
		<table>
			<caption><h3><?php _e( 'Recent Donations', 'hspg' ); ?></h3></caption>
			<?php
			foreach ( $donations as $donation_id ) :
				$donation = hs_get_donation( $donation_id );
			?>
			<tr>
				<td class="donation-date"><?php echo $donation->get_date(); ?></td>
				<td class="donation-id">#<?php echo $donation->get_number(); ?></td>
				<td class="donation-status"><?php echo $donation->get_status_label(); ?></td>
				<td class="donation-total"><?php echo hs_format_money( $donation->get_total_donation_amount() ); ?></td>
			</tr>
			<?php
			endforeach;
			?>
		</table>
	</div>
<?php endif ?>
