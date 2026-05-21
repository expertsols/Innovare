<?php
/**
 * Homepage — Hero section.
 *
 * @package Innovare
 */
?>
<section class="andromeda-hero" aria-labelledby="andromeda-hero-title">
	<div class="hero-backdrop" aria-hidden="true">
		<div class="hero-grid"></div>
		<div class="hero-glow hero-glow--a"></div>
		<div class="hero-glow hero-glow--b"></div>
	</div>

	<div class="container position-relative">
		<div class="row align-items-center gy-5">

			<div class="col-lg-7">
				<span class="hero-eyebrow">
					<i class="bi bi-shield-check" aria-hidden="true"></i>
					<?php esc_html_e( 'IT Infrastructure · Managed Services · Business Technology', 'innovare' ); ?>
				</span>
				<h1 id="andromeda-hero-title" class="hero-title">
					<?php esc_html_e( 'Reliable IT Infrastructure & Business Technology Solutions', 'innovare' ); ?>
				</h1>
				<p class="hero-subtitle">
					<?php esc_html_e( 'Innovate helps organizations design, deploy, secure and manage stable technology environments — with modern infrastructure, managed support and accountable engineering.', 'innovare' ); ?>
				</p>
				<div class="hero-actions">
					<a class="btn btn-primary btn-lg" href="<?php echo esc_url( andromeda_page_url( 'contact' ) ); ?>?type=quote">
						<?php esc_html_e( 'Get a Quote', 'innovare' ); ?>
						<i class="bi bi-arrow-right ms-2" aria-hidden="true"></i>
					</a>
					<a class="btn btn-outline-light btn-lg" href="<?php echo esc_url( andromeda_page_url( 'services' ) ); ?>">
						<?php esc_html_e( 'Explore Services', 'innovare' ); ?>
					</a>
				</div>

				<ul class="hero-meta" role="list">
					<li><i class="bi bi-check2-circle" aria-hidden="true"></i> <?php esc_html_e( 'SLA-Backed Managed Support', 'innovare' ); ?></li>
					<li><i class="bi bi-check2-circle" aria-hidden="true"></i> <?php esc_html_e( 'Enterprise-Grade Engineering', 'innovare' ); ?></li>
					<li><i class="bi bi-check2-circle" aria-hidden="true"></i> <?php esc_html_e( 'Nationwide Coverage', 'innovare' ); ?></li>
				</ul>
			</div>

			<div class="col-lg-5">
				<div class="hero-card" role="presentation">
					<div class="hero-card-row">
						<span class="hero-card-dot hero-card-dot--green"></span>
						<div>
							<strong><?php esc_html_e( 'Network Operations', 'innovare' ); ?></strong>
							<small><?php esc_html_e( 'All sites healthy · 99.98% uptime', 'innovare' ); ?></small>
						</div>
					</div>
					<div class="hero-card-row">
						<span class="hero-card-dot hero-card-dot--blue"></span>
						<div>
							<strong><?php esc_html_e( 'Firewall & Endpoint', 'innovare' ); ?></strong>
							<small><?php esc_html_e( 'Policies up-to-date · 0 critical alerts', 'innovare' ); ?></small>
						</div>
					</div>
					<div class="hero-card-row">
						<span class="hero-card-dot hero-card-dot--amber"></span>
						<div>
							<strong><?php esc_html_e( 'Backup & DR', 'innovare' ); ?></strong>
							<small><?php esc_html_e( 'Last verified backup · 02:14 AM', 'innovare' ); ?></small>
						</div>
					</div>
					<div class="hero-card-row">
						<span class="hero-card-dot hero-card-dot--blue"></span>
						<div>
							<strong><?php esc_html_e( 'Helpdesk', 'innovare' ); ?></strong>
							<small><?php esc_html_e( 'Avg. first response · 8 min', 'innovare' ); ?></small>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>
