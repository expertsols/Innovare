<?php
/**
 * Innovate — Solutions data.
 *
 * Single source of truth for the Solutions listing (template-solutions.php)
 * AND the per-solution detail pages (template-solution-detail.php).
 *
 * Each solution is keyed by its WordPress page slug (so /solutions/<slug>/
 * routes cleanly to a detail page when one exists).
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Bump when bundled solution defaults change — triggers DB sync on bootstrap. */
define( 'ANDROMEDA_SOLUTIONS_DATA_VERSION', 2 );

/** wp_options key for stored solution content. */
define( 'ANDROMEDA_SOLUTIONS_OPTION', 'andromeda_solutions_data' );

/** wp_options key for stored solutions data version. */
define( 'ANDROMEDA_SOLUTIONS_VERSION_OPTION', 'andromeda_solutions_data_version' );

/**
 * Return all solutions from the database (seeded from theme defaults).
 *
 * @return array<string, array>
 */
function andromeda_get_solutions() {
	$cached = wp_cache_get( 'innovare_solutions', 'innovare' );
	if ( false !== $cached ) {
		return $cached;
	}

	$stored = get_option( ANDROMEDA_SOLUTIONS_OPTION, null );
	if ( ! is_array( $stored ) || empty( $stored ) ) {
		$stored = andromeda_get_solutions_defaults();
	}

	wp_cache_set( 'innovare_solutions', $stored, 'innovare' );

	return $stored;
}

/**
 * Bundled default solution content (used to seed or reset the database).
 *
 * @return array<string, array>
 */
