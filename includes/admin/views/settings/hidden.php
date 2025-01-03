<?php
/**
 * Add a hidden field in settings area.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin View/Settings
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

?>
<input type="hidden"
	id="<?php printf( 'hs_settings_%s', implode( '_', $view_args['key'] ) ); ?>"
	name="<?php printf( 'hs_settings[%s]', $view_args['name'] ); ?>"
	value="<?php echo esc_attr( $view_args['value'] ); ?>"
/>
