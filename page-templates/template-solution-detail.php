<?php
/**
 * Template Name: Innovare — Solution Detail
 *
 * Renders a single solution's detail page. The template reads the current
 * page's slug (post_name) and looks up the matching solution from
 * innovare_get_solutions(). If no match is found, falls back to redirecting
 * to the Solutions listing page.
 *
 * Expected URL: /solutions/<slug>/
 *
 * @package Innovare
 */

get_header();

$page_slug = get_post_field( 'post_name', get_queried_object_id() );
$solution  = innovare_get_solution( $page_slug );

// If the slug doesn't match a known solution, gracefully fall back to the
// Solutions listing — better UX than a blank page or a hard 404.
if ( ! $solution ) {
	$fallback = innovare_page_url( 'solutions' );
	if ( $fallback ) {
		wp_safe_redirect( $fallback, 302 );
		exit;
	}
}

$contact_url   = innovare_page_url( 'contact' );
$discuss_url   = add_query_arg(
	array(
		'type'    => 'quote',
		'service' => 'solution-' . $page_slug,
	),
	$contact_url
);
// Short brand-style label for CTAs (falls back to the full product title).
$cta_subject   = ! empty( $solution['short_title'] ) ? $solution['short_title'] : $solution['title'];
/* translators: %s: solution short name */
$discuss_label = sprintf( __( 'Discuss %s', 'innovare' ), $cta_subject );
/* translators: %s: solution short name */
$discuss_aria  = sprintf( __( 'Discuss %s with our team', 'innovare' ), $cta_subject );

// Optional "Explore" CTA — only renders when a destination URL is set in
// the data file (inc/solutions-data.php). Until then, the page gracefully
// shows only the Discuss button.
$explore_cta = isset( $solution['cta']['explore'] ) && is_array( $solution['cta']['explore'] )
	? $solution['cta']['explore']
	: array();
$explore_url    = ! empty( $explore_cta['url'] ) ? $explore_cta['url'] : '';
$explore_label  = ! empty( $explore_cta['label'] ) ? $explore_cta['label']
	/* translators: %s: solution short name */
	: sprintf( __( 'Explore %s', 'innovare' ), $cta_subject );
$explore_aria   = ! empty( $explore_cta['aria'] ) ? $explore_cta['aria']
	/* translators: %s: solution short name */
	: sprintf( __( 'Explore %s in detail', 'innovare' ), $cta_subject );
$explore_target = ! empty( $explore_cta['target'] ) ? $explore_cta['target'] : '';
// Classify the link so we can pick the right icon:
//   - in-page anchor (#xxx)        -> down-arrow (scroll cue)
//   - absolute http/https URL or
//     explicit _blank target       -> external-link icon
//   - everything else (relative)   -> right-arrow
$explore_is_anchor = $explore_url && strpos( $explore_url, '#' ) === 0;
$explore_is_ext    = $explore_target === '_blank'
	|| ( $explore_url && preg_match( '#^https?://#i', $explore_url ) );
if ( $explore_is_anchor ) {
	$explore_icon = 'bi-arrow-down';
} elseif ( $explore_is_ext ) {
	$explore_icon = 'bi-box-arrow-up-right';
} else {
	$explore_icon = 'bi-arrow-right';
}

innovare_page_header(
	$solution['badge'],
	$solution['title'],
	$solution['lede']
);
?>

