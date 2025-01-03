<?php
/**
 * Functions to improve compatibility.
 *
 * @package   Hspg/Functions/Compatibility
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.6.44
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load plugin compatibility files on plugins_loaded hook.
 *
 * @since  1.5.0
 *
 * @return void
 */
function hs_load_compat_functions() {
	$includes_path = hspg()->get_path( 'includes' );

	/* WP Super Cache */
	if ( function_exists( 'wp_super_cache_text_domain' ) ) {
		require_once( $includes_path . 'compat/hs-wp-super-cache-compat-functions.php' );
	}

	/* W3TC */
	if ( defined( 'W3TC' ) && W3TC ) {
		require_once( $includes_path . 'compat/hs-w3tc-compat-functions.php' );
	}

	/* WP Rocket */
	if ( defined( 'WP_ROCKET_VERSION' ) ) {
		require_once( $includes_path . 'compat/hs-wp-rocket-compat-functions.php' );
	}

	/* WP Fastest Cache */
	if ( class_exists( 'WpFastestCache' ) ) {
		require_once( $includes_path . 'compat/hs-wp-fastest-cache-compat-functions.php' );
	}

	/* Litespeed Cache */
	if ( class_exists( 'LiteSpeed_Cache' ) ) {
		require_once( $includes_path . 'compat/hs-litespeed-cache-compat-functions.php' );
	}

	/* Twenty Seventeen */
	if ( 'twentyseventeen' == wp_get_theme()->stylesheet ) {
		require_once( $includes_path . 'compat/hs-twentyseventeen-compat-functions.php' );
	}

	/* Ultimate Member */
	if ( class_exists( 'UM' ) ) {
		require_once( $includes_path . 'compat/hs-ultimate-member-compat-functions.php' );
	}

	/* GDPR Cookie Compliance */
	if ( function_exists( 'gdpr_cookie_is_accepted' ) ) {
		require_once( $includes_path . 'compat/hs-gdpr-cookie-compliance-compat-functions.php' );
	}

	/* WooCommerce */
	if ( defined( 'WC_PLUGIN_FILE' ) ) {
		require_once( $includes_path . 'compat/hs-woocommerce-compat-functions.php' );
	}

	/* Polylang */
	if ( defined( 'POLYLANG_VERSION' ) ) {
		new Hs_Polylang_Compat();
	}

	/* WPML */
	if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
		new Hs_WPML_Compat();
	}

	/* Permalink Manager */
	if ( defined( 'PERMALINK_MANAGER_PLUGIN_NAME' ) ) {
		require_once( $includes_path . 'compat/hs-permalink-manager-compat-functions.php' );
	}
}

/**
 * Add custom styles for certain themes.
 *
 * @since  1.6.29
 *
 * @return void
 */
function hs_compat_styles() {
	$styles = include( 'styles/inline-styles.php' );

	foreach ( $styles as $stylesheet => $custom_styles ) {
		wp_add_inline_style( $stylesheet, $custom_styles );
	}
}

add_action( 'wp_enqueue_scripts', 'hs_compat_styles', 20 );

/**
 * Change the default accent colour based on the current theme.
 *
 * @since  1.6.29
 *
 * @param  string $colour The default accent colour.
 * @return string
 */
function hs_compat_theme_highlight_colour( $colour ) {
	$colours    = include( 'styles/highlight-colours.php' );
	$stylesheet = strtolower( wp_get_theme()->stylesheet );

	if ( 'twentytwenty' === $stylesheet ) {
		return sanitize_hex_color( twentytwenty_get_color_for_area( 'content', 'accent' ) );
	}

	if ( 'divi' === $stylesheet ) {
		$stylesheet = 'divi-' . et_get_option( 'color_schemes', 'none' );
	}

	if ( array_key_exists( $stylesheet, $colours ) ) {
		return $colours[ $stylesheet ];
	}

	/* Return default colour. */
	return $colour;
}

add_filter( 'hs_default_highlight_colour', 'hs_compat_theme_highlight_colour' );

/**
 * Add button classes depending on the theme.
 *
 * @since  1.6.29
 *
 * @param  array  $classes The classes to add to the button by default.
 * @param  string $button  The specific button we're showing.
 * @return array
 */
function hs_compat_button_classes( $classes, $button ) {
	switch ( strtolower( wp_get_theme()->template ) ) {
		case 'divi':
			$classes[] = 'et_pb_button';
			break;
	}

	return $classes;
}

add_filter( 'hs_button_class', 'hs_compat_button_classes', 10, 2 );

/**
 * Enable locale functions in Hspg based on presence of other plugins.
 *
 * @since  1.6.43
 *
 * @param  boolean $locale_enabled Whether to enable locale functions.
 * @return boolean
 */
function hs_compat_load_locale_functions( $locale_enabled ) {
	/* We've already enabled locale functions. */
	if ( $locale_enabled ) {
		return $locale_enabled;
	}

	/* Polylang */
	if ( defined( 'POLYLANG_VERSION' ) ) {
		return true;
	}

	/* TranslatePress */
	if ( class_exists( 'TRP_Translate_Press' ) ) {
		return true;
	}

	return $locale_enabled;
}

add_filter( 'hs_enable_locale_functions', 'hs_compat_load_locale_functions' );
