<?php
/**
 * Template Name: Innovare — Insights
 *
 * Blog archive: pinned/sticky hero → two highlight cards → masonry grid
 * with compact thumbnails. Uses real WP_Query.
 *
 * Pin posts from wp-admin: Quick Edit → “Stick to the front page”.
 *
 * @package Innovare
 */

get_header();

andromeda_page_header(
	__( 'Insights', 'innovare' ),
	__( 'Field notes, guides and best practices', 'innovare' ),
	__( 'Practical thinking from our engineering team on infrastructure, security, productivity and managed operations.', 'innovare' )
);

$sticky_ids = get_option( 'sticky_posts' );
$sticky_ids = is_array( $sticky_ids ) ? array_values( array_filter( array_map( 'intval', $sticky_ids ) ) ) : array();

// Hero: newest sticky, otherwise latest published post.
$featured_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 1,
	'ignore_sticky_posts' => true,
);
if ( ! empty( $sticky_ids ) ) {
	$featured_args['post__in'] = $sticky_ids;
	$featured_args['orderby']  = 'date';
	$featured_args['order']    = 'DESC';
} else {
	$featured_args['orderby'] = 'date';
	$featured_args['order']    = 'DESC';
}

$featured_query = new WP_Query( $featured_args );
$featured_id    = 0;
if ( $featured_query->have_posts() ) {
	while ( $featured_query->have_posts() ) {
		$featured_query->the_post();
		$featured_id = (int) get_the_ID();
		break;
	}
	$featured_query->rewind_posts();
}

$exclude_ids = array_filter( array( $featured_id ) );

$highlight_posts = get_posts(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 2,
		'post__not_in'        => $exclude_ids,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'fields'              => 'all',
	)
);

$highlight_ids = wp_list_pluck( $highlight_posts, 'ID' );
$exclude_ids   = array_unique( array_merge( $exclude_ids, $highlight_ids ) );

$masonry_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 12,
		'post__not_in'        => $exclude_ids,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	)
);

$has_posts = $featured_query->have_posts();

$samples = array(
	array( 'cat' => __( 'Networking', 'innovare' ), 'title' => __( 'How to Design a Reliable Office Network', 'innovare' ), 'time' => 6 ),
	array( 'cat' => __( 'Continuity', 'innovare' ), 'title' => __( 'Why Every Business Needs a Backup Strategy', 'innovare' ), 'time' => 5 ),
	array( 'cat' => __( 'Security', 'innovare' ), 'title' => __( 'Microsoft 365 Security Checklist', 'innovare' ), 'time' => 7 ),
	array( 'cat' => __( 'Security', 'innovare' ), 'title' => __( 'Firewall Best Practices', 'innovare' ), 'time' => 5 ),
	array( 'cat' => __( 'Infrastructure', 'innovare' ), 'title' => __( 'Common IT Infrastructure Mistakes', 'innovare' ), 'time' => 6 ),
);
?>

