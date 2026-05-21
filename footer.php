<?php
/**
 * Footer template with widget columns + meta strip.
 *
 * @package Innovare
 */

$phone    = get_theme_mod( 'innovare_contact_phone', innovare_default_contact_phone() );
$email    = get_theme_mod( 'innovare_contact_email', 'info@innovare.com' );
$address  = get_theme_mod( 'innovare_contact_address', 'P-46, Siddiq Trade Center, Gulberg II, Lahore' );
$whatsapp = get_theme_mod( 'innovare_contact_whatsapp', innovare_default_contact_phone() );
?>
</main><!-- /#site-content -->

<footer id="colophon" class="site-footer innovare-footer">

	<div class="footer-main">
		<div class="container">
			<div class="row gy-4">

				<div class="col-lg-4 col-md-12">
					<div class="footer-brand">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
							<?php innovare_brand_logo( 'footer' ); ?>
						</a>
					</div>
					<p class="footer-tagline">
						<?php esc_html_e( 'IT infrastructure, managed services, enterprise software and technology solutions for organizations that need their business technology to just work.', 'innovare' ); ?>
					</p>
					<?php innovare_social_icons( 'footer-socials' ); ?>
				</div>

				<div class="col-lg-2 col-md-3 col-6">
					<h6 class="footer-widget-title"><?php esc_html_e( 'Company', 'innovare' ); ?></h6>
					<?php if ( ! innovare_use_footer_column_defaults( 'footer-1' ) ) : ?>
						<?php dynamic_sidebar( 'footer-1' ); ?>
					<?php else : ?>
						<ul class="footer-links">
							<li><a href="<?php echo esc_url( innovare_page_url( innovare_about_page_slug() ) ); ?>"><?php esc_html_e( 'About Us', 'innovare' ); ?></a></li>
							<li><a href="<?php echo esc_url( innovare_page_url( innovare_about_page_slug() ) ); ?>#industries"><?php esc_html_e( 'Industries Served', 'innovare' ); ?></a></li>
							<li><a href="<?php echo esc_url( innovare_page_url( 'insights' ) ); ?>"><?php esc_html_e( 'Insights', 'innovare' ); ?></a></li>
							<li><a href="<?php echo esc_url( innovare_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact', 'innovare' ); ?></a></li>
						</ul>
					<?php endif; ?>
				</div>

				<div class="col-lg-2 col-md-3 col-6">
					<h6 class="footer-widget-title"><?php esc_html_e( 'Services', 'innovare' ); ?></h6>
					<?php if ( ! innovare_use_footer_column_defaults( 'footer-2' ) ) : ?>
						<?php dynamic_sidebar( 'footer-2' ); ?>
					<?php else : ?>
						<ul class="footer-links">
							<li><a href="<?php echo esc_url( innovare_page_url( 'services' ) ); ?>#managed"><?php esc_html_e( 'Managed IT', 'innovare' ); ?></a></li>
							<li><a href="<?php echo esc_url( innovare_page_url( 'services' ) ); ?>#infrastructure"><?php esc_html_e( 'Infrastructure', 'innovare' ); ?></a></li>
							<li><a href="<?php echo esc_url( innovare_page_url( 'services' ) ); ?>#security"><?php esc_html_e( 'Security', 'innovare' ); ?></a></li>
							<li><a href="<?php echo esc_url( innovare_page_url( 'services' ) ); ?>#consulting"><?php esc_html_e( 'Consulting', 'innovare' ); ?></a></li>
						</ul>
					<?php endif; ?>
				</div>

				<div class="col-lg-2 col-md-3 col-6">
					<h6 class="footer-widget-title"><?php esc_html_e( 'Solutions', 'innovare' ); ?></h6>
					<?php if ( ! innovare_use_footer_column_defaults( 'footer-3' ) ) : ?>
						<?php dynamic_sidebar( 'footer-3' ); ?>
					<?php else : ?>
						<ul class="footer-links">
							<li><a href="<?php echo esc_url( innovare_solution_page_url( 'microsoft-365' ) ); ?>"><?php esc_html_e( 'Microsoft 365', 'innovare' ); ?></a></li>
							<li><a href="<?php echo esc_url( innovare_solution_page_url( 'business-continuity' ) ); ?>"><?php esc_html_e( 'Business Continuity', 'innovare' ); ?></a></li>
							<li><a href="<?php echo esc_url( innovare_solution_page_url( 'managed-office-infrastructure' ) ); ?>"><?php esc_html_e( 'Office Infrastructure', 'innovare' ); ?></a></li>
							<li><a href="<?php echo esc_url( innovare_solution_page_url( 'network-security' ) ); ?>"><?php esc_html_e( 'Network Security', 'innovare' ); ?></a></li>
						</ul>
					<?php endif; ?>
				</div>

				<div class="col-lg-2 col-md-3 col-6">
					<h6 class="footer-widget-title"><?php esc_html_e( 'Contact', 'innovare' ); ?></h6>
					<?php if ( ! innovare_use_footer_column_defaults( 'footer-4' ) ) : ?>
						<?php dynamic_sidebar( 'footer-4' ); ?>
					<?php else : ?>
						<ul class="footer-contact">
							<li><?php innovare_icon( 'pin' ); ?> <span><?php echo esc_html( $address ); ?></span></li>
							<li><?php innovare_icon( 'phone' ); ?> <a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
							<li><?php innovare_icon( 'mail' ); ?> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
							<?php if ( $whatsapp ) : ?>
								<li><?php innovare_icon( 'whatsapp' ); ?> <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^\d]/', '', $whatsapp ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $whatsapp ); ?></a></li>
							<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
			<div class="footer-bottom-start">
				<p class="mb-0 footer-copy">
					<span class="footer-copy-line">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'innovare' ); ?></span>
				</p>
				<?php innovare_theme_footer_credit(); ?>
			</div>
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => 'nav',
					'container_class'=> 'footer-nav',
					'menu_class'     => 'footer-bottom-links',
					'depth'          => 1,
				) );
			} else {
				echo '<ul class="footer-bottom-links">';
				printf( '<li><a href="%s">%s</a></li>', esc_url( innovare_privacy_policy_url() ), esc_html__( 'Privacy', 'innovare' ) );
				printf( '<li><a href="%s">%s</a></li>', esc_url( innovare_page_url( 'terms' ) ), esc_html__( 'Terms', 'innovare' ) );
				printf( '<li><a href="%s">%s</a></li>', esc_url( innovare_page_url( 'sitemap' ) ), esc_html__( 'Sitemap', 'innovare' ) );
				echo '</ul>';
			}
			?>
		</div>
	</div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
