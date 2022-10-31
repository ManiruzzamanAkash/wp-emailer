<?php

namespace Akash\WpEmailer\Settings\Sanitizer;

use Akash\WpEmailer\Abstracts\AbstractSettingsSanitizer;

/**
 * HumanDateSanitizer class.
 *
 * Handle is human date switch-box sanitization logic.
 */
class HumanDateSanitizer extends AbstractSettingsSanitizer {

	/**
	 * Get sanitized value.
	 *
	 * @since 0.0.1
	 *
	 * @return bool
	 */
	public function sanitize() {
		// Check yes-no.
		if ( 'yes' === $this->value || 'no' === $this->value ) {
			return 'yes' === strtolower( $this->value ) ? 1 : 0;
		}

		return boolval( $this->value ) ? 1 : 0;
	}
}
