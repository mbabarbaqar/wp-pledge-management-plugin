<?php
/**
 * Renders the Campaign Creator metabox.
 *
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @package   Hspg/Admin Views/Metaboxes
 * @since     1.2.0
 * @version   1.2.0
 */

global $post;

$creator  = new Hs_User( $post->post_author );
$campaign = new Hs_Campaign( $post );

?>
<div id="hs-campaign-creator-metabox-wrap" class="hs-metabox-wrap">
	<div id="campaign-creator" class="hs-media-block">
		<div class="creator-avatar hs-media-image">
			<?php echo $creator->get_avatar(); ?>
		</div><!--.creator-avatar-->
		<div class="creator-facts hs-media-body">
			<h3 class="creator-name"><a href="<?php echo admin_url( 'user-edit.php?user_id=' . $creator->ID ); ?>"><?php printf( '%s (%s %d)', $creator->display_name, __( 'User ID', 'hs-ambassadors' ), $creator->ID ); ?></a></h3>
			<p><?php printf( '%s %s', _x( 'Joined on', 'joined on date', 'hs-ambassadors' ), date_i18n( 'F Y', strtotime( $creator->user_registered ) ) ); ?></p>
			<ul>
				<li><a href="<?php echo get_author_posts_url( $creator->ID ); ?>"><?php _e( 'Public Profile', 'hs-ambassadors' ); ?></a></li>
				<li><a href="<?php echo admin_url( 'user-edit.php?user_id=' . $creator->ID ); ?>"><?php _e( 'Edit Profile', 'hspg' ); ?></a></li>
			</ul>
		</div><!--.creator-facts-->
	</div><!--#campaign-creator-->
	<div id="hs-post-author-wrap" class="hs-metabox hs-select-wrap">
		<label for="post_author"><?php _e( 'Change the campaign creator' ); ?></label>
		<?php
		wp_dropdown_users( array(
			'name'     => 'post_author',
			'selected' => $post->post_author,
		) );
		?>
	</div>
</div><!--#hs-campaign-description-metabox-wrap-->
