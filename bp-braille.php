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
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\assets' );
}

function bootstrap() {
	// Bail if WP Braill plugin isn't active
	if ( ! function_exists( 'get_braille' ) ) {
		return;
	}

	Plugin::init();
}

function assets() {
	// Bail if WP Braill plugin isn't active
	if ( ! function_exists( 'get_braille' ) ) {
		return;
	}

	wp_enqueue_script( 'bp-braille', plugins_url( 'public/js/bp-braille.js', __FILE__ ), [ 'jquery' ], '0.1.0' );

	$l10n = [
		'strings' => [
			'on'  => esc_html__( 'Braille: On', 'bp-braille' ),
			'off' => esc_html__( 'Braille: Off', 'bp-braille' ),
		]
	];
	wp_localize_script( 'bp-braille', 'bpBraille', $l10n );
}
