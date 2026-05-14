<?php
/**
 * Homepage — Solutions section.
 *
 * Mirrors the /solutions/ listing exactly (same data, same card markup),
 * so the home preview and the solutions page stay in lock-step. The only
 * difference is a single "Explore this solution" CTA that opens the
 * matching /solutions/<slug>/ detail page directly — no detour through
 * the solutions index page.
 *
 * SkilledIM HRM and Silver Accounting are presented as business
 * solutions under Innovare — not standalone SaaS brands.
 *
 * @package Innovare
 */

$solutions     = andromeda_get_solutions();
$solutions_url = andromeda_page_url( 'solutions' );
?>
<section class="andromeda-section andromeda-solutions-home" aria-labelledby="solutions-home-heading">
	<div class="container">

		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Solutions', 'innovare' ); ?></span>
			<h2 id="solutions-home-heading"><?php esc_html_e( 'Enterprise solutions built around real business needs', 'innovare' ); ?></h2>
			<p><?php esc_html_e( 'Pre-shaped outcomes that combine our infrastructure, support and software expertise into a single, accountable engagement.', 'innovare' ); ?></p>
		</div>

		<div class="row g-3 g-lg-4">
			<?php foreach ( $solutions as $slug => $s ) : ?>
				<?php
				$detail_url   = andromeda_get_solution_url( $slug );
				$anchor       = isset( $s['anchor'] ) ? $s['anchor'] : $slug;
				// Fall back to the listing anchor only if no detail page exists yet.
				$explore_url  = $detail_url ? $detail_url : ( $solutions_url . '#' . $anchor );
				/* translators: %s: solution title */
				$explore_aria = sprintf( __( 'Explore %s in detail', 'innovare' ), $s['title'] );
				?>
				<div class="col-md-6 col-lg-4">
					<article class="solution-card solution-card--home">
						<div class="solution-card-head">
							<span class="solution-card-icon"><?php andromeda_icon( $s['icon'] ); ?></span>
							<span class="solution-card-badge"><?php echo esc_html( $s['badge'] ); ?></span>
						</div>
						<h3 class="solution-card-title"><?php echo esc_html( $s['title'] ); ?></h3>
						<p class="solution-card-desc"><?php echo esc_html( $s['lede'] ); ?></p>

						<?php $points = ! empty( $s['whats_included'] ) ? array_slice( $s['whats_included'], 0, 3 ) : array(); ?>
						<?php if ( $points ) : ?>
							<ul class="solution-card-list">
								<?php foreach ( $points as $point ) : ?>
									<li><i class="bi bi-check2 me-2" aria-hidden="true"></i><?php echo esc_html( $point ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<div class="solution-card-actions solution-card-actions--single">
							<a class="btn-explore" href="<?php echo esc_url( $explore_url ); ?>" aria-label="<?php echo esc_attr( $explore_aria ); ?>">
								<span><?php esc_html_e( 'Explore this solution', 'innovare' ); ?></span>
								<i class="bi bi-arrow-up-right" aria-hidden="true"></i>
							</a>
						</div>
					</article>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="text-center mt-4 mt-lg-5">
			<a class="btn btn-outline-primary" href="<?php echo esc_url( $solutions_url ); ?>">
				<?php esc_html_e( 'Explore all solutions', 'innovare' ); ?>
				<i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
			</a>
		</div>

	</div>
</section>
