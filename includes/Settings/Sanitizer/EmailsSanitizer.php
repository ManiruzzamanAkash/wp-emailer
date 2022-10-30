<?php

namespace Akash\WpEmailer\Settings\Sanitizer;

use Akash\WpEmailer\Abstracts\AbstractSettingsSanitizer;

/**
 * EmailsSanitizer class.
 *
 * Handle emails sanitization logics.
 */
class EmailsSanitizer extends AbstractSettingsSanitizer {

	/**
	 * Get value.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return array
	 */
	public function sanitize(): array {
		$emails = $this->value;

		if ( empty( $emails ) ) {
			return array();
		}

		return array_filter(
			$emails,
			function ( $email ) {
				return filter_var( sanitize_text_field( wp_unslash( $email ) ), FILTER_VALIDATE_EMAIL );
			}
		);
	}
}
