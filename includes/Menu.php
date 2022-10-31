<?php

namespace Akash\WpEmailer;

/**
 * Menu generator class.
 *
 * Ensure admin menu registrations.
 *
 * @since WP_EMAILER_SINCE
 */
class Menu {

	/**
	 * Constructor.
	 *
	 * @since WP_EMAILER_SINCE
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'init_menu' ) );
	}

	/**
	 * Init Menu.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function init_menu() {
		global $submenu;

		$slug          = WP_EMAILER_SLUG;
		$menu_position = 50;
		$capability    = 'manage_options';
		$page_url      = admin_url( 'admin.php?page=wp-emailer' );

		add_menu_page( esc_attr__( 'WP Emailer', 'wp-emailer' ), esc_attr__( 'WP Emailer', 'wp-emailer' ), $capability, $slug, array( $this, 'plugin_page' ), 'dashicons-email', $menu_position );

		// Register this only for Administrator user.
		if ( current_user_can( $capability ) ) {
			$submenu[ $slug ][] = array( esc_attr__( 'Settings', 'wp-emailer' ), $capability, $page_url . '#/' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$submenu[ $slug ][] = array( esc_attr__( 'Top Pages', 'wp-emailer' ), $capability, $page_url . '#/list' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			$submenu[ $slug ][] = array( esc_attr__( 'Graph', 'wp-emailer' ), $capability, $page_url . '#/graph' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		}
	}

	/**
	 * Render the plugin page.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function plugin_page() {
		require_once WP_EMAILER_TEMPLATE_PATH . '/app.php';
	}
}