<section class="innovare-section solution-detail-intro">
	<div class="container">
		<div class="row gx-lg-5 gy-4 align-items-start">
			<div class="col-lg-8">
				<div class="solution-detail-summary">

					<span class="eyebrow"><?php esc_html_e( 'Overview', 'innovare' ); ?></span>
					<h2><?php esc_html_e( 'What this solution actually delivers', 'innovare' ); ?></h2>

					<?php if ( ! empty( $solution['notice'] ) && is_array( $solution['notice'] ) ) : ?>
						<?php
						$notice_icon = ! empty( $solution['notice']['icon'] )
							? sanitize_html_class( $solution['notice']['icon'] )
							: 'bi-info-circle';
						?>
						<aside class="solution-detail-notice" role="note">
							<span class="solution-detail-notice-icon" aria-hidden="true">
								<i class="bi <?php echo esc_attr( $notice_icon ); ?>"></i>
							</span>
							<div class="solution-detail-notice-body">
								<?php if ( ! empty( $solution['notice']['label'] ) ) : ?>
									<strong><?php echo esc_html( $solution['notice']['label'] ); ?></strong>
								<?php endif; ?>
								<?php if ( ! empty( $solution['notice']['message'] ) ) : ?>
									<span><?php echo esc_html( $solution['notice']['message'] ); ?></span>
								<?php endif; ?>
							</div>
						</aside>
					<?php endif; ?>

					<p class="solution-detail-lede"><?php echo esc_html( $solution['summary'] ); ?></p>

					<div class="solution-detail-cta-row">
						<?php if ( $explore_url ) : ?>
							<a class="btn btn-outline-primary solution-detail-cta-explore"
								href="<?php echo esc_url( $explore_url ); ?>"
								aria-label="<?php echo esc_attr( $explore_aria ); ?>"
								<?php if ( $explore_target ) : ?>target="<?php echo esc_attr( $explore_target ); ?>" rel="noopener noreferrer"<?php endif; ?>>
								<span><?php echo esc_html( $explore_label ); ?></span>
								<i class="bi <?php echo esc_attr( $explore_icon ); ?> ms-2" aria-hidden="true"></i>
							</a>
						<?php endif; ?>

						<a class="btn btn-primary solution-detail-cta-discuss"
							href="<?php echo esc_url( $discuss_url ); ?>"
							aria-label="<?php echo esc_attr( $discuss_aria ); ?>">
							<span><?php echo esc_html( $discuss_label ); ?></span>
							<i class="bi bi-chat-dots ms-2" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>

			<?php if ( ! empty( $solution['best_for'] ) ) : ?>
				<div class="col-lg-4">
					<?php
					$bf_brand = isset( $solution['best_for_brand'] ) && is_array( $solution['best_for_brand'] )
						? $solution['best_for_brand']
						: array();
					$bf_file   = isset( $bf_brand['file'] ) ? ltrim( $bf_brand['file'], '/' ) : '';
					$bf_path   = $bf_file ? trailingslashit( get_template_directory() ) . $bf_file : '';
					$bf_src    = ( $bf_file && $bf_path && file_exists( $bf_path ) )
						? trailingslashit( get_template_directory_uri() ) . $bf_file
						: '';
					$bf_alt    = ! empty( $bf_brand['alt'] ) ? $bf_brand['alt'] : $solution['title'];
					$bf_word   = ! empty( $bf_brand['fallback'] ) ? $bf_brand['fallback'] : $bf_alt;
					$bf_tag    = ! empty( $bf_brand['tagline'] ) ? $bf_brand['tagline'] : '';
					$bf_show   = $bf_src || $bf_word || $bf_tag;
					?>
					<?php if ( $bf_show ) : ?>
						<div class="solution-detail-aside-brand">
							<?php if ( $bf_src ) : ?>
								<img
									class="solution-detail-aside-brand-img"
									src="<?php echo esc_url( $bf_src ); ?>"
									alt="<?php echo esc_attr( $bf_alt ); ?>"
									loading="lazy"
									decoding="async"
								/>
							<?php elseif ( $bf_word ) : ?>
								<p
									class="solution-detail-aside-brand-fallback"
									role="img"
									aria-label="<?php echo esc_attr( $bf_alt ); ?>"
								><?php echo esc_html( $bf_word ); ?></p>
							<?php endif; ?>
							<?php if ( $bf_tag && ! $bf_src ) : ?>
								<span class="solution-detail-aside-brand-tagline"><?php echo esc_html( $bf_tag ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<aside class="solution-detail-aside">
						<span class="solution-detail-aside-eyebrow">
							<i class="bi bi-people" aria-hidden="true"></i>
							<?php esc_html_e( 'Best for', 'innovare' ); ?>
						</span>
						<ul>
							<?php foreach ( $solution['best_for'] as $item ) : ?>
								<li><i class="bi bi-check2-circle" aria-hidden="true"></i><span><?php echo esc_html( $item ); ?></span></li>
							<?php endforeach; ?>
						</ul>
					</aside>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php if ( ! empty( $solution['whats_included'] ) ) : ?>
<section id="features" class="innovare-section solution-detail-included" aria-labelledby="included-heading">
	<div class="container">
		<div class="section-heading mb-4 mb-lg-5">
			<span class="eyebrow"><?php esc_html_e( "What's included", 'innovare' ); ?></span>
			<h2 id="included-heading"><?php esc_html_e( 'A single, accountable engagement — not just a tool', 'innovare' ); ?></h2>
		</div>
		<div class="row g-3">
			<?php
			$module_grid = ! empty( $solution['whats_included'][0] ) && is_array( $solution['whats_included'][0] );
			foreach ( $solution['whats_included'] as $item ) :
				if ( $module_grid && is_array( $item ) ) :
					$mod_title = isset( $item['title'] ) ? $item['title'] : '';
					$mod_desc  = isset( $item['desc'] ) ? $item['desc'] : '';
					$mod_icon  = isset( $item['icon'] ) ? $item['icon'] : 'bi-check2-circle';
					$mod_tone  = isset( $item['tone'] ) ? sanitize_html_class( $item['tone'] ) : 'blue';
					?>
					<div class="col-md-6 col-lg-4">
						<article class="solution-module-card">
							<span class="solution-module-icon solution-module-icon--<?php echo esc_attr( $mod_tone ); ?>">
								<i class="bi <?php echo esc_attr( $mod_icon ); ?>" aria-hidden="true"></i>
							</span>
							<div class="solution-module-card-body">
								<h3 class="solution-module-title"><?php echo esc_html( $mod_title ); ?></h3>
								<?php if ( $mod_desc ) : ?>
									<p class="solution-module-desc"><?php echo esc_html( $mod_desc ); ?></p>
								<?php endif; ?>
							</div>
						</article>
					</div>
				<?php else : ?>
					<div class="col-md-6 col-lg-4">
						<div class="service-item">
							<i class="bi bi-check2-circle" aria-hidden="true"></i>
							<span><?php echo esc_html( is_array( $item ) ? innovare_solution_included_label( $item ) : $item ); ?></span>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $solution['outcomes'] ) ) : ?>
