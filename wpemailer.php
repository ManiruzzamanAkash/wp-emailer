<?php
/**
 * WpEmailer.
 *
 * @package Akash\Wp_Emailer
 * @author ManiruzzamanAkash <manirujjamanakash@gmail.com>
 * @license GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       WpEmailer
 * Description:       A WordPress plugin using Vue JS library to work with email settings.
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Version:           0.0.1
 * Author:            Maniruzzaman Akash<manirujjamanakash@gmail.com>
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-emailer
 */

defined( 'ABSPATH' ) || exit;

/**
 * Wp_Emailer App class.
 *
 * @class Wp_Emailer The class that holds the entire WpEmailer App plugin
 */
final class Wp_Emailer {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '0.0.1';

	/**
	 * Plugin slug.
	 *
	 * @var string
	 *
	 * @since WP_EMAILER_SINCE
	 */
	const SLUG = 'wp-emailer';

	/**
	 * Holds various class instances.
	 *
	 * @var array
	 *
	 * @since WP_EMAILER_SINCE
	 */
	private $container = array();

	/**
	 * Constructor for the Wp_Emailer class.
	 *
	 * Sets up all the appropriate hooks and actions within our plugin.
	 *
	 * @since WP_EMAILER_SINCE
	 */
	private function __construct() {
		require_once __DIR__ . '/vendor/autoload.php';

		$this->define_constants();

		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		$this->init_plugin();
	}

	/**
	 * Initializes the Wp_Emailer() class.
	 *
	 * Checks for an existing Wp_Emailer() instance
	 * and if it doesn't find one, creates it.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return Wp_Emailer|bool
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new Wp_Emailer();
		}

		return $instance;
	}

	/**
	 * Magic getter to bypass referencing plugin.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param string $prop class name.
	 *
	 * @return mixed
	 */
	public function __get( $prop ) {
		if ( array_key_exists( $prop, $this->container ) ) {
			return $this->container[ $prop ];
		}

		return $this->{$prop};
	}

	/**
	 * Magic isset to bypass referencing plugin.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param string $prop class name to access from container.
	 *
	 * @return mixed
	 */
	public function __isset( $prop ) {
		return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
	}

	/**
	 * Define the constants.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'WP_EMAILER_VERSION', self::VERSION );
		define( 'WP_EMAILER_SLUG', self::SLUG );
		define( 'WP_EMAILER_FILE', __FILE__ );
		define( 'WP_EMAILER_DIR', __DIR__ );
		define( 'WP_EMAILER_PATH', dirname( WP_EMAILER_FILE ) );
		define( 'WP_EMAILER_INCLUDES', WP_EMAILER_PATH . '/includes' );
		define( 'WP_EMAILER_TEMPLATE_PATH', WP_EMAILER_PATH . '/templates' );
		define( 'WP_EMAILER_URL', plugins_url( '', WP_EMAILER_FILE ) );
		define( 'WP_EMAILER_BUILD', WP_EMAILER_URL . '/build' );
		define( 'WP_EMAILER_ASSETS', WP_EMAILER_URL . '/assets' );
	}

	/**
	 * Load the plugin after all plugins are loaded.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function init_plugin() {
		$this->includes();
		$this->init_hooks();

		/**
		 * Fires after the plugin is loaded.
		 *
		 * @since WP_EMAILER_SINCE
		 */
		do_action( 'wp_emailer_loaded' );
	}

	/**
	 * Activating the plugin.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function activate() {
		// Run the installer to create necessary migrations and seeders.
		$this->install();
	}

	/**
	 * Placeholder for deactivation function.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function deactivate() {
	}

	/**
	 * Run the installer to create necessary migrations and seeders.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	private function install() {
		$installer = new \Akash\WpEmailer\Setup\Installer();
		$installer->run();
	}

	/**
	 * Include the required files.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function includes() {
		if ( $this->is_request( 'admin' ) ) {
			// Show this only if administrator role is enabled.
			$this->container['menu'] = new Akash\WpEmailer\Menu();
		}
	}

	/**
	 * Initialize the hooks.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function init_hooks() {
		// Init classes.
		add_action( 'init', array( $this, 'init_classes' ) );

		// Localize our plugin.
		add_action( 'init', array( $this, 'localization_setup' ) );

		// Register styles and scripts.
		add_action( 'init', array( $this, 'register_asset' ) );

		// Add the plugin page links.
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
	}

	/**
	 * Instantiate the required classes.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function init_classes() {
		$this->container['assets'] = new Akash\WpEmailer\Asset();
	}

	/**
	 * Initialize plugin for localization.
	 *
	 * @uses load_plugin_textdomain()
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function localization_setup() {
		load_plugin_textdomain( 'wp-emailer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Register all styles and scripts.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function register_asset() {
		wp_emailer()->assets->register_all_scripts();
		wp_emailer()->assets->localize_scripts();
	}

	/**
	 * What type of request is this.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param string $type admin, ajax, cron or frontend.
	 *
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();

			case 'ajax':
				return defined( 'DOING_AJAX' );

			case 'rest':
				return defined( 'REST_REQUEST' );

			case 'cron':
				return defined( 'DOING_CRON' );

			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Plugin action links
	 *
	 * @param array $links necessary links in plugin list page.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=wp-emailer#/settings' ) . '">' . __( 'Settings', 'wp-emailer' ) . '</a>';
		$links[] = '<a href="https://github.com/ManiruzzamanAkash/wp-emailer" target="_blank">' . __( 'Documentation', 'wp-emailer' ) . '</a>';

		return $links;
	}
}

/**
 * Initialize the main plugin.
 *
 * @since WP_EMAILER_SINCE
 *
 * @return \WP_Emailer|bool
 */
function wp_emailer() {
	return WP_Emailer::init();
}

/*
 * Kick-off the plugin.
 *
 * @since WP_EMAILER_SINCE
 */
wp_emailer();
