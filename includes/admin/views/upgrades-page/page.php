<?php
/**
 * Display the upgrades page.
 *
 * @author  Studio 164a
 * @package Hspg/Admin View/Upgrades
 * @since   1.0.0
 * @version 1.6.35
 */

$page   = $view_args['page'];
$action = $page->get_action();
$step   = $page->get_step();
$total  = $page->get_total();
$number = $page->get_number();
$steps  = $page->get_steps( $total, $number );
$args   = array(
	'hs-upgrade' => $action,
	'page'               => 'hs-upgrades',
	'step'               => $step,
	'total'              => $total,
	'steps'              => $steps,
);

$timeout_url  = 'index.php?hs_action=' . $action;
$timeout_url .= '&step=' . $step;

if ( $total ) {
	$timeout_url .= '&total=' . $total;
}

update_option( 'hs_doing_upgrade', $args );

if ( $step > $steps ) {
	// Prevent a weird case where the estimate was off. Usually only a couple.
	$steps = $step;
}
?>
<div class="wrap">
	<h2><?php _e( 'Hspg - Upgrades', 'hspg' ); ?></h2>

	<div id="hs-upgrade-status">
		<p><?php _e( 'The upgrade process has started, please be patient. This could take several minutes. You will be automatically redirected when the upgrade is finished.', 'hspg' ); ?></p>
		<?php if ( ! empty( $total ) ) : ?>
			<p><strong><?php printf( __( 'Step %d of approximately %d running', 'hspg' ), $step, $steps ); ?></strong></p>
		<?php endif; ?>
	</div>
	<script type="text/javascript">
		setTimeout(function() { document.location.href = "<?php echo $timeout_url; ?>"; }, 250);
	</script>
</div>
