<?php

namespace Akash\WpEmailer\Ajax;

use Akash\WpEmailer\Data\Data as DataManager;

/**
 * Ajax Data end-point class.
 *
 * @since 0.0.1
 */
class Data extends Ajax {

	/**
	 * Data manager.
	 *
	 * @since 0.0.1
	 *
	 * @var \Akash\WpEmailer\Data\Data
	 */
	public $data_manager;

	/**
	 * Class constructor.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		$this->data_manager = new DataManager();
		add_action( 'wp_ajax_wp_emailer_get_data', array( $this, 'get_data' ) );
	}

	/**
	 * Get data via ajax.
	 *
	 * @since 0.0.1
	 *
	 * @return void
	 */
	public function get_data() {
		$this->set_method( 'get' )
			->pre_checking_and_maybe_stop();

		$this->data_manager->set_user_id( $this->user_id );

		if ( $this->data_manager->is_hard_refreshing_data() ||
			! $this->data_manager->is_already_fetched_in_hour( $this->user_id )
		) {
			$data = $this->data_manager->get_remote_data_and_set_fetched_time();
			$this->response_success( $data, __( 'Data fetched successfully.', 'wp-emailer' ) );
		} else {
			// Otherwise send it from transient storage.
			$transient_data = $this->data_manager->get_data_from_transient();
			$data           = empty( $transient_data ) ? array() : $transient_data;
		}

		$this->response_success( $data, __( 'Data fetched successfully.', 'wp-emailer' ) );
	}
}
