<?php

namespace Akash\WpEmailer\Tests\Settings;

use Akash\WpEmailer\Exceptions\InvalidSettingException;
use Akash\WpEmailer\Settings\SettingItem;

/**
 * Setting Item class test.
 *
 * @uses WP_UnitTestCase Settings Unit test case.
 *
 * @since WP_EMAILER_SINCE
 */
class SettingItemTest extends \WP_UnitTestCase {

	/**
	 * Test if is key in settings.
	 *
	 * @return void
	 */
	public function test_is_key_in_settings() {
		$setting_item = new SettingItem( 'test', 'Test value' );
		$this->assertNotTrue( $setting_item->is_key_in_settings() );

		$setting_item2 = new SettingItem( 'numrows', 1 );
		$this->assertTrue( $setting_item2->is_key_in_settings() );
	}

	/**
	 * Test if is valid value for the key for numrows.
	 *
	 * @return void
	 */
	public function test_is_valid_value_numrows() {
		$setting_item = new SettingItem( 'test', 'Test value' );
		$this->assertNotTrue( $setting_item->is_valid_value() );

		$setting_item = new SettingItem( 'numrows', 0 );
		$this->assertNotTrue( $setting_item->is_valid_value() );

		$setting_item = new SettingItem( 'numrows', 1 );
		$setting_item = new SettingItem( 'numrows', 2 );
		$setting_item = new SettingItem( 'numrows', 3 );
		$setting_item = new SettingItem( 'numrows', 4 );
		$setting_item = new SettingItem( 'numrows', 5 );
		$this->assertTrue( $setting_item->is_valid_value() );
		$this->assertTrue( $setting_item->is_valid_value() );
		$this->assertTrue( $setting_item->is_valid_value() );
		$this->assertTrue( $setting_item->is_valid_value() );
		$this->assertTrue( $setting_item->is_valid_value() );

		$setting_item = new SettingItem( 'numrows', 6 );
		$this->assertNotTrue( $setting_item->is_valid_value() );
	}

	/**
	 * Test if is valid value for the key for human date switch-box.
	 *
	 * @return void
	 */
	public function test_is_valid_value_humandate() {
		$setting_item = new SettingItem( 'humandate', 0 );
		$this->assertTrue( $setting_item->is_valid_value() );

		$setting_item = new SettingItem( 'humandate', 1 );
		$this->assertTrue( $setting_item->is_valid_value() );

		$setting_item = new SettingItem( 'humandate', true );
		$this->assertTrue( $setting_item->is_valid_value() );

		$setting_item = new SettingItem( 'humandate', false );
		$this->assertTrue( $setting_item->is_valid_value() );

		$setting_item = new SettingItem( 'humandate', 2 );
		$this->assertNotTrue( $setting_item->is_valid_value() );
	}

	/**
	 * Test if is valid value for the key for emails.
	 *
	 * @return void
	 */
	public function test_is_valid_value_emails() {
		$setting_item = new SettingItem( 'emails', null );
		$this->assertNotTrue( $setting_item->is_valid_value() );

		// We allow no emails.
		$setting_item = new SettingItem( 'emails', [] );
		$this->assertTrue( $setting_item->is_valid_value() );

		$emails = [
			'a@example.com',
			'b@example.com',
			'c@example.com',
			'd@example.com',
			'e@example.com',
			'6themail@example.com'
		];

		// length not match, max length is 5;
		$setting_item = new SettingItem( 'emails', $emails );
		$this->assertNotTrue( $setting_item->is_valid_value() );

		// check by giving 5 emails.
		array_pop($emails);
		$setting_item = new SettingItem( 'emails', $emails );
		$this->assertTrue( $setting_item->is_valid_value() );

		// check by giving 1 invalid email.
		$emails = ['x@'];
		$setting_item = new SettingItem( 'emails', $emails );
		$this->assertNotTrue( $setting_item->is_valid_value() );

		// Giving empty invalid email.
		$emails = [''];
		$setting_item = new SettingItem( 'emails', $emails );
		$this->assertNotTrue( $setting_item->is_valid_value() );
	}

	/**
	 * Test if is valid value for the key for emails.
	 *
	 * @return void
	 */
	public function test_get_sanitized_data() {
		$setting_item = new SettingItem( 'numrows', '1' );
		$this->assertEquals( $setting_item->sanitize(), 1 );

		$setting_item = new SettingItem( 'humandate', '1' );
		$this->assertEquals( $setting_item->sanitize(), true );

		$setting_item = new SettingItem( 'humandate', '0' );
		$this->assertEquals( $setting_item->sanitize(), false );

		$setting_item = new SettingItem( 'humandate', 'yes' );
		$this->assertEquals( $setting_item->sanitize(), true );

		$setting_item = new SettingItem( 'humandate', 'no' );
		$this->assertEquals( $setting_item->sanitize(), false );

		$setting_item = new SettingItem( 'emails', ['akash<script>alert("test-alert")</script>'] );
		$this->assertEquals( $setting_item->sanitize(), [] );

		$setting_item = new SettingItem( 'emails', ['akash<script>alert("test-alert")</script>', 'akash@example.com'] );
		$this->assertContainsEquals( 'akash@example.com', $setting_item->sanitize() );
	}
}
