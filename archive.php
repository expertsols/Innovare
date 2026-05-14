<?php
/**
 * Archive template — categories, tags, dates, authors.
 *
 * @package Innovare
 */

get_header();

$eyebrow = '';
$title   = get_the_archive_title();
$intro   = get_the_archive_description();

if ( is_category() ) {
	$eyebrow = __( 'Category', 'innovare' );
} elseif ( is_tag() ) {
	$eyebrow = __( 'Tag', 'innovare' );
} elseif ( is_author() ) {
	$eyebrow = __( 'Author', 'innovare' );
} else {
	$eyebrow = __( 'Insights', 'innovare' );
}

andromeda_page_header( $eyebrow, wp_strip_all_tags( $title ), wp_strip_all_tags( $intro ) );
?>

<section class="andromeda-section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="row g-3 g-lg-4 insights-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="col-md-6 col-lg-4">
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'insight-card' ); ?>>
							<a class="insight-card-media" href="<?php the_permalink(); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'andromeda-card', array( 'loading' => 'lazy', 'class' => 'img-fluid' ) ); ?>
								<?php else : ?>
									<span class="insight-card-placeholder"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
								<?php endif; ?>
							</a>
							<div class="insight-card-body">
								<span class="insight-cat"><?php echo esc_html( wp_strip_all_tags( get_the_category_list( ', ' ) ) ); ?></span>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="insight-meta">
									<span><i class="bi bi-clock" aria-hidden="true"></i> <?php echo esc_html( sprintf( __( '%d min read', 'innovare' ), andromeda_reading_time( get_the_content() ) ) ); ?></span>
									<span><i class="bi bi-calendar3" aria-hidden="true"></i> <?php echo esc_html( get_the_date() ); ?></span>
								</div>
							</div>
						</article>
					</div>
				<?php endwhile; ?>
			</div>

			<nav class="andromeda-pagination" aria-label="<?php esc_attr_e( 'Posts navigation', 'innovare' ); ?>">
				<?php
				the_posts_pagination( array(
					'prev_text' => '<i class="bi bi-arrow-left" aria-hidden="true"></i>',
					'next_text' => '<i class="bi bi-arrow-right" aria-hidden="true"></i>',
				) );
				?>
			</nav>

		<?php else : ?>
			<div class="andromeda-empty text-center py-5">
				<h2><?php esc_html_e( 'No posts found', 'innovare' ); ?></h2>
				<p><?php esc_html_e( 'Try a different category or return home.', 'innovare' ); ?></p>
				<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'innovare' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer();
