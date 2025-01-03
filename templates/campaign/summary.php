<?php
/**
 * Displays the campaign summary.
 *
 * Override this template by copying it to yourtheme/hspg/campaign/summary.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Campaign Page
 * @since   1.0.0
 * @version 1.0.0
 */

$campaign = $view_args['campaign'];

/**
 * Do something before the campaign summary is rendered.
 *
 * @since 1.0.0
 *
 * @param Hs_Campaign $campaign The Campaign instance.
 */
do_action( 'hs_campaign_summary_before', $campaign );

?>
<div class="campaign-summary">
	<?php
	/**
	 * Do something while the campaign summary is rendered.
	 *
	 * By default, the following callbacks are run on the
	 * `hs_campaign_summary` hook:
	 *
	 * - hs_template_campaign_percentage_raised (priority: 4)
	 * - hs_template_campaign_donation_summary (priority: 6)
	 * - hs_template_campaign_donor_count (priority: 8)
	 * - hs_template_campaign_time_left (priority: 10)
	 * - hs_template_donate_button (priority: 12)
	 *
	 * @since 1.0.0
	 *
	 * @param Hs_Campaign $campaign The Campaign instance.
	 */
	do_action( 'hs_campaign_summary', $campaign );
	?>
</div>
<?php
/**
 * Do something after the campaign summary is rendered.
 *
 * @since 1.0.0
 *
 * @param Hs_Campaign $campaign The Campaign instance.
 */
do_action( 'hs_campaign_summary_after', $campaign );
