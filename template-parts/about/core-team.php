<?php
/**
 * Core team section — About page.
 *
 * Data source: andromeda_get_team_members() (wp_options).
 *
 * @package Innovare
 */

$core_team              = andromeda_get_team_members( true );
$core_team_social_icons = andromeda_team_social_icons();

if ( empty( $core_team ) ) {
	return;
}

$core_team_count = count( $core_team );
$team_col_class  = $core_team_count > 1 ? 'col-12 col-lg-6' : 'col-12';
?>
<div class="core-team-section mt-5 mt-lg-6" id="team">
	<div class="section-heading mb-4 mb-lg-5">
		<span class="eyebrow"><?php esc_html_e( 'Leadership & core team', 'innovare' ); ?></span>
		<h2><?php esc_html_e( 'The people behind your technology partnership', 'innovare' ); ?></h2>
		<p class="mb-0"><?php esc_html_e( 'A small, senior team — accountable, reachable and aligned with how your organization actually runs.', 'innovare' ); ?></p>
	</div>
	<div class="row g-4">
		<?php foreach ( $core_team as $member ) : ?>
			<?php
			$m_name   = isset( $member['name'] ) ? $member['name'] : '';
			$m_role   = isset( $member['role'] ) ? $member['role'] : '';
			$m_bio    = isset( $member['bio'] ) ? $member['bio'] : '';
			$m_photo  = andromeda_team_member_photo_url( $member );
			$m_social = isset( $member['social'] ) && is_array( $member['social'] ) ? array_filter( $member['social'] ) : array();
			?>
			<div class="<?php echo esc_attr( $team_col_class ); ?>">
				<article class="core-team-card h-100">
					<div class="row g-0 align-items-stretch core-team-card-inner h-100">
						<div class="col-12 col-md-auto">
							<div class="core-team-card-media">
								<?php if ( $m_photo ) : ?>
									<img src="<?php echo esc_url( $m_photo ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $m_name ) ); ?>" loading="lazy" decoding="async" />
								<?php elseif ( $m_name ) : ?>
									<?php
									$initials = '';
									$parts    = preg_split( '/\s+/', wp_strip_all_tags( $m_name ), -1, PREG_SPLIT_NO_EMPTY );
									if ( $parts ) {
										$initials .= mb_substr( $parts[0], 0, 1 );
										if ( count( $parts ) > 1 ) {
											$initials .= mb_substr( $parts[ count( $parts ) - 1 ], 0, 1 );
										}
									}
									$initials = $initials ? strtoupper( $initials ) : '?';
									?>
									<span class="core-team-card-initials" aria-hidden="true"><?php echo esc_html( $initials ); ?></span>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-12 col-md">
							<div class="core-team-card-body">
								<?php if ( $m_name ) : ?>
									<h3 class="core-team-card-name"><?php echo esc_html( $m_name ); ?></h3>
								<?php endif; ?>
								<?php if ( $m_role ) : ?>
									<p class="core-team-card-role"><?php echo esc_html( $m_role ); ?></p>
								<?php endif; ?>
								<?php if ( $m_bio ) : ?>
									<p class="core-team-card-bio"><?php echo esc_html( $m_bio ); ?></p>
								<?php endif; ?>
								<?php if ( $m_social ) : ?>
									<ul class="core-team-card-socials" aria-label="<?php echo esc_attr__( 'Social profiles', 'innovare' ); ?>">
										<?php foreach ( $m_social as $platform => $url ) : ?>
											<?php
											$url = esc_url( $url );
											if ( ! $url ) {
												continue;
											}
											$icon = isset( $core_team_social_icons[ $platform ] ) ? $core_team_social_icons[ $platform ] : 'bi-link-45deg';
											/* translators: %1$s: person name; %2$s: network name */
											$aria = sprintf( __( '%1$s on %2$s', 'innovare' ), wp_strip_all_tags( $m_name ), ucfirst( $platform ) );
											?>
											<li>
												<a href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $aria ); ?>">
													<i class="bi <?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</article>
			</div>
		<?php endforeach; ?>
	</div>
</div>
