<?php

namespace Akash\WpEmailer\Traits;

use Exception;

/**
 * Filterable trait.
 *
 * This trait is used to filter some array filters.
 */
trait ArrayFilterable {

	/**
	 * Remove any empty-item from array.
	 *
	 * @since 0.0.1
	 *
	 * @param array $values Array values.
	 *
	 * @return array
	 *
	 * @throws Exception Throws an exception for invalid array values.
	 */
	public function get_non_empty_values( $values ) {
		if ( ! is_array( $values ) ) {
			throw new Exception( 'Invalid array.', 400 );
		}

		return array_filter(
			$this->value,
			function ( $email ) {
				return ! empty( $email );
			}
		);
	}

	/**
	 * Get valid emails after proper filtering.
	 *
	 * @since 0.0.1
	 *
	 * @param array $emails Valid-invalid email lists.
	 *
	 * @return array
	 *
	 * @throws Exception Throws an exception for invalid emails passed.
	 */
	public function get_valid_emails_after_filtering( $emails ) {
		if ( ! is_array( $emails ) ) {
			throw new Exception( 'Invalid array.', 400 );
		}

		return array_filter(
			$emails,
			function ( $email ) {
				return filter_var( $email, FILTER_VALIDATE_EMAIL );
			}
		);
	}
}
