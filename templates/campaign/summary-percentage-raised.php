<?php
/**
 * Displays the percentage of its goal that the campaign has raised.
 *
 * Override this template by copying it to yourtheme/hspg/campaign/summary-percentage-raised.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Campaign Page
 * @since   1.0.0
 * @version 1.0.0
 */

$campaign = $view_args['campaign'];

?>
<div class="campaign-raised campaign-summary-item">
	<?php
	printf(
		/* translators: %s: percentage raised */
		_x( '%s Raised', 'percentage raised', 'hspg' ),
		'<span class="amount">' . $campaign->get_percent_donated() . '</span>'
	);
	?>
</div>
