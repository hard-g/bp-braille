<?php

namespace HardG\BpBraille\Messages;

use HardG\BpBraille\Registerable;

/**
 * Adds Braille support to the message templates.
 */
class Template implements Registerable {

	/** @var bool */
	protected $enabled;

	public function __construct( $user_id = null ) {
		$this->enabled = (bool) bp_get_user_meta( $user_id, 'bp_messages_braille', true );
	}

	public function register() {
		add_action( 'bp_after_message_meta', array( $this, 'render' ) );
	}

	public function render() {
		if ( ! $this->enabled ) {
			return;
		}

		// Hack to avoid displaying the link above reply form.
		if ( did_action( 'bp_before_message_thread_reply' ) ) {
			return;
		}

		$message_id = bp_get_the_thread_message_id();
		$nonce = wp_create_nonce( "bp-messages-braille-{$message_id}" );

		?>
		<div class="message-braille-actions">
			<a class="braille-on" data-message-id="<?php echo esc_attr( $message_id ); ?>" data-braille-nonce="<?php echo esc_attr( $nonce ); ?>" href="#"><?php esc_html_e( 'Braille: On', 'bp-braille' ); ?></a>
		</div>
		<?php
	}
}