<section class="innovare-section solution-detail-outcomes" aria-labelledby="outcomes-heading">
	<div class="container">
		<div class="row gx-lg-5 gy-4 align-items-start">
			<div class="col-lg-5">
				<span class="eyebrow"><?php esc_html_e( 'Outcomes', 'innovare' ); ?></span>
				<h2 id="outcomes-heading"><?php esc_html_e( 'Tangible outcomes you can measure', 'innovare' ); ?></h2>
				<p class="text-muted">
					<?php esc_html_e( 'We are not selling features — we are committing to outcomes. Here is what success looks like once this solution is live.', 'innovare' ); ?>
				</p>
			</div>
			<div class="col-lg-7">
				<ul class="outcomes-list" role="list">
					<?php foreach ( $solution['outcomes'] as $i => $outcome ) : ?>
						<li>
							<span class="outcome-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
							<p><?php echo esc_html( $outcome ); ?></p>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $solution['engagement'] ) ) : ?>
<section class="innovare-section solution-detail-engagement" aria-labelledby="engagement-heading">
	<div class="container">
		<div class="section-heading mb-4 mb-lg-5">
			<span class="eyebrow"><?php esc_html_e( 'How we engage', 'innovare' ); ?></span>
			<h2 id="engagement-heading">
				<?php
				echo esc_html(
					! empty( $solution['engagement_heading'] )
						? $solution['engagement_heading']
						: __( 'A simple, predictable engagement model', 'innovare' )
				);
				?>
			</h2>
		</div>
		<ol class="engagement-flow" role="list">
			<?php foreach ( $solution['engagement'] as $i => $step ) : ?>
				<li class="engagement-step">
					<span class="engagement-step-num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
					<h3 class="engagement-step-title"><?php echo esc_html( $step['label'] ); ?></h3>
					<p class="engagement-step-desc"><?php echo esc_html( $step['desc'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
<?php endif; ?>

<?php
// If WordPress page content exists beyond the auto-generated stub, render it
// below the structured sections — gives the marketing team an escape hatch
// to add long-form prose, FAQs, screenshots, etc., without editing PHP.
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$raw_content = trim( wp_strip_all_tags( get_the_content() ) );
		if ( $raw_content && strlen( $raw_content ) > 30 ) :
?>
			<section class="innovare-section solution-detail-prose">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-10 col-xl-8">
							<div class="solution-detail-prose-body">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				</div>
			</section>
<?php
		endif;
	endwhile;
	wp_reset_postdata();
endif;
?>

<?php get_template_part( 'template-parts/home/final-cta' ); ?>

<?php get_footer();
