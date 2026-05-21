<?php
/**
 * CLI: full Innovate site import / bootstrap.
 *
 * Run from anywhere:
 *
 *   php wp-content/themes/Innovare/scripts/bootstrap-site-content.php
 *
 * Includes: core pages, menus, reading settings, Customizer defaults,
 * legal pages, solution detail pages, phone migrations, cache clear,
 * and rewrite flush. Safe to run multiple times.
 *
 * @package Innovare
 */

declare( strict_types=1 );

$dir = __DIR__;
$wp_load = '';
for ( $i = 0; $i < 8; $i++ ) {
	$candidate = $dir . '/wp-load.php';
	if ( is_readable( $candidate ) ) {
		$wp_load = $candidate;
		break;
	}
	$parent = dirname( $dir );
	if ( $parent === $dir ) {
		break;
	}
	$dir = $parent;
}

if ( ! $wp_load ) {
	fwrite( STDERR, "Could not find wp-load.php above " . __DIR__ . "\n" );
	exit( 1 );
}

require $wp_load;

if ( ! function_exists( 'andromeda_run_site_bootstrap' ) ) {
	fwrite( STDERR, "Theme bootstrap not loaded. Activate the Innovate theme first.\n" );
	exit( 1 );
}

$version_before = (int) get_option( 'andromeda_site_bootstrap_version', 0 );
$result         = andromeda_run_site_bootstrap( true );
$version_after  = (int) get_option( 'andromeda_site_bootstrap_version', 0 );

echo "Innovate site setup complete.\n";
echo 'Bootstrap version: ' . $version_before . ' -> ' . $version_after . "\n";

if ( ! empty( $result['pages']['created'] ) ) {
	echo 'Created pages: ' . implode( ', ', $result['pages']['created'] ) . "\n";
}
if ( ! empty( $result['pages']['existing'] ) ) {
	echo 'Existing pages: ' . implode( ', ', $result['pages']['existing'] ) . "\n";
}
if ( ! empty( $result['messages'] ) ) {
	echo "\nTasks:\n";
	foreach ( $result['messages'] as $msg ) {
		echo ' - ' . $msg . "\n";
	}
}

echo "\nDone.\n";
