<?php
/**
 * Seed demo blog posts for the Insights page layout (hero + highlights + masonry).
 *
 * Run (from anywhere):
 *
 *   php wp-content/themes/innovare/scripts/seed-insights-demo-posts.php
 *
 * Re-run safe: removes any posts marked `_andromeda_insights_demo` then recreates them.
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

if ( ! function_exists( 'wp_insert_post' ) ) {
	fwrite( STDERR, "WordPress did not load.\n" );
	exit( 1 );
}

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$demo_meta_key   = '_andromeda_insights_demo';
$demo_meta_value = 'v1';

// Remove previous demo posts.
$existing = get_posts(
	array(
		'post_type'      => 'post',
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'meta_key'       => $demo_meta_key,
		'meta_value'     => $demo_meta_value,
		'fields'         => 'ids',
	)
);
foreach ( $existing as $eid ) {
	wp_delete_post( (int) $eid, true );
}

/**
 * Ensure a category exists; return term ID.
 *
 * @param string $name Category name.
 * @param string $slug Category slug.
 * @return int
 */
function andromeda_seed_ensure_cat( $name, $slug ) {
	$term = get_term_by( 'slug', $slug, 'category' );
	if ( $term && ! is_wp_error( $term ) ) {
		return (int) $term->term_id;
	}
	$r = wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
	if ( is_wp_error( $r ) ) {
		return 0;
	}
	return (int) $r['term_id'];
}

$cat_networking    = andromeda_seed_ensure_cat( 'Networking', 'networking' );
$cat_security      = andromeda_seed_ensure_cat( 'Security', 'security' );
$cat_continuity    = andromeda_seed_ensure_cat( 'Continuity', 'continuity' );
$cat_infrastructure = andromeda_seed_ensure_cat( 'Infrastructure', 'infrastructure' );

$posts_def = array(
	array(
		'slug'    => 'andromeda-demo-office-wifi-basics',
		'title'   => 'Designing dependable office WiFi for growing teams',
		'cat'     => $cat_networking,
		'excerpt' => 'Coverage, capacity and clean handoffs — what we look at before we touch a single access point.',
		'date'    => '2025-03-12 09:00:00',
		'sticky'  => false,
		'pic_id'  => 1015,
	),
	array(
		'slug'    => 'andromeda-demo-backup-rpo-rto',
		'title'   => 'Translating RPO and RTO into a backup architecture you can test',
		'cat'     => $cat_continuity,
		'excerpt' => 'Paper policies fail when disks fail. Here is how we turn recovery targets into engineered reality.',
		'date'    => '2025-04-02 10:30:00',
		'sticky'  => false,
		'pic_id'  => 1018,
	),
	array(
		'slug'    => 'andromeda-demo-m365-hardening',
		'title'   => 'A practical Microsoft 365 hardening checklist for SMEs',
		'cat'     => $cat_security,
		'excerpt' => 'Identity, mail flow and collaboration settings that close the gaps we see most often on tenant reviews.',
		'date'    => '2025-05-18 14:00:00',
		'sticky'  => false,
		'pic_id'  => 1019,
	),
	array(
		'slug'    => 'andromeda-demo-firewall-rules',
		'title'   => 'Firewall rules that match the business, not the vendor defaults',
		'cat'     => $cat_security,
		'excerpt' => 'Why “allow any” creep happens — and how we document intent so audits and incidents are survivable.',
		'date'    => '2025-06-07 11:15:00',
		'sticky'  => false,
		'pic_id'  => 1020,
	),
	array(
		'slug'    => 'andromeda-demo-infra-mistakes',
		'title'   => 'Seven infrastructure mistakes we undo in the first month of an engagement',
		'cat'     => $cat_infrastructure,
		'excerpt' => 'Flat networks, mystery servers and “temporary” VPNs — patterns we replace with something measurable.',
		'date'    => '2025-08-22 09:45:00',
		'sticky'  => false,
		'pic_id'  => 1021,
	),
	array(
		'slug'    => 'andromeda-demo-branch-connectivity',
		'title'   => 'Multi-site connectivity without a spaghetti diagram',
		'cat'     => $cat_networking,
		'excerpt' => 'Templates for branch rollouts that keep HQ and field sites on the same policy baseline.',
		'date'    => '2026-01-10 08:00:00',
		'sticky'  => false,
		'pic_id'  => 1022,
	),
	array(
		'slug'    => 'andromeda-demo-identity-lifecycle',
		'title'   => 'User lifecycle hygiene that makes offboarding boring (in a good way)',
		'cat'     => $cat_security,
		'excerpt' => 'Joiners, movers and leavers — tying directory, mailboxes and SaaS seats to one accountable runbook.',
		'date'    => '2026-04-28 16:20:00',
		'sticky'  => true,
		'pic_id'  => 1033,
	),
	array(
		'slug'    => 'andromeda-demo-field-notes-2026',
		'title'   => 'Field notes: what “stable IT” looks like after the first 90 days',
		'cat'     => $cat_infrastructure,
		'excerpt' => 'Signals we track with clients — tickets trending down, documented changes up, and leadership reading the same numbers.',
		'date'    => '2026-05-14 12:00:00',
		'sticky'  => true,
		'pic_id'  => 1062,
	),
	array(
		'slug'    => 'andromeda-demo-dr-tabletop',
		'title'   => 'Running a disaster-recovery tabletop that engineers actually respect',
		'cat'     => $cat_continuity,
		'excerpt' => 'Scenarios that reflect your dependencies, not generic ransomware bingo — and how we capture follow-ups.',
		'date'    => '2026-05-13 10:00:00',
		'sticky'  => false,
		'pic_id'  => 1036,
	),
);

