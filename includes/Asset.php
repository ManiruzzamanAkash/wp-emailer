<?php

namespace Akash\WpEmailer;

/**
 * Asset Manager class.
 *
 * Responsible for managing all of the assets (CSS, JS, Images, Locales).
 */
class Asset {

	/**
	 * Constructor.
	 *
	 * @since WP_EMAILER_SINCE
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ), 11 );
	}

	/**
	 * Register all scripts and styles.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function register_all_scripts() {
		$this->register_styles( $this->get_styles() );
		$this->register_scripts( $this->get_scripts() );
	}

	/**
	 * Get all styles.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return array
	 */
	public function get_styles(): array {
		return array(
			'wp-emailer-css' => array(
				'src'     => WP_EMAILER_ASSETS . '/css/main.css',
				'version' => filemtime( WP_EMAILER_DIR . '/assets/css/main.css' ),
				'deps'    => array(),
			),
		);
	}

	/**
	 * Get all scripts.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return array
	 */
	public function get_scripts(): array {
		return array(
			'wp-emailer-js' => array(
				'src'       => WP_EMAILER_ASSETS . '/js/main.js',
				'version'   => filemtime( WP_EMAILER_DIR . '/assets/js/main.js' ),
				'deps'      => array( 'jquery' ),
				'in_footer' => true,
			),
		);
	}

	/**
	 * Register styles.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param array $styles Array of styles.
	 *
	 * @return void
	 */
	public function register_styles( array $styles ) {
		foreach ( $styles as $handle => $style ) {
			wp_register_style( $handle, $style['src'], $style['deps'], $style['version'] );
		}
	}

	/**
	 * Register scripts.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param array $scripts Array of scripts.
	 *
	 * @return void
	 */
	public function register_scripts( array $scripts ) {
		foreach ( $scripts as $handle => $script ) {
			wp_register_script( $handle, $script['src'], $script['deps'], $script['version'], $script['in_footer'] );
		}
	}

	/**
	 * Enqueue admin styles and scripts.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function enqueue_admin_assets() {
		// Check if we are on the admin page and page=wp-emailer.
		if ( ! is_admin() || ! isset( $_GET['page'] ) || sanitize_text_field( wp_unslash( $_GET['page'] ) ) !== 'wp-emailer' ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return;
		}

		wp_enqueue_style( 'wp-emailer-css' );
		wp_enqueue_script( 'wp-emailer-js' );
	}

	/**
	 * Localize scripts.
	 *
	 * @return void
	 */
	public function localize_scripts() {
		$user = wp_get_current_user();

		wp_localize_script(
			'wp-emailer-js',
			'wpEmailer',
			array(
				'user'     => array(
					'id'        => $user->ID,
					'name'      => $user->display_name,
					'username'  => $user->user_login,
					'email'     => $user->user_email,
					'avatar'    => get_avatar_url( $user->ID ),
					'adminUrl'  => admin_url( 'profile.php' ),
					'logoutUrl' => wp_logout_url(),
				),
				'site'     => array(
					'admin_url' => admin_url( 'admin.php' ),
					'name'      => get_bloginfo( 'name' ),
					'url'       => get_site_url(),
					'logo'      => get_site_icon_url(),
					'base_url'  => $this->get_router_base_url( admin_url( 'admin.php' ) . '?page = wp-emailer' ),
				),
				'nonce'    => wp_create_nonce( 'wp-emailer-nonce' ),
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	/**
	 * Get router base url.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param string $admin_page_url Admin page URL.
	 *
	 * @return string
	 */
	public function get_router_base_url( $admin_page_url ) {
		$url_with_domain = substr( $admin_page_url, strpos( $admin_page_url, '//' ) + 2 );
		return substr( $url_with_domain, strpos( $url_with_domain, '/' ) + 1 ) . '#';
	}
}
