<?php
/**
 * Homepage — Industries we serve.
 *
 * Industries live on the homepage only — there is no separate Industries page
 * in the navbar (intentional positioning choice).
 *
 * @package Innovare
 */

$industries = array(
	array( 'icon' => 'education',     'title' => __( 'Education', 'innovare' ),         'desc' => __( 'Campus networks, labs, identity and e-learning infrastructure for institutions.', 'innovare' ) ),
	array( 'icon' => 'government',    'title' => __( 'Government', 'innovare' ),        'desc' => __( 'Secure, auditable IT environments for public-sector and regulated teams.', 'innovare' ) ),
	array( 'icon' => 'corporate',     'title' => __( 'Corporate Offices', 'innovare' ), 'desc' => __( 'Head-office and branch IT, identity, collaboration and access control.', 'innovare' ) ),
	array( 'icon' => 'manufacturing', 'title' => __( 'Manufacturing', 'innovare' ),     'desc' => __( 'Plant networks, OT/IT separation and reliable shop-floor connectivity.', 'innovare' ) ),
	array( 'icon' => 'sme',           'title' => __( 'SMEs', 'innovare' ),              'desc' => __( 'Right-sized IT with predictable cost, real accountability and room to grow.', 'innovare' ) ),
);
?>
<section class="andromeda-section andromeda-industries" aria-labelledby="industries-heading">
	<div class="container">

		<div class="section-heading">
			<span class="eyebrow"><?php esc_html_e( 'Industries', 'innovare' ); ?></span>
			<h2 id="industries-heading"><?php esc_html_e( 'Built around the realities of each sector', 'innovare' ); ?></h2>
			<p><?php esc_html_e( 'We adapt our delivery to the constraints, compliance and operating tempo of the industries we serve.', 'innovare' ); ?></p>
		</div>

		<div class="row g-3 g-lg-4">
			<?php foreach ( $industries as $i ) : ?>
				<div class="col-sm-6 col-lg-4">
					<div class="industry-card">
						<span class="industry-card-icon"><?php andromeda_icon( $i['icon'] ); ?></span>
						<div>
							<h3 class="industry-card-title"><?php echo esc_html( $i['title'] ); ?></h3>
							<p class="industry-card-desc"><?php echo esc_html( $i['desc'] ); ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
