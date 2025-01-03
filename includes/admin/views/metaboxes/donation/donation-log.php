<?php
/**
 * Renders the donation details meta box for the Donation post type.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin Views/Metaboxes
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.35
 */

global $post;

$logs             = hs_get_donation( $post->ID )->log()->get_log();
$date_time_format = get_option( 'date_format' ) . ' - ' . get_option( 'time_format' );
?>
<div id="hs-donation-log-metabox" class="hs-metabox">
	<table class="widefat">
		<thead>
			<tr>
				<th><?php _e( 'Date &amp; Time', 'hspg' ); ?></th>
				<th><?php _e( 'Log', 'hspg' ); ?></th>
			</th>
		</thead>
		<?php foreach ( $logs as $log ) : ?>
		<tr>
			<td><?php echo get_date_from_gmt( date( 'Y-m-d H:i:s', $log['time'] ), $date_time_format ); ?></td>
			<td><?php echo $log['message']; ?></td>
		</tr>
		<?php endforeach ?>
	</table>
</div>
