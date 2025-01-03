<?php
/**
 * The template used to display notices.
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Form Fields
 * @since   1.0.0
 * @version 1.3.0
 */

if ( ! isset( $view_args['notices'] ) ) {
	return;
}

$notices = array_filter( $view_args['notices'] );

if ( empty( $notices ) ) {
	return;
}

foreach ( $notices as $type => $messages ) :
	if ( 'error' == $type ) :
		$type = 'errors';
	endif;
	?>
	<div class="hs-notice hs-form-<?php echo esc_attr( $type ); ?>">
		<ul class="hs-notice-<?php echo esc_attr( $type ); ?> <?php echo esc_attr( $type ); ?>">
			<?php foreach ( $messages as $message ) : ?>
				<li><?php echo $message; ?></li>
			<?php endforeach ?>
		</ul><!-- hs-notice-<?php esc_attr( $type ); ?> -->
	</div><!-- .hs-notices -->
<?php endforeach ?>
