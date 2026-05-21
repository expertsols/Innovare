<?php
/**
 * Asset loading — Bootstrap 5.3, Bootstrap Icons, Google Fonts, custom CSS/JS.
 *
 * Bootstrap is loaded from jsDelivr CDN by default for zero-config setup.
 * To switch to local files, drop bootstrap.min.css / bootstrap.bundle.min.js
 * into /assets/vendor/bootstrap/ and toggle the innovare_USE_LOCAL_BOOTSTRAP
 * constant in wp-config.php (see README).
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'innovare_USE_LOCAL_BOOTSTRAP' ) ) {
	define( 'innovare_USE_LOCAL_BOOTSTRAP', false );
}

/**
 * Front-end assets.
 */
function innovare_enqueue_assets() {

	$bootstrap_css = innovare_USE_LOCAL_BOOTSTRAP
		? INNOVARE_URI . 'assets/vendor/bootstrap/bootstrap.min.css'
		: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css';

	$bootstrap_js = innovare_USE_LOCAL_BOOTSTRAP
		? INNOVARE_URI . 'assets/vendor/bootstrap/bootstrap.bundle.min.js'
		: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js';

	wp_enqueue_style(
		'innovare-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap',
		array(),
		INNOVARE_VERSION
	);

	wp_enqueue_style(
		'bootstrap',
		$bootstrap_css,
		array(),
		'5.3.3'
	);

	wp_enqueue_style(
		'bootstrap-icons',
		'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
		array(),
		'1.11.3'
	);

	wp_enqueue_style(
		'innovare-theme',
		get_stylesheet_uri(),
		array( 'bootstrap' ),
		INNOVARE_VERSION
	);

	wp_enqueue_style(
		'innovare-custom',
		INNOVARE_URI . 'assets/css/custom.css',
		array( 'bootstrap', 'innovare-theme' ),
		INNOVARE_VERSION
	);

	wp_enqueue_script(
		'bootstrap',
		$bootstrap_js,
		array(),
		'5.3.3',
		true
	);

	wp_enqueue_script(
		'innovare-custom',
		INNOVARE_URI . 'assets/js/custom.js',
		array( 'bootstrap' ),
		INNOVARE_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'innovare_enqueue_assets', 20 );

/**
 * Add a small preconnect hint for fonts to reduce TTFB on first paint.
 *
 * @param array  $hints         URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array
 */
function innovare_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
		$hints[] = array(
			'href' => 'https://cdn.jsdelivr.net',
		);
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'innovare_resource_hints', 10, 2 );
