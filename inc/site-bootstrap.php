<?php
/**
 * Idempotent site content bootstrap for fresh installs and production deploys.
 *
 * Creates core pages, primary navigation, reading settings, and slug migrations
 * automatically on theme activation and on each request until complete.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ANDROMEDA_SITE_BOOTSTRAP_VERSION', 6 );

/** Stable English menu name so production always resolves the same nav menu. */
define( 'ANDROMEDA_PRIMARY_MENU_NAME', 'Innovate Primary' );

/**
 * Core pages required by the theme (slug => definition).
 *
 * @return array<string, array{title: string, template: string, content: string, is_front?: bool}>
 */
function andromeda_core_page_definitions() {
	return array(
		'home'                  => array(
			'title'    => __( 'Home', 'innovare' ),
			'template' => '',
			'content'  => '',
			'is_front' => true,
		),
		'services'              => array(
			'title'    => __( 'Services', 'innovare' ),
			'template' => 'page-templates/template-services.php',
			'content'  => '',
		),
		'solutions'             => array(
			'title'    => __( 'Solutions', 'innovare' ),
			'template' => 'page-templates/template-solutions.php',
			'content'  => '',
		),
		'insights'              => array(
			'title'    => __( 'Insights', 'innovare' ),
			'template' => 'page-templates/template-insights.php',
			'content'  => '',
		),
		'about' => array(
			'title'    => __( 'Company', 'innovare' ),
			'template' => 'page-templates/template-company.php',
			'content'  => '',
		),
		'contact'               => array(
			'title'    => __( 'Contact', 'innovare' ),
			'template' => 'page-templates/template-contact.php',
			'content'  => '',
		),
	);
}

/**
 * Display name for Innovate (site brand).
 *
 * @return string
 */
function andromeda_brand_name() {
	return __( 'Innovate', 'innovare' );
}

/**
 * Update Customizer-stored phone numbers when still using the legacy default.
 */
function andromeda_migrate_contact_phone_defaults() {
	if ( wp_installing() || get_option( 'andromeda_contact_phone_migrated_v2', false ) ) {
		return;
	}

	$old_phone = '+92 345 4243541';
	$new_phone = andromeda_default_contact_phone();
	$keys      = array( 'andromeda_contact_phone', 'andromeda_contact_whatsapp' );

	foreach ( $keys as $key ) {
		$stored = get_theme_mod( $key, '' );
		if ( $old_phone === $stored || '' === $stored ) {
			set_theme_mod( $key, $new_phone );
		}
	}

	update_option( 'andromeda_contact_phone_migrated_v2', true, false );
}

/**
 * Migrate hyphenated number (+92 333-4106911) to spaced format.
 */
function andromeda_migrate_contact_phone_no_hyphen() {
	if ( wp_installing() || get_option( 'andromeda_contact_phone_migrated_v3', false ) ) {
		return;
	}

	$hyphenated = '+92 333-4106911';
	$new_phone  = andromeda_default_contact_phone();
	$keys       = array( 'andromeda_contact_phone', 'andromeda_contact_whatsapp' );

	foreach ( $keys as $key ) {
		$stored = get_theme_mod( $key, '' );
		if ( $hyphenated === $stored ) {
			set_theme_mod( $key, $new_phone );
		}
	}

	update_option( 'andromeda_contact_phone_migrated_v3', true, false );
}

/**
 * Migrate compact number (+92 3334106911) to spaced format (+92 333 4106911).
 */
function andromeda_migrate_contact_phone_spaced_format() {
	if ( wp_installing() || get_option( 'andromeda_contact_phone_migrated_v4', false ) ) {
		return;
	}

	$compact   = '+92 3334106911';
	$new_phone = andromeda_default_contact_phone();
	$keys      = array( 'andromeda_contact_phone', 'andromeda_contact_whatsapp' );

	foreach ( $keys as $key ) {
		$stored = get_theme_mod( $key, '' );
		if ( $compact === $stored ) {
			set_theme_mod( $key, $new_phone );
		}
	}

	update_option( 'andromeda_contact_phone_migrated_v4', true, false );
}

/**
 * Run all one-time data migrations (phone numbers, slugs, etc.).
 */