<section class="andromeda-section andromeda-insights-page">
	<div class="container">

		<?php if ( $has_posts ) : ?>

			<?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>
				<?php
				$is_pinned = $featured_id && ! empty( $sticky_ids ) && in_array( $featured_id, $sticky_ids, true );
				$badge     = $is_pinned
					? __( 'Pinned', 'innovare' )
					: __( 'Featured', 'innovare' );
				$cat_label = andromeda_insights_primary_cat( get_the_ID() );
				?>
				<article class="insight-feature insight-feature--hero">
					<div class="insight-feature-frame">
						<div class="row align-items-stretch g-0 flex-column flex-lg-row">
							<div class="col-lg-7">
								<div class="insight-feature-media">
									<span class="insight-badge insight-badge--hero" aria-hidden="true"><?php echo esc_html( $badge ); ?></span>
									<?php if ( has_post_thumbnail() ) : ?>
										<?php
										the_post_thumbnail(
											'andromeda-hero',
											array(
												'loading' => 'eager',
												'class'   => 'insight-feature-img',
												'alt'     => wp_strip_all_tags( get_the_title() ),
											)
										);
										?>
									<?php else : ?>
										<div class="insight-feature-placeholder"><i class="bi bi-journal-text" aria-hidden="true"></i></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-lg-5">
								<div class="insight-feature-body">
									<?php if ( $cat_label ) : ?>
										<span class="insight-cat"><?php echo esc_html( $cat_label ); ?></span>
									<?php endif; ?>
									<h2 class="insight-feature-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<p class="insight-feature-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 32, '…' ) ); ?></p>
									<div class="insight-meta">
										<span><i class="bi bi-clock" aria-hidden="true"></i> <?php echo esc_html( sprintf( __( '%d min read', 'innovare' ), andromeda_reading_time( get_the_content() ) ) ); ?></span>
										<span><i class="bi bi-calendar3" aria-hidden="true"></i> <?php echo esc_html( get_the_date() ); ?></span>
									</div>
									<a class="btn btn-primary insight-feature-cta" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read article', 'innovare' ); ?><i class="bi bi-arrow-right ms-2" aria-hidden="true"></i></a>
								</div>
							</div>
						</div>
					</div>
				</article>
			<?php endwhile;
			wp_reset_postdata(); ?>

			<?php if ( ! empty( $highlight_posts ) ) : ?>
				<div class="insights-highlights">
					<p class="insights-section-eyebrow"><?php esc_html_e( 'More highlights', 'innovare' ); ?></p>
					<div class="row g-3 g-lg-4">
						<?php foreach ( $highlight_posts as $hp ) : ?>
							<?php
							$pid   = (int) $hp->ID;
							$plink = get_permalink( $pid );
							$hc    = andromeda_insights_primary_cat( $pid );
							?>
							<div class="col-md-6">
								<article class="insight-highlight-card h-100">
									<a class="insight-highlight-media" href="<?php echo esc_url( $plink ); ?>" tabindex="-1" aria-hidden="true">
										<?php if ( has_post_thumbnail( $pid ) ) : ?>
											<?php echo get_the_post_thumbnail( $pid, 'andromeda-thumb', array( 'class' => 'insight-highlight-img', 'loading' => 'lazy', 'alt' => wp_strip_all_tags( get_the_title( $pid ) ) ) ); ?>
										<?php else : ?>
											<span class="insight-highlight-placeholder"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
										<?php endif; ?>
									</a>
									<div class="insight-highlight-body">
										<?php if ( $hc ) : ?>
											<span class="insight-cat"><?php echo esc_html( $hc ); ?></span>
										<?php endif; ?>
										<h3 class="insight-highlight-title"><a href="<?php echo esc_url( $plink ); ?>"><?php echo esc_html( get_the_title( $pid ) ); ?></a></h3>
										<p class="insight-highlight-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $pid ), 18, '…' ) ); ?></p>
										<div class="insight-meta insight-meta--compact">
											<span><i class="bi bi-clock" aria-hidden="true"></i> <?php echo esc_html( sprintf( __( '%d min read', 'innovare' ), andromeda_reading_time( $hp->post_content ) ) ); ?></span>
											<span><i class="bi bi-calendar3" aria-hidden="true"></i> <?php echo esc_html( get_the_date( '', $pid ) ); ?></span>
										</div>
										<a class="insight-highlight-link" href="<?php echo esc_url( $plink ); ?>"><?php esc_html_e( 'Continue reading', 'innovare' ); ?><i class="bi bi-arrow-right ms-1" aria-hidden="true"></i></a>
									</div>
								</article>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $masonry_query->have_posts() ) : ?>
				<div class="insights-masonry-wrap">
					<p class="insights-section-eyebrow"><?php esc_html_e( 'All articles', 'innovare' ); ?></p>
					<div class="insights-masonry" role="list">
						<?php
						while ( $masonry_query->have_posts() ) :
							$masonry_query->the_post();
							$mc = andromeda_insights_primary_cat( get_the_ID() );
							?>
							<article class="insight-mason-card" role="listitem">
								<a class="insight-mason-media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'andromeda-thumb', array( 'class' => 'insight-mason-img', 'loading' => 'lazy', 'alt' => wp_strip_all_tags( get_the_title() ) ) ); ?>
									<?php else : ?>
										<span class="insight-mason-placeholder"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
									<?php endif; ?>
								</a>
								<div class="insight-mason-body">
									<?php if ( $mc ) : ?>
										<span class="insight-cat insight-cat--small"><?php echo esc_html( $mc ); ?></span>
									<?php endif; ?>
									<h3 class="insight-mason-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<div class="insight-meta insight-meta--compact">
										<span><i class="bi bi-clock" aria-hidden="true"></i> <?php echo esc_html( sprintf( __( '%d min read', 'innovare' ), andromeda_reading_time( get_the_content() ) ) ); ?></span>
										<span><?php echo esc_html( get_the_date() ); ?></span>
									</div>
								</div>
							</article>
						<?php endwhile; ?>
					</div>
					<?php wp_reset_postdata(); ?>
				</div>
			<?php endif; ?>

		<?php else : ?>

			<div class="insights-empty">
				<p><?php esc_html_e( 'No articles published yet — here are sample topics we’ll be covering:', 'innovare' ); ?></p>
				<div class="row g-3 g-lg-4">
					<?php foreach ( $samples as $sample ) : ?>
						<div class="col-md-6 col-lg-4">
							<article class="insight-card insight-card--sample">
								<div class="insight-card-media">
									<span class="insight-card-placeholder"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
								</div>
								<div class="insight-card-body">
									<span class="insight-cat"><?php echo esc_html( $sample['cat'] ); ?></span>
									<h3><?php echo esc_html( $sample['title'] ); ?></h3>
									<div class="insight-meta">
										<span><i class="bi bi-clock" aria-hidden="true"></i> <?php echo esc_html( sprintf( __( '%d min read', 'innovare' ), $sample['time'] ) ); ?></span>
										<span class="badge text-bg-light"><?php esc_html_e( 'Coming soon', 'innovare' ); ?></span>
									</div>
								</div>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

		<?php endif; ?>

	</div>
</section>

<?php get_template_part( 'template-parts/home/final-cta' ); ?>

<?php get_footer();
