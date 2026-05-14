<?php
/**
 * Template Name: Innovare — Contact
 *
 * Modern responsive contact form + meta + map.
 *
 * Form integration:
 *   - If a Fluent Forms or Contact Form 7 shortcode is present in the page
 *     content, it is rendered (and replaces the fallback).
 *   - Otherwise a clean Bootstrap 5 fallback form is rendered. Wire up the
 *     submission handler by replacing the form action or installing a forms
 *     plugin and pasting its shortcode into the page content.
 *
 * @package Innovare
 */

get_header();

$phone    = get_theme_mod( 'andromeda_contact_phone', '+92 345 4243541' );
$email    = get_theme_mod( 'andromeda_contact_email', 'info@andromedalinks.com' );
$whatsapp = get_theme_mod( 'andromeda_contact_whatsapp', '+92 345 4243541' );
$address  = get_theme_mod( 'andromeda_contact_address', 'P-46, Siddiq Trade Center, Gulberg II, Lahore' );
$hours    = get_theme_mod( 'andromeda_contact_hours', 'Mon–Sat · 9:00–18:00' );
$map      = get_theme_mod( 'andromeda_contact_map', 'https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3400.7399635671154!2d74.35023902484548!3d31.53130122420893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sP-198%2C%20Siddique%20Trade%20Center%2C%20Gulberg%20II%2C%20Lahore%2C%20Pakistan!5e0!3m2!1sen!2s!4v1771649949690!5m2!1sen!2s' );

$type_param    = isset( $_GET['type'] ) ? sanitize_key( wp_unslash( $_GET['type'] ) ) : '';
$service_param = isset( $_GET['service'] ) ? sanitize_key( wp_unslash( $_GET['service'] ) ) : '';
$is_quote      = ( 'quote' === $type_param );
$is_consult    = ( 'consultation' === $type_param );

// Map service slugs (matching $g['id'] on the Services page + procurement
// category slugs + solution slugs) to the exact dropdown labels below.
$procurement_label = __( 'Technology Procurement (Hardware & Vendors)', 'innovare' );
$service_slug_map  = array(
	// Service pillars (service-pillar group IDs)
	'managed'                                => __( 'Managed IT Services', 'innovare' ),
	'infrastructure'                         => __( 'Enterprise Infrastructure', 'innovare' ),
	'security'                               => __( 'Network Security', 'innovare' ),
	'consulting'                             => __( 'IT Consulting', 'innovare' ),
	// Hardware-procurement categories — all preselect the procurement option;
	// the specific category travels in the URL slug for the receiving team.
	'procurement-laptops'                    => $procurement_label,
	'procurement-servers'                    => $procurement_label,
	'procurement-components'                 => $procurement_label,
	'procurement-networking'                 => $procurement_label,
	'procurement-security'                   => $procurement_label,
	// Solution slugs (from inc/solutions-data.php) — preselect their nearest
	// dropdown label; the original slug stays in the URL for context.
	'solution-skilledim-hrm'                 => __( 'SkilledIM HRM', 'innovare' ),
	'solution-silver-accounting'             => __( 'Silver Accounting', 'innovare' ),
	'solution-microsoft-365'                 => __( 'Microsoft 365 Solutions', 'innovare' ),
	'solution-business-continuity'           => __( 'Backup & Disaster Recovery', 'innovare' ),
	'solution-managed-office-infrastructure' => __( 'Enterprise Infrastructure', 'innovare' ),
	'solution-network-security'              => __( 'Network Security', 'innovare' ),
	'solution-multi-branch-connectivity'     => __( 'Multi-Site Connectivity', 'innovare' ),
);

if ( $is_quote ) {
	$header_title = __( 'Request a Quote', 'innovare' );
	$header_intro = __( 'Tell us a bit about your environment and the services you need — we’ll respond with a scoped, engineered proposal.', 'innovare' );
} elseif ( $is_consult ) {
	$header_title = __( 'Request a Consultation', 'innovare' );
	$header_intro = __( 'Share where you are today and what you’re trying to improve — and we’ll suggest a practical next step.', 'innovare' );
} else {
	$header_title = __( 'Talk to our engineering team', 'innovare' );
	$header_intro = __( 'Share a bit about your organization, your environment and your goals — we’ll respond with the right next step.', 'innovare' );
}

