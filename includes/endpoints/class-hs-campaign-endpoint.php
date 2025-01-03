<?php
/**
 * Campaign endpoint.
 *
 * @package   Hspg/Classes/Hs_Campaign_Endpoint
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Campaign_Endpoint' ) ) :

	/**
	 * Hs_Campaign_Endpoint
	 *
	 * @since 1.5.0
	 */
	class Hs_Campaign_Endpoint extends Hs_Endpoint {

		/** Endpoint ID. */
		const ID = 'campaign';

		/**
		 * Endpoint class constructor.
		 *
		 * @since 1.6.36
		 */
		public function __construct() {
			$this->comments_disabled = false;
		}

		/**
		 * Return the endpoint ID.
		 *
		 * @since  1.5.0
		 *
		 * @return string
		 */
		public static function get_endpoint_id() {
			return self::ID;
		}

		/**
		 * Return the endpoint URL.
		 *
		 * @since  1.5.0
		 *
		 * @global WP_Rewrite $wp_rewrite
		 * @param  array $args Mixed args.
		 * @return string
		 */
		public function get_page_url( $args = array() ) {
			$campaign_id = array_key_exists( 'campaign_id', $args ) ? $args['campaign_id'] : get_the_ID();

			return get_permalink( $campaign_id );
		}

		/**
		 * Return whether we are currently viewing the endpoint.
		 *
		 * @since  1.5.0
		 *
		 * @global WP_Query $wp_query
		 * @param  array $args Mixed arguments.
		 * @return boolean
		 */
		public function is_page( $args = array() ) {
			global $wp_query;

			if ( ! $wp_query->is_singular( Hspg::CAMPAIGN_POST_TYPE ) ) {
				return false;
			}

			return ! array_key_exists( 'donate', $wp_query->query_vars );
		}

		/**
		 * Return the template to display for this endpoint.
		 *
		 * @since  1.5.14
		 *
		 * @param  string $template The default template.
		 * @return string
		 */
		public function get_template( $template ) {
			$donation_id = get_query_var( 'donation_id', false );

			/* If a donation ID is included, make sure it belongs to the current user. */
			if ( $donation_id && ! hs_user_can_access_donation( $donation_id ) ) {
				wp_safe_redirect( hs_get_permalink( 'campaign_donation' ) );
				exit();
			}

			return $template;
		}

		/**
		 * Get the content to display for the endpoint.
		 *
		 * @since  1.5.0
		 *
		 * @param  string $content Default content.
		 * @return string
		 */
		public function get_content( $content ) {
			if ( ! hs_is_main_loop() ) {
				return $content;
			}

			/**
			 * If this is the donation form, and it's showing on a separate page, return the content.
			 */
			if ( hs_is_page( 'campaign_donation_page' ) ) {
				if ( 'separate_page' == hs_get_option( 'donation_form_display', 'separate_page' ) ) {
					return $content;
				}

				if ( false !== get_query_var( 'donate', false ) ) {
					return $content;
				}
			}

			/**
			 * If you do not want to use the default campaign template, use this filter and return false.
			 *
			 * @uses hs_use_campaign_template
			 */
			if ( ! apply_filters( 'hs_use_campaign_template', true ) ) {
				return $content;
			}

			/**
			 * Remove ourselves as a filter to prevent eternal recursion if apply_filters( 'the_content' )
			 * is called by one of the templates.
			 */
			remove_filter( 'the_content', array( hspg()->endpoints(), 'get_content' ) );

			ob_start();

			hs_template(
				'content-campaign.php',
				array(
					'content'  => $content,
					'campaign' => hs_get_current_campaign(),
				)
			);

			$content = ob_get_clean();

			add_filter( 'the_content', array( hspg()->endpoints(), 'get_content' ) );

			return $content;
		}

		/**
		 * Return the body class to add for the endpoint.
		 *
		 * @since  1.5.0
		 *
		 * @return string
		 */
		public function get_body_class() {
			return 'campaign-donation-page';
		}
	}

endif;
