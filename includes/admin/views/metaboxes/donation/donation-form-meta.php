<?php
/**
 * Renders the donation form meta box for the Donation post type.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin Views/Metaboxes
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.5.0
 */

$form   = $view_args['form'];
$fields = $form->get_fields();

if ( $form->has_donation() ) :
	$button_text = __( 'Update Donation', 'hspg' );
	$cancel_url  = remove_query_arg( 'show_form' );
else :
	$button_text = __( 'Save Donation', 'hspg' );
	$cancel_url  = admin_url( 'edit.php?post_type=donation' );
endif;

?>
<div class="hs-form-fields secondary">
	<?php $form->view()->render_field( $fields['meta_fields'], 'meta_fields' ); ?>
</div>
<div class="hs-form-field hs-submit-field">
	<a href="<?php echo esc_url( $cancel_url ); ?>" class="alignright" title="<?php esc_attr_e( 'Return to donation page', 'hspg' ); ?>" tabindex="401"><?php _e( 'Cancel', 'hspg' ); ?></a>
	<button class="button button-primary" type="submit" name="donate" tabindex="400"><?php echo $button_text; ?></button>
</div><!-- .hs-submit-field -->
