<?php
/**
 * Renders the donation details meta box for the Donation post type.
 *
 * @author    Eric Daams
 * @package   Hspg/Admin Views/Metaboxes
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

global $post;

$meta = hs_get_donation( $post->ID )->get_donation_meta();

?>
<div id="hs-donation-details-metabox" class="hs-metabox">
	<dl>
	<?php foreach ( $meta as $key => $details ) : ?>
		<dt><?php echo $details['label']; ?></dt>
		<dd><?php echo $details['value']; ?></dd>
	<?php endforeach ?>
	</dl>
</div>
