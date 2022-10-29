<?php

namespace Akash\WpEmailer\Ajax;

use Exception;

/**
 * Ajax Settings end-points class.
 *
 * @since WP_EMAILER_SINCE
 */
class Settings extends Ajax {

	/**
	 * Class constructor.
	 *
	 * @since WP_EMAILER_SINCE
	 */
	public function __construct() {
		add_action( 'wp_ajax_wp_emailer_get_settings', array( $this, 'get_settings' ) );
		add_action( 'wp_ajax_wp_emailer_update_setting', array( $this, 'update_setting' ) );
	}

	/**
	 * Get settings data.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function get_settings() {
		$this->set_method( 'get' )
			->pre_checking_and_maybe_stop();

		$settings = wp_emailer()->settings->get();

		$this->response_success( $settings, 'Settings data fetched successfully.' );

		wp_die();
	}

	/**
	 * Update settings data.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function update_setting() {
		$this->set_method( 'post' )
			->pre_checking_and_maybe_stop();

		if ( ! isset( $_POST['key'] ) || ! isset( $_POST['value'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$this->response_error( 'Please provide key and value.', 400 );
		}

		try {
			$settings = wp_emailer()->settings->set(
				array(
					'key'   => sanitize_text_field( wp_unslash( $_POST['key'] ) ), // phpcs:ignore WordPress.Security.NonceVerification.Missing
					'value' => map_deep( wp_unslash( $_POST['value'] ), 'sanitize_text_field' ), // phpcs:ignore WordPress.Security.NonceVerification.Missing
				)
			);

			$this->response_success( $settings, 'Settings data updated successfully.' );
		} catch ( Exception $e ) {
			$this->response_error( $e->getMessage(), $e->getCode() );
		}

		wp_die();
	}
}
