<?php
/**
 * Homepage — Operational social proof / "Follow Our Work".
 *
 * Social media here is operational proof of real on-site infrastructure work,
 * not a decorative footer block. Connects to Facebook, LinkedIn, Instagram,
 * TikTok and X/Twitter (configured via Customizer → Innovare — Social Links).
 *
 * @package Innovare
 */

$tiles = array(
	array( 'icon' => 'server',         'title' => __( 'Infrastructure Deployments', 'innovare' ), 'desc' => __( 'Server racks, structured cabling and clean infrastructure rollouts on site.', 'innovare' ) ),
	array( 'icon' => 'network',        'title' => __( 'Networking Setups', 'innovare' ),          'desc' => __( 'WiFi surveys, switching upgrades and multi-branch network projects.', 'innovare' ) ),
	array( 'icon' => 'support',        'title' => __( 'Support Operations', 'innovare' ),         'desc' => __( 'How our team responds, escalates and closes tickets day-to-day.', 'innovare' ) ),
	array( 'icon' => 'office',         'title' => __( 'Office IT Setups', 'innovare' ),           'desc' => __( 'End-to-end IT for new offices, expansions and relocations.', 'innovare' ) ),
	array( 'icon' => 'security',       'title' => __( 'Security Deployments', 'innovare' ),       'desc' => __( 'Firewalls, endpoint protection and secure access engagements.', 'innovare' ) ),
	array( 'icon' => 'infrastructure', 'title' => __( 'Server & Network Work', 'innovare' ),      'desc' => __( 'Behind-the-scenes engineering that keeps systems stable.', 'innovare' ) ),
);
?>
<section class="andromeda-section andromeda-social-proof" aria-labelledby="follow-heading">
	<div class="container">

		<div class="row align-items-end mb-4 mb-lg-5 gy-3">
			<div class="col-lg-8">
				<span class="eyebrow"><?php esc_html_e( 'Follow Our Work', 'innovare' ); ?></span>
				<h2 id="follow-heading"><?php esc_html_e( 'Real infrastructure projects — shared from the field', 'innovare' ); ?></h2>
				<p class="mb-0"><?php esc_html_e( 'We publish operational updates, deployment snapshots and field notes from real customer environments. Follow us to see how an engineering-led IT team actually operates.', 'innovare' ); ?></p>
			</div>
			<div class="col-lg-4 text-lg-end">
				<?php andromeda_social_icons( 'social-proof-icons' ); ?>
			</div>
		</div>

		<div class="row g-3 g-lg-4">
			<?php foreach ( $tiles as $tile ) : ?>
				<div class="col-sm-6 col-lg-4">
					<div class="proof-card">
						<div class="proof-card-media">
							<?php andromeda_icon( $tile['icon'] ); ?>
						</div>
						<div class="proof-card-body">
							<h3 class="proof-card-title"><?php echo esc_html( $tile['title'] ); ?></h3>
							<p class="proof-card-desc"><?php echo esc_html( $tile['desc'] ); ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
