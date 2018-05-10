<?php

namespace HardG\BpBraille\Messages;

use HardG\BpBraille\Registerable;

class Ajax implements Registerable {

	public function register() {
		add_action( 'wp_ajax_bp_messages_braille', [ $this, 'convert' ] );
	}

	/**
	 * Converts Message text into Braille.
	 *
	 * @return void
	 */
	public function convert() {
		if ( empty( $_POST['message_id'] ) ) {
			wp_send_json_error();
		}

		check_ajax_referer( 'bp-messages-braille-' . (int) $_POST['message_id'], 'nonce' );

		$content = wp_kses_post( $_POST['content'] );
		$braille = get_braille( null, $content );

		wp_send_json_success( [
			'original' => $content,
			'braille' => sprintf( '<span class="braille">%s</span>', $braille ),
		] );
	}
}
