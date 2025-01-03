<?php
/**
 * Displays the campaign content.
 *
 * Override this template by copying it to yourtheme/hspg/content-campaign.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Campaign
 * @since   1.0.0
 * @version 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$campaign = $view_args['campaign'];
$content  = $view_args['content'];

/**
 * Add something before the campaign content.
 *
 * @since 1.0.0
 *
 * @param $campaign Hs_Campaign Instance of `Hs_Campaign`.
 */
do_action( 'hs_campaign_content_before', $campaign );

echo $content;

/**
 * Add something after the campaign content.
 *
 * @since 1.0.0
 *
 * @param $campaign Hs_Campaign Instance of `Hs_Campaign`.
 */
do_action( 'hs_campaign_content_after', $campaign );
