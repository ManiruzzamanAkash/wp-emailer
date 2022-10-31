<?php

namespace Akash\WpEmailer\Data;

/**
 * Data class.
 *
 * @since WP_EMAILER_SINCE
 */
class Data {

	/**
	 * User id for whom data will be fetching.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @var integer
	 */
	public int $user_id;

	/**
	 * Data end-point URL.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @var string
	 */
	public const DATA_URL = 'https://miusage.com/v1/challenge/2/static/';

	/**
	 * Data fetched at key.
	 */
	public const DATA_FETCHED_AT_KEY = 'wp_emailer_last_fetched_time';

	/**
	 * Data fetched at key.
	 */
	public const DATA_TRANSIENT_KEY = 'wp_emailer_data';

	/**
	 * Class constructor.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param int $user_id User id.
	 */
	public function __construct( $user_id = 0 ) {
		$this->user_id = $user_id;
	}

	/**
	 * Set user id.
	 *
	 * @param int $user_id User id.
	 *
	 * @return self
	 */
	public function set_user_id( $user_id ) {
		$this->user_id = $user_id;

		return $this;
	}

	/**
	 * Check If data is forcefully getting by refresh button.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return boolean
	 */
	public function is_hard_refreshing_data() {
		return isset( $_GET['refresh'] ) && absint( wp_unslash( $_GET['refresh'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
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
		return $this->get_remote_data();
	}

	/**
	 * Get remote data.
	 *
	 * @return array
	 */
	public function get_remote_data() {
		$response = wp_remote_get( self::DATA_URL );

		if ( is_wp_error( $response ) ) {
			return array(
				'table' => array(),
				'graph' => array(),
			);
		}

		$data = wp_remote_retrieve_body( $response );

		$encoded_data = json_decode( $data, true );

		$this->update_last_fetched_at();
		$this->store_data_in_transient( $encoded_data );

		return $encoded_data;
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
	 * Store list data in transient.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param array $value Stored value.
	 *
	 * @return void
	 */
	public function store_data_in_transient( $value ) {
		set_transient( self::DATA_TRANSIENT_KEY, $value, HOUR_IN_SECONDS );
	}

	/**
	 * Get data from transient.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return array|null
	 */
	public function get_data_from_transient() {
		return get_transient( self::DATA_TRANSIENT_KEY );
	}
}
