<?php
/**
 * The template used to display the default form.
 *
 * Override this template by copying it to yourtheme/hspg/donation-form/form-donation.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Donation Form
 * @since   1.0.0
 * @version 1.6.29
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$form     = $view_args['form'];
$user     = wp_get_current_user();
$use_ajax = 'make_donation' == $form->get_form_action() && (int) Hs_Gateways::get_instance()->gateways_support_ajax();
$form_id  = isset( $view_args['form_id'] ) ? $view_args['form_id'] : 'hs-donation-form';

if ( ! $form ) {
	return;
}

?>
<form method="post" id="<?php echo esc_attr( $form_id ); ?>" class="hs-donation-form hs-form" data-use-ajax="<?php echo esc_attr( $use_ajax ); ?>">
	<?php
	/**
	 * Do something before rendering the form fields.
	 *
	 * @since 1.0.0
	 * @since 1.6.0 Added $view_args parameter.
	 *
	 * @param Hs_Form $form      The form object.
	 * @param array           $view_args All args passed to template.
	 */
	do_action( 'hs_form_before_fields', $form, $view_args );

	?>
	<div class="hs-form-fields cf">
		<?php $form->view()->render(); ?>
	</div><!-- .hs-form-fields -->
	<?php
	/**
	 * Do something after rendering the form fields.
	 *
	 * @since 1.0.0
	 * @since 1.6.0 Added $view_args parameter.
	 *
	 * @param Hs_Form $form      The form object.
	 * @param array           $view_args All args passed to template.
	 */
	do_action( 'hs_form_after_fields', $form, $view_args );

	?>
	<div class="hs-form-field hs-submit-field">
		<button class="<?php echo esc_attr( hs_get_button_class( 'donate' ) ); ?>" type="submit" name="donate"><?php _e( 'Donate', 'hspg' ); ?></button>
		<div class="hs-form-processing" style="display: none;">
			<img src="<?php echo esc_url( hspg()->get_path( 'assets', false ) ); ?>/images/hs-loading.gif" width="60" height="60" alt="<?php esc_attr_e( 'Loading&hellip;', 'hspg' ); ?>" />
		</div>
	</div>
</form><!-- #<?php echo $form_id; ?>-->
