<?php

namespace Akash\WpEmailer\Abstracts;

/**
 * Abstract setting validator class.
 *
 * @since WP_EMAILER_SINCE
 */
abstract class AbstractSettingsValidator {

	/**
	 * Setting's item value.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * Class constructor.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @param mixed $value Setting item value.
	 */
	public function __construct( $value ) {
		$this->value = $value;
	}

	/**
	 * Validate Setting's item value.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return bool True if a valid item otherwise false.
	 */
	abstract public function validate(): bool;
}