$body_tpl = '<p>%s</p><p>%s</p><p><em>%s</em></p>';

$created = 0;
foreach ( $posts_def as $def ) {
	$p1 = 'Operations leaders rarely get a quiet week — which is why we write infrastructure changes in small batches, with rollback paths and owners named in the ticket.';
	$p2 = 'This article expands on patterns we use on real engagements. Replace or extend it from the WordPress editor; it is safe demo content tagged for removal by the seed script.';
	$p3 = 'Demo post for Innovare Insights layout — delete via re-running the seed script or remove the _andromeda_insights_demo meta in the database.';

	$post_id = wp_insert_post(
		array(
			'post_title'   => $def['title'],
			'post_name'    => $def['slug'],
			'post_status'  => 'publish',
			'post_type'    => 'post',
			'post_date'    => $def['date'],
			'post_content' => sprintf( $body_tpl, $p1, $p2, $p3 ),
			'post_excerpt' => $def['excerpt'],
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		echo 'Error creating ' . $def['slug'] . ': ' . $post_id->get_error_message() . "\n";
		continue;
	}

	$post_id = (int) $post_id;
	update_post_meta( $post_id, $demo_meta_key, $demo_meta_value );

	if ( ! empty( $def['cat'] ) ) {
		wp_set_post_categories( $post_id, array( (int) $def['cat'] ) );
	}

	$img_url = sprintf( 'https://picsum.photos/id/%d/960/600.jpg', (int) $def['pic_id'] );
	$tmp     = download_url( $img_url );
	if ( ! is_wp_error( $tmp ) ) {
		$file_array = array(
			'name'     => 'andromeda-demo-' . $def['slug'] . '.jpg',
			'tmp_name' => $tmp,
		);
		$att_id = media_handle_sideload( $file_array, $post_id, 'Insights demo image for ' . $def['title'] );
		if ( ! is_wp_error( $att_id ) ) {
			set_post_thumbnail( $post_id, (int) $att_id );
		} else {
			@unlink( $tmp );
			echo 'Thumbnail sideload warning for ' . $def['slug'] . ': ' . $att_id->get_error_message() . "\n";
		}
	} else {
		echo 'Thumbnail download skipped for ' . $def['slug'] . ': ' . $tmp->get_error_message() . "\n";
	}

	if ( ! empty( $def['sticky'] ) ) {
		stick_post( $post_id );
	}

	++$created;
}

flush_rewrite_rules( false );

echo "Seeded {$created} demo post(s). Two are sticky (newest sticky = hero on Insights). Visit /insights/\n";
echo "Remove: run this script again (it deletes demo posts first) or delete posts manually.\n";
