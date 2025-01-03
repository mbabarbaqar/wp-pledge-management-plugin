<?php
/**
 * Display a series of checkboxes.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin View/Settings
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

$value = hs_get_option( $view_args['key'], array() );

if ( empty( $value ) ) :
	$value = isset( $view_args['default'] ) ? (array) $view_args['default'] : array();
endif;

if ( ! is_array( $value ) ) {
	$value = (array) $value;
}

$setting_attributes = '';

if ( array_key_exists( 'attrs', $view_args ) ) {

	$setting_attributes_keys = array( 'data-trigger-key', 'data-trigger-change-type', 'data-trigger-value' );

	foreach ( $setting_attributes_keys as $key ) {

		if ( ! array_key_exists( $key, $view_args['attrs'] ) ) {
			continue;
		}

		$setting_attributes .= sprintf( ' %s="%s"', $key, esc_attr( $view_args['attrs'][ $key ] ) );

		unset( $view_args['attrs'][ $key ] );

	}
}

?>
<ul class="hs-checkbox-list <?php echo esc_attr( $view_args['classes'] ); ?>" <?php echo $setting_attributes; ?>>

	<?php foreach ( $view_args['options'] as $option => $label ) : ?>

		<li><input type="checkbox"
				id="<?php printf( 'hs_settings_%s_%s', implode( '_', $view_args['key'] ), $option ); ?>"
				name="<?php printf( 'hs_settings[%s][]', $view_args['name'] ); ?>"
				value="<?php echo esc_attr( $option ); ?>"
				<?php checked( in_array( $option, $value ) ); ?>
				<?php echo hs_get_arbitrary_attributes( $view_args ); ?>
			/>
			<?php echo $label; ?>
		</li>

	<?php endforeach ?>

</ul>
<?php if ( isset( $view_args['help'] ) ) : ?>
	<div class="hs-help"><?php echo $view_args['help']; ?></div>
<?php
endif;
