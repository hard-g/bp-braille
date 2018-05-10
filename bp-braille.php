<?php
/**
 * Plugin Name:     BP Braille
 * Plugin URI:      https://github.com/hard-g/bp-braille
 * Description:     Provides a number of Braille related services to BuddyPress
 * Author:          Hard G
 * Author URI:      https://hardg.com/
 * Text Domain:     bp-braille
 * Domain Path:     /languages
 * Version:         0.1.0
 */

namespace HardG\BpBraille;

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';

	add_action( 'bp_loaded', __NAMESPACE__ . '\\bootstrap' );
}

function bootstrap() {
	if ( ! braille_works() ) {
		return;
	}

	Plugin::init();

	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\assets' );
}

function assets() {
	wp_enqueue_script( 'bp-braille', plugins_url( 'public/js/bp-braille.js', __FILE__ ), [ 'jquery' ], '0.1.0' );

	$l10n = [
		'strings' => [
			'on'  => esc_html__( 'Braille: On', 'bp-braille' ),
			'off' => esc_html__( 'Braille: Off', 'bp-braille' ),
		]
	];
	wp_localize_script( 'bp-braille', 'bpBraille', $l10n );
}

/**
 * Checks Baille LibLouis server connection.
 *
 * @return bool
 */
function braille_works() {
	$use_remote = get_option( 'braille_use_remote' );
	$remote_url = get_option( 'braille_remote_url', '' );

	if ( empty( $use_remote ) ) {
		return false;
	}

	if ( empty( $remote_url ) ) {
		return false;
	}

	$works = (bool) get_transient( 'braille_works' );

	if ( false === $works ) {
		$response = wp_remote_post( $remote_url, [
			'timeout' => 45,
			'headers' => [ 'Content-type: application/json' ],
			'body' => json_encode( [ 'content' => 'Connection Test' ] ),
			'cookies' => []
		] );

		$works = 200 === wp_remote_retrieve_response_code( $response );

		set_transient( 'braille_works', $works, HOUR_IN_SECONDS );
	}

	return $works;
}
