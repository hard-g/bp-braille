<?php

namespace HardG\BpBraille\Groups;

use HardG\BpBraille\Registerable;

class Settings implements Registerable {

	public function register() {
		add_action( 'bp_after_group_details_admin', array( $this, 'render' ) );
		add_action( 'groups_group_details_edited', array( $this, 'save' ) );
	}

	/**
	 * Renders Braille settings for a group.
	 *
	 * @return void
	 */
	public function render() {
		$group = groups_get_current_group();

		if ( ! bp_group_is_forum_enabled( $group ) ) {
			return;
		}

		$enabled = (bool) groups_get_groupmeta( (int) $group->id , 'group_enable_braille', true );

		?>
		<label for="group-enable-braille">
			<input type="checkbox" name="group-enable-braille" id="group-enable-braille" value="1" <?php checked( $enabled ); ?> /> <?php esc_html_e( 'Show Braille toggle for group discussions', 'bp-braille' ); ?>
		</label>
		<?php
	}

	/**
	 * Save group's Braille option.
	 *
	 * Security checks are done in `groups_screen_group_admin_settings()`.
	 *
	 * @param int $group_id Group ID.
	 * @return void.
	 */
	public function save( $group_id = 0 ) {
		$enable = isset( $_POST['group-enable-braille'] ) ? 1 : 0;

		$updated = groups_update_groupmeta( (int) $group_id, 'group_enable_braille', $enable );
	}
}
