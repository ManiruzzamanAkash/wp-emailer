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
		add_action( 'init', array( $this, 'register_all_scripts' ), 10 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
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
				'version' => WP_EMAILER_VERSION,
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
				'version'   => filemtime( WP_EMAILER_DIR . '/js/main.js' ),
				'deps'      => array(),
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
	 * @since WP_EMAILER_SINCE Loads the JS and CSS only on the Job Place admin page.
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
}
