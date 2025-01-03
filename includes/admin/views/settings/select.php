<?php
/**
 * Display select field.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin View/Settings
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.25
 */

$value = hs_get_option( $view_args['key'] );

if ( false === $value ) {
	$value = isset( $view_args['default'] ) ? $view_args['default'] : '';
}
?>
<select id="<?php printf( 'hs_settings_%s', implode( '_', $view_args['key'] ) ); ?>"
	name="<?php printf( 'hs_settings[%s]', $view_args['name'] ); ?>"
	class="<?php echo esc_attr( $view_args['classes'] ); ?>"
	<?php echo hs_get_arbitrary_attributes( $view_args ); ?>
	>
	<?php
	foreach ( $view_args['options'] as $key => $option ) :
		if ( is_array( $option ) ) :
			$label = isset( $option['label'] ) ? $option['label'] : '';
			?>
			<optgroup label="<?php echo $label; ?>">
			<?php foreach ( $option['options'] as $k => $opt ) : ?>
				<option value="<?php echo $k; ?>" <?php selected( $k, $value ); ?>><?php echo $opt; ?></option>
			<?php endforeach ?>
			</optgroup>
		<?php else : ?>
			<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $value ); ?>><?php echo $option; ?></option>
			<?php
		endif;
	endforeach
	?>
</select>
<?php if ( isset( $view_args['help'] ) ) : ?>
	<div class="hs-help"><?php echo $view_args['help']; ?></div>
	<?php
endif;
