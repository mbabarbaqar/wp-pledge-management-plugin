<?php
/**
 * The template used to display form fields with multiple checkboxes.
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Form Fields
 * @since   1.0.0
 * @version 1.0.0
 */

if ( ! isset( $view_args['form'] ) || ! isset( $view_args['field'] ) ) {
	return;
}

$form        = $view_args['form'];
$field       = $view_args['field'];
$classes     = $view_args['classes'];
$is_required = isset( $field['required'] ) ? $field['required'] : false;
$options     = isset( $field['options'] ) ? $field['options'] : array();
$value       = isset( $field['value'] ) ? (array) $field['value'] : array();

if ( empty( $options ) ) {
	return;
}
?>
<div id="hs_field_<?php echo esc_attr( $field['key'] ); ?>" class="<?php echo $classes; ?>">
	<fieldset class="hs-fieldset-field-wrapper">
		<?php if ( isset( $field['label'] ) ) : ?>
			<div class="hs-fieldset-field-header" id="hs_field_<?php echo esc_attr( $field['key'] ); ?>_label">
				<?php echo $field['label']; ?>
				<?php if ( $is_required ) : ?>
					<abbr class="required" title="required">*</abbr>
				<?php endif ?>
			</div>
		<?php endif ?>
		<ul class="hs-checkbox-list options">
		<?php foreach ( $options as $val => $label ) : ?>
			<li>
				<input type="checkbox"
					id="<?php echo esc_attr( $field['key'] . '-' . $val ); ?>"
					name="<?php echo $field['key']; ?>[]"
					value="<?php echo $val; ?>"
					aria-describedby="hs_field_<?php echo esc_attr( $field['key'] ); ?>_label"
					<?php checked( in_array( $val, $value ) ); ?>
					<?php echo hs_get_arbitrary_attributes( $field ); ?> />
				<label for="<?php echo esc_attr( $field['key'] . '-' . $val ); ?>"><?php echo $label; ?></label>
			</li>
		<?php endforeach ?>
		</ul>
	</fieldset>
</div>
