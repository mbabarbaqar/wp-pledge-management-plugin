<?php
/**
 * Donors shortcode class.
 *
 * @package   Hspg/Shortcodes/Donors
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.5.7
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Donors_Shortcode' ) ) :

	/**
	 * Hs_Donors_Shortcode class.
	 *
	 * @since   1.5.0
	 */
	class Hs_Donors_Shortcode {

		/**
		 * Display the shortcode output. This is the callback method for the donors shortcode.
		 *
		 * @since  1.5.0
		 *
		 * @param  array $atts The user-defined shortcode attributes.
		 * @return string
		 */
		public static function display( $atts ) {
			$default = array(
				'number'            => 10,
				'orderby'           => 'date',
				'order'             => 'DESC',
				'campaign'          => 0,
				'distinct_donors'   => 0,
				'orientation'       => 'horizontal',
				'show_name'         => 1,
				'show_location'     => 0,
				'show_amount'       => 1,
				'show_avatar'       => 1,
				'hide_if_no_donors' => 0,
			);

			$args           = shortcode_atts( $default, $atts, 'hs_donors' );
			$args['donors'] = self::get_donors( $args );

			/**
			 * Replace the default template with your own.
			 *
			 * If you replace the template with your own, it needs to be an instance of Hs_Template.
			 *
			 * @since  1.5.0
			 *
			 * @param  false|Hs_Template The template. If false (the default), we will use our own template.
			 * @param  array $args               All the parsed arguments.
			 * @return false|Hs_Template
			 */
			$template = apply_filters( 'hs_donors_shortcode_template', false, $args );

			/* Fall back to default Hs_Template if no template returned or if template was not object of 'Hs_Template' class. */
			if ( ! is_object( $template ) || ! is_a( $template, 'Hs_Template' ) ) {
				$template = new Hs_Template( 'donor-loop.php', false );
			}

			if ( ! $template->template_file_exists() ) {
				return false;
			}

			/**
			 * Modify the view arguments that are passed to the donors template.
			 *
			 * @since  1.5.0
			 *
			 * @param  array $view_args The arguments to pass.
			 * @param  array $args      All the parsed arguments.
			 * @return array
			 */
			$view_args = apply_filters(
				'hs_donors_shortcode_view_args',
				hs_array_subset(
					$args,
					array(
						'donors',
						'number',
						'orderby',
						'order',
						'campaign',
						'orientation',
						'distinct_donors',
						'show_name',
						'show_location',
						'show_amount',
						'show_avatar',
						'hide_if_no_donors',
					)
				),
				$args
			);

			$template->set_view_args( $view_args );

			ob_start();

			$template->render();

			/**
			 * Customize the output of the shortcode.
			 *
			 * @since  1.5.0
			 *
			 * @param  string $content The content to be displayed.
			 * @param  array  $args    All the parsed arguments.
			 * @return string
			 */
			return apply_filters( 'hs_donors_shortcode', ob_get_clean(), $args );
		}

		/**
		 * Return donors to display in the donors shortcode.
		 *
		 * @since  1.5.0
		 *
		 * @param  array $args The query arguments to be used to retrieve donors.
		 * @return Hs_Donor_Query
		 */
		public static function get_donors( $args ) {
			/**
			 * Filter the arguments passed to Hs_Donor_Query.
			 *
			 * @since  1.5.0
			 *
			 * @param  array $query_args The arguments to be passed to Hs_Donor_Query::__construct.
			 * @param  array $args       All the parsed arguments.
			 * @return array
			 */
			$query_args = apply_filters( 'hs_donors_shortcode_donor_query_args',
				hs_array_subset( $args, array( 'number', 'orderby', 'order', 'campaign', 'distinct_donors' ) ),
				$args
			);

			return new Hs_Donor_Query( $query_args );
		}
	}

endif;
