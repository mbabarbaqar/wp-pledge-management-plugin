<?php
/**
 * Hspg Install class.
 *
 * The responsibility of this class is to manage the events that need to happen
 * when the plugin is activated.
 *
 * @package   Hspg/Class/Hspg Install
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.6.42
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hs_Install' ) ) :

	/**
	 * Hs_Install
	 *
	 * @since  1.0.0
	 */
	class Hs_Install {

		/**
		 * Includes directory path.
		 *
		 * @since 1.6.42
		 *
		 * @var   string
		 */
		private $includes_path;

		/**
		 * Install the plugin.
		 *
		 * @since 1.0.0
		 *
		 * @param string $includes_path Path to the includes directory.
		 */
		public function __construct( $includes_path ) {
			$this->includes_path = $includes_path;

			$this->setup_roles();
			$this->create_tables();
			$this->setup_upgrade_log();

			set_transient( 'hs_install', 1, 0 );
		}

		/**
		 * Finish the plugin installation.
		 *
		 * @since  1.3.4
		 *
		 * @return void
		 */
		public static function finish_installing() {
			Hs_Cron::schedule_events();

			add_action( 'init', 'flush_rewrite_rules' );
		}

		/**
		 * Create wp roles and assign capabilities
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		protected function setup_roles() {
			require_once( $this->includes_path . '/users/class-hs-roles.php' );
			$roles = new Hs_Roles();
			$roles->add_roles();
			$roles->add_caps();
		}

		/**
		 * Create database tables.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		protected function create_tables() {
			require_once( $this->includes_path . 'abstracts/abstract-class-hs-db.php' );

			$tables = array(
				$this->includes_path . 'data/class-hs-donors-db.php'             => 'Hs_Donors_DB',
				$this->includes_path . 'data/class-hs-donormeta-db.php'          => 'Hs_Donormeta_DB',
				$this->includes_path . 'data/class-hs-campaign-donations-db.php' => 'Hs_Campaign_Donations_DB',
			);

			foreach ( $tables as $file => $class ) {
				require_once( $file );
				$table = new $class;
				$table->create_table();
			}
		}

		/**
		 * Set up the upgrade log.
		 *
		 * @since  1.3.0
		 *
		 * @return void
		 */
		protected function setup_upgrade_log() {
			require_once( $this->includes_path . '/admin/upgrades/class-hs-upgrade.php' );
			Hs_Upgrade::get_instance()->populate_upgrade_log_on_install();
		}
	}

endif;
