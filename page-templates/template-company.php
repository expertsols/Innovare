<?php
/**
 * Template Name: Innovare — Company
 *
 * Replaces the legacy "About" page. Communicates Innovare as a
 * Managed IT & Business Technology Partner — not a reseller.
 *
 * Sections (per the brief):
 *  - About Innovare
 *  - Mission & Vision
 *  - Operational Excellence + Technology Expertise + Engineering-first mindset
 *  - Industries Served
 *  - Social Presence
 *  - Core team (names, roles, bios, social links — edit $core_team below)
 *
 * Page slug in WordPress should be `about-andromeda-links` (see
 * `scripts/migrate-company-to-about-page.php` once to rename from `company`).
 *
 * @package Innovare
 */

get_header();

andromeda_page_header(
	__( 'About Innovare', 'innovare' ),
	__( 'A modern IT infrastructure & business technology partner', 'innovare' ),
	__( 'Innovare designs, deploys, secures and manages the technology that keeps businesses running — with a small, accountable engineering team and operational discipline.', 'innovare' )
);

/**
 * Core team — edit this array with real people, roles, short bios and profile URLs.
 * Supported social keys: linkedin, x (Twitter), facebook, instagram, github, website.
 * Omit a key or leave its URL empty to hide that icon.
 */
$core_team = array(
	array(
		'name'   => __( 'Akhlaq Ahmad', 'innovare' ),
		'role'   => __( 'Founder', 'innovare' ),
		'bio'    => __( 'Founder of Innovare — focused on reliable IT infrastructure, managed services and accountable delivery for growing organizations.', 'innovare' ),
		'photo'  => '',
		'social' => array(
			'linkedin' => 'https://www.linkedin.com/in/akhlaqsipra/',
		),
	),
);

$core_team_social_icons = array(
	'linkedin'  => 'bi-linkedin',
	'x'         => 'bi-twitter-x',
	'twitter'   => 'bi-twitter-x',
	'facebook'  => 'bi-facebook',
	'instagram' => 'bi-instagram',
	'github'    => 'bi-github',
	'website'   => 'bi-globe2',
);

$pillars = array(
	array(
		'icon'  => 'consulting',
		'title' => __( 'Engineering-first mindset', 'innovare' ),
		'desc'  => __( 'We start with the business problem, then choose the right design and the right vendors — in that order.', 'innovare' ),
	),
	array(
		'icon'  => 'speed',
		'title' => __( 'Operational excellence', 'innovare' ),
		'desc'  => __( 'Clear processes, repeatable procedures and reporting that lets leadership act on what is actually happening.', 'innovare' ),
	),
	array(
		'icon'  => 'infrastructure',
		'title' => __( 'Technology expertise', 'innovare' ),
		'desc'  => __( 'Networks, servers, security, identity and enterprise software — done properly, documented and maintained.', 'innovare' ),
	),
	array(
		'icon'  => 'support',
		'title' => __( 'Support-first delivery', 'innovare' ),
		'desc'  => __( 'Day-two operations matter more than launch day. We build for the years after go-live, not the demo.', 'innovare' ),
	),
);

$industries = array(
	array( 'icon' => 'education',     'title' => __( 'Education', 'innovare' ) ),
	array( 'icon' => 'government',    'title' => __( 'Government', 'innovare' ) ),
	array( 'icon' => 'corporate',     'title' => __( 'Corporate Offices', 'innovare' ) ),
	array( 'icon' => 'manufacturing', 'title' => __( 'Manufacturing', 'innovare' ) ),
	array( 'icon' => 'sme',           'title' => __( 'SMEs', 'innovare' ) ),
);
?>

