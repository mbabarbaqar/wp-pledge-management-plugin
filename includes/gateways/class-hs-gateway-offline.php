<?php
/**
 * Offline Payment Gateway
 *
 * @version		1.0.0
 * @package		Hspg/Classes/Hs_Gateway_Offline
 * @author 		Eric Daams
 * @copyright 	Copyright (c) 2020, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Gateway_Offline' ) ) :

	/**
	 * Offline Payment Gateway
	 *
	 * @since   1.0.0
	 */
	class Hs_Gateway_Offline extends Hs_Gateway {

		/**
		 * Gateway ID.
		 */
		const ID = 'offline';

		/**
		 * Whether the gateway supports Hspg 1.3.0.
		 *
		 * @var     boolean
		 * @since   1.3.0
		 */
		protected $supports_130 = false;

		/**
		 * Instantiate the gateway class, defining its key values.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {
			$this->name = apply_filters( 'hs_gateway_offline_name', __( 'Offline', 'hspg' ) );

			$this->defaults = array(
				'label' => __( 'Offline Donation', 'hspg' ),
				'instructions' => __( 'Thank you for your donation. We will contact you shortly for payment.', 'hspg' ),
			);

			$this->supports = array(
				'recurring',
				'1.3.0',
			);
		}

		/**
		 * Register gateway settings.
		 *
		 * @since   1.0.0
	 	*
		 * @param   array $settings
		 * @return  array
		 */
		public function gateway_settings( $settings ) {
			$settings['instructions'] = array(
				'type'      => 'textarea',
				'title'     => __( 'Instructions', 'hspg' ),
				'help'      => __( 'These are the instructions you provide to donors after they make a donation.', 'hspg' ),
				'priority'  => 6,
				'default'   => $this->defaults['instructions'],
			);

			return $settings;
		}

		/**
		 * Returns the current gateway's ID.
		 *
		 * @since   1.0.3
		 *
		 * @return  string
		 */
		public static function get_gateway_id() {
			return self::ID;
		}
	}

endif;
