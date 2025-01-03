<?php
/**
 * Renders the donation options metabox for the Campaign post type.
 *
 * @author 	Studio 164a
 * @since   1.0.0
 * @package Hspg/Admin Views/Metaboxes
 */

$title       = isset( $view_args['title'] ) ? $view_args['title'] : '';
$tooltip     = isset( $view_args['tooltip'] ) ? '<span class="tooltip"> '. $view_args['tooltip'] . '</span>' : '';
$description = isset( $view_args['description'] ) ? '<span class="hs-helper">' . $view_args['description'] . '</span>' : '';
?>
<div class="hs-metabox">
	<?php
	do_action( 'hs_campaign_donation_options_metabox' );
	?>
</div>
