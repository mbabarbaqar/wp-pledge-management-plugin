<?php
/**
 * Displays the logged in message.
 *
 * Override this template by copying it to yourtheme/hspg/shortcodes/logged-in.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Account
 * @since   1.0.0
 * @version 1.5.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$message = isset( $view_args['logged_in_message'] )
	? $view_args['logged_in_message']
	: __( 'You are already logged in!', 'hspg' );

echo wpautop( $message );

?>
<a href="<?php echo wp_logout_url( hs_get_current_url() ) ?>"><?php _e( 'Logout.', 'hspg' ) ?></a>
