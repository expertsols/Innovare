<?php
/**
 * Small helper functions used across templates.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render an inline SVG/Bootstrap-icon based icon for service cards.
 *
 * @param string $name  Icon shorthand (mapped to Bootstrap Icons class).
 * @param string $class Extra classes.
 */
function andromeda_icon( $name, $class = '' ) {
	$icons = array(
		'managed'        => 'bi-gear-wide-connected',
		'infrastructure' => 'bi-diagram-3',
		'security'       => 'bi-shield-lock',
		'server'         => 'bi-hdd-stack',
		'continuity'     => 'bi-cloud-arrow-up',
		'multi-site'     => 'bi-globe2',
		'consulting'     => 'bi-clipboard-data',
		'hardware'       => 'bi-laptop',
		'cpu'            => 'bi-cpu',
		'support'        => 'bi-headset',
		'network'        => 'bi-router',
		'firewall'       => 'bi-bricks',
		'backup'         => 'bi-archive',
		'cloud'          => 'bi-cloud',
		'identity'       => 'bi-person-badge',
		'wifi'           => 'bi-wifi',
		'cctv'           => 'bi-camera-video',
		'office'         => 'bi-building',
		'education'      => 'bi-mortarboard',
		'government'     => 'bi-bank',
		'corporate'      => 'bi-briefcase',
		'manufacturing'  => 'bi-tools',
		'sme'            => 'bi-shop',
		'retail'         => 'bi-bag',
		'warehouse'      => 'bi-box-seam',
		'speed'          => 'bi-speedometer2',
		'check'          => 'bi-check2-circle',
		'arrow'          => 'bi-arrow-right',
		'mail'           => 'bi-envelope',
		'phone'          => 'bi-telephone',
		'whatsapp'       => 'bi-whatsapp',
		'pin'            => 'bi-geo-alt',
		'clock'          => 'bi-clock-history',
	);

	$bi = isset( $icons[ $name ] ) ? $icons[ $name ] : 'bi-circle';
	printf( '<i class="bi %s %s" aria-hidden="true"></i>', esc_attr( $bi ), esc_attr( $class ) );
}

/**
 * Render a social-icons block.
 *
 * @param string $extra_class Optional wrapper classes.
 */
function andromeda_social_icons( $extra_class = '' ) {
	$links = array(
		'facebook'  => array( 'mod' => 'andromeda_social_facebook',  'icon' => 'bi-facebook',  'label' => 'Facebook',  'default' => 'https://www.facebook.com/AndromedaLinks' ),
		'linkedin'  => array( 'mod' => 'andromeda_social_linkedin',  'icon' => 'bi-linkedin',  'label' => 'LinkedIn',  'default' => 'https://www.linkedin.com/company/andromedalinks/' ),
		'instagram' => array( 'mod' => 'andromeda_social_instagram', 'icon' => 'bi-instagram', 'label' => 'Instagram', 'default' => 'https://www.instagram.com/andromeda.links/' ),
		'tiktok'    => array( 'mod' => 'andromeda_social_tiktok',    'icon' => 'bi-tiktok',    'label' => 'TikTok',    'default' => 'https://www.tiktok.com/@andromedalinks' ),
		'twitter'   => array( 'mod' => 'andromeda_social_twitter',   'icon' => 'bi-twitter-x', 'label' => 'X (Twitter)', 'default' => 'https://x.com/LinksAndromeda' ),
	);

	echo '<ul class="andromeda-socials ' . esc_attr( $extra_class ) . '">';
	foreach ( $links as $key => $cfg ) {
		$url = get_theme_mod( $cfg['mod'], $cfg['default'] );
		if ( ! $url ) {
			continue;
		}
		printf(
			'<li><a href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s"><i class="bi %3$s" aria-hidden="true"></i></a></li>',
			esc_url( $url ),
			esc_attr( $cfg['label'] ),
			esc_attr( $cfg['icon'] )
		);
	}
	echo '</ul>';
}

/**
 * Render a reusable inner-page hero header.
 *
 * @param string $eyebrow Small label above the title.
 * @param string $title   Main title.
 * @param string $intro   Subtitle / intro copy.
 */
