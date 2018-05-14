<?php

namespace HardG\BpBraille\Groups;

use HardG\BpBraille\Registerable;

class Ajax implements Registerable {

	public function register() {
		add_action( 'wp_ajax_bp_groups_braille', array( $this, 'convert' ) );
	}

	/**
	 * Converts Forum/Reply text into Braille.
	 *
	 * @return void
	 */
	public function convert() {
		if ( empty( $_POST['reply_id'] ) ) {
			wp_send_json_error();
		}

		check_ajax_referer( 'bp-group-braille-' . (int) $_POST['reply_id'], 'nonce' );

		$content = wp_kses_post( $_POST['content'] );
		$braille = get_braille( null, $content );

		wp_send_json_success( array(
			'original' => $content,
			'braille' => sprintf( '<span class="braille">%s</span>', $braille ),
		) );
	}
}
