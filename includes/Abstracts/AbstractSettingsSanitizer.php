<?php

namespace Akash\WpEmailer\Abstracts;

/**
 * Abstract setting sanitizer class.
 *
 * @since WP_EMAILER_SINCE
 */
abstract class AbstractSettingsSanitizer {

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
	 * Get sanitized value.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return mixed
	 */
	abstract public function sanitize();
}
