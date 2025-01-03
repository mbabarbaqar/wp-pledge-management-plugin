<?php
/**
 * Displays the table header.
 *
 * Override this template by copying it to yourtheme/hspg/tables/header.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Tables
 * @since   1.5.0
 * @version 1.5.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! array_key_exists( 'helper', $view_args ) ) {
    return;
}

?>
<tr>
    <?php foreach ( $view_args['helper']->columns as $key => $header ) : ?>
    <th scope="col" class="hs-table-header-<?php echo esc_attr( $key ) ?>"><?php echo $header ?></th>
    <?php endforeach ?>
</tr>
