<?php
/**
 * Display number field.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin View/Settings
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

$value = hs_get_option( $view_args['key'] );

if ( false === $value ) {
	$value = isset( $view_args['default'] ) ? $view_args['default'] : '';
}

$min = isset( $view_args['min'] ) ? 'min="' . $view_args['min'] . '"' : '';
$max = isset( $view_args['max'] ) ? 'max="' . $view_args['max'] . '"' : '';
?>
<input type="number"
	id="<?php printf( 'hs_settings_%s', implode( '_', $view_args['key'] ) ); ?>"
	name="<?php printf( 'hs_settings[%s]', $view_args['name'] ); ?>"
	value="<?php echo $value; ?>"
	<?php echo $min; ?>
	<?php echo $max; ?>
	class="<?php echo esc_attr( $view_args['classes'] ); ?>"
	<?php echo hs_get_arbitrary_attributes( $view_args ); ?>
	/>
<?php if ( isset( $view_args['help'] ) ) : ?>
	<div class="hs-help"><?php echo $view_args['help']; ?></div>
<?php
endif;
