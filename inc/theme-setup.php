<?php
/**
 * Theme setup — supports, image sizes, sidebars, editor styles.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Declare theme support.
 */
function andromeda_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 220,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	add_image_size( 'andromeda-card', 720, 480, true );
	add_image_size( 'andromeda-hero', 1920, 900, true );
	add_image_size( 'andromeda-thumb', 480, 320, true );

	load_theme_textdomain( 'innovare', INNOVARE_DIR . 'languages' );
}
add_action( 'after_setup_theme', 'andromeda_theme_setup', 15 );

/**
 * Register footer widget areas.
 */
function andromeda_register_sidebars() {
	$columns = array(
		'footer-1' => __( 'Footer Column 1 — Company', 'innovare' ),
		'footer-2' => __( 'Footer Column 2 — Services', 'innovare' ),
		'footer-3' => __( 'Footer Column 3 — Solutions', 'innovare' ),
		'footer-4' => __( 'Footer Column 4 — Contact', 'innovare' ),
	);

	foreach ( $columns as $id => $name ) {
		register_sidebar( array(
			'name'          => $name,
			'id'            => $id,
			'description'   => __( 'Drag widgets here to populate a footer column.', 'innovare' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="footer-widget-title">',
			'after_title'   => '</h6>',
		) );
	}
}
add_action( 'widgets_init', 'andromeda_register_sidebars' );

/**
 * Editor styles so the block editor matches the front-end.
 */
function andromeda_editor_styles() {
	add_editor_style( 'assets/css/editor.css' );
}
add_action( 'after_setup_theme', 'andromeda_editor_styles' );

/**
 * Body classes — add a marker for the front-end stylesheet.
 *
 * @param array $classes Body classes.
 * @return array
 */
function andromeda_body_classes( $classes ) {
	$classes[] = 'andromeda-site';
	$classes[] = 'innovare-theme';
	if ( is_front_page() ) {
		$classes[] = 'andromeda-home';
	}
	return $classes;
}
add_filter( 'body_class', 'andromeda_body_classes' );

/**
 * Custom templates that render full-width sections (no extra theme wrapper).
 *
 * @return array
 */
function andromeda_custom_templates() {
	return array(
		'page-templates/template-services.php',
		'page-templates/template-solutions.php',
		'page-templates/template-solution-detail.php',
		'page-templates/template-insights.php',
		'page-templates/template-company.php',
		'page-templates/template-contact.php',
		'page-templates/template-legal-document.php',
		'page-templates/template-sitemap.php',
	);
}
