<?php
/**
 * Displays the donate button to be displayed on campaign pages.
 *
 * Override this template by copying it to yourtheme/hspg/campaign/donate-modal.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Campaign Page
 * @since   1.0.0
 * @version 1.6.44
 */

$campaign = $view_args['campaign'];
$label    = sprintf(
	/* translators: %s: campaign title */
	esc_attr_x( 'Make a donation to %s', 'make a donation to campaign', 'hspg' ),
	get_the_title( $campaign->ID )
);

?>
<div class="campaign-donation">
	<a data-trigger-modal="hs-donation-form-modal-<?php echo $campaign->ID; ?>"
		class="<?php echo esc_attr( hs_get_button_class( 'donate' ) ); ?>"
		href="<?php echo hs_get_permalink( 'campaign_donation_page', array( 'campaign_id' => $campaign->ID ) ); ?>"
		aria-label="<?php echo $label; ?>"
	>
	<?php _e( 'Donate', 'hspg' ); ?>
	</a>
</div>
