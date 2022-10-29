<?php

namespace Akash\WpEmailer\Setup;

use Akash\WpEmailer\Settings\Settings;

/**
 * Install plugin DB works.
 *
 * This will fire up, after activation of the plugin.
 */
class Installer {

	/**
	 * Run default database setups.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	public function run() {
		$this->set_default_settings();
	}

	/**
	 * Add default settings while running the application.
	 *
	 * @since WP_EMAILER_SINCE
	 *
	 * @return void
	 */
	private function set_default_settings() {
		$settings = new Settings();
		$settings->set();
	}
}