function andromeda_migrate_about_slug_to_innovate() {
	if ( wp_installing() || get_option( 'andromeda_about_slug_migrated_v3', false ) ) {
		return;
	}

	$canonical      = andromeda_about_page_slug();
	$canonical_page = get_page_by_path( $canonical, OBJECT, 'page' );
	$legacy_page    = get_page_by_path( 'about-andromeda-links', OBJECT, 'page' );

	if ( $legacy_page instanceof WP_Post && 'publish' === $legacy_page->post_status && ! $canonical_page ) {
		wp_update_post(
			array(
				'ID'        => (int) $legacy_page->ID,
				'post_name' => $canonical,
			)
		);
		update_post_meta( (int) $legacy_page->ID, '_wp_old_slug', 'about-andromeda-links' );
	}

	update_option( 'andromeda_about_slug_migrated_v3', true, false );
}

function andromeda_bootstrap_run_migrations() {
	andromeda_migrate_about_slug_to_innovate();
	andromeda_migrate_legacy_about_page_slugs();
	andromeda_migrate_legacy_site_branding();
	andromeda_migrate_andromeda_to_innovate_branding();
	andromeda_migrate_legacy_footer_widgets();
	andromeda_migrate_contact_phone_defaults();
	andromeda_migrate_contact_phone_no_hyphen();
	andromeda_migrate_contact_phone_spaced_format();
}

/**
 * Seed empty Customizer contact + social settings from theme defaults.
 *
 * @return int Number of values written.
 */
function andromeda_seed_customizer_defaults() {
	if ( wp_installing() ) {
		return 0;
	}

	$written = 0;
	foreach ( andromeda_theme_mod_defaults() as $key => $default ) {
		$stored = get_theme_mod( $key, false );
		if ( false === $stored || '' === $stored ) {
			set_theme_mod( $key, $default );
			++$written;
		}
	}

	return $written;
}

/**
 * Ensure bootstrap-managed core pages use the current page templates.
 */
function andromeda_sync_core_page_templates( $force = false ) {
	if ( wp_installing() ) {
		return;
	}

	foreach ( andromeda_core_page_definitions() as $slug => $def ) {
		if ( empty( $def['template'] ) ) {
			continue;
		}

		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page || 'publish' !== $page->post_status ) {
			continue;
		}

		$post_id          = (int) $page->ID;
		$current_template = get_post_meta( $post_id, '_wp_page_template', true );
		$is_bootstrap     = (bool) get_post_meta( $post_id, '_andromeda_bootstrap_page', true );

		if ( $force || $is_bootstrap || ! $current_template || 'default' === $current_template ) {
			update_post_meta( $post_id, '_wp_page_template', $def['template'] );
			update_post_meta( $post_id, '_andromeda_bootstrap_page', 'v1' );
		}
	}
}

/**
 * Legal pages, solution detail children, privacy option.
 */
function andromeda_bootstrap_legal_and_solutions() {
	if ( function_exists( 'andromeda_migrate_privacy_page_slug' ) ) {
		andromeda_migrate_privacy_page_slug();
	}
	if ( function_exists( 'andromeda_ensure_legal_pages' ) ) {
		andromeda_ensure_legal_pages();
	}
	if ( function_exists( 'andromeda_ensure_solution_detail_pages' ) ) {
		andromeda_ensure_solution_detail_pages();
	}
	if ( function_exists( 'andromeda_sync_privacy_policy_option' ) ) {
		andromeda_sync_privacy_policy_option();
	}
}

/**
 * Clear theme runtime caches (solutions data, etc.).
 */
function andromeda_clear_theme_runtime_cache() {
	if ( function_exists( 'andromeda_clear_solutions_cache' ) ) {
		andromeda_clear_solutions_cache();
	}
	if ( function_exists( 'andromeda_clear_team_cache' ) ) {
		andromeda_clear_team_cache();
	}
}

/**
 * Legacy About page slugs that should resolve to `about`.
 *
 * @return string[]
 */
function andromeda_legacy_about_page_slugs() {
	return array( 'company', 'about-us', 'about-us-page', 'about-andromeda', 'about-andromeda-links' );
}

/**
 * Rename legacy About slugs to `about` when safe.
 */
