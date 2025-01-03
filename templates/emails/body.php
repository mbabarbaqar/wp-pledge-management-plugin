<?php
/**
 * Email Body
 *
 * Override this template by copying it to yourtheme/hspg/emails/body.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Emails
 * @version 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $view_args['email'] ) ) {
	return;
}

echo $view_args['email']->get_body();
