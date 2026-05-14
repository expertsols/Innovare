<?php
/**
 * Template Name: Innovare — Services
 *
 * Enterprise IT services catalogue. Leads with a visual "Technology Procurement"
 * feature (4 vendor-category tiles + a 4-step workflow strip), then the four
 * service pillars defined in the brief: Managed IT, Infrastructure, Security,
 * Consulting.
 *
 * Procurement vendors are framed as part of an engineered service — explicitly
 * NOT a product store.
 *
 * @package Innovare
 */

get_header();

$groups = array(
	array(
		'id'    => 'managed',
		'icon'  => 'managed',
		'title' => __( 'Managed IT Services', 'innovare' ),
		'intro' => __( 'Day-to-day IT operations handled by an accountable engineering team — predictable, measurable and SLA-backed.', 'innovare' ),
		'items' => array(
			__( 'Remote Support', 'innovare' ),
			__( 'Preventive Maintenance', 'innovare' ),
			__( 'Monitoring & Alerting', 'innovare' ),
			__( 'SLA Support', 'innovare' ),
			__( 'Helpdesk Operations', 'innovare' ),
			__( 'Patch & Vulnerability Management', 'innovare' ),
		),
	),
	array(
		'id'    => 'infrastructure',
		'icon'  => 'infrastructure',
		'title' => __( 'Infrastructure Services', 'innovare' ),
		'intro' => __( 'Foundational design, deployment and modernization for offices, branches and on-premise environments.', 'innovare' ),
		'items' => array(
			__( 'Network Design', 'innovare' ),
			__( 'Server Deployment', 'innovare' ),
			__( 'Virtualization', 'innovare' ),
			__( 'Structured Cabling', 'innovare' ),
			__( 'WiFi Deployment', 'innovare' ),
			__( 'Multi-Site Connectivity', 'innovare' ),
		),
	),
	array(
		'id'    => 'security',
		'icon'  => 'security',
		'title' => __( 'Security Services', 'innovare' ),
		'intro' => __( 'Layered protection across network, endpoint, identity and data — engineered around your operating reality.', 'innovare' ),
		'items' => array(
			__( 'Firewall Solutions', 'innovare' ),
			__( 'Endpoint Security', 'innovare' ),
			__( 'Backup & Recovery', 'innovare' ),
			__( 'Secure Access', 'innovare' ),
			__( 'Email & Identity Hardening', 'innovare' ),
			__( 'Disaster Recovery Planning', 'innovare' ),
		),
	),
	array(
		'id'    => 'consulting',
		'icon'  => 'consulting',
		'title' => __( 'Consulting', 'innovare' ),
		'intro' => __( 'Independent advice grounded in real operations — not vendor pitches. Built for IT leadership and business owners.', 'innovare' ),
		'items' => array(
			__( 'IT Audits', 'innovare' ),
			__( 'Infrastructure Planning', 'innovare' ),
			__( 'Vendor Consultation', 'innovare' ),
			__( 'Cost Optimization', 'innovare' ),
			__( 'Compliance Readiness', 'innovare' ),
			__( 'Cloud Strategy', 'innovare' ),
		),
	),
);

$procurement_img_base = get_template_directory_uri() . '/assets/images/procurement/';

