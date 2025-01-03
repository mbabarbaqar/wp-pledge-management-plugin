<?php
/**
 * Display the date filters above the campaigns table.
 *
 * @author  Studio 164a
 * @package Hspg/Admin View/Campaigns Page
 * @since   1.6.36
 * @version 1.6.36
 */

$filters = $_GET;

unset(
	$filters['post_type'],
	$filters['paged'],
	$filters['ids']
);

?>
<a href="#hs-campaigns-filter-modal" class="hs-filter-button button dashicons-before dashicons-filter trigger-modal hide-if-no-js" data-trigger-modal><?php _e( 'Filter', 'hspg' ); ?></a>

<?php if ( count( $filters ) ) : ?>
	<a href="<?php echo esc_url_raw( add_query_arg( array( 'post_type' => Hspg::CAMPAIGN_POST_TYPE ), admin_url( 'edit.php' ) ) ); ?>" class="hs-campaigns-clear button dashicons-before dashicons-clear"><?php _e( 'Clear Filters', 'hspg' ); ?></a>
<?php endif ?>
