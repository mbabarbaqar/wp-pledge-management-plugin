<?php
/**
 * The template used to display the registration form.
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Account
 * @since   1.0.0
 * @version 1.6.29
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$form = $view_args['form'];

/**
 * Do something before rendering the user registration form.
 *
 * @param Hs_Form $form      The form object.
 * @param array           $view_args All args passed to template.
 */
do_action( 'hs_user_registration_before', $form, $view_args );

?>
<form method="post" id="hs-registration-form" class="hs-form">
	<?php
	/**
	 * Do something before rendering the form fields.
	 *
	 * @since 1.0.0
	 *
	 * @param Hs_Form $form      The form object.
	 * @param array           $view_args All args passed to template.
	 */
	do_action( 'hs_form_before_fields', $form, $view_args );

	?>
	<div class="hs-form-fields cf row">
		<?php $form->view()->render(); ?>
	</div><!-- .hs-form-fields -->
	<?php

	/**
	 * Do something after rendering the form fields.
	 *
	 * @since 1.0.0
	 *
	 * @param Hs_Form $form      The form object.
	 * @param array           $view_args All args passed to template.
	 */
	do_action( 'hs_form_after_fields', $form, $view_args );

	?>
	<div class="hs-form-field hs-submit-field">
		<button class="<?php echo esc_attr( hs_get_button_class( 'registration' ) ); ?>" type="submit" name="register"><?php esc_attr_e( 'Register', 'hspg' ); ?></button>
	</div>
</form><!-- #hs-registration-form -->
<?php

/**
 * Do something after rendering the user registration form.
 *
 * @param Hs_Form $form      The form object.
 * @param array           $view_args All args passed to template.
 */
do_action( 'hs_user_registration_after', $form, $view_args );
