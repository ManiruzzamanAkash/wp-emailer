<?php

namespace Akash\WpEmailer\Abstracts;

/**
 * Abstract setting validator class.
 *
 * @since 0.0.1
 */
abstract class AbstractSettingsValidator {

	/**
	 * Setting's item value.
	 *
	 * @since 0.0.1
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * Class constructor.
	 *
	 * @since 0.0.1
	 *
	 * @param mixed $value Setting item value.
	 */
	public function __construct( $value ) {
		$this->value = $value;
	}

	/**
	 * Validate Setting's item value.
	 *
	 * @since 0.0.1
	 *
	 * @return bool True if a valid item otherwise false.
	 */
	abstract public function validate(): bool;
}
