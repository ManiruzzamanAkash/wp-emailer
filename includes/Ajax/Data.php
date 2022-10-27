<?php

namespace Akash\WpEmailer\Ajax;

/**
 * Ajax Data end-point class.
 *
 * @since WP_EMAILER_SINCE
 */
class Data extends Ajax {

	/**
	 * Data end-point.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @var string
	 */
	public string $url;

	/**
	 * Current user id
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @var integer
	 */
	public int $user_id;

	/**
	 * Data fetched at key.
	 */
	public const DATA_FETCHED_AT_KEY = 'wp_emailer_last_fetched_time';

	/**
	 * Class constructor.
	 *
	 * @since WP_EMAILER_SINCE
	 */
	public function __construct() {
		$this->url     = 'https://miusage.com/v1/challenge/2/static/';
		$this->user_id = get_current_user_id();

		add_action( 'wp_ajax_wp_emailer_get_data', array( $this, 'get_data' ) );
	}

	/**
	 * Get data via ajax.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function get_data() {
		$this->set_method( 'get' )
			->pre_checking_and_maybe_stop();

		if ( $this->is_fetching_data_for_graph() ||
			! $this->is_already_fetched_in_hour()
		) {
			$data = $this->get_remote_data_and_set_fetched_time();
			$this->response_success( $data, 'Data fetched successfully.' );
		}

		$this->response_error( 'Data is already fetched in an hour. Please request later.' );
	}

	/**
	 * Check If data is forcefully getting for the graph.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return boolean
	 */
	public function is_fetching_data_for_graph() {
		return isset( $_GET['graph'] ) && boolval( wp_unslash( $_GET['graph'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}

	/**
	 * Check if data is already fetched once in an hour.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return bool
	 */
	public function is_already_fetched_in_hour() {
		$last_fetched_time = get_user_meta( $this->user_id, self::DATA_FETCHED_AT_KEY, true );

		// If last fetched time is empty, means user doesn't try yet.
		if ( empty( $last_fetched_time ) ) {
			return false;
		}

		$last_fetched_time_diff_in_seconds = current_datetime()->getTimestamp() - absint( $last_fetched_time );

		return $last_fetched_time_diff_in_seconds < 3600;
	}

	/**
	 * Get remote data and update fetched at time.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return array
	 */
	public function get_remote_data_and_set_fetched_time() {
		$this->update_last_fetched_at();

		return $this->get_remote_data();
	}

	/**
	 * Update last fetched at meta data for user.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function update_last_fetched_at() {
		update_user_meta( $this->user_id, self::DATA_FETCHED_AT_KEY, current_datetime()->getTimestamp() );
	}

	/**
	 * Get remote data.
	 *
	 * @return array
	 */
	public function get_remote_data() {
		$response = wp_remote_get( $this->url );

		if ( is_wp_error( $response ) ) {
			return array(
				'table' => array(),
				'graph' => array(),
			);
		}

		$data = wp_remote_retrieve_body( $response );

		return json_decode( $data, true );
	}
}
