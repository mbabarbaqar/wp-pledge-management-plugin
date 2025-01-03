<?php
/**
 * Display the Welcome page.
 *
 * @author  Studio 164a
 * @package Hspg/Admin View/Welcome Page
 * @since   1.0.0
 * @version 1.6.38
 */

wp_enqueue_style( 'hs-admin-pages' );

require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );

$gateways        = Hs_Gateways::get_instance()->get_active_gateways_names();
$campaigns       = wp_count_posts( 'campaign' );
$campaigns_count = $campaigns->publish + $campaigns->draft + $campaigns->future + $campaigns->pending + $campaigns->private;
$emails          = hs_get_helper( 'emails' )->get_enabled_emails_names();
$install         = isset( $_GET['install'] ) && $_GET['install'];
$languages       = wp_get_available_translations();
$locale          = get_locale();
$language        = isset( $languages[ $locale ]['native_name'] ) ? $languages[ $locale ]['native_name'] : $locale;
$currency        = hs_get_option( 'currency', 'AUD' );
$currencies      = hs_get_currency_helper()->get_all_currencies();
$all_extensions  = array(
	'payfast'                        => __( 'Accept donations in South African Rand', 'hspg' ),
	'payu-money'                     => __( 'Accept donations in Indian Rupees with PayUmoney', 'hspg' ),
	'easy-digital-downloads-connect' => __( 'Collect donations with Easy Digital Downloads', 'hspg' ),
	'recurring-donations'            => __( 'Accept recurring donations', 'hspg' ),
	'fee-relief'                     => __( 'Let donors cover the gateway fees', 'hspg' ),
	'stripe'                         => __( 'Accept credit card donations with Stripe', 'hspg' ),
	'authorize-net'                  => __( 'Collect donations with Authorize.Net', 'hspg' ),
	'ambassadors'                    => __( 'Peer to peer fundraising or crowdfunding', 'hspg' ),
	'windcave'                       => sprintf(
		/* translators: %s: currency code */
		__( 'Collect donations in %s', 'hspg' ),
		$currencies[ $currency ]
	),
	'anonymous-donations'            => __( 'Let donors give anonymously', 'hspg' ),
	'user-avatar'                    => __( 'Let your donors upload their own profile photo', 'hspg' ),
);

if ( 'en_ZA' == $locale || 'ZAR' == $currency ) {
	$extensions = array_intersect_key( $all_extensions, array( 'payfast' => '', 'recurring-donations' => '', 'ambassadors' => '', 'fee-relief' => '' ) );
} elseif ( 'hi_IN' == $locale || 'INR' == $currency ) {
	$extensions = array_intersect_key( $all_extensions, array( 'payu-money' => '', 'ambassadors' => '', 'fee-relief' => '', 'windcave' => '' ) );
} elseif ( in_array( $locale, array( 'en_NZ', 'ms_MY', 'ja', 'zh_HK' ) ) || in_array( $currency, array( 'NZD', 'MYR', 'JPY', 'HKD' ) ) ) {
	$extensions = array_intersect_key( $all_extensions, array( 'recurring-donations' => '', 'stripe' => '', 'windcave' => '', 'fee-relief' => '' ) );
} elseif( in_array( $locale, array( 'th' ) ) || in_array( $currency, array( 'BND', 'FJD', 'KWD', 'PGK', 'SBD', 'THB', 'TOP', 'VUV', 'WST' ) ) ) {
	$extensions = array_intersect_key( $all_extensions, array( 'windcave' => '', 'fee-relief' => '', 'ambassadors' => '', 'anonymous-donations' => '' ) );
} elseif ( class_exists( 'EDD' ) ) {
	$extensions = array_intersect_key( $all_extensions, array( 'ambassadors' => '', 'easy-digital-downloads-connect' => '', 'anonymous-donations' => '', 'user-avatar' => '' ) );
} else {
	$extensions = array_intersect_key( $all_extensions, array( 'recurring-donations' => '', 'stripe' => '', 'authorize-net' => '', 'fee-relief' => '' ) );
}

