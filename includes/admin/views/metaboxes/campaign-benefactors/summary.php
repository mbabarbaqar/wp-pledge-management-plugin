<?php
/**
 * Renders the campaign benefactors form.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin Views/Metaboxes
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

$benefactor = $view_args['benefactor'];

if ( $benefactor->is_active() ) {
	$summary = $benefactor;
} elseif ( $benefactor->is_expired() ) {
	$summary = sprintf( '<span>%s</span>%s', __( 'Expired', 'hspg' ), $benefactor );
} else {
	$summary = sprintf( '<span>%s</span>%s', __( 'Inactive', 'hspg' ), $benefactor );
}

?>
<div class="hs-benefactor-summary">
	<span class="summary"><?php echo $summary; ?></span>
	<span class="alignright">
		<a href="#" data-hs-toggle="campaign_benefactor_<?php echo esc_attr( $benefactor->campaign_benefactor_id ); ?>" data-hs-toggle-text="<?php esc_attr_e( 'Close', 'hspg' ); ?>"><?php _e( 'Edit', 'hspg' ); ?></a>&nbsp;&nbsp;&nbsp;
		<a href="#" data-campaign-benefactor-delete="<?php echo esc_attr( $benefactor->campaign_benefactor_id ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'hs-deactivate-benefactor' ) ); ?>"><?php _e( 'Delete', 'hspg' ); ?></a>
	</span>
</div>
