<?php
/**
 * Displays the donate button to be displayed on campaign pages.
 *
 * Override this template by copying it to yourtheme/hspg/campaign/donate-button.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Campaign Page
 * @since   1.3.0
 * @version 1.6.42
 */

$campaign = $view_args['campaign'];

?>
<form class="campaign-donation" method="post">
	<?php wp_nonce_field( 'hs-donate', 'hs-donate-now' ); ?>
	<input type="hidden" name="hs_action" value="start_donation" />
	<input type="hidden" name="campaign_id" value="<?php echo $campaign->ID; ?>" />
	<button type="submit" name="hs_submit" class="<?php echo esc_attr( hs_get_button_class( 'donate' ) ); ?>"><?php esc_attr_e( 'Donate', 'hspg' ); ?></button>
</form>