function andromeda_migrate_legacy_about_page_slugs() {
	if ( wp_installing() || get_option( 'andromeda_legacy_about_slug_migrated_v2', false ) ) {
		return;
	}

	$canonical      = andromeda_about_page_slug();
	$canonical_page = get_page_by_path( $canonical, OBJECT, 'page' );

	foreach ( andromeda_legacy_about_page_slugs() as $slug ) {
		if ( $slug === $canonical ) {
			continue;
		}

		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page instanceof WP_Post || 'publish' !== $page->post_status ) {
			continue;
		}

		if ( ! $canonical_page ) {
			wp_update_post(
				array(
					'ID'        => (int) $page->ID,
					'post_name' => $canonical,
				)
			);
			update_post_meta( (int) $page->ID, '_wp_old_slug', $slug );
			update_post_meta( (int) $page->ID, '_wp_page_template', 'page-templates/template-company.php' );
			update_post_meta( (int) $page->ID, '_andromeda_bootstrap_page', 'v1' );
			$canonical_page = get_post( (int) $page->ID );
			continue;
		}

		if ( (int) $page->ID === (int) $canonical_page->ID ) {
			continue;
		}

		$template = get_post_meta( (int) $page->ID, '_wp_page_template', true );
		if ( ! $template || 'default' === $template ) {
			update_post_meta( (int) $page->ID, '_wp_page_template', 'page-templates/template-company.php' );
		}
	}

	andromeda_fix_legacy_about_menu_urls();
	update_option( 'andromeda_legacy_about_slug_migrated_v2', true, false );
}

/**
 * Replace legacy site title/branding left from the previous site.
 */
function andromeda_migrate_legacy_site_branding() {
	if ( wp_installing() || get_option( 'andromeda_site_branding_migrated_v1', false ) ) {
		return;
	}

	$name = (string) get_option( 'blogname', '' );
	if ( '' === $name || false !== stripos( $name, 'Top Notch' ) ) {
		update_option( 'blogname', andromeda_brand_name() );
	}

	$tagline = (string) get_option( 'blogdescription', '' );
	if ( in_array( $tagline, array( 'Just another WordPress site', 'Real Geeks, Real Solutions', '' ), true ) ) {
		update_option(
			'blogdescription',
			__( 'IT infrastructure, managed services and business technology solutions.', 'innovare' )
		);
	}

	update_option( 'andromeda_site_branding_migrated_v1', true, false );
}

/**
 * Migrate site title from Andromeda Links to Innovate.
 */
function andromeda_migrate_andromeda_to_innovate_branding() {
	if ( wp_installing() || get_option( 'andromeda_site_branding_migrated_v2', false ) ) {
		return;
	}

	$name = (string) get_option( 'blogname', '' );
	if ( '' === $name || false !== stripos( $name, 'Andromeda' ) || false !== stripos( $name, 'Top Notch' ) ) {
		update_option( 'blogname', andromeda_brand_name() );
	}

	update_option( 'andromeda_site_branding_migrated_v2', true, false );
}

/**
 * Remove legacy footer widgets that override theme footer columns.
 */
function andromeda_migrate_legacy_footer_widgets() {
	if ( wp_installing() ) {
		return;
	}

	if ( get_option( 'andromeda_footer_widgets_migrated_v2', false ) ) {
		return;
	}

	andromeda_clear_footer_sidebars();
	update_option( 'andromeda_footer_widgets_migrated_v2', true, false );
	update_option( 'andromeda_footer_widgets_migrated_v1', true, false );
}

/**
 * Update menu items that still point at legacy About URLs or page IDs.
 */
function andromeda_fix_legacy_about_menu_urls() {
	$canonical      = andromeda_about_page_slug();
	$canonical_page = get_page_by_path( $canonical, OBJECT, 'page' );
	$canonical_url  = $canonical_page ? get_permalink( $canonical_page ) : andromeda_page_url( $canonical );
	$home           = trailingslashit( home_url() );

	foreach ( wp_get_nav_menus() as $menu ) {
		$items = wp_get_nav_menu_items( $menu->term_id, array( 'post_status' => 'any' ) );
		if ( ! $items ) {
			continue;
		}

		foreach ( $items as $item ) {
			if ( 'post_type' === $item->type && 'page' === $item->object ) {
				$page = get_post( (int) $item->object_id );
				if ( $page instanceof WP_Post && in_array( $page->post_name, andromeda_legacy_about_page_slugs(), true ) && $page->post_name !== $canonical ) {
					if ( $canonical_page ) {
						update_post_meta( (int) $item->ID, '_menu_item_object_id', (int) $canonical_page->ID );
						update_post_meta( (int) $item->ID, '_menu_item_url', '' );
					}
				}
				continue;
			}

			if ( empty( $item->url ) ) {
				continue;
			}

			$new_url = $item->url;
			foreach ( andromeda_legacy_about_page_slugs() as $legacy_slug ) {
				if ( $legacy_slug === $canonical ) {
					continue;
				}
				$prefixes = array(
					trailingslashit( $home . $legacy_slug ),
					home_url( '/' . $legacy_slug ),
				);
				foreach ( $prefixes as $prefix ) {
					if ( 0 === strpos( $new_url, $prefix ) ) {
						$new_url = $canonical_url;
						break 2;
					}
				}
			}

			if ( $new_url !== $item->url ) {
				update_post_meta( (int) $item->ID, '_menu_item_url', esc_url_raw( $new_url ) );
			}
		}
	}
}

