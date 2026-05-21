<?php
/**
 * Footer column helpers — keep legacy widgets from overriding theme markup.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Footer widget area IDs registered by this theme.
 *
 * @return string[]
 */
function innovare_footer_column_sidebar_ids() {
	return array( 'footer-1', 'footer-2', 'footer-3', 'footer-4' );
}

/**
 * Strings that indicate stale footer widget content from the previous site.
 *
 * @return string[]
 */
function innovare_legacy_footer_widget_markers() {
	return array(
		'Top Notch',
		'MP_EMMET',
		'Real Geeks',
		'site-about',
		'team-box',
		'team-avatar',
		'info-list',
		'phone-wrapper',
		'cost-effective, but intuitive',
	);
}

/**
 * Widget id_base values from the previous theme that must not render in our footer.
 *
 * @return string[]
 */
function innovare_legacy_footer_widget_bases() {
	return array(
		'theme-about',
		'theme_about',
		'theme-widget-team',
		'theme_widget_team',
		'theme-team',
		'theme_team',
		'theme-contact',
		'theme_contact',
		'theme-social',
		'theme_social',
	);
}

/**
 * Parse a sidebar widget instance ID into base + number.
 *
 * @param string $widget_id Widget instance ID (e.g. theme-about-3).
 * @return array{0: string, 1: int}|null
 */
function innovare_parse_sidebar_widget_id( $widget_id ) {
	if ( ! preg_match( '/^(.+)-(\d+)$/', (string) $widget_id, $matches ) ) {
		return null;
	}

	return array( $matches[1], (int) $matches[2] );
}

/**
 * Whether a widget option blob contains known legacy placeholder strings.
 *
 * @param string   $widget_id Widget instance ID.
 * @param string[] $markers   Legacy strings to detect.
 * @return bool
 */
function innovare_widget_has_legacy_marker( $widget_id, $markers ) {
	$parsed = innovare_parse_sidebar_widget_id( $widget_id );
	if ( ! $parsed ) {
		return false;
	}

	$option = get_option( 'widget_' . $parsed[0], array() );
	$index  = (int) $parsed[1];

	if ( empty( $option[ $index ] ) || ! is_array( $option[ $index ] ) ) {
		return false;
	}

	$blob = wp_json_encode( $option[ $index ] );
	if ( ! is_string( $blob ) ) {
		return false;
	}

	foreach ( $markers as $marker ) {
		if ( false !== stripos( $blob, $marker ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Whether a widget instance belongs to the legacy site theme.
 *
 * @param string $widget_id Widget instance ID.
 * @return bool
 */
function innovare_widget_is_legacy_footer_widget( $widget_id ) {
	$parsed = innovare_parse_sidebar_widget_id( $widget_id );
	if ( ! $parsed ) {
		return false;
	}

	$base = $parsed[0];

	foreach ( innovare_legacy_footer_widget_bases() as $legacy_base ) {
		if ( $base === $legacy_base ) {
			return true;
		}
	}

	if ( 0 === strpos( $base, 'theme_' ) || 0 === strpos( $base, 'theme-' ) ) {
		return true;
	}

	return innovare_widget_has_legacy_marker( $widget_id, innovare_legacy_footer_widget_markers() );
}

/**
 * Whether a footer sidebar still contains legacy widget instances.
 *
 * @param string $sidebar_id Sidebar ID.
 * @return bool
 */
function innovare_footer_sidebar_has_legacy_widgets( $sidebar_id ) {
	if ( ! function_exists( 'wp_get_sidebars_widgets' ) ) {
		return false;
	}

	$sidebars = wp_get_sidebars_widgets();
	if ( empty( $sidebars[ $sidebar_id ] ) || ! is_array( $sidebars[ $sidebar_id ] ) ) {
		return false;
	}

	foreach ( $sidebars[ $sidebar_id ] as $widget_id ) {
		if ( innovare_widget_is_legacy_footer_widget( $widget_id ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Clear widget assignments for one or more footer sidebars.
 *
 * @param string[]|null $sidebar_ids Sidebar IDs to clear; all footer columns when null.
 * @return bool True when sidebars_widgets was updated.
 */
function innovare_clear_footer_sidebars( $sidebar_ids = null ) {
	if ( ! function_exists( 'wp_get_sidebars_widgets' ) || ! function_exists( 'wp_set_sidebars_widgets' ) ) {
		return false;
	}

	$sidebar_ids = null === $sidebar_ids ? innovare_footer_column_sidebar_ids() : array_values( (array) $sidebar_ids );
	$sidebars    = wp_get_sidebars_widgets();

	if ( ! is_array( $sidebars ) ) {
		return false;
	}

	$changed = false;
	foreach ( $sidebar_ids as $sidebar_id ) {
		if ( ! empty( $sidebars[ $sidebar_id ] ) ) {
			$sidebars[ $sidebar_id ] = array();
			$changed                 = true;
		}
	}

	if ( $changed ) {
		wp_set_sidebars_widgets( $sidebars );
	}

	return $changed;
}

/**
 * Whether a footer column should render bundled theme links instead of widgets.
 *
 * Legacy widgets from the previous theme are ignored. Custom footer widgets are
 * opt-in via the `innovare_footer_use_widgets` theme mod.
 *
 * @param string $sidebar_id Footer sidebar ID.
 * @return bool
 */
function innovare_use_footer_column_defaults( $sidebar_id ) {
	if ( ! is_active_sidebar( $sidebar_id ) ) {
		return true;
	}

	if ( innovare_footer_sidebar_has_legacy_widgets( $sidebar_id ) ) {
		return true;
	}

	return ! (bool) get_theme_mod( 'innovare_footer_use_widgets', false );
}

/**
 * Remove legacy footer widgets as soon as they are detected.
 */
function innovare_maybe_purge_legacy_footer_widgets() {
	if ( wp_installing() || ! function_exists( 'wp_get_sidebars_widgets' ) ) {
		return;
	}

	static $done = false;
	if ( $done ) {
		return;
	}
	$done = true;

	$to_clear = array();
	foreach ( innovare_footer_column_sidebar_ids() as $sidebar_id ) {
		if ( innovare_footer_sidebar_has_legacy_widgets( $sidebar_id ) ) {
			$to_clear[] = $sidebar_id;
		}
	}

	if ( $to_clear ) {
		innovare_clear_footer_sidebars( $to_clear );
	}
}
add_action( 'init', 'innovare_maybe_purge_legacy_footer_widgets', 9 );
