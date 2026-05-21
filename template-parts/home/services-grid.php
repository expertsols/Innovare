<?php
/**
 * Homepage — Core Services section.
 *
 * Modern enterprise-style service cards. Avoids product/ecommerce framing —
 * "Technology Procurement" is positioned as a deployment service, not a store.
 *
 * @package Innovare
 */

$services = array(
	array(
		'icon'   => 'managed',
		'title'  => __( 'Managed IT Services', 'innovare' ),
		'desc'   => __( 'End-to-end IT operations: monitoring, helpdesk, patching and SLA-backed support across your environment.', 'innovare' ),
		'anchor' => 'managed',
	),
	array(
		'icon'   => 'infrastructure',
		'title'  => __( 'Enterprise Infrastructure', 'innovare' ),
		'desc'   => __( 'Networks, servers, virtualization and structured cabling engineered to scale with your business.', 'innovare' ),
		'anchor' => 'infrastructure',
	),
	array(
		'icon'   => 'security',
		'title'  => __( 'Network Security', 'innovare' ),
		'desc'   => __( 'Next-gen firewalls, segmentation, endpoint protection and secure remote access policies.', 'innovare' ),
		'anchor' => 'security',
	),
	array(
		'icon'   => 'server',
		'title'  => __( 'Server & Identity Infrastructure', 'innovare' ),
		'desc'   => __( 'Active Directory, virtualization, file services and hardened server estates — done right.', 'innovare' ),
		'anchor' => 'infrastructure',
	),
	array(
		'icon'   => 'multi-site',
		'title'  => __( 'Multi-Site Connectivity', 'innovare' ),
		'desc'   => __( 'Site-to-site VPN, SD-WAN style routing and unified policies for branch-to-HQ communications.', 'innovare' ),
		'anchor' => 'infrastructure',
	),
	array(
		'icon'   => 'backup',
		'title'  => __( 'Backup & Disaster Recovery', 'innovare' ),
		'desc'   => __( 'Resilient backup strategy, replication and tested restore procedures for true business continuity.', 'innovare' ),
		'anchor' => 'security',
	),
	array(
		'icon'   => 'consulting',
		'title'  => __( 'IT Consulting', 'innovare' ),
		'desc'   => __( 'Audits, infrastructure planning, vendor consultation and cost optimization for IT leadership.', 'innovare' ),
		'anchor' => 'consulting',
	),
	array(
		'icon'   => 'hardware',
		'title'  => __( 'Technology Procurement', 'innovare' ),
		'desc'   => __( 'Sourcing, configuration, deployment and lifecycle care for servers, networking, security and end-user hardware.', 'innovare' ),
		'anchor' => 'procurement',
	),
);

$services_url = innovare_page_url( 'services' );
?>
<section class="innovare-section innovare-services-grid" aria-labelledby="services-grid-heading">
	<div class="container">

		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Core Services', 'innovare' ); ?></span>
			<h2 id="services-grid-heading"><?php esc_html_e( 'Engineered IT services for stable, secure operations', 'innovare' ); ?></h2>
			<p><?php esc_html_e( 'From day-to-day IT support to long-term infrastructure planning — one accountable partner across your whole technology stack.', 'innovare' ); ?></p>
		</div>

		<div class="row g-3 g-lg-4">
			<?php foreach ( $services as $service ) : ?>
				<div class="col-md-6 col-lg-4 col-xl-3">
					<a class="service-card" href="<?php echo esc_url( $services_url . '#' . $service['anchor'] ); ?>">
						<span class="service-card-icon"><?php innovare_icon( $service['icon'] ); ?></span>
						<h3 class="service-card-title"><?php echo esc_html( $service['title'] ); ?></h3>
						<p class="service-card-desc"><?php echo esc_html( $service['desc'] ); ?></p>
						<span class="service-card-link">
							<?php esc_html_e( 'Learn more', 'innovare' ); ?>
							<i class="bi bi-arrow-right" aria-hidden="true"></i>
						</span>
					</a>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="text-center mt-4 mt-lg-5">
			<a class="btn btn-outline-primary" href="<?php echo esc_url( $services_url ); ?>">
				<?php esc_html_e( 'View all services', 'innovare' ); ?>
				<i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
			</a>
		</div>

	</div>
</section>
