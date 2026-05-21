<?php
/**
 * Generic page template — used for any page that doesn't pick a custom one.
 *
 * @package Innovare
 */

get_header();
?>

<section class="innovare-section innovare-generic-page">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="page-<?php the_ID(); ?>" <?php post_class( 'innovare-article' ); ?>>
				<header class="innovare-article-header">
					<h1 class="innovare-article-title"><?php the_title(); ?></h1>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="innovare-article-thumb mb-4">
						<?php the_post_thumbnail( 'innovare-hero', array( 'loading' => 'eager', 'class' => 'img-fluid rounded-4' ) ); ?>
					</div>
				<?php endif; ?>

				<div class="innovare-article-content entry-content">
					<?php the_content(); ?>
					<?php
					wp_link_pages( array(
						'before' => '<nav class="innovare-link-pages">' . esc_html__( 'Pages:', 'innovare' ),
						'after'  => '</nav>',
					) );
					?>
				</div>
			</article>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		<?php endwhile; ?>
	</div>
</section>

<?php get_footer();
