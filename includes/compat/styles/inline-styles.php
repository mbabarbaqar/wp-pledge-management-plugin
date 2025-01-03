<?php
/**
 * Returns an array with all compat styles, ordered by the stylesheet they should be added to.
 *
 * @package   Hspg/Compat
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.6.29
 * @version   1.6.44
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$highlight_colour = hs_get_option( 'highlight_colour', apply_filters( 'hs_default_highlight_colour', '#f89d35' ) );

return [
	'twentytwenty-style' => '.mce-btn button{background: transparent;}'
							. '.supports-drag-drop .hs-drag-drop-dropzone,.campaign-summary,.campaign-loop .campaign,.hs-donation-form .donation-amounts .donation-amount{background-color:#fff;color:#000;}'
							. '.hs-form-fields .hs-fieldset{border:none;padding:0;margin-bottom:2em;}'
							. '#hs-donor-fields .hs-form-header,#hs-user-fields,#hs-meta-fields{padding-left:0;padding-right:0;}'
							. '.campaign-loop.campaign-grid{margin:0 auto 1em;}'
							. '.hs-form-field.hs-form-field-checkbox input[type="checkbox"] {height:1.5rem;width:1.5rem;display:inline-block;}',
	'hello-elementor'    => '.donate-button{color: #fff;}',
	'divi-style'         => '.donate-button.button{color:' . $highlight_colour . ';background:#fff;border-color:' . $highlight_colour . ';}'
							. '#left-area .donation-amounts{padding: 0;}'
							. '.hs-submit-field .button{font-size:20px;}'
							. '.et_pb_widget .hs-submit-field .button{font-size:1em;}'
							. '.et_pb_widget .hs-submit-field .et_pb_button:after{font-size:1.6em;}',
	'solopine_style'     => '.hs-button{background-color:#161616;color:#fff;font:700 10px/10px "Montserrat", sans-serif;border:none;text-transform:uppercase;padding:14px 15px 14px 16px;letter-spacing:1.5px;}'
							. '.hs-button.donate-button{background-color:' . $highlight_colour . ';}',
];
