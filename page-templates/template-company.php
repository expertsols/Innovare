<?php
/**
 * Template Name: Innovate — Company
 *
 * About page for Innovate — a managed IT and business technology partner.
 *
 * Sections:
 *  - About Innovate
 *  - Mission & Vision
 *  - Operational Excellence + Technology Expertise + Engineering-first mindset
 *  - Industries Served
 *  - Social Presence
 *  - Core team (stored in wp_options — see inc/team-data.php)
 *
 * Page slug in WordPress should be `about` (legacy `about-andromeda-links` redirects).
 *
 * @package Innovare
 */

get_header();

andromeda_page_header(
	__( 'About Innovate', 'innovare' ),
	__( 'A modern IT infrastructure & business technology partner', 'innovare' ),
	__( 'Innovate designs, deploys, secures and manages the technology that keeps organizations running — with an accountable engineering team and operational discipline.', 'innovare' )
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
		'desc'  => __( 'Networks, servers, security, identity and cloud platforms — done properly, documented and maintained.', 'innovare' ),
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
				<span class="eyebrow"><?php esc_html_e( 'About Innovate', 'innovare' ); ?></span>
				<h2><?php esc_html_e( 'A focused IT infrastructure & managed services team', 'innovare' ); ?></h2>
				<p>
					<?php esc_html_e( 'Innovate is an IT infrastructure and business technology company. We work with growing organizations across education, government, corporate offices, manufacturing and SME sectors — providing managed IT services, enterprise infrastructure, network security, business continuity and cloud solutions under one accountable partnership.', 'innovare' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'Our model is deliberately simple: a small team of engineers, clear SLAs, honest reporting and long-term relationships. We are not a reseller and we are not a break-fix vendor.', 'innovare' ); ?>
				</p>
				<p class="company-solutions-note">
					<?php esc_html_e( 'From office rollouts to multi-site connectivity and ongoing managed support, we deliver technology outcomes as integrated engagements — designed, deployed and supported by the same engineering team.', 'innovare' ); ?>
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

		<?php get_template_part( 'template-parts/about/core-team' ); ?>

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
