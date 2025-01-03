<?php
/**
 * Displays the notice to say that the user cannot access the donation receipt.
 *
 * Override this template by copying it to yourtheme/hspg/donation-receipt/not-authorized.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Donation Receipt
 * @since   1.1.2
 * @version 1.6.27
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$content = $view_args['content'];

if ( is_user_logged_in() ) : ?>
	<div class="hs-notice">
		<?php _e( 'You do not have access to this donation receipt.', 'hspg' ); ?>
	</div>
<?php else : ?>
	<div class="hs-notice">
		<?php
			_e( 'You must be logged in to access your donation receipt.', 'hspg' );

			/* Display any other notices. */
			hs_template( 'form-fields/notices.php', array( 'notices' => hs_get_notices()->get_notices() ) );

			/**
			 * Unhook the default template notices function from showing, as it would
			 * result in another <noscript> element being created inside of this one.
			 *
			 * @see https://github.com/Hspg/Hspg/issues/715
			 */
			remove_action( 'hs_login_form_before', 'hs_template_notices', 10, 0 );
		?>
	</div>
	<?php
		echo Hs_Login_Shortcode::display( array( 'redirect' => hs_get_current_url() ) );

		/* Turn the login form notices hook back on. */
		add_action( 'hs_login_form_before', 'hs_template_notices', 10, 0 );
endif;
