<?php
/**
 * Light-touch SEO helpers.
 *
 * If RankMath / Yoast is active, those plugins win — we bail out so we
 * don't duplicate meta tags or schema. Otherwise we output a baseline
 * Open Graph + Organization schema so the site is presentable from day one.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Detect whether a major SEO plugin is active.
 *
 * @return bool
 */
function andromeda_has_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

/**
 * Output baseline Open Graph + Twitter Card tags.
 */
function andromeda_open_graph_tags() {
	if ( andromeda_has_seo_plugin() ) {
		return;
	}

	global $wp;
	$title       = wp_get_document_title();
	$description = get_bloginfo( 'description' );
	$url         = is_singular() ? get_permalink() : home_url( isset( $wp->request ) && $wp->request ? '/' . $wp->request . '/' : '/' );
	$site_name   = get_bloginfo( 'name' );
	$image       = '';

	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post && ! empty( $post->post_excerpt ) ) {
			$description = wp_strip_all_tags( $post->post_excerpt );
		} elseif ( $post ) {
			$description = wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 30, '…' );
		}
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( null, 'full' );
		}
	}

	if ( ! $image ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( $custom_logo_id ) {
			$image = wp_get_attachment_image_url( $custom_logo_id, 'full' );
		}
	}

	echo "\n<!-- Innovare baseline OG tags -->\n";
	printf( '<meta property="og:type" content="%s" />' . "\n", is_singular() ? 'article' : 'website' );
	printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( $site_name ) );
	printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $description ) );
	printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $url ) );
	if ( $image ) {
		printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $image ) );
	}
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	printf( '<meta name="twitter:title" content="%s" />' . "\n", esc_attr( $title ) );
	printf( '<meta name="twitter:description" content="%s" />' . "\n", esc_attr( $description ) );
	if ( $image ) {
		printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $image ) );
	}

	if ( ! is_singular() || is_front_page() ) {
		printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $description ) );
	}
}
add_action( 'wp_head', 'andromeda_open_graph_tags', 5 );

/**
 * Inject Organization JSON-LD on the home page.
 */
function andromeda_organization_schema() {
	if ( andromeda_has_seo_plugin() || ! is_front_page() ) {
		return;
	}

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'Organization',
		'name'        => get_bloginfo( 'name' ),
		'url'         => home_url( '/' ),
		'description' => get_bloginfo( 'description' ),
	);

	$custom_logo_id = get_theme_mod( 'custom_logo' );
	if ( $custom_logo_id ) {
		$schema['logo'] = wp_get_attachment_image_url( $custom_logo_id, 'full' );
	} else {
		$schema['logo'] = INNOVARE_URI . 'assets/images/andromedalinks-logo.png';
	}

	$phone   = get_theme_mod( 'andromeda_contact_phone', '+92 345 4243541' );
	$email   = get_theme_mod( 'andromeda_contact_email', 'info@andromedalinks.com' );
	$address = get_theme_mod( 'andromeda_contact_address', 'P-46, Siddiq Trade Center, Gulberg II, Lahore' );

	if ( $phone ) {
		$schema['telephone'] = preg_replace( '/[^+\d]/', '', $phone );
	}
	if ( $email ) {
		$schema['email'] = $email;
	}
	if ( $address ) {
		$schema['address'] = array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $address,
			'addressLocality' => 'Lahore',
			'addressCountry'  => 'PK',
		);
	}

	$social = array_filter( array(
		get_theme_mod( 'andromeda_social_facebook', 'https://www.facebook.com/AndromedaLinks' ),
		get_theme_mod( 'andromeda_social_linkedin', 'https://www.linkedin.com/company/andromedalinks/' ),
		get_theme_mod( 'andromeda_social_instagram', 'https://www.instagram.com/andromeda.links/' ),
		get_theme_mod( 'andromeda_social_tiktok', 'https://www.tiktok.com/@andromedalinks' ),
		get_theme_mod( 'andromeda_social_twitter', 'https://x.com/LinksAndromeda' ),
	) );
	if ( ! empty( $social ) ) {
		$schema['sameAs'] = array_values( $social );
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'andromeda_organization_schema', 6 );
