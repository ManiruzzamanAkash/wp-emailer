<?php

namespace Akash\WpEmailer\Settings\Sanitizer;

use Akash\WpEmailer\Abstracts\AbstractSettingsSanitizer;

/**
 * NumrowsSanitizer class.
 *
 * Handle number of rows validation logic.
 */
class NumrowsSanitizer extends AbstractSettingsSanitizer {

	/**
	 * Get sanitized value.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return int
	 */
	public function sanitize(): int {
		return absint( $this->value );
	}
}
