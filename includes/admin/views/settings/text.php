<?php
/**
 * Display text field.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin View/Settings
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

$value = hs_get_option( $view_args['key'] );

if ( empty( $value ) ) :
	$value = isset( $view_args['default'] ) ? $view_args['default'] : '';
endif;

?>
<input type="text"
	id="<?php printf( 'hs_settings_%s', implode( '_', $view_args['key'] ) ); ?>"
	name="<?php printf( 'hs_settings[%s]', $view_args['name'] ); ?>"
	value="<?php echo esc_attr( $value ); ?>"
	class="<?php echo esc_attr( $view_args['classes'] ); ?>"
	<?php echo hs_get_arbitrary_attributes( $view_args ); ?> />
<?php if ( isset( $view_args['help'] ) ) : ?>
	<div class="hs-help"><?php echo $view_args['help']; ?></div>
	<?php
endif;
