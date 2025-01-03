<?php
/**
 * The template for displaying campaign content within loops.
 *
 * Override this template by copying it to yourtheme/hspg/campaign-loop/campaign.php
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

$campaign = hs_get_current_campaign();

?>
<li id="campaign-<?php echo get_the_ID() ?>" <?php post_class() ?>>
<?php
	/**
	 * @hook hs_campaign_content_loop_before
	 */
	do_action( 'hs_campaign_content_loop_before', $campaign, $view_args );

	?>
	<a href="<?php the_permalink() ?>">
		<?php
			/**
			 * @hook hs_campaign_content_loop_before_title
			 */
			do_action( 'hs_campaign_content_loop_before_title', $campaign, $view_args );
		?>

		<h3><?php the_title() ?></h3>

		<?php
			/**
			 * @hook hs_campaign_content_loop_after_title
			 */
			do_action( 'hs_campaign_content_loop_after_title', $campaign, $view_args );
		?>
	</a>
	<?php

	/**
	 * @hook hs_campaign_content_loop_after
	 */
	do_action( 'hs_campaign_content_loop_after', $campaign, $view_args );
?>
</li>
