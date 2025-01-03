<?php
/**
 * Display radio field.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin View/Settings
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.7
 */

$default = array_key_exists( 'default', $view_args ) ? $view_args['default'] : false;
$value   = hs_get_option( $view_args['key'], $default );

?>
<ul class="hs-radio-list <?php echo esc_attr( $view_args['classes'] ); ?>">
	<?php foreach ( $view_args['options'] as $option => $label ) : ?>
		<li><input type="radio"
				id="<?php printf( 'hs_settings_%s_%s', implode( '_', $view_args['key'] ), $option ); ?>"
				name="<?php printf( 'hs_settings[%s]', $view_args['name'] ); ?>"
				value="<?php echo esc_attr( $option ); ?>"
				<?php checked( $value, $option ); ?>
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
