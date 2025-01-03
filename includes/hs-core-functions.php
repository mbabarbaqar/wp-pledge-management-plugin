<?php
/**
 * Hspg Core Functions.
 *
 * General core functions.
 *
 * @package   Hspg/Functions/Core
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.37
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This returns the original Hspg object.
 *
 * Use this whenever you want to get an instance of the class. There is no
 * reason to instantiate a new object, though you can do so if you're stubborn :)
 *
 * @since  1.0.0
 *
 * @return Hspg
 */
function hspg() {
	return Hspg::get_instance();
}

/**
 * This returns the value for a particular Hspg setting.
 *
 * @since  1.0.0
 *
 * @param  mixed $key          Accepts an array of strings or a single string.
 * @param  mixed $default      The value to return if key is not set.
 * @param  array $settings     Optional. Used when $key is an array.
 * @param  mixed $original_key Optional. Original array of keys.
 * @return mixed
 */
function hs_get_option( $key, $default = false, $settings = array(), $original_key = array() ) {
	if ( empty( $settings ) ) {
		$settings = get_option( 'hs_settings' );
	}

	if ( ! is_array( $key ) ) {
		$key = array( $key );
	}

	$current_key = current( $key );

	if ( empty( $original_key ) ) {
		$original_key = $key;
	}

	/* Key does not exist */
	if ( ! isset( $settings[ $current_key ] ) ) {
		return $default;
	}

	array_shift( $key );

	if ( ! empty( $key ) ) {
		return hs_get_option( $key, $default, $settings[ $current_key ], $original_key );
	}

	/**
	 * Filter the option value.
	 *
	 * @since 1.6.37
	 *
	 * @param mixed $value   The option value.
	 * @param mixed $key     The key, or list of keys.
	 * @param mixed $default The default value.
	 */
	return apply_filters( 'hs_option_' . $current_key, $settings[ $current_key ], $original_key, $default );
}

/**
 * Returns a helper class.
 *
 * @since  1.0.0
 *
 * @param  string $class_key The class to get an object for.
 * @return mixed|false
 */
function hs_get_helper( $class_key ) {
	return hspg()->registry()->get( $class_key );
}

/**
 * Returns the Hs_Notices class instance.
 *
 * @since  1.0.0
 *
 * @return Hs_Notices
 */
function hs_get_notices() {
	return hspg()->registry()->get( 'notices' );
}

/**
 * Returns the Hs_Donation_Processor class instance.
 *
 * @since  1.0.0
 *
 * @return Hs_Donation_Processor
 */
function hs_get_donation_processor() {
	$registry = hspg()->registry();

	if ( ! $registry->has( 'donation_processor' ) ) {
		$registry->register_object( Hs_Donation_Processor::get_instance() );
	}

	return $registry->get( 'donation_processor' );
}

/**
 * Return Hs_Locations helper class.
 *
 * @since  1.0.0
 *
 * @return Hs_Locations
 */
function hs_get_location_helper() {
	return hspg()->registry()->get( 'locations' );
}

/**
 * Returns the current user's session object.
 *
 * @since  1.0.0
 *
 * @return Hs_Session
 */
function hs_get_session() {
	return hspg()->registry()->get( 'session' );
}

/**
 * Returns the current request helper object.
 *
 * @since  1.0.0
 *
 * @return Hs_Request
 */
function hs_get_request() {
	$registry = hspg()->registry();

	if ( ! $registry->has( 'request' ) ) {
		$registry->register_object( Hs_Request::get_instance() );
	}

	return $registry->get( 'request' );
}

/**
 * Returns the Hs_User_Dashboard object.
 *
 * @since  1.0.0
 *
 * @return Hs_User_Dashboard
 */
function hs_get_user_dashboard() {
	return hspg()->registry()->get( 'user_dashboard' );
}

/**
 * Return the database table helper object.
 *
 * @since  1.0.0
 *
 * @param  string $table The table key.
 * @return mixed|null A child class of Hs_DB if table exists. null otherwise.
 */
function hs_get_table( $table ) {
	return hspg()->get_db_table( $table );
}

/**
 * Returns the current donation form.
 *
 * @since  1.0.0
 *
 * @return Hs_Donation_Form_Interface|false
 */
function hs_get_current_donation_form() {
	$campaign = hs_get_current_campaign();
	return false === $campaign ? false : $campaign->get_donation_form();
}

/**
 * Returns the provided array as a HTML element attribute.
 *
 * @since  1.0.0
 *
 * @param  array $args Arguments to be added.
 * @return string
 */
function hs_get_action_args( $args ) {
	return sprintf( "data-hs-args='%s'", json_encode( $args ) );
}

/**
 * Returns the Hs_Deprecated class, loading the file if required.
 *
 * @since  1.4.0
 *
 * @return Hs_Deprecated
 */
function hs_get_deprecated() {
	$registry = hspg()->registry();

	if ( ! $registry->has( 'deprecated' ) ) {
		$registry->register_object( Hs_Deprecated::get_instance() );
	}

	return $registry->get( 'deprecated' );
}
