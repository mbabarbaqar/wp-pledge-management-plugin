<?php
/**
 * Display the table of payment gateways.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin View/Settings
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.38
 */

$helper   = hs_get_helper( 'gateways' );
$gateways = $helper->get_available_gateways();
$default  = $helper->get_default_gateway();
$upgrades = $helper->get_recommended_gateways();

foreach ( $gateways as $gateway ) :

	$gateway   = new $gateway;
	$is_active = $helper->is_active_gateway( $gateway->get_gateway_id() );

	if ( $is_active ) {
		$action_url  = esc_url( add_query_arg( array(
			'hs_action' => 'disable_gateway',
			'gateway_id'        => $gateway->get_gateway_id(),
			'_nonce'            => wp_create_nonce( 'gateway' ),
		), admin_url( 'admin.php?page=hs-settings&tab=gateways' ) ) );
		$action_text = __( 'Disable Gateway', 'hspg' );
	} else {
		$action_url  = esc_url( add_query_arg( array(
			'hs_action' => 'enable_gateway',
			'gateway_id'        => $gateway->get_gateway_id(),
			'_nonce'            => wp_create_nonce( 'gateway' ),
		), admin_url( 'admin.php?page=hs-settings&tab=gateways' ) ) );
		$action_text = __( 'Enable Gateway', 'hspg' );
	}

	$action_url = esc_url( add_query_arg( array(
		'hs_action' => $is_active ? 'disable_gateway' : 'enable_gateway',
		'gateway_id'        => $gateway->get_gateway_id(),
		'_nonce'            => wp_create_nonce( 'gateway' ),
	), admin_url( 'admin.php?page=hs-settings&tab=gateways' ) ) );

	$make_default_url = esc_url( add_query_arg( array(
		'hs_action' => 'make_default_gateway',
		'gateway_id'        => $gateway->get_gateway_id(),
		'_nonce'            => wp_create_nonce( 'gateway' ),
	), admin_url( 'admin.php?page=hs-settings&tab=gateways' ) ) );

	?>
	<div class="hs-settings-object hs-gateway cf">
		<h4><?php echo $gateway->get_name(); ?></h4>
		<?php if ( $gateway->get_gateway_id() == $default ) : ?>

			<span class="default-gateway"><?php _e( 'Default gateway', 'hspg' ); ?></span>

		<?php elseif ( $is_active ) : ?>

			<a href="<?php echo $make_default_url; ?>" class="make-default-gateway"><?php _e( 'Make default gateway', 'hspg' ); ?></a>

		<?php endif ?>
		<span class="actions">
			<?php
			if ( $is_active ) :
				$settings_url = esc_url( add_query_arg( array(
					'group' => 'gateways_' . $gateway->get_gateway_id(),
				), admin_url( 'admin.php?page=hs-settings&tab=gateways' ) ) );
				?>

				<a href="<?php echo $settings_url; ?>" class="button button-primary"><?php _e( 'Gateway Settings', 'hspg' ); ?></a>
			<?php endif ?>
			<a href="<?php echo $action_url; ?>" class="button"><?php echo $action_text; ?></a>
		</span>
	</div>
<?php endforeach ?>
<!--<?php
if ( ! empty( $upgrades ) ) :
	if ( 1 === count( $upgrades ) ) {
		$currencies = hs_get_currency_helper()->get_all_currencies();
		$gateway    = key( $upgrades );
		$message    = sprintf(
			/* translators: %1$s: currency; %2$s: hyperlink %3$s: payment gateway name */
			__( '<strong>Tip</strong>: Accept donations in %1$s with <a href="%2$s" target="_blank">%3$s</a>.', 'hspg' ),
			$currencies[ hs_get_currency() ],
			'https://www.wphspg.com/extensions/hs-' . $gateway . '/?utm_source=gateways-page&amp;utm_medium=wordpress-dashboard&amp;utm_campaign=' . $gateway,
			current( $upgrades )
		);
	} else {
		$message = sprintf(
			/* translators: %1$s: hyperlink; %2$s: single extension name; %3$s: comma-separated list of extension names */
			__( '<strong>Need more options?</strong> <a href="%1$s" target="_blank">Click here to browse our payment gateway extensions</a>, including %3$s and %2$s.', 'hspg' ),
			'https://www.wphspg.com/extensions/category/payment-gateways/?utm_source=gateways-page&amp;utm_medium=wordpress-dashboard&amp;utm_campaign=gateways',
			array_pop( $upgrades ),
			implode( ', ', $upgrades )
		);
	}
	?>
	<p class="hs-gateway-prompt hs-settings-notice"><?php echo $message; ?></p>
<?php endif ?>-->
