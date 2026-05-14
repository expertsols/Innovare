<?php
/**
 * Search results template.
 *
 * @package Innovare
 */

get_header();

andromeda_page_header(
	__( 'Search', 'innovare' ),
	/* translators: search keyword */
	sprintf( __( 'Results for: %s', 'innovare' ), esc_html( get_search_query() ) ),
	''
);
?>

<section class="andromeda-section">
	<div class="container">

		<div class="row mb-4">
			<div class="col-lg-8 mx-auto">
				<?php get_search_form(); ?>
			</div>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="row g-3 g-lg-4 insights-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="col-md-6 col-lg-4">
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'insight-card' ); ?>>
							<a class="insight-card-media" href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'andromeda-card', array( 'loading' => 'lazy', 'class' => 'img-fluid' ) ); ?>
								<?php else : ?>
									<span class="insight-card-placeholder"><i class="bi bi-search" aria-hidden="true"></i></span>
								<?php endif; ?>
							</a>
							<div class="insight-card-body">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?></p>
							</div>
						</article>
					</div>
				<?php endwhile; ?>
			</div>
			<nav class="andromeda-pagination" aria-label="<?php esc_attr_e( 'Posts navigation', 'innovare' ); ?>">
				<?php the_posts_pagination(); ?>
			</nav>
		<?php else : ?>
			<div class="andromeda-empty text-center py-5">
				<h2><?php esc_html_e( 'No results matched your search', 'innovare' ); ?></h2>
				<p><?php esc_html_e( 'Try different keywords or browse our services.', 'innovare' ); ?></p>
				<a class="btn btn-primary" href="<?php echo esc_url( andromeda_page_url( 'services' ) ); ?>"><?php esc_html_e( 'See services', 'innovare' ); ?></a>
			</div>
		<?php endif; ?>

	</div>
</section>

<?php get_footer();