function andromeda_get_solutions_defaults() {
	$solutions = array(

		'microsoft-365' => array(
			'anchor'  => 'm365',
			'icon'    => 'cloud',
			'badge'   => __( 'Productivity', 'innovare' ),
			'title'   => __( 'Microsoft 365 Solutions', 'innovare' ),
			'lede'    => __( 'Email, identity, collaboration and security designed around your business policies — and supported day-two.', 'innovare' ),
			'summary' => __( 'We design Microsoft 365 the way your business actually uses it: tenant configuration, identity, conditional access, email hardening, collaboration policies — then continue to administer it as your environment evolves.', 'innovare' ),
			'whats_included' => array(
				__( 'Tenant setup, domain & licensing review', 'innovare' ),
				__( 'Identity, MFA & conditional access', 'innovare' ),
				__( 'Exchange Online & email hardening', 'innovare' ),
				__( 'Teams, SharePoint & OneDrive policies', 'innovare' ),
				__( 'Email & file migration from legacy systems', 'innovare' ),
				__( 'Long-term administration & user lifecycle', 'innovare' ),
			),
			'outcomes' => array(
				__( 'A Microsoft 365 estate that is secure by design, not by accident.', 'innovare' ),
				__( 'Clean identity & access — onboarding and offboarding in minutes.', 'innovare' ),
				__( 'A single accountable partner for tenant-level changes.', 'innovare' ),
			),
			'engagement' => array(
				array( 'label' => __( 'Tenant & identity audit', 'innovare' ), 'desc' => __( 'Assess current state, licensing and security posture.', 'innovare' ) ),
				array( 'label' => __( 'Design & migrate', 'innovare' ),         'desc' => __( 'Apply tenant baseline, harden identity, migrate mailboxes & files.', 'innovare' ) ),
				array( 'label' => __( 'Administer day-two', 'innovare' ),       'desc' => __( 'Run user lifecycle, policy updates and incident response.', 'innovare' ) ),
			),
			'best_for' => array(
				__( 'Businesses migrating from Google Workspace or on-prem Exchange', 'innovare' ),
				__( 'Companies that need an MSP to own day-two M365 operations', 'innovare' ),
				__( 'Teams hardening identity, MFA and conditional access', 'innovare' ),
			),
		),

		'business-continuity' => array(
			'anchor'  => 'continuity',
			'icon'    => 'continuity',
			'badge'   => __( 'Continuity', 'innovare' ),
			'title'   => __( 'Business Continuity', 'innovare' ),
			'lede'    => __( 'Backup, disaster recovery and resilience strategy that has been engineered, documented and actually tested.', 'innovare' ),
			'summary' => __( 'A real business continuity solution means more than a backup tool. We engineer the backup architecture, write the disaster-recovery procedure, run the restore drills and report on it — so an outage is a managed event, not a crisis.', 'innovare' ),
			'whats_included' => array(
				__( 'Backup architecture & retention policy', 'innovare' ),
				__( 'On-prem and cloud replication where applicable', 'innovare' ),
				__( 'Disaster-recovery runbooks & RPO/RTO targets', 'innovare' ),
				__( 'Periodic restore drills with reporting', 'innovare' ),
				__( 'Ransomware-aware immutability where supported', 'innovare' ),
				__( 'Quarterly continuity review with leadership', 'innovare' ),
			),
			'outcomes' => array(
				__( 'A documented, tested recovery plan — not a hopeful one.', 'innovare' ),
				__( 'Measurable recovery objectives (RPO / RTO) for each tier.', 'innovare' ),
				__( 'Confidence with leadership, auditors and insurers.', 'innovare' ),
			),
			'engagement' => array(
				array( 'label' => __( 'Risk & dependency map', 'innovare' ), 'desc' => __( 'Identify what must survive an outage and at what speed.', 'innovare' ) ),
				array( 'label' => __( 'Design & implement', 'innovare' ),    'desc' => __( 'Architect backup, replication and runbooks for each tier.', 'innovare' ) ),
				array( 'label' => __( 'Test & report', 'innovare' ),         'desc' => __( 'Run drills, report outcomes and refine over time.', 'innovare' ) ),
			),
			'best_for' => array(
				__( 'Businesses where downtime has a real cost (operations, finance, healthcare, etc.)', 'innovare' ),
				__( 'Teams preparing for audits, compliance or cyber-insurance', 'innovare' ),
				__( 'Organizations replacing tape-era backup with modern tooling', 'innovare' ),
			),
		),

		'managed-office-infrastructure' => array(
			'anchor'  => 'office',
			'icon'    => 'office',
			'badge'   => __( 'Infrastructure', 'innovare' ),
			'title'   => __( 'Managed Office Infrastructure', 'innovare' ),
			'lede'    => __( 'Networks, servers, identity, endpoints and security — turnkey for new offices and growing teams, then managed long-term.', 'innovare' ),
			'summary' => __( 'A complete office IT estate as a single, accountable engagement: structured network, WiFi, servers, identity, endpoints and security — designed up-front, deployed cleanly and managed long-term under measurable SLAs.', 'innovare' ),
			'whats_included' => array(
				__( 'Network design, structured cabling & WiFi', 'innovare' ),
				__( 'Server, identity & file services', 'innovare' ),
				__( 'Standardized end-user devices & imaging', 'innovare' ),
				__( 'Firewall, endpoint protection & secure access', 'innovare' ),
				__( 'Documented runbook for the entire office estate', 'innovare' ),
				__( 'Ongoing managed support with clear SLAs', 'innovare' ),
			),
			'outcomes' => array(
				__( 'A stable, modern office where IT is not the team\'s daily friction.', 'innovare' ),
				__( 'One partner for the network, servers, devices, security and support.', 'innovare' ),
				__( 'Predictable monthly IT spend instead of break-fix surprises.', 'innovare' ),
			),
			'engagement' => array(
				array( 'label' => __( 'Office walk-through & design', 'innovare' ), 'desc' => __( 'Map space, headcount, current systems and growth plans.', 'innovare' ) ),
				array( 'label' => __( 'Build & rollout', 'innovare' ),               'desc' => __( 'Cabling, WiFi, servers, devices and policy in one rollout.', 'innovare' ) ),
				array( 'label' => __( 'Manage day-to-day', 'innovare' ),             'desc' => __( 'Monitor, support and evolve the estate under SLAs.', 'innovare' ) ),
			),
			'best_for' => array(
				__( 'Businesses opening a new office or relocating', 'innovare' ),
				__( 'Growing teams outgrowing ad-hoc IT', 'innovare' ),
				__( 'Founders who want one accountable partner for "all of IT"', 'innovare' ),
			),
		),

		'network-security' => array(
			'anchor'  => 'netsec',
			'icon'    => 'security',
			'badge'   => __( 'Security', 'innovare' ),
			'title'   => __( 'Network Security Solutions', 'innovare' ),
			'lede'    => __( 'Segmented networks, next-gen firewalls and controlled remote access — built for organizations that take risk seriously.', 'innovare' ),
			'summary' => __( 'Network security is more than a firewall on the perimeter. We design segmented networks, engineered firewall policy, controlled remote access and continuous posture reviews — so the security story matches the operational reality.', 'innovare' ),
			'whats_included' => array(
				__( 'Network segmentation & policy design', 'innovare' ),
				__( 'Next-gen firewall sizing & rule engineering', 'innovare' ),
				__( 'Endpoint protection & device posture', 'innovare' ),
				__( 'Secure remote & site-to-site access', 'innovare' ),
				__( 'Email & identity hardening', 'innovare' ),
				__( 'Periodic posture review & hardening', 'innovare' ),
			),
			'outcomes' => array(
				__( 'A defensible, segmented network — not a flat trust zone.', 'innovare' ),
				__( 'Firewall rules that match the business, not the vendor defaults.', 'innovare' ),
				__( 'Continuous improvement instead of "set and forget".', 'innovare' ),
			),
			'engagement' => array(
				array( 'label' => __( 'Posture assessment', 'innovare' ), 'desc' => __( 'Audit network, identity, endpoints and current policy.', 'innovare' ) ),
				array( 'label' => __( 'Design & implement', 'innovare' ), 'desc' => __( 'Engineer segmentation, firewall policy and access controls.', 'innovare' ) ),
				array( 'label' => __( 'Review & harden', 'innovare' ),     'desc' => __( 'Quarterly review of posture, rules and incidents.', 'innovare' ) ),
			),
			'best_for' => array(
				__( 'Organizations with sensitive data (finance, healthcare, education, etc.)', 'innovare' ),
				__( 'Teams preparing for compliance audits or cyber-insurance', 'innovare' ),
				__( 'Businesses replacing aging firewalls with modern policy', 'innovare' ),
			),
		),

		'multi-branch-connectivity' => array(
			'anchor'  => 'multibranch',
			'icon'    => 'multi-site',
			'badge'   => __( 'Connectivity', 'innovare' ),
			'title'   => __( 'Multi-Branch Connectivity', 'innovare' ),
			'lede'    => __( 'Site-to-site links, unified policies and reliable inter-branch communications across HQ, branches and remote workers.', 'innovare' ),
			'summary' => __( 'Multi-branch IT only works when every branch feels like an extension of HQ. We design the inter-site connectivity, standardize branch network templates and centrally monitor performance across the whole estate.', 'innovare' ),
			'whats_included' => array(
				__( 'Site-to-site VPN & SD-WAN style routing', 'innovare' ),
				__( 'Standardized branch network templates', 'innovare' ),
				__( 'Central monitoring across all sites', 'innovare' ),
				__( 'Unified firewall & access policy', 'innovare' ),
				__( 'Branch fail-over & link redundancy', 'innovare' ),
				__( 'Remote-worker access aligned with branch policy', 'innovare' ),
			),
			'outcomes' => array(
				__( 'Branches that operate like extensions of HQ — same policies, same experience.', 'innovare' ),
				__( 'Visibility into link health and incidents across all sites.', 'innovare' ),
				__( 'Faster, repeatable rollouts when a new branch opens.', 'innovare' ),
			),
			'engagement' => array(
				array( 'label' => __( 'Topology & needs mapping', 'innovare' ), 'desc' => __( 'Inventory sites, links, dependencies and growth plans.', 'innovare' ) ),
				array( 'label' => __( 'Design & roll out', 'innovare' ),         'desc' => __( 'Standardize branch design, deploy links and policy.', 'innovare' ) ),
				array( 'label' => __( 'Operate & extend', 'innovare' ),          'desc' => __( 'Monitor, support and replicate the template per new branch.', 'innovare' ) ),
			),
			'best_for' => array(
				__( 'Businesses operating across multiple offices or stores', 'innovare' ),
				__( 'Teams with growing hybrid / remote workforce', 'innovare' ),
				__( 'Organizations replacing point-to-point patchwork connectivity', 'innovare' ),
			),
		),

	);

	return $solutions;
}

