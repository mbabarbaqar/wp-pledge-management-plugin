<?php
/**
 * The template used to display checkbox form fields.
 *
 * Override this template by copying it to yourtheme/hspg/form-fields/checkbox.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Form Fields
 * @since   1.0.0
 * @version 1.2.0
 */

if ( ! isset( $view_args['form'] ) || ! isset( $view_args['field'] ) ) {
	return;
}

$form        = $view_args['form'];
$field       = $view_args['field'];
$classes     = $view_args['classes'];
$is_required = isset( $field['required'] ) ? $field['required'] : false;
$value       = isset( $field['value'] ) ? esc_attr( $field['value'] ) : '1';

if ( isset( $field['checked'] ) ) {
	$checked = $field['checked'];
} else {
	$checked = isset( $field['default'] ) ? $field['default'] : 0;
}
?>
<div id="hs_field_<?php echo $field['key']; ?>" class="<?php echo $classes; ?>">
	<input
		type="checkbox"
		name="<?php echo $field['key']; ?>"
		value="<?php echo $value; ?>"
		id="hs_field_<?php echo $field['key']; ?>_element"
		<?php checked( $checked ); ?>
		<?php echo hs_get_arbitrary_attributes( $field ); ?>
	/>
	<?php if ( isset( $field['label'] ) ) : ?>
		<label for="hs_field_<?php echo $field['key']; ?>_element">
			<?php echo $field['label']; ?>
			<?php if ( $is_required ) : ?>
				<abbr class="required" title="required">*</abbr>
			<?php endif ?>
		</label>
	<?php endif ?>
	<?php if ( isset( $field['help'] ) ) : ?>
		<p class="hs-field-help"><?php echo $field['help']; ?></p>
	<?php endif ?>
</div>
