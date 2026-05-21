<?php
/**
 * Innovate — Core team data (About page).
 *
 * Stored in wp_options; seeded from theme defaults on bootstrap.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Bump when bundled team defaults change — triggers DB sync on bootstrap. */
define( 'ANDROMEDA_TEAM_DATA_VERSION', 1 );

/** wp_options key for stored team members. */
define( 'ANDROMEDA_TEAM_OPTION', 'andromeda_team_data' );

/** wp_options key for stored team data version. */
define( 'ANDROMEDA_TEAM_VERSION_OPTION', 'andromeda_team_data_version' );

/**
 * Supported social profile keys for team members.
 *
 * @return string[]
 */
function andromeda_team_social_platforms() {
	return array( 'linkedin', 'x', 'twitter', 'facebook', 'instagram', 'github', 'website' );
}

/**
 * Bootstrap Icons class map for team social links.
 *
 * @return array<string, string>
 */
function andromeda_team_social_icons() {
	return array(
		'linkedin'  => 'bi-linkedin',
		'x'         => 'bi-twitter-x',
		'twitter'   => 'bi-twitter-x',
		'facebook'  => 'bi-facebook',
		'instagram' => 'bi-instagram',
		'github'    => 'bi-github',
		'website'   => 'bi-globe2',
	);
}

/**
 * Bundled default team members.
 *
 * @return array<int, array<string, mixed>>
 */
function andromeda_get_team_defaults() {
	return array(
		array(
			'id'       => 'akhlaq-ahmad',
			'name'     => __( 'Akhlaq Ahmad', 'innovare' ),
			'role'     => __( 'Founder', 'innovare' ),
			'bio'      => __( 'Founder of Innovate — focused on reliable IT infrastructure, managed services and accountable delivery for growing organizations.', 'innovare' ),
			'photo'    => '',
			'photo_id' => 0,
			'social'   => array(
				'linkedin' => 'https://www.linkedin.com/in/akhlaqsipra/',
			),
			'order'    => 1,
			'visible'  => true,
		),
	);
}

/**
 * Normalize a single team member record from storage.
 *
 * @param array<string, mixed> $member Raw member.
 * @return array<string, mixed>|null
 */
function andromeda_normalize_team_member( $member ) {
	if ( ! is_array( $member ) ) {
		return null;
	}

	$name = isset( $member['name'] ) ? sanitize_text_field( (string) $member['name'] ) : '';
	if ( '' === $name ) {
		return null;
	}

	$social = array();
	if ( ! empty( $member['social'] ) && is_array( $member['social'] ) ) {
		foreach ( $member['social'] as $platform => $url ) {
			$platform = sanitize_key( (string) $platform );
			if ( ! in_array( $platform, andromeda_team_social_platforms(), true ) ) {
				continue;
			}
			$url = esc_url_raw( (string) $url );
			if ( $url ) {
				$social[ $platform ] = $url;
			}
		}
	}

	return array(
		'id'       => ! empty( $member['id'] ) ? sanitize_key( (string) $member['id'] ) : sanitize_title( $name ),
		'name'     => $name,
		'role'     => isset( $member['role'] ) ? sanitize_text_field( (string) $member['role'] ) : '',
		'bio'      => isset( $member['bio'] ) ? sanitize_textarea_field( (string) $member['bio'] ) : '',
		'photo'    => ! empty( $member['photo'] ) ? esc_url_raw( (string) $member['photo'] ) : '',
		'photo_id' => ! empty( $member['photo_id'] ) ? absint( $member['photo_id'] ) : 0,
		'social'   => $social,
		'order'    => isset( $member['order'] ) ? (int) $member['order'] : 0,
		'visible'  => ! isset( $member['visible'] ) || (bool) $member['visible'],
	);
}

/**
 * Return all team members from the database (seeded from theme defaults).
 *
 * @param bool $visible_only Skip members marked not visible.
 * @return array<int, array<string, mixed>>
 */
function andromeda_get_team_members( $visible_only = true ) {
	$cached = wp_cache_get( 'innovare_team', 'innovare' );
	if ( false === $cached ) {
		$stored = get_option( ANDROMEDA_TEAM_OPTION, null );
		if ( ! is_array( $stored ) || empty( $stored ) ) {
			$stored = andromeda_get_team_defaults();
		}

		$cached = array();
		foreach ( $stored as $member ) {
			$normalized = andromeda_normalize_team_member( $member );
			if ( $normalized ) {
				$cached[] = $normalized;
			}
		}

		usort(
			$cached,
			static function ( $a, $b ) {
				return (int) $a['order'] <=> (int) $b['order'];
			}
		);

		wp_cache_set( 'innovare_team', $cached, 'innovare' );
	}

	if ( ! $visible_only ) {
		return $cached;
	}

	return array_values(
		array_filter(
			$cached,
			static function ( $member ) {
				return ! empty( $member['visible'] );
			}
		)
	);
}

/**
 * Resolve profile photo URL for a team member.
 *
 * @param array<string, mixed> $member Team member.
 * @return string
 */
function andromeda_team_member_photo_url( $member ) {
	if ( ! empty( $member['photo_id'] ) ) {
		$url = wp_get_attachment_image_url( (int) $member['photo_id'], 'medium' );
		if ( $url ) {
			return $url;
		}
	}

	return ! empty( $member['photo'] ) ? (string) $member['photo'] : '';
}

/**
 * Seed or update team content in wp_options from theme defaults.
 *
 * @param bool $force_reset When true, overwrite all stored team content.
 * @return array{updated: bool, version: int, forced: bool}
 */
function andromeda_seed_team_data( $force_reset = false ) {
	$defaults   = andromeda_get_team_defaults();
	$theme_ver  = ANDROMEDA_TEAM_DATA_VERSION;
	$stored_ver = (int) get_option( ANDROMEDA_TEAM_VERSION_OPTION, 0 );
	$existing   = get_option( ANDROMEDA_TEAM_OPTION, null );

	$needs_seed = ! is_array( $existing ) || empty( $existing );
	$needs_sync = $stored_ver < $theme_ver;
	$updated    = false;

	if ( $force_reset || $needs_seed || $needs_sync ) {
		update_option( ANDROMEDA_TEAM_OPTION, $defaults, false );
		update_option( ANDROMEDA_TEAM_VERSION_OPTION, $theme_ver, false );
		andromeda_clear_team_cache();
		$updated = true;
	}

	return array(
		'updated' => $updated,
		'version' => (int) get_option( ANDROMEDA_TEAM_VERSION_OPTION, $theme_ver ),
		'forced'  => (bool) $force_reset,
	);
}

/**
 * Reset all team content in the database to theme defaults.
 *
 * @return array{updated: bool, version: int, forced: bool}
 */
function andromeda_reset_team_data() {
	return andromeda_seed_team_data( true );
}

/**
 * Clear cached team data.
 */
function andromeda_clear_team_cache() {
	wp_cache_delete( 'innovare_team', 'innovare' );
}
