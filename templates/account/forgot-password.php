
<?php
/**
 * The template used to display the forgot password form. Provided here primarily as a way to make it easier to override using theme templates.
 *
 * Override this template by copying it to yourtheme/hspg/account/forgot-password.php
 *
 * @author  Rafe Colton
 * @package Hspg/Templates/Account
 * @since   1.4.0
 * @version 1.5.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var Hs_Forgot_Password_Form
 */
$form = $view_args['form'];

?>
<div class="hs-forgot-password-form">
	<?php
	/**
	* @hook hs_forgot_password_before
	*/
	do_action( 'hs_forgot_password_before' );

	?>
	<form id="lostpasswordform" class="hs-form" method="post">

		<?php do_action( 'hs_form_before_fields', $form ); ?>

		<div class="hs-form-fields cf">
			<?php $form->view()->render() ?>
		</div><!-- .hs-form-fields -->

		<?php do_action( 'hs_form_after_fields', $form ); ?>

		<div class="hs-form-field hs-submit-field">
			<button class="button button-primary lostpassword-button" type="submit"><?php esc_attr_e( 'Reset Password', 'hspg' ) ?></button>
		</div>

	</form>
	<?php

	/**
	* @hook hs_forgot_password_after
	*/
	do_action( 'hs_forgot_password_after' );
	?>
</div>
