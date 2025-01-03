<?php
/**
 * Display the date filters above the Donations table.
 *
 * @author  Studio 164a
 * @package Hspg/Admin View/Donations Page
 * @since   1.4.0
 */

$filters = $_GET;

unset(
	$filters['post_type'],
	$filters['paged'],
	$filters['bulk_donation_status_update'],
	$filters['ids']
);

?>
<a href="#hs-donations-filter-modal" class="hs-filter-button button dashicons-before dashicons-filter trigger-modal hide-if-no-js" data-trigger-modal><?php _e( 'Filter', 'hspg' ); ?></a>

<?php if ( count( $filters ) ) : ?>
	<a href="<?php echo esc_url_raw( add_query_arg( array( 'post_type' => Hspg::DONATION_POST_TYPE ), admin_url( 'edit.php' ) ) ); ?>" class="hs-donations-clear button dashicons-before dashicons-clear"><?php _e( 'Clear Filters', 'hspg' ); ?></a>
<?php endif ?>
