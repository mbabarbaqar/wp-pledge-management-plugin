<?php
/**
 * Renders the custom styles added by Hspg.
 *
 * Override this template by copying it to yourtheme/hspg/custom-styles.css.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/CSS
 * @since   1.0.0
 * @version 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$highlight_colour = hs_get_option( 'highlight_colour', apply_filters( 'hs_default_highlight_colour', '#f89d35' ) );

?>
<style id="hs-highlight-colour-styles">
.campaign-raised .amount,
.campaign-figures .amount,
.donors-count,
.time-left,
.hs-form-field a:not(.button),
.hs-form-fields .hs-fieldset a:not(.button),
.hs-notice,
.hs-notice .errors a { color: <?php echo $highlight_colour; ?>; }

.campaign-progress-bar .bar,
.donate-button,
.hs-donation-form .donation-amount.selected,
.hs-donation-amount-form .donation-amount.selected { background-color: <?php echo $highlight_colour; ?>; }

.hs-donation-form .donation-amount.selected,
.hs-donation-amount-form .donation-amount.selected,
.hs-notice,
.hs-drag-drop-images li:hover a.remove-image,
.supports-drag-drop .hs-drag-drop-dropzone.drag-over { border-color: <?php echo $highlight_colour; ?>; }

<?php do_action( 'hs_custom_styles', $highlight_colour ) ?>
</style>
