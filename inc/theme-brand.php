<?php
/**
 * Innovare theme brand + author (expertsols / expertsols.com).
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Theme author display name (WordPress style.css Author). */
if ( ! defined( 'INNOVARE_THEME_AUTHOR' ) ) {
	define( 'INNOVARE_THEME_AUTHOR', 'expertsols' );
}

/** Theme author / owner website. */
if ( ! defined( 'INNOVARE_THEME_AUTHOR_URI' ) ) {
	define( 'INNOVARE_THEME_AUTHOR_URI', 'https://expertsols.com/' );
}

/**
 * Public theme brand name (matches style.css Theme Name).
 *
 * @return string
 */
function innovare_theme_name() {
	return __( 'Innovare', 'innovare' );
}

/**
 * Theme author name.
 *
 * @return string
 */
function innovare_theme_author() {
	return INNOVARE_THEME_AUTHOR;
}

/**
 * Theme author URL.
 *
 * @return string
 */
function innovare_theme_author_uri() {
	return INNOVARE_THEME_AUTHOR_URI;
}

/**
 * Footer credit: Innovare theme by expertsols (expertsols.com).
 */
function innovare_theme_footer_credit() {
	printf(
		'<p class="footer-theme-credit mb-0"><a href="%1$s" target="_blank" rel="noopener noreferrer">%2$s</a></p>',
		esc_url( innovare_theme_author_uri() ),
		esc_html(
			sprintf(
				/* translators: 1: theme name, 2: author name */
				__( '%1$s theme by %2$s', 'innovare' ),
				innovare_theme_name(),
				innovare_theme_author()
			)
		)
	);
}
