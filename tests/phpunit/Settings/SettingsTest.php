<?php

namespace Akash\WpEmailer\Tests\Settings;

use Akash\WpEmailer\Exceptions\InvalidSettingException;

/**
 * Settings class test.
 *
 * @uses WP_UnitTestCase Settings Unit test case.
 *
 * @since WP_EMAILER_SINCE
 */
class SettingsTest extends \WP_UnitTestCase {

    /**
     * Settings class instance.
     *
     * @var \Akash\WpEmailer\Settings\Settings()
     */
    public $settings;

    /**
     * Setup test environment.
     */
    protected function setUp() : void {
        $this->settings = new \Akash\WpEmailer\Settings\Settings();
    }

    /**
     * Test getting default settings data as array key-value pair.
     *
     * @dataProvider dataProviderForGettingDefaultSettings
     *
     * @return void
     */
    public function test_get_default_settings( $actual, $expected ) {
        $this->assertEquals( $expected, $actual );
    }

    /**
     * Test save invalid settings key-value.
     *
     * @return void
     */
    public function test_save_invalid_setting_item() {
        $this->expectException( InvalidSettingException::class );
        $this->settings->set(
            array(
                'key'   => 'x',
                'value' => 'val'
            )
        );
    }

    /**
     * Test save valid setting item's key-value pair.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @dataProvider dataProviderForValidSettingItems
     *
     * @return void
     */
    public function test_save_valid_setting_item( $key, $value, $expected = true ) {
        $saved = $this->settings->set(
            array(
                'key'   => $key,
                'value' => $value
            )
        );

        if ( $expected ) {
            $this->assertTrue( $saved );
        } else {
            $this->assertNotTrue( $saved );
        }
    }

    public function test_automated_test_for_email_get_set() {
        $default = $this->settings->get_default();
        $this->assertEquals( $default['numrows'], 5);
        $this->assertEquals( $default['humandate'], 1 );
        $this->assertEquals( $default['emails'], [ get_option( 'admin_email' ) ] );

        $this->settings->set(
            array(
                'key'   => 'numrows',
                'value' => 2,
            )
        );

        $this->settings->set(
            array(
                'key'   => 'humandate',
                'value' => false,
            )
        );

        $this->settings->set(
            array(
                'key'   => 'emails',
                'value' => ['akash@example.com', 'jhondoe@example.com'],
            )
        );

        $final_settings = $this->settings->get();

        $this->assertEquals( $final_settings['numrows'], 2 );
        $this->assertEquals( $final_settings['humandate'], 0 );
        $this->assertEquals( $final_settings['emails'], ['akash@example.com', 'jhondoe@example.com'] );
    }

    public function dataProviderForGettingDefaultSettings(): array
    {
        // Check if Default settings.
        $settings = wp_emailer()->settings->get_default();

        return [
            'Default numrows would be 5' => [ $settings['numrows'], 5 ],
            'Is human date would be true' => [ $settings['humandate'], true ],
        ];
    }

    public function dataProviderForValidSettingItems(): array
    {
        return [
            'Numrows value 1 should be true' => [ 'numrows', 1 ],
            'Numrows value 5 should be true' => [ 'numrows', 5 ],

            'Humandate value 1 should be true' => [ 'humandate', 1 ],
            'Humandate value 0 should be true' => [ 'humandate', 0 ],
            'Humandate value "1" should be true' => [ 'humandate', "1" ],
            'Humandate value "0" should be true' => [ 'humandate', "0" ],
            'Humandate value "yes" should be true' => [ 'humandate', 'yes' ],
            'Humandate value "no" should be true' => [ 'humandate', 'no' ],
            'Humandate value true should be true' => [ 'humandate', true ],
            'Humandate value false should be true' => [ 'humandate', false ],

            'Valid emails should be true' => [ 'emails', ['akash@example.com'] ],
        ];
    }
}
