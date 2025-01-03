<?php
/**
 * The template used to display the donor's current details.
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Donation Form
 * @since   1.0.0
 * @version 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var Hs_User
 */
$user = $view_args['user'];

if ( ! $user && ! is_customize_preview() ) {
	return;
}

?>
<div class="hs-donor-details">
	<address class="donor-address"><?php echo $user->get_address(); ?></address>
	<p class="donor-contact-details">
		<?php
		/* translators: %s: email address */
		printf( __( 'Email: %s', 'hspg ' ), $user->user_email );

		if ( $user->__isset( 'donor_phone' ) ) :
			/* translators: %s: phone number */
			echo '<br />' . sprintf( __( 'Phone number: %s', 'hspg' ), $user->get( 'donor_phone' ) );
		endif;
		?>
	</p>
	<p class="hs-change-user-details">
		<a href="#" data-hs-toggle="hs-user-fields"><?php _e( 'Update your details', 'hspg' ); ?></a>
	</p><!-- .hs-change-user-details -->
</div><!-- .hs-donor-details -->