function andromeda_page_header( $eyebrow, $title, $intro = '' ) {
	?>
	<section class="andromeda-page-header" aria-labelledby="andromeda-page-header-title">
		<div class="page-header-backdrop" aria-hidden="true">
			<div class="page-header-grid"></div>
			<div class="page-header-glow page-header-glow--a"></div>
			<div class="page-header-glow page-header-glow--b"></div>
		</div>
		<div class="container position-relative">
			<div class="row justify-content-center text-center">
				<div class="col-lg-9 col-xl-8">
					<?php if ( $eyebrow ) : ?>
						<span class="page-header-eyebrow">
							<i class="bi bi-shield-check" aria-hidden="true"></i>
							<?php echo esc_html( $eyebrow ); ?>
						</span>
					<?php endif; ?>
					<h1 id="andromeda-page-header-title" class="page-header-title"><?php echo esc_html( $title ); ?></h1>
					<?php if ( $intro ) : ?>
						<p class="page-header-intro"><?php echo esc_html( $intro ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Estimate reading time in minutes from a content string.
 *
 * @param string $content HTML content.
 * @return int Minutes (minimum 1).
 */
function andromeda_reading_time( $content ) {
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes    = (int) ceil( $word_count / 220 );
	return max( 1, $minutes );
}

/**
 * First category label for Insights cards (single primary topic).
 *
 * @param int $post_id Post ID.
 * @return string
 */
function andromeda_insights_primary_cat( $post_id ) {
	$terms = get_the_terms( (int) $post_id, 'category' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return '';
	}
	return $terms[0]->name;
}

/**
 * Render the site's CTA contact info bar (phone / email / hours).
 */
function andromeda_topbar() {
	$phone    = get_theme_mod( 'andromeda_contact_phone', '+92 345 4243541' );
	$email    = get_theme_mod( 'andromeda_contact_email', 'info@andromedalinks.com' );
	$hours    = get_theme_mod( 'andromeda_contact_hours', 'Mon–Sat · 9:00–18:00' );
	$whatsapp = get_theme_mod( 'andromeda_contact_whatsapp', '+92 345 4243541' );
	?>
	<div class="andromeda-topbar d-none d-lg-block">
		<div class="container d-flex justify-content-between align-items-center">
			<div class="topbar-meta">
				<span><?php andromeda_icon( 'clock' ); ?> <?php echo esc_html( $hours ); ?></span>
				<span><?php andromeda_icon( 'pin' ); ?> <?php esc_html_e( 'Lahore, Pakistan · Nationwide Support', 'innovare' ); ?></span>
			</div>
			<div class="topbar-actions">
				<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php andromeda_icon( 'mail' ); ?> <?php echo esc_html( $email ); ?></a>
				<a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>"><?php andromeda_icon( 'phone' ); ?> <?php echo esc_html( $phone ); ?></a>
				<?php if ( $whatsapp ) : ?>
					<a class="topbar-whatsapp" href="https://wa.me/<?php echo esc_attr( preg_replace( '/[^\d]/', '', $whatsapp ) ); ?>" target="_blank" rel="noopener"><?php andromeda_icon( 'whatsapp' ); ?> <?php esc_html_e( 'WhatsApp', 'innovare' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Slug for the About / Company landing page (formerly `company`).
 *
 * @return string
 */
function andromeda_about_page_slug() {
	return 'about-andromeda-links';
}

/**
 * URL for the site privacy policy page at `/privacy/` (Settings → Privacy when synced).
 *
 * @return string
 */
function andromeda_privacy_policy_url() {
	$page = get_page_by_path( 'privacy', OBJECT, 'page' );
	if ( $page && 'publish' === $page->post_status ) {
		return get_permalink( $page );
	}

	$policy_id = (int) get_option( 'wp_page_for_privacy_policy' );
	if ( $policy_id && 'publish' === get_post_status( $policy_id ) ) {
		return get_permalink( $policy_id );
	}

	if ( function_exists( 'get_privacy_policy_url' ) ) {
		$url = get_privacy_policy_url();
		if ( $url ) {
			return $url;
		}
	}

	return andromeda_page_url( 'privacy' );
}

/**
 * Resolve a likely URL for a page-by-slug, falling back to home if missing.
 *
 * @param string $slug Page slug.
 * @return string
 */
function andromeda_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( $page );
	}
	return home_url( '/' . trim( $slug, '/' ) . '/' );
}

/**
 * 301 redirect legacy `/company/` URLs to `/about-andromeda-links/` after the
 * page slug was renamed (bookmarks and external links).
 */
function andromeda_redirect_legacy_company_page() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
		return;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	if ( ! $uri ) {
		return;
	}
	$path = wp_parse_url( $uri, PHP_URL_PATH );
	if ( ! is_string( $path ) ) {
		return;
	}
	$home_path = wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	if ( is_string( $home_path ) && $home_path && '/' !== $home_path ) {
		$path = preg_replace( '#^' . preg_quote( untrailingslashit( $home_path ), '#' ) . '#', '', $path );
	}
	$path = trim( $path, '/' );
	if ( 'company' !== $path ) {
		return;
	}
	wp_safe_redirect( andromeda_page_url( andromeda_about_page_slug() ), 301 );
	exit;
}
add_action( 'template_redirect', 'andromeda_redirect_legacy_company_page', 1 );

/**
 * Render the Innovare brand:
 *   - If a custom logo is uploaded in Customizer → Site Identity, that wins.
 *   - Otherwise, fall back to the bundled brand PNG shipped with the theme.
 *
 * @param string $variant 'navbar' | 'footer' — controls wrapper class only.
 */
function andromeda_brand_logo( $variant = 'navbar' ) {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}

	$src = INNOVARE_URI . 'assets/images/andromedalinks-logo.png';
	printf(
		'<img class="andromeda-brand-img andromeda-brand-img--%1$s" src="%2$s" alt="%3$s" width="160" height="160" decoding="async" %4$s />',
		esc_attr( $variant ),
		esc_url( $src ),
		esc_attr( get_bloginfo( 'name' ) ),
		'navbar' === $variant ? 'fetchpriority="high"' : 'loading="lazy"'
	);
}