/**
 * Seed or update solution content in wp_options from theme defaults.
 *
 * @param bool $force_reset When true, overwrite all stored solution content.
 * @return array{updated: bool, version: int, forced: bool}
 */
function andromeda_seed_solutions_data( $force_reset = false ) {
	$defaults   = andromeda_get_solutions_defaults();
	$theme_ver  = ANDROMEDA_SOLUTIONS_DATA_VERSION;
	$stored_ver = (int) get_option( ANDROMEDA_SOLUTIONS_VERSION_OPTION, 0 );
	$existing   = get_option( ANDROMEDA_SOLUTIONS_OPTION, null );

	$needs_seed = ! is_array( $existing ) || empty( $existing );
	$needs_sync = $stored_ver < $theme_ver;
	$updated    = false;

	if ( $force_reset || $needs_seed || $needs_sync ) {
		update_option( ANDROMEDA_SOLUTIONS_OPTION, $defaults, false );
		update_option( ANDROMEDA_SOLUTIONS_VERSION_OPTION, $theme_ver, false );
		andromeda_clear_solutions_cache();
		$updated = true;
	}

	return array(
		'updated' => $updated,
		'version' => (int) get_option( ANDROMEDA_SOLUTIONS_VERSION_OPTION, $theme_ver ),
		'forced'  => (bool) $force_reset,
	);
}

