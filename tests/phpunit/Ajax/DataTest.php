<?php

namespace Akash\WpEmailer\Tests\Ajax;

/**
 * Ajax Data class test.
 *
 * @uses WP_UnitTestCase Unit test case.
 *
 * @since WP_EMAILER_SINCE
 */
class DataTest extends \WP_UnitTestCase {

	/**
	 * Data class instance.
	 *
	 * @var \Akash\WpEmailer\Ajax\Data()
	 */
	public $data;

	/**
	 * Data Manager class instance.
	 *
	 * @var \Akash\WpEmailer\Data\Data()
	 */
	public $data_manager;

	/**
	 * Setup test environment.
	 */
	protected function setUp() : void {
		$this->data          = new \Akash\WpEmailer\Ajax\Data();
		$this->data_manager  = new \Akash\WpEmailer\Data\Data( 1 );
		$this->data->user_id = 1;

		delete_user_meta( $this->data->user_id, $this->data_manager::DATA_FETCHED_AT_KEY );
	}

	/**
	 * Test if data is already fetched in hour.
	 *
	 * @return void
	 */
	public function test_is_already_fetched_in_hour() {
		// First time fetched, should return false.
		$this->assertFalse( $this->data_manager->is_already_fetched_in_hour() );

		// Get remote data and check again if is already fetched in hour true.
		$this->data_manager->get_remote_data_and_set_fetched_time();

		$this->assertTrue( $this->data_manager->is_already_fetched_in_hour() );
	}

	/**
	 * Test remote end-point api.
	 *
	 * @return void
	 */
	public function test_get_remote_data() {
		// Test to get remote data-endpoint
		$response = $this->data_manager->get_remote_data();

		$this->assertNotEmpty( $response['graph'] );
		$this->assertNotEmpty( $response['table'] );
	}

	/**
	 * Get and fetched data.
	 *
	 * @return void
	 */
	public function test_get_data() {
		$this->assertFalse( $this->data_manager->is_already_fetched_in_hour() );
		$this->assertFalse( $this->data_manager->is_hard_refreshing_data() );

		if ( $this->data_manager->is_hard_refreshing_data() ||
			! $this->data_manager->is_already_fetched_in_hour()
		) {
			$data = $this->data_manager->get_remote_data_and_set_fetched_time();

			$this->assertArrayHasKey( 'graph', $data );
			$this->assertArrayHasKey( 'table', $data );

			// Check if there is valid graph data.
			$this->assertIsArray( $data['graph'] );
			$this->assertCount( 7, $data['graph'] );

			// Check if there is valid table data.
			$this->assertEquals( $data['table']['title'], 'Top Pages' );
			$this->assertIsArray( $data['table']['data']['headers'] );
			$this->assertIsArray( $data['table']['data']['rows'] );

			$this->assertCount( 5, $data['table']['data']['headers'] );
			$this->assertCount( 5, $data['table']['data']['rows'] );
		}
	}
}
