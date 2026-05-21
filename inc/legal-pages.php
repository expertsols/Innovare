<?php
/**
 * Bootstrap core pages: Privacy, Terms, Sitemap, and solution detail child pages.
 *
 * Runs idempotently on each request (batched queries) so links always resolve after
 * theme activation — no fragile one-shot flag.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Legal page definitions keyed by slug.
 *
 * @return array<string, array{title: string, template: string, content: string}>
 */
function innovare_legal_page_definitions() {
	return array(
		'privacy' => array(
			'title'    => __( 'Privacy Policy', 'innovare' ),
			'template' => 'page-templates/template-legal-document.php',
			'content'  => '<p>' . esc_html__( 'This page is a starter privacy policy. Replace this text with your organization’s final policy, or edit this page in the WordPress admin under Pages.', 'innovare' ) . '</p>',
		),
		'terms'          => array(
			'title'    => __( 'Terms of Use', 'innovare' ),
			'template' => 'page-templates/template-legal-document.php',
			'content'  => '<p>' . esc_html__( 'These terms govern use of this website and related communications. Replace this placeholder with your organization’s final terms of use.', 'innovare' ) . '</p>',
		),
		'sitemap'        => array(
			'title'    => __( 'Sitemap', 'innovare' ),
			'template' => 'page-templates/template-sitemap.php',
			'content'  => '<p>' . esc_html__( 'Quick links to main sections of this site. You can add an introduction above or below the generated lists by editing this page.', 'innovare' ) . '</p>',
		),
	);
}

/**
 * Rename legacy `privacy-policy` slug to `privacy` so the site uses /privacy/.
 */
function innovare_migrate_privacy_page_slug() {
	if ( wp_installing() || get_option( 'innovare_privacy_slug_migrated_v1', false ) ) {
		return;
	}

	$privacy = get_page_by_path( 'privacy', OBJECT, 'page' );
	if ( $privacy && 'publish' === $privacy->post_status ) {
		update_option( 'innovare_privacy_slug_migrated_v1', true, false );
		return;
	}

	$legacy = get_page_by_path( 'privacy-policy', OBJECT, 'page' );
	if ( $legacy && 'publish' === $legacy->post_status && ! $privacy ) {
		wp_update_post(
			array(
				'ID'        => (int) $legacy->ID,
				'post_name' => 'privacy',
			)
		);
	}

	update_option( 'innovare_privacy_slug_migrated_v1', true, false );
}

/**
 * Create published legal pages when missing (not in trash).
 */
function innovare_ensure_legal_pages() {
	if ( wp_installing() ) {
		return;
	}

	$definitions = innovare_legal_page_definitions();
	$slugs       = array_keys( $definitions );

	$existing = get_posts(
		array(
			'post_type'              => 'page',
			'post_status'            => 'publish',
			'post_name__in'          => $slugs,
			'posts_per_page'         => count( $slugs ),
			'orderby'                => 'none',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	$have = array();
	foreach ( $existing as $p ) {
		$have[ $p->post_name ] = true;
	}

	foreach ( $definitions as $slug => $def ) {
		if ( ! empty( $have[ $slug ] ) ) {
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

		update_post_meta( (int) $post_id, '_wp_page_template', $def['template'] );
	}
}

/**
 * Create /solutions/<slug>/ child pages for each entry in solutions data.
 */
function innovare_ensure_solution_detail_pages() {
	if ( wp_installing() || ! function_exists( 'innovare_get_solutions' ) ) {
		return;
	}

	$parent = get_page_by_path( 'solutions', OBJECT, 'page' );
	if ( ! $parent || 'publish' !== $parent->post_status ) {
		return;
	}

	$parent_id = (int) $parent->ID;
	$solutions = innovare_get_solutions();
	if ( empty( $solutions ) || ! is_array( $solutions ) ) {
		return;
	}

	$children = get_posts(
		array(
			'post_type'              => 'page',
			'post_status'            => 'publish',
			'post_parent'            => $parent_id,
			'posts_per_page'         => -1,
			'orderby'                => 'none',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	$have = array();
	foreach ( $children as $p ) {
		$have[ $p->post_name ] = (int) $p->ID;
	}

	$detail_template = 'page-templates/template-solution-detail.php';

	foreach ( $solutions as $slug => $data ) {
		$slug = sanitize_key( $slug );
		if ( ! $slug ) {
			continue;
		}

		$title = isset( $data['title'] ) ? $data['title'] : $slug;
		$stub  = '<!-- ' . __( 'Innovare solution detail — primary copy is maintained in the theme. Add optional long-form content here.', 'innovare' ) . ' -->';

		if ( ! empty( $have[ $slug ] ) ) {
			$post_id = (int) $have[ $slug ];
			if ( $title && get_the_title( $post_id ) !== $title ) {
				wp_update_post(
					array(
						'ID'         => $post_id,
						'post_title' => $title,
					)
				);
			}
			update_post_meta( $post_id, '_wp_page_template', $detail_template );
			if ( 'publish' !== get_post_status( $post_id ) ) {
				wp_update_post(
					array(
						'ID'          => $post_id,
						'post_status' => 'publish',
					)
				);
			}
			continue;
		}

		$blocked = get_page_by_path( 'solutions/' . $slug, OBJECT, 'page' );
		if ( $blocked && 'trash' === $blocked->post_status ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_title'   => $title,
				'post_name'    => $slug,
				'post_parent'  => $parent_id,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => $stub,
			),
			true
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_post_meta( (int) $post_id, '_wp_page_template', $detail_template );
		update_post_meta( (int) $post_id, '_innovare_bootstrap_page', 'v1' );
	}
}

/**
 * Point WordPress “Privacy Policy page” at the published /privacy/ page when unset or broken.
 */
function innovare_sync_privacy_policy_option() {
	if ( wp_installing() ) {
		return;
	}

	$current = (int) get_option( 'wp_page_for_privacy_policy' );
	if ( $current && 'publish' === get_post_status( $current ) ) {
		return;
	}

	$page = get_page_by_path( 'privacy', OBJECT, 'page' );
	if ( $page && 'publish' === $page->post_status ) {
		update_option( 'wp_page_for_privacy_policy', (int) $page->ID );
	}
}

/**
 * One hook: legal pages, solution children, then privacy option.
 */
function innovare_bootstrap_core_pages() {
	static $done = false;
	if ( $done || wp_installing() ) {
		return;
	}
	$done = true;

	innovare_migrate_privacy_page_slug();
	innovare_ensure_legal_pages();
	innovare_ensure_solution_detail_pages();
	innovare_sync_privacy_policy_option();
}
add_action( 'init', 'innovare_bootstrap_core_pages', 20 );

/**
 * Remove obsolete option from older theme versions (it could block creation).
 */
function innovare_remove_stale_legal_seed_flag() {
	if ( get_option( 'innovare_seed_legal_pages_done', false ) ) {
		delete_option( 'innovare_seed_legal_pages_done' );
	}
}
add_action( 'init', 'innovare_remove_stale_legal_seed_flag', 5 );
