<?php

namespace HardG\BpBraille\Groups;

use HardG\BpBraille\Registerable;

class Template implements Registerable {

	public function register() {
		add_filter( 'bbp_topic_admin_links', array( $this, 'render' ), 10, 2 );
		add_filter( 'bbp_reply_admin_links', array( $this, 'render' ), 10, 2 );
	}

	/**
	 * Renders Braille switch for Group forums.
	 *
	 * @return void
	 */
	public function render( $links = array(), $id = 0 ) {
		$group = groups_get_current_group();

		if ( empty( $group ) ) {
			return $links;
		}

		$enabled = (bool) groups_get_groupmeta( (int) $group->id , 'group_enable_braille', true );

		if ( ! $enabled ) {
			return $links;
		}

		$links['braille'] = sprintf(
			'<a class="braille-action braille-on" data-group-id="%1$d" data-reply-id="%2$d" data-braille-nonce="%3$s" href="#">%4$s</a>',
			$group->id,
			$id,
			wp_create_nonce( "bp-group-braille-{$id}" ),
			esc_html__( 'Enable Braille', 'bp-braille' )
		);

		return $links;
	}
}
