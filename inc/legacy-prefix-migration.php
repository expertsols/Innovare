<?php
/**
 * One-time migration: legacy theme storage keys → innovare_*.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Copy legacy Customizer values (prior theme prefix) to innovare_* when the new key is empty.
 */
function innovare_migrate_legacy_theme_mod_prefix() {
	if ( wp_installing() || get_option( 'innovare_prefix_migrated_v1', false ) ) {
		return;
	}

	$mods = get_theme_mods();
	if ( ! is_array( $mods ) ) {
		update_option( 'innovare_prefix_migrated_v1', true, false );
		return;
	}

	foreach ( $mods as $key => $value ) {
		if ( 0 !== strpos( (string) $key, 'andromeda_' ) ) {
			continue;
		}
		$new_key = 'innovare_' . substr( (string) $key, 10 );
		$current = get_theme_mod( $new_key, false );
		if ( false === $current || '' === $current ) {
			set_theme_mod( $new_key, $value );
		}
	}

	update_option( 'innovare_prefix_migrated_v1', true, false );
}

/**
 * Copy legacy wp_options keys to innovare_* equivalents.
 */
function innovare_migrate_legacy_options_prefix() {
	if ( wp_installing() || get_option( 'innovare_options_prefix_migrated_v1', false ) ) {
		return;
	}

	$map = array(
		'andromeda_solutions_data'          => 'innovare_solutions_data',
		'andromeda_solutions_data_version'  => 'innovare_solutions_data_version',
		'andromeda_team_data'               => 'innovare_team_data',
		'andromeda_team_data_version'       => 'innovare_team_data_version',
		'andromeda_site_bootstrap_version'  => 'innovare_site_bootstrap_version',
		'andromeda_site_bootstrap_last_run' => 'innovare_site_bootstrap_last_run',
	);

	$legacy_rewrite = get_option( 'andromeda_insights_rewrite_ver', null );
	if ( null !== $legacy_rewrite && false === get_option( 'innovare_insights_rewrite_ver', false ) ) {
		update_option( 'innovare_insights_rewrite_ver', $legacy_rewrite, false );
	}

	foreach ( $map as $old => $new ) {
		$stored = get_option( $old, null );
		if ( null === $stored ) {
			continue;
		}
		if ( false === get_option( $new, false ) ) {
			update_option( $new, $stored, false );
		}
	}

	update_option( 'innovare_options_prefix_migrated_v1', true, false );
}

/**
 * Migrate legacy insights demo post meta key.
 */
function innovare_migrate_legacy_insights_demo_meta() {
	if ( wp_installing() || get_option( 'innovare_insights_demo_meta_migrated_v1', false ) ) {
		return;
	}

	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'meta_key'       => '_andromeda_insights_demo',
			'fields'         => 'ids',
		)
	);

	foreach ( $posts as $post_id ) {
		$flag = get_post_meta( (int) $post_id, '_andromeda_insights_demo', true );
		if ( $flag ) {
			update_post_meta( (int) $post_id, '_innovare_insights_demo', $flag );
			delete_post_meta( (int) $post_id, '_andromeda_insights_demo' );
		}
	}

	update_option( 'innovare_insights_demo_meta_migrated_v1', true, false );
}

/**
 * Migrate legacy bootstrap page meta key.
 */
function innovare_migrate_legacy_bootstrap_page_meta() {
	if ( wp_installing() || get_option( 'innovare_bootstrap_meta_migrated_v1', false ) ) {
		return;
	}

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'meta_key'       => '_andromeda_bootstrap_page',
			'fields'         => 'ids',
		)
	);

	foreach ( $pages as $post_id ) {
		$flag = get_post_meta( (int) $post_id, '_andromeda_bootstrap_page', true );
		if ( $flag ) {
			update_post_meta( (int) $post_id, '_innovare_bootstrap_page', $flag );
			delete_post_meta( (int) $post_id, '_andromeda_bootstrap_page' );
		}
	}

	update_option( 'innovare_bootstrap_meta_migrated_v1', true, false );
}

/**
 * Run all legacy storage prefix migrations.
 */
function innovare_migrate_legacy_storage_prefix() {
	innovare_migrate_legacy_theme_mod_prefix();
	innovare_migrate_legacy_options_prefix();
	innovare_migrate_legacy_insights_demo_meta();
	innovare_migrate_legacy_bootstrap_page_meta();
}