<section class="andromeda-section andromeda-about-page">
	<div class="container">

		<div class="row align-items-center gx-lg-5 gy-4 mb-5 mb-lg-6">
			<div class="col-lg-6">
				<span class="eyebrow"><?php esc_html_e( 'About Innovare', 'innovare' ); ?></span>
				<h2><?php esc_html_e( 'A focused IT infrastructure & managed services team', 'innovare' ); ?></h2>
				<p class="about-founded">
					<i class="bi bi-calendar3" aria-hidden="true"></i>
					<?php esc_html_e( 'Innovare was started in October 2018.', 'innovare' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'Innovare is an IT infrastructure and business technology company. We work with growing organizations across education, government, corporate offices, manufacturing and SME sectors — providing managed IT services, enterprise infrastructure, network security, business continuity and enterprise software solutions under one accountable partnership.', 'innovare' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'Our model is deliberately simple: a small team of engineers, clear SLAs, honest reporting and long-term relationships. We are not a reseller and we are not a break-fix vendor.', 'innovare' ); ?>
				</p>
				<p class="company-solutions-note">
					<?php esc_html_e( 'SkilledIM HRM and Silver Accounting are business solutions under Innovare — deployed, integrated and supported by the same engineering team that runs your infrastructure.', 'innovare' ); ?>
				</p>
			</div>
			<div class="col-lg-6">
				<div class="about-pillars">
					<div class="about-pillar">
						<strong><?php esc_html_e( 'Mission', 'innovare' ); ?></strong>
						<p><?php esc_html_e( 'To make reliable, well-engineered IT infrastructure and business technology accessible to organizations that need it — without forcing them to build a large internal team to get it.', 'innovare' ); ?></p>
					</div>
					<div class="about-pillar">
						<strong><?php esc_html_e( 'Vision', 'innovare' ); ?></strong>
						<p><?php esc_html_e( 'A market where every growing business has a real infrastructure and technology partner — engineering-first, accountable and long-term.', 'innovare' ); ?></p>
					</div>
				</div>
			</div>
		</div>

		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'How we operate', 'innovare' ); ?></span>
			<h2><?php esc_html_e( 'Four principles that shape every engagement', 'innovare' ); ?></h2>
		</div>

		<div class="row g-3 g-lg-4">
			<?php foreach ( $pillars as $p ) : ?>
				<div class="col-sm-6 col-lg-3">
					<div class="value-card">
						<span class="value-card-icon"><?php andromeda_icon( $p['icon'] ); ?></span>
						<h3 class="value-card-title"><?php echo esc_html( $p['title'] ); ?></h3>
						<p class="value-card-desc"><?php echo esc_html( $p['desc'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<?php if ( ! empty( $core_team ) && is_array( $core_team ) ) : ?>
		<div class="core-team-section mt-5 mt-lg-6" id="team">
			<div class="section-heading mb-4 mb-lg-5">
				<span class="eyebrow"><?php esc_html_e( 'Leadership & core team', 'innovare' ); ?></span>
				<h2><?php esc_html_e( 'The people behind your technology partnership', 'innovare' ); ?></h2>
				<p class="mb-0"><?php esc_html_e( 'A small, senior team — accountable, reachable and aligned with how your organization actually runs.', 'innovare' ); ?></p>
			</div>
			<?php
			$core_team_count = count( $core_team );
			$team_col_class  = $core_team_count > 1 ? 'col-12 col-lg-6' : 'col-12';
			?>
			<div class="row g-4">
				<?php foreach ( $core_team as $member ) : ?>
					<?php
					$m_name   = isset( $member['name'] ) ? $member['name'] : '';
					$m_role   = isset( $member['role'] ) ? $member['role'] : '';
					$m_bio    = isset( $member['bio'] ) ? $member['bio'] : '';
					$m_photo  = isset( $member['photo'] ) ? $member['photo'] : '';
					$m_social = isset( $member['social'] ) && is_array( $member['social'] ) ? $member['social'] : array();
					$m_social = array_filter( $m_social );
					?>
					<div class="<?php echo esc_attr( $team_col_class ); ?>">
						<article class="core-team-card h-100">
							<div class="row g-0 align-items-stretch core-team-card-inner h-100">
								<div class="col-12 col-md-auto">
									<div class="core-team-card-media">
										<?php if ( $m_photo ) : ?>
											<img src="<?php echo esc_url( $m_photo ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $m_name ) ); ?>" loading="lazy" decoding="async" />
										<?php elseif ( $m_name ) : ?>
											<?php
											$initials = '';
											$parts    = preg_split( '/\s+/', wp_strip_all_tags( $m_name ), -1, PREG_SPLIT_NO_EMPTY );
											if ( $parts ) {
												$initials .= mb_substr( $parts[0], 0, 1 );
												if ( count( $parts ) > 1 ) {
													$initials .= mb_substr( $parts[ count( $parts ) - 1 ], 0, 1 );
												}
											}
											$initials = $initials ? strtoupper( $initials ) : '?';
											?>
											<span class="core-team-card-initials" aria-hidden="true"><?php echo esc_html( $initials ); ?></span>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-12 col-md">
									<div class="core-team-card-body">
										<?php if ( $m_name ) : ?>
											<h3 class="core-team-card-name"><?php echo esc_html( $m_name ); ?></h3>
										<?php endif; ?>
										<?php if ( $m_role ) : ?>
											<p class="core-team-card-role"><?php echo esc_html( $m_role ); ?></p>
										<?php endif; ?>
										<?php if ( $m_bio ) : ?>
											<p class="core-team-card-bio"><?php echo esc_html( $m_bio ); ?></p>
										<?php endif; ?>
										<?php if ( $m_social ) : ?>
											<ul class="core-team-card-socials" aria-label="<?php echo esc_attr__( 'Social profiles', 'innovare' ); ?>">
												<?php foreach ( $m_social as $platform => $url ) : ?>
													<?php
													$url = esc_url( $url );
													if ( ! $url ) {
														continue;
													}
													$icon = isset( $core_team_social_icons[ $platform ] ) ? $core_team_social_icons[ $platform ] : 'bi-link-45deg';
													/* translators: %1$s: person name; %2$s: network name */
													$aria = sprintf( __( '%1$s on %2$s', 'innovare' ), wp_strip_all_tags( $m_name ), ucfirst( $platform ) );
													?>
													<li>
														<a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $aria ); ?>">
															<i class="bi <?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
														</a>
													</li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</article>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<div class="company-industries mt-5 mt-lg-6" id="industries">
			<div class="row align-items-center gx-lg-5 gy-3 mb-3 mb-lg-4">
				<div class="col-lg-7">
					<span class="eyebrow"><?php esc_html_e( 'Industries Served', 'innovare' ); ?></span>
					<h2><?php esc_html_e( 'Sectors we know well', 'innovare' ); ?></h2>
					<p class="mb-0"><?php esc_html_e( 'We adapt design choices, support models and security posture to match the operating tempo of each sector.', 'innovare' ); ?></p>
				</div>
			</div>

			<div class="row g-3 g-lg-4">
				<?php foreach ( $industries as $i ) : ?>
					<div class="col-6 col-md-4 col-lg">
						<div class="company-industry-card">
							<span class="company-industry-icon"><?php andromeda_icon( $i['icon'] ); ?></span>
							<strong><?php echo esc_html( $i['title'] ); ?></strong>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="about-community mt-5 mt-lg-6">
			<div class="row align-items-center gy-3">
				<div class="col-lg-8">
					<span class="eyebrow"><?php esc_html_e( 'Social Presence', 'innovare' ); ?></span>
					<h3><?php esc_html_e( 'Follow our work on the ground', 'innovare' ); ?></h3>
					<p class="mb-0"><?php esc_html_e( 'We regularly publish operational updates, deployment snapshots and field notes from real engagements. Follow us to see how an engineering-led IT team actually operates.', 'innovare' ); ?></p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<?php andromeda_social_icons( 'about-socials' ); ?>
				</div>
			</div>
		</div>

	</div>
</section>

<?php get_template_part( 'template-parts/home/final-cta' ); ?>

<?php get_footer();