/**
 * Reset all solution content in the database to theme defaults.
 *
 * @return array{updated: bool, version: int, forced: bool}
 */
function andromeda_reset_solutions_data() {
	return andromeda_seed_solutions_data( true );
}

/**
 * Clear cached solution data.
 */
function andromeda_clear_solutions_cache() {
	wp_cache_delete( 'innovare_solutions', 'innovare' );
}

/**
 * Return a single solution by slug, or null.
 *
 * @param string $slug Solution slug.
 * @return array|null
 */
function andromeda_get_solution( $slug ) {
	$all = andromeda_get_solutions();
	$slug = sanitize_key( $slug );
	return isset( $all[ $slug ] ) ? $all[ $slug ] : null;
}

/**
 * Return the URL for a solution's detail page, or null if it doesn't exist.
 * Detail pages are expected to live under /solutions/<slug>/.
 *
 * @param string $slug Solution slug.
 * @return string|null
 */
function andromeda_get_solution_url( $slug ) {
	$slug = sanitize_key( $slug );
	if ( ! $slug ) {
		return null;
	}
	$page = get_page_by_path( 'solutions/' . $slug );
	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}
	return null;
}

/**
 * URL for a solution detail page, or the solutions listing with anchor as fallback.
 *
 * @param string $slug Solution key from andromeda_get_solutions().
 * @return string
 */
function andromeda_solution_page_url( $slug ) {
	$slug = sanitize_key( $slug );
	$direct = andromeda_get_solution_url( $slug );
	if ( $direct ) {
		return $direct;
	}

	$solution = andromeda_get_solution( $slug );
	$anchor   = ( $solution && ! empty( $solution['anchor'] ) ) ? sanitize_key( (string) $solution['anchor'] ) : $slug;

	return andromeda_page_url( 'solutions' ) . '#' . $anchor;
}