/**
 * Create or update core site pages (idempotent).
 *
 * @return array{created: string[], existing: string[]}
 */
function andromeda_ensure_core_site_pages() {
	if ( wp_installing() ) {
		return array( 'created' => array(), 'existing' => array() );
	}

	$definitions = andromeda_core_page_definitions();
	$slugs       = array_keys( $definitions );
	$result      = array( 'created' => array(), 'existing' => array() );

	$existing_posts = get_posts(
		array(
			'post_type'              => 'page',
			'post_status'            => array( 'publish', 'draft', 'pending', 'private' ),
			'post_name__in'          => $slugs,
			'posts_per_page'         => count( $slugs ),
			'orderby'                => 'none',
			'no_found_rows'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => false,
		)
	);

	$by_slug = array();
	foreach ( $existing_posts as $page ) {
		if ( 'trash' === $page->post_status ) {
			continue;
		}
		$by_slug[ $page->post_name ] = $page;
	}

	foreach ( $definitions as $slug => $def ) {
		if ( ! empty( $by_slug[ $slug ] ) ) {
			$post_id = (int) $by_slug[ $slug ]->ID;
			$result['existing'][] = $slug;

			if ( ! empty( $def['template'] ) ) {
				$current_template = get_post_meta( $post_id, '_wp_page_template', true );
				if ( ! $current_template || 'default' === $current_template ) {
					update_post_meta( $post_id, '_wp_page_template', $def['template'] );
				}
			}

			if ( 'publish' !== $by_slug[ $slug ]->post_status ) {
				wp_update_post(
					array(
						'ID'          => $post_id,
						'post_status' => 'publish',
					)
				);
			}
			continue;
		}

		$blocked = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $blocked && 'trash' === $blocked->post_status ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_title'   => $def['title'],
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => $def['content'],
			),
			true
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		if ( ! empty( $def['template'] ) ) {
			update_post_meta( (int) $post_id, '_wp_page_template', $def['template'] );
		}

		update_post_meta( (int) $post_id, '_andromeda_bootstrap_page', 'v1' );
		$result['created'][] = $slug;
		$by_slug[ $slug ]    = get_post( (int) $post_id );
	}

	return $result;
}

/**
 * Set static front page to Home when not configured or when forced on bootstrap.
 *
 * @param bool $force Assign Home as the front page even when another page is set.
 */
