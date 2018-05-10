<?php

namespace HardG\BpBraille;

class Plugin {

	private function __constructor() {}

	/**
	 * Create and return an instance of the plugin.
	 *
	 * @return Plugin $instance
	 */
	public static function get_instance() {
		static $instance = null;

		if ( null === $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Initialize BuddyPress integrations.
	 *
	 * @return void
	 */
	public static function init() {
		$instance = self::get_instance();

		if ( bp_is_active( 'messages' ) ) {
			$instance->messages = new \stdClass;
			$instance->messages->template = new Messages\Template( get_current_user_id() );
			$instance->messages->template->register();

			$instance->messages->settings = new Messages\Settings();
			$instance->messages->settings->register();

			$instance->messages->ajax = new Messages\Ajax();
			$instance->messages->ajax->register();
		}

		if ( bp_is_active( 'groups' ) ) {
			$instance->groups = new \stdClass;
			$instance->groups->template = new Groups\Template();
			$instance->groups->template->register();

			$instance->groups->settings = new Groups\Settings();
			$instance->groups->settings->register();

			$instance->groups->ajax = new Groups\Ajax();
			$instance->groups->ajax->register();
		}
	}
}
