<?php
/**
 * Displays the campaign status tag.
 *
 * Override this template by copying it to yourtheme/hspg/campaign/status-tag.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Campaign Page
 * @since   1.0.0
 * @version 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$campaign = $view_args['campaign'];
$tag      = $campaign->get_status_tag();

if ( empty( $tag ) ) {
	return;
}

?>
<div class="campaign-status-tag campaign-status-tag-<?php echo esc_attr( strtolower( str_replace( ' ', '-', $campaign->get_status_key() ) ) ); ?>">
	<?php echo $tag; ?>
</div>
