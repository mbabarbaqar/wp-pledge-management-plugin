<?php
/**
 * Display number field.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin Views/Metaboxes
 * @copyright Copyright (c) 2020, Studio 164a
 * @since     1.6.36
 * @version   1.6.36
 */

if ( ! array_key_exists( 'form_view', $view_args ) || ! $view_args['form_view']->field_has_required_args( $view_args ) ) {
	return;
}

$is_required = array_key_exists( 'required', $view_args ) && $view_args['required'];
$field_attrs = array_key_exists( 'field_attrs', $view_args ) ? $view_args['field_attrs'] : array();

?>
<div id="<?php echo esc_attr( $view_args['wrapper_id'] ); ?>" class="<?php echo esc_attr( $view_args['wrapper_class'] ); ?>" <?php echo hs_get_arbitrary_attributes( $view_args ); ?>>
	<?php if ( isset( $view_args['label'] ) ) : ?>
		<label for="<?php echo esc_attr( $view_args['id'] ); ?>">
			<?php
			echo esc_html( $view_args['label'] );
			if ( $is_required ) :
				?>
				<abbr class="required" title="required">*</abbr>
				<?php
			endif;
			?>
		</label>
	<?php endif ?>
	<input type="number"
		id="<?php echo esc_attr( $view_args['id'] ); ?>"
		name="<?php echo esc_attr( $view_args['key'] ); ?>"
		value="<?php echo esc_attr( $view_args['value'] ); ?>"
		tabindex="<?php echo esc_attr( $view_args['tabindex'] ); ?>"
		<?php echo $is_required ? 'required' : ''; ?>
		<?php echo hs_get_arbitrary_attributes( $field_attrs ); ?>
	/>
	<?php if ( isset( $view_args['description'] ) ) : ?>
		<span class="hs-helper"><?php echo esc_html( $view_args['description'] ); ?></span>
	<?php endif ?>
</div>
