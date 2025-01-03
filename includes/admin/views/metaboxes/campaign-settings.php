<?php
/**
 * Loops over the meta boxes inside the advanced settings area of the Campaign post type.
 *
 * @author    Studio 164a
 * @package   Hspg/Admin Views/Metaboxes
 * @copyright Copyright (c) 2020, Studio 164a
 * @since     1.6.0
 * @version   1.6.0
 */

global $post;

$helper = hspg()->registry()->get( 'campaign_meta_boxes' );
$panels = $helper->get_campaign_settings_panels();

?>
<div id="hs-campaign-advanced-metabox" class="hs-metabox hs-campaign-settings">
	<ul class="hs-tabs">
		<?php foreach ( $panels as $id => $panel ) : ?>
			<li><a href="<?php echo esc_attr( sprintf( '#%s', $id ) ); ?>"><?php echo $panel['title']; ?></a></li>
		<?php endforeach ?>
	</ul>
	<?php foreach ( $panels as $id => $panel ) : ?>
		<div id="<?php echo esc_attr( $id ); ?>" class="hs-campaign-settings-panel">
			<?php
			if ( ! array_key_exists( 'view', $panel ) ) :
				$panel['view'] = 'metaboxes/campaign-settings/panel';
			endif;

			$helper->get_meta_box_helper()->metabox_display( $post, array( 'args' => $panel ) );
			?>
		</div><!-- #<?php echo esc_attr( $id ); ?> -->
	<?php endforeach ?>
</div><!-- #hs-campaign-advanced-metabox -->
