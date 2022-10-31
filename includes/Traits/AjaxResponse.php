<?php

namespace Akash\WpEmailer\Traits;

/**
 * AjaxResponse trait.
 *
 * This trait is used to response generation for AJAX endpoints.
 */
trait AjaxResponse {

	/**
	 * Send JSON success response.
	 *
	 * @since 0.0.1
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
	 * @since 0.0.1
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