$procurement_categories = array(
	array(
		'slug'    => 'procurement-laptops',
		'image'   => $procurement_img_base . 'laptops.jpg',
		'alt'     => __( 'Business laptop and external monitor on an office desk', 'innovare' ),
		'title'   => __( 'Laptops & Desktops', 'innovare' ),
		'desc'    => __( 'Standardized end-user devices, imaged and ready for production on day one.', 'innovare' ),
		'vendors' => array( 'Dell', 'HP', 'Lenovo' ),
		'tone'    => 'a',
	),
	array(
		'slug'    => 'procurement-servers',
		'image'   => $procurement_img_base . 'servers.jpg',
		'alt'     => __( 'Rack-mounted servers in a data center', 'innovare' ),
		'title'   => __( 'Servers', 'innovare' ),
		'desc'    => __( 'Rack and tower platforms configured for virtualization, file services and identity workloads.', 'innovare' ),
		'vendors' => array( 'Dell', 'HP' ),
		'tone'    => 'b',
	),
	array(
		'slug'      => 'procurement-components',
		'image'     => $procurement_img_base . 'components.jpg',
		'alt'       => __( 'Storage drive and components close-up', 'innovare' ),
		'title'     => __( 'Components & Accessories', 'innovare' ),
		'desc'      => __( 'Peripherals, memory, storage and lifecycle spares — for existing estates and new deployments.', 'innovare' ),
		'subgroups' => array(
			array(
				'label'   => __( 'Accessories', 'innovare' ),
				'vendors' => array( 'A4Tech', 'Logitech', 'Baseus', 'Wiwu' ),
			),
			array(
				'label'   => __( 'Components', 'innovare' ),
				'vendors' => array( 'Kingston', 'Teamgroup', 'Adata', 'Transcend', 'Hiksemi', 'Dahua', 'Seagate', 'Western Digital' ),
			),
		),
		'tone'      => 'c',
	),
	array(
		'slug'      => 'procurement-networking',
		'image'     => $procurement_img_base . 'infrastructure.jpg',
		'alt'       => __( 'Network patch panel with structured cabling', 'innovare' ),
		'title'     => __( 'IT Infrastructure & Networking', 'innovare' ),
		'desc'      => __( 'Active networking gear, wireless infrastructure and structured cabling — engineered for stability, segmentation and growth.', 'innovare' ),
		'subgroups' => array(
			array(
				'label'   => __( 'Routing, Switching & Firewalls', 'innovare' ),
				'vendors' => array( 'MikroTik', 'Fortinet', 'Planet Technology', 'Maipu', 'Ruckus Networks', 'Cisco', 'D-Link', 'TP-Link' ),
			),
			array(
				'label'   => __( 'Wireless & Access Points', 'innovare' ),
				'vendors' => array( 'Ubiquiti', 'Cisco', 'Ruckus Networks' ),
			),
			array(
				'label'   => __( 'Structured Cabling & Network Components', 'innovare' ),
				'vendors' => array( 'Molex', 'Digitus', 'Baynet', 'D-Link' ),
			),
		),
		'tone'      => 'd',
	),
	array(
		'slug'      => 'procurement-security',
		'image'     => $procurement_img_base . 'surveillance.jpg',
		'alt'       => __( 'Grid of CCTV security cameras mounted on a wall', 'innovare' ),
		'title'     => __( 'Security & Communication', 'innovare' ),
		'desc'      => __( 'Surveillance, access control and business communications — specified, installed and supported as one integrated estate.', 'innovare' ),
		'subgroups' => array(
			array(
				'label'   => __( 'CCTV & Video Surveillance', 'innovare' ),
				'vendors' => array( 'Dahua', 'Hikvision', 'Tiandy' ),
			),
			array(
				'label'   => __( 'Access Control & Biometrics', 'innovare' ),
				'vendors' => array( 'ZKTeco' ),
			),
			array(
				'label'   => __( 'IP Telephony & Communications', 'innovare' ),
				'vendors' => array( 'Dinstar', 'Grandstream' ),
			),
		),
		'tone'      => 'e',
	),
);

$procurement_flow = array(
	array( 'step' => '01', 'icon' => 'consulting', 'title' => __( 'Source', 'innovare' ),    'desc' => __( 'Right-sized hardware from trusted vendors.', 'innovare' ) ),
	array( 'step' => '02', 'icon' => 'cpu',        'title' => __( 'Configure', 'innovare' ), 'desc' => __( 'Imaging, hardening and integration with your stack.', 'innovare' ) ),
	array( 'step' => '03', 'icon' => 'managed',    'title' => __( 'Deploy', 'innovare' ),    'desc' => __( 'Installation, racking and structured rollout.', 'innovare' ) ),
	array( 'step' => '04', 'icon' => 'support',    'title' => __( 'Support', 'innovare' ),   'desc' => __( 'Warranty, replacements and lifecycle care.', 'innovare' ) ),
);

