<?php
/**
 * One-off: rename the WordPress page slug from `company` to `about-andromeda-links`
 * and fix primary-menu custom links that still point at `/company/`.
 *
 * Run (from anywhere):
 *
 *   php wp-content/themes/innovare/scripts/migrate-company-to-about-page.php
 *
 * Safe to run more than once: if the page is already at the new slug, it no-ops.
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

if ( ! function_exists( 'wp_update_post' ) ) {
	fwrite( STDERR, "WordPress did not load.\n" );
	exit( 1 );
}

$new_slug = 'about-andromeda-links';
$old_slug  = 'company';

$existing_new = get_page_by_path( $new_slug );
$old_page     = get_page_by_path( $old_slug );

if ( $existing_new && ( ! $old_page || (int) $existing_new->ID !== (int) $old_page->ID ) ) {
	echo "A different page already uses slug \"{$new_slug}\" (ID {$existing_new->ID}). Resolve manually.\n";
	exit( 1 );
}

if ( $old_page instanceof WP_Post ) {
	wp_update_post(
		array(
			'ID'        => $old_page->ID,
			'post_name' => $new_slug,
		)
	);
	update_post_meta( $old_page->ID, '_wp_old_slug', $old_slug );
	echo "Updated page ID {$old_page->ID}: slug \"{$old_slug}\" -> \"{$new_slug}\".\n";
} elseif ( $existing_new instanceof WP_Post ) {
	echo "Page already uses slug \"{$new_slug}\" (ID {$existing_new->ID}). Nothing to rename.\n";
} else {
	echo "No page with slug \"{$old_slug}\" found. Create a page and assign template \"Innovare — Company\", or set slug to \"{$new_slug}\" in wp-admin.\n";
}

$home = trailingslashit( home_url() );
$from = array(
	trailingslashit( $home . $old_slug ),
	home_url( '/' . $old_slug ),
);
$to = trailingslashit( $home . $new_slug );

$menus = wp_get_nav_menus();
$fixed = 0;
foreach ( $menus as $menu ) {
	$items = wp_get_nav_menu_items( $menu->term_id, array( 'post_status' => 'any' ) );
	if ( ! $items ) {
		continue;
	}
	foreach ( $items as $item ) {
		if ( empty( $item->url ) ) {
			continue;
		}
		$new_url = $item->url;
		foreach ( $from as $prefix ) {
			if ( 0 === strpos( $new_url, $prefix ) ) {
				$new_url = $to . ltrim( substr( $new_url, strlen( $prefix ) ), '/' );
				break;
			}
		}
		if ( $new_url !== $item->url ) {
			update_post_meta( (int) $item->ID, '_menu_item_url', esc_url_raw( $new_url ) );
			++$fixed;
			echo "Menu item {$item->ID} ({$menu->name}): URL updated.\n";
		}
	}
}

if ( $fixed ) {
	echo "Updated {$fixed} custom menu link(s).\n";
}

flush_rewrite_rules( false );
echo "Rewrite rules flushed.\n";
echo "Done.\n";
