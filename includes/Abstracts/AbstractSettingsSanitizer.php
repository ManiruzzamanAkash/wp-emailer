<?php

namespace Akash\WpEmailer\Abstracts;

/**
 * Abstract setting sanitizer class.
 *
 * @since 0.0.1
 */
abstract class AbstractSettingsSanitizer {

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
	 * Get sanitized value.
	 *
	 * @since 0.0.1
	 *
	 * @return mixed
	 */
	abstract public function sanitize();
}