andromeda_page_header(
	__( 'Services', 'innovare' ),
	__( 'A complete IT services catalogue for modern businesses', 'innovare' ),
	__( 'From helpdesk through to architecture — one accountable partner for the operational and strategic work behind your technology.', 'innovare' )
);

$contact_page = get_page_by_path( 'contact' );
$contact_url  = $contact_page ? get_permalink( $contact_page ) : home_url( '/contact/' );
?>

<nav class="services-nav-band" aria-label="<?php esc_attr_e( 'Services sections', 'innovare' ); ?>">
	<div class="container">
		<div class="services-nav">
			<ul>
				<li><a href="#procurement"><?php esc_html_e( 'Technology Procurement', 'innovare' ); ?></a></li>
				<?php foreach ( $groups as $g ) : ?>
					<li><a href="#<?php echo esc_attr( $g['id'] ); ?>"><?php echo esc_html( $g['title'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</nav>

<section class="procurement-section" id="procurement" aria-labelledby="procurement-heading">
	<span class="procurement-section-grid" aria-hidden="true"></span>
	<span class="procurement-section-glow procurement-section-glow--a" aria-hidden="true"></span>
	<span class="procurement-section-glow procurement-section-glow--b" aria-hidden="true"></span>

	<div class="container">
		<div class="procurement-feature">

			<div class="procurement-feature-head">
				<span class="eyebrow"><?php esc_html_e( 'Technology Procurement', 'innovare' ); ?></span>
				<h2 id="procurement-heading"><?php esc_html_e( 'Hardware procurement, engineered — not retailed', 'innovare' ); ?></h2>
				<p>
					<?php esc_html_e( 'We source, configure and deploy business technology as part of an engineered solution. Servers, networking, firewalls, surveillance and end-user devices are selected to fit the design — not the other way around.', 'innovare' ); ?>
				</p>
			</div>

			<ol class="procurement-flow" role="list">
				<?php foreach ( $procurement_flow as $step ) : ?>
					<li class="procurement-flow-step">
						<div class="procurement-flow-node">
							<span class="procurement-flow-num"><?php echo esc_html( $step['step'] ); ?></span>
						</div>
						<div class="procurement-flow-body">
							<div class="procurement-flow-title">
								<?php andromeda_icon( $step['icon'] ); ?>
								<strong><?php echo esc_html( $step['title'] ); ?></strong>
							</div>
							<p><?php echo esc_html( $step['desc'] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>

			<div class="procurement-groups">
				<?php foreach ( $procurement_categories as $cat ) : ?>
					<?php
					$has_subgroups = ! empty( $cat['subgroups'] ) && is_array( $cat['subgroups'] );
					$cat_slug      = isset( $cat['slug'] ) ? $cat['slug'] : sanitize_title( $cat['title'] );
					$cat_cta_url   = add_query_arg(
						array(
							'type'    => 'quote',
							'service' => $cat_slug,
						),
						$contact_url
					);
					/* translators: %s: procurement category title */
					$cat_cta_label = sprintf( __( 'Get a quote for %s', 'innovare' ), $cat['title'] );
					$cat_cta_aria  = sprintf( __( 'Request a quote for %s', 'innovare' ), $cat['title'] );
					?>
					<div class="procurement-group<?php echo $has_subgroups ? ' procurement-group--subgrouped' : ''; ?>">
						<div class="row align-items-start gx-lg-5 gy-4">
							<div class="col-lg-4">
								<div class="procurement-group-head">
									<figure class="procurement-group-media">
										<img
											src="<?php echo esc_url( $cat['image'] ); ?>"
											alt="<?php echo esc_attr( $cat['alt'] ); ?>"
											loading="lazy"
											decoding="async"
										/>
									</figure>
									<h3><?php echo esc_html( $cat['title'] ); ?></h3>
									<p><?php echo esc_html( $cat['desc'] ); ?></p>
									<a class="service-group-cta" href="<?php echo esc_url( $cat_cta_url ); ?>" aria-label="<?php echo esc_attr( $cat_cta_aria ); ?>">
										<span><?php echo esc_html( $cat_cta_label ); ?></span>
										<i class="bi bi-arrow-right" aria-hidden="true"></i>
									</a>
								</div>
							</div>
							<div class="col-lg-8">
								<?php if ( $has_subgroups ) : ?>
									<?php foreach ( $cat['subgroups'] as $sg ) : ?>
										<div class="procurement-subgroup">
											<span class="procurement-subgroup-label">
												<i class="bi bi-diagram-3" aria-hidden="true"></i>
												<?php echo esc_html( $sg['label'] ); ?>
											</span>
											<div class="row g-3">
												<?php foreach ( $sg['vendors'] as $vendor ) : ?>
													<div class="col-sm-6">
														<div class="service-item">
															<i class="bi bi-check2-circle" aria-hidden="true"></i>
															<span><?php echo esc_html( $vendor ); ?></span>
														</div>
													</div>
												<?php endforeach; ?>
											</div>
										</div>
									<?php endforeach; ?>
								<?php else : ?>
									<div class="row g-3">
										<?php foreach ( $cat['vendors'] as $vendor ) : ?>
											<div class="col-sm-6">
												<div class="service-item">
													<i class="bi bi-check2-circle" aria-hidden="true"></i>
													<span><?php echo esc_html( $vendor ); ?></span>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<p class="procurement-note">
				<i class="bi bi-info-circle me-1" aria-hidden="true"></i>
				<?php esc_html_e( 'Vendor-aware, not vendor-locked. Selection always follows the engineering need — we will recommend alternatives when they fit the design better.', 'innovare' ); ?>
			</p>

		</div>
	</div>
</section>

<section class="andromeda-section andromeda-services-page">
	<div class="container">

		<?php foreach ( $groups as $g ) : ?>
			<?php
			$cta_url = add_query_arg(
				array(
					'type'    => 'quote',
					'service' => $g['id'],
				),
				$contact_url
			);
			/* translators: %s: service group title */
			$cta_label = sprintf( __( 'Get a quote for %s', 'innovare' ), $g['title'] );
			$cta_aria  = sprintf( __( 'Request a quote for %s', 'innovare' ), $g['title'] );
			?>
			<div class="service-group" id="<?php echo esc_attr( $g['id'] ); ?>">
				<div class="row align-items-start gx-lg-5 gy-4">
					<div class="col-lg-4">
						<div class="service-group-head">
							<span class="service-group-icon"><?php andromeda_icon( $g['icon'] ); ?></span>
							<h2><?php echo esc_html( $g['title'] ); ?></h2>
							<p><?php echo esc_html( $g['intro'] ); ?></p>
							<a class="service-group-cta" href="<?php echo esc_url( $cta_url ); ?>" aria-label="<?php echo esc_attr( $cta_aria ); ?>">
								<span><?php echo esc_html( $cta_label ); ?></span>
								<i class="bi bi-arrow-right" aria-hidden="true"></i>
							</a>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="row g-3">
							<?php foreach ( $g['items'] as $item ) : ?>
								<div class="col-sm-6">
									<div class="service-item">
										<i class="bi bi-check2-circle" aria-hidden="true"></i>
										<span><?php echo esc_html( $item ); ?></span>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

	</div>
</section>

<?php get_template_part( 'template-parts/home/final-cta' ); ?>

<?php get_footer();
