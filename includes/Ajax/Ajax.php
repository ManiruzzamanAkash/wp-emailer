<?php

namespace Akash\WpEmailer\Ajax;

/**
 * Ajax end-points class.
 *
 * @since WP_EMAILER_SINCE
 */
class Ajax {

	/**
	 * Ajax method type.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @var string
	 */
	public string $method;

	/**
	 * Class constructor.
	 *
	 * @since WP_EMAILER_SINCE
	 */
	public function __construct() {
		$this->method = 'post';
	}

	/**
	 * Set method.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param string $method Method name.
	 *
	 * @return self
	 */
	public function set_method( $method ) {
		$this->method = strtolower( $method );

		return $this;
	}

	/**
	 * Checks pre-checking before running any ajax-endpoint.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	protected function pre_checking_and_maybe_stop() {
		$this->verify_nonce();
		$this->check_administrator_permission();
	}

	/**
	 * Verify nonce for get and post method.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	protected function verify_nonce() {
		if ( 'post' === $this->method ) {
			if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ), 'wp-emailer-nonce' ) ) {
				$this->response_error(
					__( 'Nonce verification failed.', 'wp-emailer' )
				);
			}
			return;
		}

		if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'wp-emailer-nonce' ) ) {
			$this->response_error(
				__( 'Nonce verification failed.', 'wp-emailer' )
			);
		}
	}

	/**
	 * Check if user has administrator permission.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	protected function check_administrator_permission() {
		if ( ! current_user_can( 'manage_options' ) ) {
			$this->response_error(
				__( 'You are not authorized to do this action.', 'wp-emailer' ),
				401
			);
		}
	}

	/**
	 * Send JSON success response.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param mixed   $data        Response data.
	 * @param string  $message     Response message.
	 * @param integer $status_code Response status code.
	 *
	 * @return void
	 */
	protected function response_success( $data = null, $message = 'Response successful.', $status_code = 200 ) {
		wp_send_json_success(
			array(
				'message' => $message,
				'data'    => $data,
			),
			$status_code
		);

		wp_die();
	}

	/**
	 * Send JSON error response.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param string  $message     Response message.
	 * @param integer $status_code Response status code.
	 * @param array   $errors      Response errors if any.
	 *
	 * @return void
	 */
	protected function response_error( $message = 'Failed to process.', $status_code = 400, $errors = array() ) {
		wp_send_json_error(
			array(
				'message' => $message,
				'errors'  => $errors,
			),
			$status_code
		);

		wp_die();
	}
}
