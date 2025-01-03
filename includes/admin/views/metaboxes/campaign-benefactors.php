<?php
/**
 * Renders a benefactors addon metabox. Used by any plugin that utilizes the Benefactors Addon.
 *
 * @since       1.0.0
 * @author     HCS
 * @package     Hspg/Admin Views/Metaboxes
 * @copyright   Copyright (c) 2020, Studio 164a
 */

global $post;

if ( ! isset( $view_args['extension'] ) ) {
	hs_get_deprecated()->doing_it_wrong(
		'hs_campaign_meta_boxes',
		'Campaign benefactors metabox requires an extension argument.',
		'1.0.0'
	);
	return;
}

$extension   = $view_args['extension'];
$benefactors = hs_get_table( 'benefactors' )->get_campaign_benefactors_by_extension( $post->ID, $extension );
$ended       = hs_get_campaign( $post->ID )->has_ended();

?>
<div class="hs-metabox hs-metabox-wrap">
	<?php
	if ( empty( $benefactors ) ) :
		if ( $ended ) :
		?>
			<p><?php _e( 'You did not add any contribution rules.', 'hspg' ); ?></p>
		<?php else : ?>
			<p><?php _e( 'You have not added any contribution rules yet.', 'hspg' ); ?></p>
		<?php
		endif;
	else :
		foreach ( $benefactors as $benefactor ) :
			$benefactor_object = Hs_Benefactor::get_object( $benefactor, $extension );

			if ( $benefactor_object->is_active() ) {
				$active_class = 'hs-benefactor-active';
			} elseif ( $benefactor_object->is_expired() ) {
				$active_class = 'hs-benefactor-expired';
			} else {
				$active_class = 'hs-benefactor-inactive';
			}
			?>
			<div class="hs-metabox-block hs-benefactor <?php echo $active_class; ?>">
				<?php do_action( 'hs_campaign_benefactor_meta_box', $benefactor_object, $extension ); ?>
			</div>
			<?php

		endforeach;
	endif;

	hs_admin_view( 'metaboxes/campaign-benefactors/form', array(
		'benefactor' => null,
		'extension'  => $extension,
	) );

	if ( ! $ended ) :
	?>
		<p><a href="#" class="button" data-hs-toggle="campaign_benefactor__0"><?php _e( '+ Add New Contribution Rule', 'hspg' ); ?></a></p>
	<?php
	endif;
	?>
</div>
