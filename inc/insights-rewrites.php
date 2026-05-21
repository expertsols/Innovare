<?php
/**
 * Single post URLs under the Insights path: /insights/{post-name}/.
 *
 * The Insights landing page stays at /insights/. Requires rewrite flush
 * after first deploy (handled via innovare_insights_rewrite_ver).
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Bump when rewrite logic changes to trigger flush_rewrite_rules. */
const INNOVARE_INSIGHTS_REWRITE_VERSION = 1;

/**
 * URL segment for single posts (must match the Insights page slug).
 *
 * @return string
 */
function innovare_insights_url_base() {
	return apply_filters( 'innovare_insights_url_base', 'insights' );
}

/**
 * Public permalink path for a post: insights/my-slug (no leading/trailing slashes).
 *
 * @param WP_Post $post Post object.
 * @return string Empty if not a public single post.
 */
function innovare_insights_post_path( $post ) {
	if ( ! $post instanceof WP_Post || 'post' !== $post->post_type ) {
		return '';
	}
	if ( ! in_array( $post->post_status, array( 'publish', 'private' ), true ) ) {
		return '';
	}
	return innovare_insights_url_base() . '/' . $post->post_name;
}

/**
 * Full URL for a public blog post under /insights/{slug}/.
 *
 * @param WP_Post $post Post object.
 * @return string
 */
function innovare_insights_post_url( $post ) {
	$path = innovare_insights_post_path( $post );
	return $path ? home_url( user_trailingslashit( $path ) ) : '';
}

/**
 * Register rewrite: /insights/{post-name}/ → main query for that post.
 */
function innovare_insights_add_rewrite_rules() {
	$base = preg_quote( innovare_insights_url_base(), '#' );
	// Single post (mirrors core rules for %postname% under a fixed prefix).
	add_rewrite_rule(
		"^{$base}/([^/]+)/?\$",
		'index.php?post_type=post&name=$matches[1]',
		'top'
	);
	add_rewrite_rule(
		"^{$base}/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?\$",
		'index.php?post_type=post&name=$matches[1]&feed=$matches[2]',
		'top'
	);
	add_rewrite_rule(
		"^{$base}/([^/]+)/(feed|rdf|rss|rss2|atom)/?\$",
		'index.php?post_type=post&name=$matches[1]&feed=$matches[2]',
		'top'
	);
	add_rewrite_rule(
		"^{$base}/([^/]+)/embed/?\$",
		'index.php?post_type=post&name=$matches[1]&embed=true',
		'top'
	);
	add_rewrite_rule(
		"^{$base}/([^/]+)/trackback/?\$",
		'index.php?post_type=post&name=$matches[1]&tb=1',
		'top'
	);
	add_rewrite_rule(
		"^{$base}/([^/]+)/comment-page-([0-9]{1,})/?\$",
		'index.php?post_type=post&name=$matches[1]&cpage=$matches[2]',
		'top'
	);
	// Multipage post content: /insights/slug/2/ (after feed/embed so literals win).
	add_rewrite_rule(
		"^{$base}/([^/]+)/([0-9]{1,})/?\$",
		'index.php?post_type=post&name=$matches[1]&page=$matches[2]',
		'top'
	);
}
add_action( 'init', 'innovare_insights_add_rewrite_rules', 5 );

/**
 * Flush rewrites once when this module’s version changes.
 */
function innovare_insights_maybe_flush_rewrites() {
	if ( (int) get_option( 'innovare_insights_rewrite_ver', 0 ) >= INNOVARE_INSIGHTS_REWRITE_VERSION ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( 'innovare_insights_rewrite_ver', INNOVARE_INSIGHTS_REWRITE_VERSION );
}
add_action( 'init', 'innovare_insights_maybe_flush_rewrites', 999 );

/**
 * Replace default post permalinks with /insights/{slug}/.
 *
 * @param string  $permalink Default permalink.
 * @param WP_Post $post      Post.
 * @param bool    $leavename Leavename flag (unused).
 * @return string
 */
function innovare_insights_post_link( $permalink, $post, $_leavename ) {
	$url = innovare_insights_post_url( $post );
	return $url ? $url : $permalink;
}
add_filter( 'post_link', 'innovare_insights_post_link', 10, 3 );

/**
 * 301 from legacy permalinks (e.g. /2026/01/10/slug/) to /insights/slug/.
 */
function innovare_insights_redirect_legacy_post_urls() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
		return;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}
	if ( ! is_singular( 'post' ) || ! is_main_query() ) {
		return;
	}
	$post = get_queried_object();
	if ( ! $post instanceof WP_Post ) {
		return;
	}
	$target = innovare_insights_post_url( $post );
	if ( ! $target ) {
		return;
	}
	$want = untrailingslashit( (string) wp_parse_url( $target, PHP_URL_PATH ) );
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$have = untrailingslashit( (string) wp_parse_url( $uri, PHP_URL_PATH ) );
	if ( $want === $have ) {
		return;
	}
	wp_safe_redirect( $target, 301 );
	exit;
}
add_action( 'template_redirect', 'innovare_insights_redirect_legacy_post_urls', 0 );