function andromeda_configure_reading_settings( $force = false ) {
	if ( wp_installing() ) {
		return;
	}

	$home = get_page_by_path( 'home', OBJECT, 'page' );
	if ( ! $home || 'publish' !== $home->post_status ) {
		return;
	}

	if ( ! $force ) {
		$front_id = (int) get_option( 'page_on_front' );
		if ( $front_id && 'publish' === get_post_status( $front_id ) ) {
			return;
		}
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', (int) $home->ID );
	update_option( 'page_for_posts', 0 );
}

/**
 * Default site title on fresh WordPress installs.
 */
function andromeda_maybe_set_default_site_title() {
	if ( wp_installing() ) {
		return;
	}

	$name = get_option( 'blogname' );
	if ( in_array( $name, array( 'WordPress', 'My Site', '' ), true ) ) {
		update_option( 'blogname', andromeda_brand_name() );
	}

	$tagline = get_option( 'blogdescription' );
	if ( in_array( $tagline, array( 'Just another WordPress site', '' ), true ) ) {
		update_option(
			'blogdescription',
			__( 'IT infrastructure, managed services and business technology solutions.', 'innovare' )
		);
	}
}

/**
 * Ordered primary menu items (page slug => nav label).
 *
 * @return array<string, string>
 */
function andromeda_primary_menu_item_definitions() {
	return array(
		'home'                  => __( 'Home', 'innovare' ),
		'services'              => __( 'Services', 'innovare' ),
		'solutions'             => __( 'Solutions', 'innovare' ),
		'insights'              => __( 'Insights', 'innovare' ),
		'about' => __( 'About', 'innovare' ),
		'contact'               => __( 'Contact', 'innovare' ),
	);
}

/**
 * Get or create the theme-managed primary navigation menu.
 *
 * @return int Menu term ID or 0.
 */
function andromeda_get_or_create_primary_menu() {
	$menu = wp_get_nav_menu_object( ANDROMEDA_PRIMARY_MENU_NAME );
	if ( $menu && ! is_wp_error( $menu ) ) {
		return (int) $menu->term_id;
	}

	$legacy = wp_get_nav_menu_object( __( 'Primary Navigation', 'innovare' ) );
	if ( $legacy && ! is_wp_error( $legacy ) ) {
		return (int) $legacy->term_id;
	}

	$menu_id = (int) wp_create_nav_menu( ANDROMEDA_PRIMARY_MENU_NAME );
	return $menu_id > 0 ? $menu_id : 0;
}

/**
 * Whether the managed primary menu needs to be rebuilt or assigned.
 *
 * @param int $menu_id Menu term ID.
 * @return bool
 */
function andromeda_primary_menu_needs_sync( $menu_id ) {
	if ( ! $menu_id ) {
		return true;
	}

	$locations   = get_theme_mod( 'nav_menu_locations', array() );
	$assigned_id = isset( $locations['primary'] ) ? (int) $locations['primary'] : 0;
	if ( ! $assigned_id || $assigned_id !== (int) $menu_id ) {
		return true;
	}

	$expected = andromeda_primary_menu_item_definitions();
	$items    = wp_get_nav_menu_items(
		$menu_id,
		array(
			'post_status' => 'publish',
		)
	);

	if ( empty( $items ) ) {
		return true;
	}

	$page_items = array();
	foreach ( $items as $item ) {
		if ( 'post_type' === $item->type && 'page' === $item->object ) {
			$page_items[] = $item;
		}
	}

	$expected_ids = array();
	foreach ( array_keys( $expected ) as $slug ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page && 'publish' === $page->post_status ) {
			$expected_ids[] = (int) $page->ID;
		}
	}

	if ( count( $page_items ) !== count( $expected_ids ) ) {
		return true;
	}

	foreach ( $expected_ids as $page_id ) {
		$found = false;
		foreach ( $page_items as $item ) {
			if ( (int) $item->object_id === $page_id ) {
				$found = true;
				break;
			}
		}
		if ( ! $found ) {
			return true;
		}
	}

	return false;
}

/**
 * Rebuild primary menu items from core theme pages.
 *
 * @param int $menu_id Menu term ID.
 */
function andromeda_sync_primary_menu_items( $menu_id ) {
	if ( ! $menu_id ) {
		return;
	}

	$items = wp_get_nav_menu_items(
		$menu_id,
		array(
			'post_status' => 'any',
		)
	);

	if ( $items ) {
		foreach ( $items as $item ) {
			if ( ! empty( $item->ID ) ) {
				wp_delete_post( (int) $item->ID, true );
			}
		}
	}

	$order = 0;
	foreach ( andromeda_primary_menu_item_definitions() as $slug => $label ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( ! $page || 'publish' !== $page->post_status ) {
			continue;
		}

		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => $label,
				'menu-item-object'    => 'page',
				'menu-item-object-id' => (int) $page->ID,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-position'  => ++$order,
			)
		);
	}
}

/**
 * Create or sync primary navigation and assign it to the theme location.
 *
 * @param bool $force_sync Rebuild menu items and reassign the primary location.
 * @return int Menu term ID or 0.
 */
