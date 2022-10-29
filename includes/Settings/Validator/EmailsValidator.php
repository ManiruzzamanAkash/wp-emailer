<?php

namespace Akash\WpEmailer\Settings\Validator;

use Akash\WpEmailer\Abstracts\AbstractSettingsValidator;
use Akash\WpEmailer\Traits\ArrayFilterable;

/**
 * EmailsValidator class.
 *
 * @since WP_EMAILER_SINCE
 *
 * Handle emails passed in settings to check is valid.
 */
class EmailsValidator extends AbstractSettingsValidator {

	use ArrayFilterable;

	/**
	 * Validate Setting's emails.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return bool
	 */
	public function validate(): bool {
		if ( ! is_array( $this->value ) ) {
			return false;
		}

		// We'll allow empty email.
		if ( ! count( $this->value ) ) {
			return true;
		}

		// Check length is between 0 to 5.
		if ( count( $this->value ) < 0 || count( $this->value ) > 5 ) {
			return false;
		}

		// If any email given like [''], we make it invalid.
		$non_empty_emails = $this->get_non_empty_values( $this->value );
		if ( ! count( $non_empty_emails ) ) {
			return false;
		}

		$filtered_emails = $this->get_valid_emails_after_filtering( $non_empty_emails );

		return count( $non_empty_emails ) === count( $filtered_emails );
	}
}
