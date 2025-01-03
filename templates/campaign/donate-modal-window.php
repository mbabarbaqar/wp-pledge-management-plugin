<?php
/**
 * Displays the donate button to be displayed on campaign pages.
 *
 * Override this template by copying it to yourtheme/hspg/campaign/donate-modal-window.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Campaign Page
 * @since   1.0.0
 * @version 1.6.44
 */

$campaign = $view_args['campaign'];

if ( ! $campaign->can_receive_donations() ) :
	return;
endif;

$modal_class = apply_filters( 'hs_modal_window_class', 'hs-modal' );

wp_print_scripts( 'lean-modal' );
wp_enqueue_style( 'lean-modal-css' );

?>
<div id="hs-donation-form-modal-<?php echo $campaign->ID; ?>" style="display: none;" class="<?php echo esc_attr( $modal_class ); ?>">
	<a class="modal-close"></a>
	<?php $campaign->get_donation_form()->render(); ?>
</div>
