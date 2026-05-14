<?php
/**
 * 404 — Not Found.
 *
 * @package Innovare
 */

get_header();
?>

<section class="andromeda-section andromeda-404 text-center">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="error-code">404</div>
				<h1 class="error-title"><?php esc_html_e( 'We couldn’t find that page', 'innovare' ); ?></h1>
				<p class="error-intro"><?php esc_html_e( 'It may have moved, or the link may be incorrect. Try searching or head back home.', 'innovare' ); ?></p>
				<div class="error-actions">
					<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'innovare' ); ?></a>
					<a class="btn btn-outline-primary" href="<?php echo esc_url( andromeda_page_url( 'services' ) ); ?>"><?php esc_html_e( 'See services', 'innovare' ); ?></a>
				</div>
				<div class="error-search mt-4">
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer();
