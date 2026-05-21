<?php
/**
 * Single blog post template.
 *
 * @package Innovare
 */

get_header();
?>

<section class="andromeda-section andromeda-single">
	<div class="container-xxl">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'andromeda-article' ); ?>>

				<header class="andromeda-article-header">
					<div class="andromeda-article-meta">
						<span class="insight-cat"><?php echo esc_html( wp_strip_all_tags( get_the_category_list( ', ' ) ) ); ?></span>
						<span><i class="bi bi-calendar3" aria-hidden="true"></i> <?php echo esc_html( get_the_date() ); ?></span>
						<span><i class="bi bi-clock" aria-hidden="true"></i> <?php echo esc_html( sprintf( __( '%d min read', 'innovare' ), andromeda_reading_time( get_the_content() ) ) ); ?></span>
						<span><i class="bi bi-person" aria-hidden="true"></i> <?php echo esc_html( get_the_author() ); ?></span>
					</div>
					<h1 class="andromeda-article-title"><?php the_title(); ?></h1>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="andromeda-article-thumb mb-4">
						<?php the_post_thumbnail( 'andromeda-hero', array( 'loading' => 'eager', 'class' => 'img-fluid rounded-4' ) ); ?>
					</div>
				<?php endif; ?>

				<div class="andromeda-article-content entry-content">
					<?php the_content(); ?>
				</div>

				<?php if ( has_tag() ) : ?>
					<div class="andromeda-article-tags">
						<i class="bi bi-tags" aria-hidden="true"></i>
						<?php the_tags( '', ' · ', '' ); ?>
					</div>
				<?php endif; ?>

				<nav class="andromeda-post-nav" aria-label="<?php esc_attr_e( 'Post navigation', 'innovare' ); ?>">
					<div class="row g-3">
						<div class="col-md-6"><?php previous_post_link( '<div class="post-nav-link post-nav-prev"><span>&laquo; %title</span></div>' ); ?></div>
						<div class="col-md-6 text-md-end"><?php next_post_link( '<div class="post-nav-link post-nav-next"><span>%title &raquo;</span></div>' ); ?></div>
					</div>
				</nav>

			</article>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		<?php endwhile; ?>
	</div>
</section>

<?php get_template_part( 'template-parts/home/final-cta' ); ?>

<?php get_footer();