?>
<div class="wrap about-wrap hs-wrap">
	<h1>
		<strong>Pledge Groups</strong>
		<sup class="version"><?php echo hspg()->get_version(); ?></sup>
	</h1>
	<!--<div class="badge">
		<a href="https://www.wphspg.com/?utm_source=welcome-page&amp;utm_medium=wordpress-dashboard&amp;utm_campaign=home&amp;utm_content=icon" target="_blank"><i class="hs-icon hs-icon-hs"></i></a>
	</div>-->
	<div class="intro">
		<?php
		if ( $install ) :
			_e( 'Thank you for installing Hspg!', 'hspg' );
		else :
			printf(__( 'Hspg is everything you need to start accepting donations today. PayPal and offline donations work right out of the box, and when your organization is ready to grow, our extensions give you the tools you need to move forward.', 'hspg' ));
		endif;
		?>
	</div>
	<div>
		<div class="column-inside">
			<?php if ( current_user_can( 'manage_hs_settings' ) ) : ?>
				<hr />
				<h3><?php _e( 'Getting Started', 'hspg' ); ?></h3>
				<ul class="checklist">
					<?php if ( count( $gateways ) > 0 ) : ?>
						<li class="done"><?php
							printf(
								_x( 'You have activated %s. <a href="%s">Change settings</a>', 'You have activated x and y. Change gateway settings.', 'hspg' ),
								hs_list_to_sentence_part( $gateways ),
								admin_url( 'admin.php?page=hs-settings&tab=gateways' )
							); ?>
						</li>
					<?php else : ?>
						<li class="not-done"><a href="<?php echo admin_url( 'admin.php?page=hs-settings&tab=gateways' ); ?>"><?php _e( 'You need to enable a payment gateway', 'hspg' ); ?></a></li>
					<?php endif ?>
					<?php if ( $campaigns_count > 0 ) : ?>
						<li class="done"><?php
							printf(
								__( 'You have created your first campaign. <a href="%s">Create another one.</a>', 'hspg' ),
								admin_url( 'post-new.php?post_type=campaign' )
							); ?>
						</li>
					<?php else : ?>
						<li class="not-done"><a href="<?php echo admin_url( 'post-new.php?post_type=campaign' ); ?>"><?php _e( 'Create your first campaign', 'hspg' ); ?></a></li>
					<?php endif ?>
					<?php if ( count( $emails ) > 0 ) : ?>
						<li class="done"><?php
							printf(
								_x( 'You have turned on the %s. <a href="%s">Change settings</a>', 'You have activated x and y. Change email settings.', 'hspg' ),
								hs_list_to_sentence_part( $emails ),
								admin_url( 'admin.php?page=hs-settings&tab=emails' )
							); ?>
						</li>
					<?php else : ?>
						<li class="not-done"><a href="<?php echo admin_url( 'admin.php?page=hs-settings&tab=emails' ); ?>"><?php _e( 'Turn on email notifications', 'hspg' ); ?></a></li>
					<?php endif ?>
				</ul>
				<!--<p style="margin-bottom: 0;"><?php
					printf(
						__( 'Need a hand with anything? You might find the answer in <a href="%s">our documentation</a>, or you can always get in touch with us via <a href="%s">our support page</a>.', 'hspg' ),
						'https://www.wphspg.com/documentation/?utm_source=welcome-page&utm_medium=wordpress-dashboard&utm_campaign=documentation',
						'https://www.wphspg.com/support/?utm_source=welcome-page&utm_medium=wordpress-dashboard&utm_campaign=support'
					); ?>
				</p>-->
			<?php endif ?>
			<hr />
			<?php if ( strpos( $locale, 'en' ) !== 0 ) : ?>
				<h3><?php printf( _x( 'Translate Hspg into %s', 'translate Hspg into language', 'hspg' ), $language ); ?></h3>
				<p><?php printf( __( 'You can help us translate Hspg into %s by <a href="https://translate.wordpress.org/projects/wp-plugins/hspg">contributing to the translation project</a>.', 'hspg' ),
					$language
				); ?></p>
				<hr />
			<?php endif ?>
		</div>
	</div>
</div>