function andromeda_ensure_primary_navigation_menu( $force_sync = false ) {
	if ( wp_installing() ) {
		return 0;
	}

	$menu_id = andromeda_get_or_create_primary_menu();
	if ( ! $menu_id ) {
		return 0;
	}

	$locations   = get_theme_mod( 'nav_menu_locations', array() );
	$assigned_id = isset( $locations['primary'] ) ? (int) $locations['primary'] : 0;

	$should_sync = $force_sync
		|| ! $assigned_id
		|| $assigned_id !== (int) $menu_id
		|| andromeda_primary_menu_needs_sync( $menu_id );

	if ( $should_sync ) {
		andromeda_sync_primary_menu_items( $menu_id );
		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	return $menu_id;
}

/**
 * Run the full bootstrap sequence.
 *
 * @param bool $flush_rewrites Whether to flush rewrite rules.
 * @return array{pages: array, menu_id: int, messages: string[]}
 */
function andromeda_run_site_bootstrap( $flush_rewrites = true ) {
	$messages     = array();
	$prev_version = (int) get_option( 'andromeda_site_bootstrap_version', 0 );

	andromeda_bootstrap_run_migrations();

	$customizer_seeded = andromeda_seed_customizer_defaults();
	if ( $customizer_seeded > 0 ) {
		$messages[] = __( 'Customizer contact and social defaults applied.', 'innovare' );
	}

	$pages = andromeda_ensure_core_site_pages();
	andromeda_sync_core_page_templates( true );
	andromeda_bootstrap_legal_and_solutions();

	$solutions_seed = andromeda_seed_solutions_data( false );
	if ( ! empty( $solutions_seed['updated'] ) ) {
		$messages[] = __( 'Solution content synced to the database from theme defaults.', 'innovare' );
	}

	$team_seed = andromeda_seed_team_data( false );
	if ( ! empty( $team_seed['updated'] ) ) {
		$messages[] = __( 'Core team content synced to the database from theme defaults.', 'innovare' );
	}

	if ( ! empty( $pages['created'] ) ) {
		$messages[] = sprintf(
			/* translators: %s: comma-separated page slugs */
			__( 'Created pages: %s', 'innovare' ),
			implode( ', ', $pages['created'] )
		);
	}

	andromeda_configure_reading_settings( true );
	andromeda_maybe_set_default_site_title();
	$menu_id = andromeda_ensure_primary_navigation_menu( true );

	if ( $menu_id ) {
		$messages[] = __( 'Primary navigation menu synced and assigned.', 'innovare' );
	}

	$messages[] = __( 'Solution detail pages synced from theme data.', 'innovare' );
	$messages[] = sprintf(
		/* translators: %d: solutions data version */
		__( 'Solutions database version: %d.', 'innovare' ),
		(int) get_option( ANDROMEDA_SOLUTIONS_VERSION_OPTION, 0 )
	);
	$messages[] = __( 'Legal pages (Privacy, Terms, Sitemap) ensured.', 'innovare' );

	andromeda_clear_theme_runtime_cache();

	if ( $prev_version < ANDROMEDA_SITE_BOOTSTRAP_VERSION ) {
		$messages[] = sprintf(
			/* translators: %d: bootstrap version number */
			__( 'Bootstrap upgraded to version %d.', 'innovare' ),
			ANDROMEDA_SITE_BOOTSTRAP_VERSION
		);
	}

	update_option( 'andromeda_site_bootstrap_version', ANDROMEDA_SITE_BOOTSTRAP_VERSION, false );
	update_option( 'andromeda_site_bootstrap_last_run', time(), false );

	if ( $flush_rewrites ) {
		flush_rewrite_rules( false );
		$messages[] = __( 'Rewrite rules flushed.', 'innovare' );
	}

	return array(
		'pages'    => $pages,
		'menu_id'  => $menu_id,
		'messages' => $messages,
	);
}

/**
 * Bootstrap on theme activation.
 */
function andromeda_on_theme_activation_bootstrap() {
	andromeda_run_site_bootstrap( true );
}
add_action( 'after_switch_theme', 'andromeda_on_theme_activation_bootstrap' );

/**
 * Auto-run bootstrap when the theme bootstrap version is bumped on deploy.
 */
function andromeda_maybe_upgrade_site_bootstrap() {
	if ( wp_installing() ) {
		return;
	}

	$stored = (int) get_option( 'andromeda_site_bootstrap_version', 0 );
	if ( $stored >= ANDROMEDA_SITE_BOOTSTRAP_VERSION ) {
		return;
	}

	andromeda_run_site_bootstrap( true );
}
add_action( 'init', 'andromeda_maybe_upgrade_site_bootstrap', 11 );

/**
 * Ensure core content exists on every load (same pattern as legal-pages.php).
 */
function andromeda_bootstrap_site_content() {
	static $done = false;
	if ( $done || wp_installing() ) {
		return;
	}
	$done = true;

	andromeda_bootstrap_run_migrations();
	andromeda_seed_customizer_defaults();
	andromeda_ensure_core_site_pages();
	andromeda_sync_core_page_templates();
	andromeda_bootstrap_legal_and_solutions();
	andromeda_seed_solutions_data( false );
	andromeda_seed_team_data( false );
	andromeda_configure_reading_settings();
	andromeda_ensure_primary_navigation_menu();
	andromeda_clear_theme_runtime_cache();
}
add_action( 'init', 'andromeda_bootstrap_site_content', 12 );

/**
 * Admin: Appearance → Site Setup — manual import / status.
 */
function andromeda_site_setup_admin_menu() {
	add_theme_page(
		__( 'Innovate — Site Setup', 'innovare' ),
		__( 'Site Setup', 'innovare' ),
		'manage_options',
		'andromeda-site-setup',
		'andromeda_site_setup_admin_page'
	);
}
add_action( 'admin_menu', 'andromeda_site_setup_admin_menu' );

/**
 * Render Site Setup admin page.
 */
function andromeda_site_setup_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$ran     = false;
	$results = null;
	$reset_solutions = false;
	$reset_team      = false;

	if ( isset( $_POST['andromeda_reset_solutions'] ) && check_admin_referer( 'andromeda_reset_solutions' ) ) {
		andromeda_reset_solutions_data();
		$reset_solutions = true;
	}

	if ( isset( $_POST['andromeda_reset_team'] ) && check_admin_referer( 'andromeda_reset_team' ) ) {
		andromeda_reset_team_data();
		$reset_team = true;
	}

	if ( isset( $_POST['andromeda_run_bootstrap'] ) && check_admin_referer( 'andromeda_site_bootstrap' ) ) {
		$results = andromeda_run_site_bootstrap( true );
		$ran     = true;
	}

	$definitions = andromeda_core_page_definitions();
	?>
	<div class="wrap">
		<h1><?php echo esc_html( sprintf( __( '%s — Site Setup', 'innovare' ), andromeda_brand_name() ) ); ?></h1>
		<p><?php esc_html_e( 'Import core pages, navigation, Customizer defaults, solution detail pages, and migrations for production deploys. Safe to run multiple times — existing custom content is not overwritten.', 'innovare' ); ?></p>

		<p class="description">
			<?php
			$last_run = get_option( 'andromeda_site_bootstrap_last_run' );
			$last_run_label = $last_run
				? wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), (int) $last_run )
				: __( 'never', 'innovare' );
			printf(
				/* translators: 1: bootstrap version, 2: last run date/time or "never" */
				esc_html__( 'Bootstrap version: %1$d · Last run: %2$s', 'innovare' ),
				(int) get_option( 'andromeda_site_bootstrap_version', 0 ),
				esc_html( $last_run_label )
			);
			?>
		</p>

		<?php if ( $reset_team ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'Core team content reset to theme defaults in the database.', 'innovare' ); ?></strong></p>
			</div>
		<?php endif; ?>

		<?php if ( $reset_solutions ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'Solution content reset to theme defaults in the database.', 'innovare' ); ?></strong></p>
			</div>
		<?php endif; ?>

		<?php if ( $ran && $results ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'Site setup completed.', 'innovare' ); ?></strong></p>
				<?php if ( ! empty( $results['messages'] ) ) : ?>
					<ul style="list-style:disc;margin-left:1.5em;">
						<?php foreach ( $results['messages'] as $msg ) : ?>
							<li><?php echo esc_html( $msg ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<h2><?php esc_html_e( 'Core pages', 'innovare' ); ?></h2>
		<table class="widefat striped" style="max-width:720px;">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Slug', 'innovare' ); ?></th>
					<th><?php esc_html_e( 'Title', 'innovare' ); ?></th>
					<th><?php esc_html_e( 'Status', 'innovare' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $definitions as $slug => $def ) : ?>
					<?php
					$page   = get_page_by_path( $slug, OBJECT, 'page' );
					$status = ( $page && 'publish' === $page->post_status )
						? __( 'Published', 'innovare' )
						: __( 'Missing', 'innovare' );
					?>
					<tr>
						<td><code><?php echo esc_html( $slug ); ?></code></td>
						<td><?php echo esc_html( $def['title'] ); ?></td>
						<td><?php echo esc_html( $status ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h2 style="margin-top:2em;"><?php esc_html_e( 'Included in site setup', 'innovare' ); ?></h2>
		<ul style="list-style:disc;margin-left:1.5em;">
			<li><?php esc_html_e( 'Core pages with Innovate page templates', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Solution detail child pages under /solutions/ (titles + templates synced from theme)', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Privacy, Terms, and Sitemap pages', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Primary navigation menu synced to core pages and assigned to the header', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Static front page → Home and site title defaults', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Customizer contact, WhatsApp, address, map, and social link defaults', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Phone number migrations (+92 333 4106911)', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Legacy About page slug migration (company, about-us, about-andromeda-links → about)', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Legacy footer widgets removed — theme footer columns restored (Company, Services, Solutions, Contact)', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Site title migration (Top Notch / Andromeda Links → Innovate)', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Core team members in wp_options (About page #team section)', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Solutions data cache cleared (bundled defaults synced)', 'innovare' ); ?></li>
			<li><?php esc_html_e( 'Rewrite rules flushed', 'innovare' ); ?></li>
		</ul>
		<p class="description"><?php esc_html_e( 'Solution page content is stored in the WordPress database and seeded from theme defaults on setup. Deploy updated theme files, then run site setup to sync — or reset solutions below to overwrite with bundled defaults.', 'innovare' ); ?></p>

		<h2 style="margin-top:2em;"><?php esc_html_e( 'Core team (database)', 'innovare' ); ?></h2>
		<p class="description">
			<?php
			printf(
				/* translators: 1: stored version, 2: theme bundled version */
				esc_html__( 'Stored version: %1$d · Theme defaults version: %2$d · Option key: andromeda_team_data', 'innovare' ),
				(int) get_option( ANDROMEDA_TEAM_VERSION_OPTION, 0 ),
				(int) ANDROMEDA_TEAM_DATA_VERSION
			);
			?>
		</p>
		<?php
		$team_members = andromeda_get_team_members( false );
		if ( $team_members ) :
			?>
			<table class="widefat striped" style="max-width:720px;margin-bottom:1em;">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Name', 'innovare' ); ?></th>
						<th><?php esc_html_e( 'Role', 'innovare' ); ?></th>
						<th><?php esc_html_e( 'Visible', 'innovare' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $team_members as $member ) : ?>
						<tr>
							<td><?php echo esc_html( $member['name'] ); ?></td>
							<td><?php echo esc_html( $member['role'] ); ?></td>
							<td><?php echo ! empty( $member['visible'] ) ? esc_html__( 'Yes', 'innovare' ) : esc_html__( 'No', 'innovare' ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else : ?>
			<p><?php esc_html_e( 'No team members stored yet — run site setup to seed defaults.', 'innovare' ); ?></p>
		<?php endif; ?>
		<form method="post" style="margin-bottom:2em;">
			<?php wp_nonce_field( 'andromeda_reset_team' ); ?>
			<p>
				<button type="submit" name="andromeda_reset_team" class="button button-secondary" onclick="return confirm('<?php echo esc_js( __( 'Reset core team content to theme defaults? Custom database edits will be lost.', 'innovare' ) ); ?>');">
					<?php esc_html_e( 'Reset core team to theme defaults', 'innovare' ); ?>
				</button>
			</p>
			<p class="description"><?php esc_html_e( 'Powers the About page team section. Edit wp_options (andromeda_team_data) or reset here after theme updates.', 'innovare' ); ?></p>
		</form>

		<h2 style="margin-top:2em;"><?php esc_html_e( 'Solutions content (database)', 'innovare' ); ?></h2>
		<p class="description">
			<?php
			printf(
				/* translators: 1: stored version, 2: theme bundled version */
				esc_html__( 'Stored version: %1$d · Theme defaults version: %2$d', 'innovare' ),
				(int) get_option( ANDROMEDA_SOLUTIONS_VERSION_OPTION, 0 ),
				(int) ANDROMEDA_SOLUTIONS_DATA_VERSION
			);
			?>
		</p>
		<form method="post" style="margin-bottom:2em;">
			<?php wp_nonce_field( 'andromeda_reset_solutions' ); ?>
			<p>
				<button type="submit" name="andromeda_reset_solutions" class="button button-secondary" onclick="return confirm('<?php echo esc_js( __( 'Reset all solution content to theme defaults? Custom database edits will be lost.', 'innovare' ) ); ?>');">
					<?php esc_html_e( 'Reset solutions content to theme defaults', 'innovare' ); ?>
				</button>
			</p>
			<p class="description"><?php esc_html_e( 'Writes bundled defaults to wp_options (andromeda_solutions_data). Use after a theme update when you want the latest solution copy and engagement steps.', 'innovare' ); ?></p>
		</form>

		<form method="post" style="margin-top:2em;">
			<?php wp_nonce_field( 'andromeda_site_bootstrap' ); ?>
			<p>
				<button type="submit" name="andromeda_run_bootstrap" class="button button-primary button-hero">
					<?php esc_html_e( 'Run site setup / import content', 'innovare' ); ?>
				</button>
			</p>
			<p class="description">
				<?php esc_html_e( 'CLI alternative: php wp-content/themes/Innovare/scripts/bootstrap-site-content.php', 'innovare' ); ?>
			</p>
		</form>
	</div>
	<?php
}
