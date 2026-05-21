<?php
/**
 * Homepage — Insights section.
 *
 * Pulls the 3 latest published posts when available, otherwise renders a
 * coherent set of sample topics that match the editorial brief so the page
 * is presentable from day one.
 *
 * @package Innovare
 */

$insights_url = innovare_page_url( 'insights' );

$query = new WP_Query( array(
	'post_type'           => 'post',
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
) );

$samples = array(
	array(
		'cat'   => __( 'Networking', 'innovare' ),
		'title' => __( 'Office Network Best Practices', 'innovare' ),
		'excerpt' => __( 'How to design a stable, segmented office network that scales with team growth and remote work.', 'innovare' ),
		'time'  => 6,
	),
	array(
		'cat'   => __( 'Security', 'innovare' ),
		'title' => __( 'Microsoft 365 Security Tips', 'innovare' ),
		'excerpt' => __( 'Practical hardening steps for tenants, identity and email — the controls every business should have on.', 'innovare' ),
		'time'  => 7,
	),
	array(
		'cat'   => __( 'Continuity', 'innovare' ),
		'title' => __( 'Backup Strategy for Businesses', 'innovare' ),
		'excerpt' => __( 'A pragmatic backup and disaster recovery framework that actually gets tested — not just configured once.', 'innovare' ),
		'time'  => 5,
	),
);
?>
<section class="innovare-section innovare-insights-home" aria-labelledby="insights-home-heading">
	<div class="container">

		<div class="row align-items-end mb-4 mb-lg-5 gy-3">
			<div class="col-lg-8">
				<span class="eyebrow"><?php esc_html_e( 'Insights', 'innovare' ); ?></span>
				<h2 id="insights-home-heading"><?php esc_html_e( 'Latest field notes from our engineering team', 'innovare' ); ?></h2>
				<p class="mb-0"><?php esc_html_e( 'Best practices, planning frameworks and security recommendations drawn from real client environments.', 'innovare' ); ?></p>
			</div>
			<div class="col-lg-4 text-lg-end">
				<a class="btn btn-outline-primary" href="<?php echo esc_url( $insights_url ); ?>">
					<?php esc_html_e( 'Read all insights', 'innovare' ); ?>
					<i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
				</a>
			</div>
		</div>

		<div class="row g-3 g-lg-4 insights-grid">
			<?php if ( $query->have_posts() ) : ?>

				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<div class="col-md-6 col-lg-4">
						<article class="insight-card">
							<a class="insight-card-media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'innovare-card', array( 'loading' => 'lazy', 'class' => 'img-fluid' ) ); ?>
								<?php else : ?>
									<span class="insight-card-placeholder"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
								<?php endif; ?>
							</a>
							<div class="insight-card-body">
								<?php
								$cats = wp_strip_all_tags( get_the_category_list( ', ' ) );
								if ( $cats ) {
									printf( '<span class="insight-cat">%s</span>', esc_html( $cats ) );
								}
								?>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '…' ) ); ?></p>
								<div class="insight-meta">
									<span><i class="bi bi-clock" aria-hidden="true"></i> <?php echo esc_html( sprintf( __( '%d min read', 'innovare' ), innovare_reading_time( get_the_content() ) ) ); ?></span>
									<span><i class="bi bi-calendar3" aria-hidden="true"></i> <?php echo esc_html( get_the_date() ); ?></span>
								</div>
							</div>
						</article>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>

			<?php else : ?>

				<?php foreach ( $samples as $sample ) : ?>
					<div class="col-md-6 col-lg-4">
						<article class="insight-card insight-card--sample">
							<div class="insight-card-media">
								<span class="insight-card-placeholder"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
							</div>
							<div class="insight-card-body">
								<span class="insight-cat"><?php echo esc_html( $sample['cat'] ); ?></span>
								<h3><?php echo esc_html( $sample['title'] ); ?></h3>
								<p><?php echo esc_html( $sample['excerpt'] ); ?></p>
								<div class="insight-meta">
									<span><i class="bi bi-clock" aria-hidden="true"></i> <?php echo esc_html( sprintf( __( '%d min read', 'innovare' ), $sample['time'] ) ); ?></span>
									<span class="badge text-bg-light"><?php esc_html_e( 'Coming soon', 'innovare' ); ?></span>
								</div>
							</div>
						</article>
					</div>
				<?php endforeach; ?>

			<?php endif; ?>
		</div>

	</div>
</section>
