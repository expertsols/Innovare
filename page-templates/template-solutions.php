<?php
/**
 * Template Name: Innovare — Solutions
 *
 * Solution-led page (NOT a product listing). Each entry frames an outcome
 * and the underlying engagement model — including SkilledIM HRM and Silver
 * Accounting as business solutions under Innovare.
 *
 * Each card has two CTAs:
 *   - "Explore now" — links to the per-solution detail page when one exists
 *     (template-solution-detail.php).
 *   - "Discuss this solution" — links to the contact form pre-selected for
 *     the matching solution.
 *
 * @package Innovare
 */

get_header();

$solutions   = andromeda_get_solutions();
$contact_url = andromeda_page_url( 'contact' );

andromeda_page_header(
	__( 'Solutions', 'innovare' ),
	__( 'Enterprise solutions built around real business outcomes', 'innovare' ),
	__( 'Pre-shaped engagements that combine infrastructure, managed support and enterprise software into one accountable solution.', 'innovare' )
);
?>

<section class="andromeda-section andromeda-solutions-page">
	<div class="container">

		<div class="row g-3 g-lg-4">
			<?php foreach ( $solutions as $slug => $s ) : ?>
				<?php
				$detail_url   = andromeda_get_solution_url( $slug );
				$discuss_url  = add_query_arg(
					array(
						'type'    => 'quote',
						'service' => 'solution-' . $slug,
					),
					$contact_url
				);
				$anchor       = isset( $s['anchor'] ) ? $s['anchor'] : $slug;
				/* translators: %s: solution title */
				$discuss_aria = sprintf( __( 'Discuss %s with our team', 'innovare' ), $s['title'] );
				/* translators: %s: solution title */
				$explore_aria = sprintf( __( 'Explore %s in detail', 'innovare' ), $s['title'] );
				?>
				<div class="col-md-6 col-lg-4" id="<?php echo esc_attr( $anchor ); ?>">
					<article class="solution-card">
						<div class="solution-card-head">
							<span class="solution-card-icon"><?php andromeda_icon( $s['icon'] ); ?></span>
							<span class="solution-card-badge"><?php echo esc_html( $s['badge'] ); ?></span>
						</div>
						<h2 class="solution-card-title"><?php echo esc_html( $s['title'] ); ?></h2>
						<p class="solution-card-desc"><?php echo esc_html( $s['lede'] ); ?></p>
						<?php $points = ! empty( $s['whats_included'] ) ? array_slice( $s['whats_included'], 0, 3 ) : array(); ?>
						<?php if ( $points ) : ?>
							<ul class="solution-card-list">
								<?php foreach ( $points as $point ) : ?>
									<li><i class="bi bi-check2 me-2" aria-hidden="true"></i><?php echo esc_html( $point ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<div class="solution-card-actions">
							<?php if ( $detail_url ) : ?>
								<a class="btn-explore" href="<?php echo esc_url( $detail_url ); ?>" aria-label="<?php echo esc_attr( $explore_aria ); ?>">
									<span><?php esc_html_e( 'Explore now', 'innovare' ); ?></span>
									<i class="bi bi-arrow-up-right" aria-hidden="true"></i>
								</a>
							<?php endif; ?>
							<a class="btn-discuss" href="<?php echo esc_url( $discuss_url ); ?>" aria-label="<?php echo esc_attr( $discuss_aria ); ?>">
								<?php esc_html_e( 'Discuss this solution', 'innovare' ); ?>
								<i class="bi bi-arrow-right" aria-hidden="true"></i>
							</a>
						</div>
					</article>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>

<?php get_template_part( 'template-parts/home/final-cta' ); ?>

<?php get_footer();
