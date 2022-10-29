<?php

namespace Akash\WpEmailer\Settings\Validator;

use Akash\WpEmailer\Abstracts\AbstractSettingsValidator;

/**
 * NumrowsValidator class.
 *
 * Handle number of rows validation logic.
 */
class NumrowsValidator extends AbstractSettingsValidator {

	/**
	 * Validate Setting's numrows.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return bool
	 */
	public function validate(): bool {
		return $this->value >= 1 && $this->value <= 5;
	}
}
