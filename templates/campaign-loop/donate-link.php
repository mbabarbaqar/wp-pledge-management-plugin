<?php
/**
 * Displays the donate button to be displayed within campaign loops.
 *
 * Override this template by copying it to yourtheme/hspg/campaign-loop/donate-link.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Campaign
 * @since   1.0.0
 * @version 1.6.29
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* @var Hs_Campaign */
$campaign = $view_args['campaign'];

if ( ! $campaign->can_receive_donations() ) :
	return;
endif;

?>
<div class="campaign-donation">
	<a class="<?php echo esc_attr( hs_get_button_class( 'donate' ) ); ?>"
		href="<?php echo hs_get_permalink( 'campaign_donation_page', array( 'campaign_id' => $campaign->ID ) ); ?>"
		aria-label="<?php echo esc_attr( sprintf( _x( 'Make a donation to %s', 'make a donation to campaign', 'hspg' ), get_the_title( $campaign->ID ) ) ); ?>"
	>
		<?php _e( 'Donate', 'hspg' ); ?>
	</a>
</div>
