<?php

namespace Akash\WpEmailer\Settings\Validator;

use Akash\WpEmailer\Abstracts\AbstractSettingsValidator;

/**
 * HumanDateValidator class.
 *
 * @since 0.0.1
 *
 * Handle is human date switch-box validator.
 */
class HumanDateValidator extends AbstractSettingsValidator {

	/**
	 * Validate Setting's human date switch-box.
	 *
	 * @since 0.0.1
	 *
	 * @return bool
	 */
	public function validate(): bool {
		if ( is_bool( $this->value ) ) {
			return true;
		}

		if ( is_numeric( $this->value ) ) {
			$value = intval( $this->value );

			return 0 === $value || 1 === $value;
		}

		// Validate Yes-no.
		if ( 'yes' === $this->value || 'no' === $this->value ) {
			return true;
		}

		return false;
	}
}
