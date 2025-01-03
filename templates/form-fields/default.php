<?php
/**
 * The template used to display text form fields.
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Form Fields
 * @since   1.0.0
 * @version 1.0.0
 */

if ( ! isset( $view_args['form'] ) || ! isset( $view_args['field'] ) ) {
	return;
}

$form           = $view_args['form'];
$field          = $view_args['field'];
$classes        = esc_attr( $view_args['classes'] );
$field_type     = isset( $field['type'] ) ? $field['type'] : 'text';
$is_required    = isset( $field['required'] ) ? $field['required'] : false;
$value          = isset( $field['value'] ) ? $field['value'] : '';
$input_class          = isset( $field['input_class'] ) ? $field['input_class'] : '';

?>
<div id="hs_field_<?php echo $field['key'] ?>" class="<?php echo $classes ?>">
	<?php if ( isset( $field['label'] ) ) : ?>
		<label for="hs_field_<?php echo $field['key'] ?>_element">
			<?php echo $field['label'] ?>
			<?php if ( $is_required ) : ?>
				<abbr class="required" title="required">*</abbr>
			<?php endif ?>
		</label>
	<?php endif ?>
	<?php if ( isset( $field['help'] ) ) : ?>
		<p class="hs-field-help"><?php echo $field['help'] ?></p>
	<?php endif ?>
	<input type="<?php echo esc_attr( $field_type ) ?>" class="<?php echo esc_attr( $input_class ) ?>" name="<?php echo $field['key'] ?>" id="hs_field_<?php echo $field['key'] ?>_element" value="<?php echo esc_attr( stripslashes( $value ) ) ?>" <?php echo hs_get_arbitrary_attributes( $field ) ?>/>
</div>
