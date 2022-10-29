<?php

namespace Akash\WpEmailer\Settings;

use Akash\WpEmailer\Exceptions\InvalidSettingException;
use Akash\WpEmailer\Settings\Sanitizer\EmailsSanitizer;
use Akash\WpEmailer\Settings\Sanitizer\HumanDateSanitizer;
use Akash\WpEmailer\Settings\Sanitizer\NumrowsSanitizer;
use Akash\WpEmailer\Settings\Validator\EmailsValidator;
use Akash\WpEmailer\Settings\Validator\HumanDateValidator;
use Akash\WpEmailer\Settings\Validator\NumrowsValidator;

/**
 * SettingItem class.
 *
 * Handle settings.
 */
class SettingItem {

	/**
	 * Settings key name.
	 *
	 * @var string
	 */
	public string $key;

	/**
	 * Settings key value.
	 *
	 * @var mixed
	 */
	public $value;

	/**
	 * Class constructor.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param string $key   Setting item key name.
	 * @param mixed  $value Setting item value.
	 */
	public function __construct( $key, $value ) {
		$this->key   = $key;
		$this->value = $value;
	}

	/**
	 * Is Valid setting item.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return bool True if the value was updated, false otherwise.
	 *
	 * @throws InvalidSettingException If not valid.
	 */
	public function is_valid() {
		if ( ! $this->is_key_in_settings( $this->key ) ) {
			throw new InvalidSettingException( __( 'Setting\'s item not found.', 'wp-emailer' ), 400 );
		}

		if ( ! $this->is_valid_value( $this->key, $this->value ) ) {
			throw new InvalidSettingException( __( 'Setting\'s item value is invalid.', 'wp-emailer' ), 400 );
		}

		return true;
	}

	/**
	 * Is key in the list of settings.
	 *
	 * @return bool
	 */
	public function is_key_in_settings() {
		$default_settings = wp_emailer()->settings->get_default();

		return in_array( $this->key, array_keys( $default_settings ), true );
	}

	/**
	 * Is setting's item value is valid.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return bool True if the value was updated, false otherwise.
	 */
	public function is_valid_value() {
		switch ( $this->key ) {
			case 'numrows':
				return ( new NumrowsValidator( $this->value ) )->validate();

			case 'humandate':
				return ( new HumanDateValidator( $this->value ) )->validate();

			case 'emails':
				return ( new EmailsValidator( $this->value ) )->validate();

			default:
				return false;
		}
	}

	/**
	 * Sanitize and return settings item.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return mixed Sanitized value.
	 */
	public function sanitize() {
		switch ( $this->key ) {
			case 'numrows':
				return ( new NumrowsSanitizer( $this->value ) )->sanitize();

			case 'humandate':
				return ( new HumanDateSanitizer( $this->value ) )->sanitize();

			case 'emails':
				return ( new EmailsSanitizer( $this->value ) )->sanitize();

			default:
				return '';
		}
	}
}
