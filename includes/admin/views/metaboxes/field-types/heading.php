<?php
/**
 * Display heading in metabox.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin Views/Metaboxes
 * @copyright Copyright (c) 2020, Studio 164a
 * @since     1.2.0
 * @version   1.5.0
 */

$level = array_key_exists( 'level', $view_args ) ? $view_args['level'] : 'h4';
?>
<<?php echo $level; ?> class="hs-metabox-header" <?php echo hs_get_arbitrary_attributes( $view_args ); ?>><?php echo esc_html( $view_args['title'] ); ?></<?php echo $level; ?>>