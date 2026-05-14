<?php
/**
 * Template Name: Innovare — Sitemap
 *
 * Human-readable overview of main site sections plus optional XML sitemap link.
 *
 * @package Innovare
 */

get_header();

while ( have_posts() ) :
	the_post();
	andromeda_page_header(
		__( 'Site map', 'innovare' ),
		get_the_title(),
		__( 'Jump to the main areas of our site.', 'innovare' )
	);

	$about_slug = andromeda_about_page_slug();
	$privacy = function_exists( 'andromeda_privacy_policy_url' ) ? andromeda_privacy_policy_url() : andromeda_page_url( 'privacy' );

	$nav_groups = array(
		__( 'Main pages', 'innovare' ) => array(
			__( 'Home', 'innovare' )       => home_url( '/' ),
			__( 'Services', 'innovare' )   => andromeda_page_url( 'services' ),
			__( 'Solutions', 'innovare' )  => andromeda_page_url( 'solutions' ),
			__( 'Insights', 'innovare' )   => andromeda_page_url( 'insights' ),
			__( 'Company', 'innovare' )    => andromeda_page_url( $about_slug ),
			__( 'Contact', 'innovare' )    => andromeda_page_url( 'contact' ),
		),
		__( 'Legal', 'innovare' ) => array(
			__( 'Privacy Policy', 'innovare' ) => $privacy,
			__( 'Terms of Use', 'innovare' )     => andromeda_page_url( 'terms' ),
		),
	);

	$xml_sitemap = '';
	if ( function_exists( 'get_sitemap_url' ) ) {
		$xml_sitemap = get_sitemap_url( 'index' );
	} else {
		$xml_sitemap = home_url( '/wp-sitemap.xml' );
	}
	?>
	<section class="andromeda-section andromeda-sitemap-page">
		<div class="container">
			<div class="row justify-content-center mb-4">
				<div class="col-lg-9 col-xl-8 andromeda-legal-content entry-content">
					<?php the_content(); ?>
				</div>
			</div>

			<div class="row g-4 justify-content-center">
				<?php foreach ( $nav_groups as $group_title => $links ) : ?>
					<div class="col-md-6 col-lg-5">
						<div class="andromeda-sitemap-card">
							<h2 class="h5 mb-3"><?php echo esc_html( $group_title ); ?></h2>
							<ul class="andromeda-sitemap-list list-unstyled mb-0">
								<?php foreach ( $links as $label => $url ) : ?>
									<?php if ( $url ) : ?>
										<li>
											<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a>
										</li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $xml_sitemap ) : ?>
				<p class="text-center text-muted small mt-4 mb-0">
					<a href="<?php echo esc_url( $xml_sitemap ); ?>"><?php esc_html_e( 'XML sitemap (for search engines)', 'innovare' ); ?></a>
				</p>
			<?php endif; ?>
		</div>
	</section>
	<?php
endwhile;

get_footer();
