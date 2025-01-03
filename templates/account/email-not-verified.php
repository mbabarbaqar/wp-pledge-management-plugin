<?php
/**
 * The template used to display a message on the email verification endpoint
 * when the email was not verified.
 *
 * Override this template by copying it to yourtheme/hspg/account/email-not-verified.php
 *
 * @author  Eric Daams
 * @package Hspg/Templates/Account
 * @since   1.5.0
 * @version 1.5.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$redirect = array_key_exists( 'redirect_url', $_GET ) ? $_GET['redirect_url'] : false;
$link     = hs_get_email_verification_link( get_user_by( 'login', $_GET['login'] ), $redirect, true );

?>
<p><?php _e( 'We were unable to verify your email address.', 'hspg' ) ?></p>
<?php if ( isset( $_GET['login'] ) ) : ?>
    <p><a href="<?php echo esc_url_raw( $link ) ?>"><?php _e( 'Resend verification email', 'hspg' ) ?></a></p>
<?php endif ?>