andromeda_page_header(
	__( 'Contact', 'innovare' ),
	$header_title,
	$header_intro
);
?>

<section class="andromeda-section andromeda-contact-page">
	<div class="container">

		<div class="row gx-lg-5 gy-4">

			<div class="col-lg-5">
				<div class="contact-meta-card">
					<h2><?php esc_html_e( 'Reach us directly', 'innovare' ); ?></h2>

					<ul class="contact-list">
						<li>
							<span class="contact-list-icon"><?php andromeda_icon( 'pin' ); ?></span>
							<div>
								<strong><?php esc_html_e( 'Address', 'innovare' ); ?></strong>
								<p class="mb-0"><?php echo esc_html( $address ); ?></p>
							</div>
						</li>
						<li>
							<span class="contact-list-icon"><?php andromeda_icon( 'phone' ); ?></span>
							<div>
								<strong><?php esc_html_e( 'Phone', 'innovare' ); ?></strong>
								<p class="mb-0"><a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
							</div>
						</li>
						<li>
							<span class="contact-list-icon"><?php andromeda_icon( 'mail' ); ?></span>
							<div>
								<strong><?php esc_html_e( 'Email', 'innovare' ); ?></strong>
								<p class="mb-0"><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
							</div>
						</li>
						<?php if ( $whatsapp ) : ?>
							<li>
								<span class="contact-list-icon"><?php andromeda_icon( 'whatsapp' ); ?></span>
								<div>
									<strong><?php esc_html_e( 'WhatsApp', 'innovare' ); ?></strong>
									<p class="mb-0"><a href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^\d]/', '', $whatsapp ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $whatsapp ); ?></a></p>
								</div>
							</li>
						<?php endif; ?>
						<li>
							<span class="contact-list-icon"><?php andromeda_icon( 'clock' ); ?></span>
							<div>
								<strong><?php esc_html_e( 'Working hours', 'innovare' ); ?></strong>
								<p class="mb-0"><?php echo esc_html( $hours ); ?></p>
							</div>
						</li>
					</ul>

					<div class="contact-socials">
						<strong><?php esc_html_e( 'Follow our work', 'innovare' ); ?></strong>
						<?php andromeda_social_icons( 'contact-socials-list' ); ?>
					</div>
				</div>
			</div>

			<div class="col-lg-7">
				<div class="contact-form-card">
					<h2>
						<?php
						if ( $is_quote ) {
							esc_html_e( 'Request a Quote', 'innovare' );
						} elseif ( $is_consult ) {
							esc_html_e( 'Request a Consultation', 'innovare' );
						} else {
							esc_html_e( 'Send us a message', 'innovare' );
						}
						?>
					</h2>
					<p class="contact-form-intro"><?php esc_html_e( 'All requests are reviewed by our engineering team. Expected response: within one business day.', 'innovare' ); ?></p>

					<?php
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							$content = get_the_content();
							if ( has_shortcode( $content, 'fluentform' ) || has_shortcode( $content, 'contact-form-7' ) ) {
								echo apply_filters( 'the_content', $content );
							} else {
								$preselected = '';
								if ( $service_param && isset( $service_slug_map[ $service_param ] ) ) {
									$preselected = $service_slug_map[ $service_param ];
								} elseif ( $is_quote ) {
									$preselected = __( 'Managed IT Services', 'innovare' );
								} elseif ( $is_consult ) {
									$preselected = __( 'IT Consulting', 'innovare' );
								}

								$service_options = array(
									__( 'Managed IT Services', 'innovare' ),
									__( 'Enterprise Infrastructure', 'innovare' ),
									__( 'Network Security', 'innovare' ),
									__( 'Server & Identity Infrastructure', 'innovare' ),
									__( 'Multi-Site Connectivity', 'innovare' ),
									__( 'Backup & Disaster Recovery', 'innovare' ),
									__( 'Microsoft 365 Solutions', 'innovare' ),
									__( 'SkilledIM HRM', 'innovare' ),
									__( 'Silver Accounting', 'innovare' ),
									__( 'Technology Procurement (Hardware & Vendors)', 'innovare' ),
									__( 'IT Consulting', 'innovare' ),
									__( 'Other / Not sure yet', 'innovare' ),
								);
								?>
								<form class="andromeda-contact-form needs-validation" novalidate action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
									<input type="hidden" name="action" value="andromeda_contact_fallback">
									<input type="hidden" name="enquiry_type" value="<?php echo esc_attr( $type_param ); ?>">
									<?php wp_nonce_field( 'andromeda_contact', 'andromeda_contact_nonce' ); ?>

									<div class="row g-3">
										<div class="col-md-6">
											<label class="form-label" for="acf-name"><?php esc_html_e( 'Name', 'innovare' ); ?> *</label>
											<input class="form-control" type="text" id="acf-name" name="full_name" autocomplete="name" required>
											<div class="invalid-feedback"><?php esc_html_e( 'Please enter your name.', 'innovare' ); ?></div>
										</div>
										<div class="col-md-6">
											<label class="form-label" for="acf-company"><?php esc_html_e( 'Company', 'innovare' ); ?></label>
											<input class="form-control" type="text" id="acf-company" name="company" autocomplete="organization">
										</div>
										<div class="col-md-6">
											<label class="form-label" for="acf-email"><?php esc_html_e( 'Email', 'innovare' ); ?> *</label>
											<input class="form-control" type="email" id="acf-email" name="email" autocomplete="email" required>
											<div class="invalid-feedback"><?php esc_html_e( 'Please provide a valid email address.', 'innovare' ); ?></div>
										</div>
										<div class="col-md-6">
											<label class="form-label" for="acf-phone"><?php esc_html_e( 'Phone', 'innovare' ); ?></label>
											<input class="form-control" type="tel" id="acf-phone" name="phone" autocomplete="tel">
										</div>
										<div class="col-12">
											<label class="form-label" for="acf-service"><?php esc_html_e( 'Service Required', 'innovare' ); ?></label>
											<select class="form-select w-100" id="acf-service" name="service">
												<option value=""><?php esc_html_e( '— Select an area of interest —', 'innovare' ); ?></option>
												<?php foreach ( $service_options as $opt ) : ?>
													<option<?php selected( $preselected, $opt ); ?>><?php echo esc_html( $opt ); ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<div class="col-12">
											<label class="form-label" for="acf-message"><?php esc_html_e( 'Message', 'innovare' ); ?> *</label>
											<textarea class="form-control" id="acf-message" name="message" rows="5" required placeholder="<?php esc_attr_e( 'A few lines about your environment, your team size and what you’re trying to achieve.', 'innovare' ); ?>"></textarea>
											<div class="invalid-feedback"><?php esc_html_e( 'Please describe your enquiry.', 'innovare' ); ?></div>
										</div>
										<div class="col-12 d-flex flex-wrap align-items-center gap-3">
											<button class="btn btn-primary btn-lg" type="submit">
												<?php
												if ( $is_quote ) {
													esc_html_e( 'Send Quote Request', 'innovare' );
												} elseif ( $is_consult ) {
													esc_html_e( 'Request Consultation', 'innovare' );
												} else {
													esc_html_e( 'Send Message', 'innovare' );
												}
												?>
												<i class="bi bi-send ms-2" aria-hidden="true"></i>
											</button>
											<p class="form-note mb-0"><?php esc_html_e( 'We respond within one business day. For urgent issues, please call or WhatsApp us directly.', 'innovare' ); ?></p>
										</div>
									</div>
								</form>
								<?php
							}
						endwhile;
					endif;
					?>
				</div>
			</div>

		</div>

		<div class="contact-map mt-4 mt-lg-5">
			<?php if ( $map ) : ?>
				<iframe src="<?php echo esc_url( $map ); ?>" width="100%" height="380" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="<?php esc_attr_e( 'Office location', 'innovare' ); ?>"></iframe>
			<?php else : ?>
				<div class="contact-map-placeholder">
					<i class="bi bi-map" aria-hidden="true"></i>
					<p><?php esc_html_e( 'Map placeholder — paste a Google Maps embed URL in Customizer → Innovare — Contact → Google Maps Embed URL.', 'innovare' ); ?></p>
				</div>
			<?php endif; ?>
		</div>

	</div>
</section>

<?php get_footer();
