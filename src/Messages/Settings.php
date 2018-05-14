<?php

namespace HardG\BpBraille\Messages;

use HardG\BpBraille\Registerable;

/**
 * Adds general settings for Braille in messages.
 */
class Settings implements Registerable {

	public function register() {
		add_action( 'bp_core_general_settings_before_submit', array( $this, 'render' ) );
		add_action( 'bp_core_general_settings_after_save', array( $this, 'save' ) );
	}

	public function render() {
		$show_braille = (bool) bp_get_user_meta( bp_displayed_user_id(), 'bp_messages_braille', true );
		?>
		<label for="bp-messages-braille">
			<input type="checkbox" name="bp-messages-braille" id="bp-messages-braille" value="1" <?php checked( $show_braille ); ?> />
			<?php esc_html_e( 'Show Braille toggle for private messages', 'bp-braille' ); ?>
		</label>
		<?php
	}

	/**
	 * Saves the messages Braille option.
	 *
	 * Security checks are done in `bp_settings_action_general()`.
	 *
	 * @return void
	 */
	public function save() {
		$show_braille = isset( $_POST['bp-messages-braille'] ) ? 1 : 0;

		$updated = bp_update_user_meta( bp_displayed_user_id(), 'bp_messages_braille', $show_braille );

		if ( $updated ) {
			bp_core_add_message( esc_html__( 'Your settings have been saved', 'bp-braille' ), 'success' );
		}
	}
}
