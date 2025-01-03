<?php
/**
 * The template used to display select fieldsets.
 *
 * Override this template by copying it to yourtheme/hspg/form-fields/fieldset.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Form Fields
 * @since   1.0.0
 * @version 1.5.0
 */

if ( ! isset( $view_args['form'] ) || ! isset( $view_args['field'] ) ) {
	return;
}

$form    = $view_args['form'];
$field   = $view_args['field'];
$classes = $view_args['classes'];
$fields  = isset( $field['fields'] ) ? $field['fields'] : array();

if ( ! count( $fields ) ) :
	return;
endif;

?>
<fieldset class="<?php echo esc_attr( $classes ); ?>">
	<?php
	if ( isset( $field['legend'] ) ) :
		?>
		<div class="hs-form-header"><?php echo $field['legend']; ?></div>
		<?php
	endif;

	$form->view()->render_fields( $fields );
	?>
</fieldset>
