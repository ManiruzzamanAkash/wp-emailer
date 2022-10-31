<?php

namespace Akash\WpEmailer\Ajax;

use Akash\WpEmailer\Traits\AjaxResponse;

/**
 * Ajax end-points class.
 *
 * @since 0.0.1
 */
class Ajax {

	use AjaxResponse;

	/**
	 * Current user id
	 *
	 * @since 0.0.1
	 *
	 * @var integer
	 */
	public int $user_id;

	/**
	 * Ajax method type.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	protected string $method;

	/**
	 * Class constructor.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		$this->method = 'post';
	}

	/**
	 * Set method.
	 *
	 * @since 0.0.1
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
	 * @since 0.0.1
	 *
	 * @return void
	 */
	protected function pre_checking_and_maybe_stop() {
		$this->verify_nonce();
		$this->check_administrator_permission();
		$this->user_id = get_current_user_id();
	}

	/**
	 * Verify nonce for get and post method.
	 *
	 * @since 0.0.1
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
	 * @since 0.0.1
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
}
