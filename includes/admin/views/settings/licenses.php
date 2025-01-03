<?php
/**
 * Display the table of products requiring licenses.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin View/Settings
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

$helper   = hs_get_helper( 'licenses' );
$products = $helper->get_products();

if ( empty( $products ) ) :
	return;
endif;
?>
<div class="hs-settings-notice" style="margin-bottom: 20px;">
	<p><?php _e( 'By adding your license keys, you agree for your website to send requests to wphspg.com to check license details and provide automatic plugin updates.', 'hspg' ); ?></p>
	<p><?php _e( 'Your license can be disconnected at any time.', 'hspg' ); ?></p>
</div>
<?php
foreach ( $products as $key => $product ) :

	$license = $helper->get_license_details( $key );

	if ( is_array( $license ) ) {
		$is_active   = $license['valid'];
		$license_key = $license['license'];
	} else {
		$is_active   = false;
		$license_key = $license;
	}

	?>
	<div class="hs-settings-object hs-licensed-product cf">
		<h4><?php echo $product['name']; ?></h4>
		<input type="text" name="hs_settings[licenses][<?php echo $key; ?>]" id="hs_settings_licenses_<?php echo $key; ?>" class="hs-settings-field" placeholder="<?php _e( 'Add your license key', 'hspg' ); ?>" value="<?php echo $license_key; ?>" />
		<?php if ( $license ) : ?>
			<div class="license-meta">
				<?php if ( $is_active ) : ?>
					<a href="<?php echo $helper->get_license_deactivation_url( $key ); ?>" class="button-secondary license-deactivation"><?php _e( 'Deactivate License', 'hspg' ); ?></a>
					<?php if ( 'lifetime' == $license['expiration_date'] ) : ?>
						<span class="license-expiration-date"><?php _e( 'Lifetime license', 'hspg' ); ?></span>
					<?php else : ?>
						<span class="license-expiration-date"><?php printf( '%s %s.', __( 'Expiring in', 'hspg' ), human_time_diff( strtotime( $license['expiration_date'] ), time() ) ); ?></span>
					<?php endif ?>
				<?php elseif ( is_array( $license ) ) : ?>
					<span class="license-invalid"><?php _e( 'This license is not valid', 'hspg' ); ?></span>
				<?php else : ?>
					<span class="license-invalid"><?php _e( 'We could not validate this license', 'hspg' ); ?></span>
				<?php endif ?>
			</div>
		<?php endif ?>
	</div>

	<?php
endforeach;
