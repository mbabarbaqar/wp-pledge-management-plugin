<?php
/**
 * The template used to display the reset password form. Provided here
 * primarily as a way to make it easier to override using theme templates.
 *
 * Override this template by copying it to yourtheme/hspg/account/reset-password.php
 *
 * @author  Rafe Colton
 * @package Hspg/Templates/Account
 * @since   1.4.0
 * @version 1.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {exit; } // Exit if accessed directly

/**
 * @var 	Hs_Reset_Password_Form
 */
$form = $view_args['form'];

?>
<div class="hs-reset-password-form">
	<?php 
	if ( $form->has_key() ) :

		/**
		 * @hook hs_reset_password_before
		 */
		do_action( 'hs_reset_password_before' );
	
		?>
		<form id="resetpassform" class="hs-form" method="post" autocomplete="off">

			<?php do_action( 'hs_form_before_fields', $form ); ?>

			<div class="hs-form-fields cf">
				<?php $form->view()->render() ?>
				<p class="description"><?php echo wp_get_password_hint() ?></p>
			</div><!-- .hs-form-fields -->

			<?php do_action( 'hs_form_after_fields', $form ); ?>

			<div class="hs-form-field hs-submit-field resetpass-submit">
				<button id="resetpass-button" class="button button-primary lostpassword-button" type="submit"><?php _e( 'Reset Password', 'hspg' ) ?></button>
			</div>
		</form>
		<?php

		/**
		 * @hook hs_reset_password_after
		 */
		do_action( 'hs_reset_password_after' );

	else :

		$errors = hs_get_notices()->get_errors();

		if ( ! empty( $errors ) ) {
			hs_template( 'form-fields/errors.php', array(
				'errors' => $errors,
			) );
		}

	endif;

	?>
</div><!-- .hs-reset-password-form -->
