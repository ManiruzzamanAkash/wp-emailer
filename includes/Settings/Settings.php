<?php

namespace Akash\WpEmailer\Settings;

/**
 * Settings static helper methods.
 *
 * @since WP_EMAILER_SINCE
 */
class Settings {

	/**
	 * Get default settings.
	 *
	 * @return array
	 */
	public static function get_default_settings() {
		return array(
			'numrows'   => 5,
			'humandate' => true,
			'emails'    => array(
				get_option( 'admin_email' ),
			),
		);
	}
}
