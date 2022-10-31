<?php

namespace Akash\WpEmailer\Settings;

use Akash\WpEmailer\Exceptions\InvalidSettingException;

/**
 * Settings class.
 *
 * @since 0.0.1
 */
class Settings {

	/**
	 * Settings data stored in DB.
	 *
	 * @since 0.0.1
	 *
	 * @var array
	 */
	public array $settings;

	/**
	 * Default Settings.
	 *
	 * @since 0.0.1
	 *
	 * @var array
	 */
	private array $default;

	/**
	 * Settings meta key which will be stored in options table.
	 *
	 * @since 0.0.1
	 */
	public const SETTING_META_KEY = 'test_project_option';

	/**
	 * Class constructor.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		$this->settings = array();
		$this->default  = apply_filters(
			'wp_emailer_default_settings',
			array(
				'numrows'   => 5,
				'humandate' => 1,
				'emails'    => array(
					get_option( 'admin_email' ),
				),
			)
		);
	}

	/**
	 * Get default settings.
	 *
	 * @since 0.0.1
	 *
	 * @return array
	 */
	public function get_default() {
		return $this->default;
	}

	/**
	 * Get all settings in key-value pair.
	 *
	 * @since 0.0.1
	 *
	 * @param string $key Settings key, optional, Pass to get a specific key settings value.
	 *
	 * @return array
	 */
	public function get( $key = null ) {
		$settings = get_option( self::SETTING_META_KEY );

		if ( ! empty( $key ) && in_array( $key, $settings, true ) ) {
			return $settings[ $key ];
		}

		return empty( $settings ) ? $this->default : $settings;
	}

	/**
	 * Set settings.
	 *
	 * @since 0.0.1
	 *
	 * @param array $settings Settings items.
	 *
	 * @return bool True if the value was updated, false otherwise.
	 *
	 * @throws InvalidSettingException If input is invalid.
	 */
	public function set( $settings = array() ) {
		$this->settings = $this->get();

		try {
			if ( is_array( $settings ) && count( $settings ) ) {

				// Single setting change.
				if ( ! isset( $settings['key'] ) && ! isset( $settings['value'] ) ) {
					throw new InvalidSettingException( __( 'Please provide key and value.', 'wp-emailer' ), 400 );
				}

				$settings_item = new SettingItem( $settings['key'], $settings['value'] );

				if ( $settings_item->is_valid() ) {
					// If same settings value is passed, then no need to process further.
					if ( $this->settings[ $settings['key'] ] === $settings_item->sanitize() ) {
						return true;
					}

					$this->settings[ $settings['key'] ] = $settings_item->sanitize();
				}
			}

			return update_option( self::SETTING_META_KEY, $this->settings );
		} catch ( InvalidSettingException $e ) {
			throw $e;
		}
	}
}
