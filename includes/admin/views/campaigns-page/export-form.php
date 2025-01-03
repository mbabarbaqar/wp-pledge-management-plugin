<?php
/**
 * Display the export button in the campaign exports box.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin View/Campaigns Page
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.6.0
 * @version   1.6.39
 */

/**
 * Filter the class to use for the modal window.
 *
 * @since 1.0.0
 *
 * @param string $class The class name.
 */
$modal_class = apply_filters( 'hs_modal_window_class', 'hs-modal' );

$start_date_from = isset( $_GET['start_date_from'] ) ? sanitize_text_field( $_GET['start_date_from'] ) : null;
$start_date_to   = isset( $_GET['start_date_to'] ) ? sanitize_text_field( $_GET['start_date_to'] ) : null;
$end_date_from   = isset( $_GET['end_date_from'] ) ? sanitize_text_field( $_GET['end_date_from'] ) : null;
$end_date_to     = isset( $_GET['end_date_to'] ) ? sanitize_text_field( $_GET['end_date_to'] ) : null;
$status          = isset( $_GET['post_status'] ) ? $_GET['post_status'] : 'any';
$report_type     = isset( $_GET['report_type'] ) ? $_GET['report_type'] : 'campaigns';

/**
 * Filter the type of exportable report types.
 *
 * @since 1.6.0
 *
 * @param array $types Types of reports.
 */
$report_types = apply_filters(
	'hs_campaign_export_report_types',
	array(
		'campaigns' => __( 'Campaigns', 'hspg' ),
	)
);

$statuses = array(
	'any'     => __( 'All', 'hspg' ),
	'pending' => __( 'Pending', 'hspg' ),
	'draft'   => __( 'Draft', 'hspg' ),
	'active'  => __( 'Active', 'hspg' ),
	'finish'  => __( 'Finished', 'hspg' ),
	'publish' => __( 'Published', 'hspg' ),
);

?>
<div id="hs-campaigns-export-modal" style="display: none" class="hs-campaigns-modal <?php echo esc_attr( $modal_class ); ?>" tabindex="0">
	<a class="modal-close"></a>
	<h3><?php _e( 'Export Campaigns', 'hspg' ); ?></h3>
	<form class="hs-campaigns-modal-form hs-modal-form" method="get" action="<?php echo admin_url( 'admin.php' ); ?>">
		<?php wp_nonce_field( 'hs_export_campaigns', '_hs_export_nonce' ); ?>
		<input type="hidden" name="hs_action" value="export_campaigns" />
		<input type="hidden" name="page" value="hs-campaigns-table" />
		<input type="hidden" name="post_type" class="post_type_page" value="campaign" />
		<fieldset>
			<legend><?php _e( 'Filter by Start Date', 'hspg' ); ?></legend>
			<input type="text" id="hs-export-start_date_from" name="start_date_from" class="hs-datepicker" value="<?php echo $start_date_from; ?>" placeholder="<?php esc_attr_e( 'From:', 'hspg' ); ?>" />
			<input type="text" id="hs-export-start_date_to" name="start_date_to" class="hs-datepicker" value="<?php echo $start_date_to; ?>" placeholder="<?php esc_attr_e( 'To:', 'hspg' ); ?>" />
		</fieldset>
		<fieldset>
			<legend><?php _e( 'Filter by End Date', 'hspg' ); ?></legend>
			<input type="text" id="hs-export-end_date_from" name="end_date_from" class="hs-datepicker" value="<?php echo $end_date_from; ?>" placeholder="<?php esc_attr_e( 'From:', 'hspg' ); ?>" />
			<input type="text" id="hs-export-end_date_to" name="end_date_to" class="hs-datepicker" value="<?php echo $end_date_to; ?>" placeholder="<?php esc_attr_e( 'To:', 'hspg' ); ?>" />
		</fieldset>
		<label for="hs-campaigns-export-status"><?php _e( 'Filter by Status', 'hspg' ); ?></label>
		<select id="hs-campaigns-filter-status" name="status">
			<?php foreach ( $statuses as $key => $label ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $status, $key ); ?>><?php echo $label; ?></option>
			<?php endforeach ?>
		</select>
		<?php if ( count( $report_types ) > 1 ) : ?>
			<label for="hs-campaign-export-report-type"><?php _e( 'Type of Report', 'hspg' ); ?></label>
			<select id="hs-campaign-export-report-type" name="report_type">
			<?php foreach ( $report_types as $key => $report_label ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>"><?php echo $report_label; ?></option>
			<?php endforeach; ?>
			</select>
		<?php else : ?>
			<input type="hidden" name="report_type" value="<?php echo esc_attr( key( $report_types ) ); ?>" />
		<?php
		endif;

		/**
		 * Add additional exports to the form.
		 *
		 * @since 1.6.36
		 */
		do_action( 'hs_export_campaigns_form' );
		?>
		<button type="submit" class="button button-primary"><?php _e( 'Export', 'hspg' ); ?></button>
	</form>
</div>
