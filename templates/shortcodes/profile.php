<?php
/**
 * The template used to display the profile form.
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

$form  = $view_args['form'];
$donor = hs_get_user( wp_get_current_user() );

/**
 * Do something before rendering the user profile form.
 *
 * @param array $view_args All args passed to template.
 */
do_action( 'hs_user_profile_before', $view_args );

?>
<form method="post" id="hs-profile-form" class="hs-form" enctype="multipart/form-data">
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
	<div class="hs-form-fields cf">
		<?php $form->view()->render() ?>
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
		<button class="<?php echo esc_attr( hs_get_button_class( 'profile' ) ); ?>" type="submit" name="update-profile"><?php echo apply_filters( 'hs_profile_form_submit_button_name', __( 'Update', 'hspg' ) ); ?></button>
	</div>
</form><!-- #hs-profile-form -->
<?php
/**
 * Do something after rendering the user profile form.
 *
 * @param array $view_args All args passed to template.
 */
do_action( 'hs_user_profile_after', $view_args );
