<?php

namespace Akash\WpEmailer\Tests\Ajax;

/**
 * Admin Ajax functions to be tested.
 */
require_once ABSPATH . 'wp-admin/includes/ajax-actions.php';

/**
 * Ajax Setting class test.
 *
 * @uses WP_Ajax_UnitTestCase Ajax Unit test case.
 *
 * @since WP_EMAILER_SINCE
 */
class SettingTest extends \WP_Ajax_UnitTestCase {

	public function test_update_settings() {
		global $_POST;

		// Become an administrator.
		$this->_setRole( 'administrator' );

		$_POST['key']      = 'numrows';
		$_POST['value']    = 2;
		$_POST['_wpnonce'] = wp_create_nonce( 'wp-emailer-nonce' );

		try {
			$this->_handleAjax( 'wp_emailer_update_setting' );
		} catch ( \WPAjaxDieStopException $e ) {
			unset( $e );
		}

		// Check that the exception was thrown.
		$this->assertNotTrue( isset( $e ) );
	}
}
