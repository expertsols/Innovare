<?php
/**
 * Homepage — Final call-to-action band.
 *
 * Reused on inner pages (Services, Solutions, Insights, Company).
 *
 * @package Innovare
 */
?>
<section class="andromeda-final-cta" aria-labelledby="final-cta-heading">
	<div class="container">
		<div class="final-cta-card">
			<div class="row align-items-center gy-4">
				<div class="col-lg-8">
					<span class="final-cta-eyebrow">
						<i class="bi bi-headset" aria-hidden="true"></i>
						<?php esc_html_e( 'Talk to our engineering team', 'innovare' ); ?>
					</span>
					<h2 id="final-cta-heading"><?php esc_html_e( 'Need Reliable IT Infrastructure & Support?', 'innovare' ); ?></h2>
					<p><?php esc_html_e( 'Share your environment, your goals and the gaps you want to close — and we’ll respond with a practical, engineered plan forward.', 'innovare' ); ?></p>
				</div>
				<div class="col-lg-4 text-lg-end">
					<a class="btn btn-light me-2 mb-2" href="<?php echo esc_url( andromeda_page_url( 'contact' ) ); ?>">
						<?php esc_html_e( 'Contact Us', 'innovare' ); ?>
						<i class="bi bi-arrow-right ms-2" aria-hidden="true"></i>
					</a>
					<a class="btn btn-outline-light mb-2" href="<?php echo esc_url( andromeda_page_url( 'contact' ) ); ?>?type=consultation">
						<?php esc_html_e( 'Request Consultation', 'innovare' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
