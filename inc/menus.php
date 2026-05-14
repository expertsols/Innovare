<?php
/**
 * Menus + Bootstrap 5 nav walker.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register primary + footer menus.
 */
function andromeda_register_menus() {
	register_nav_menus( array(
		'primary'    => __( 'Primary Navigation', 'innovare' ),
		'footer'     => __( 'Footer Navigation', 'innovare' ),
		'social'     => __( 'Social Links', 'innovare' ),
	) );
}
add_action( 'after_setup_theme', 'andromeda_register_menus' );

/**
 * A small, self-contained Bootstrap 5 nav walker.
 *
 * Outputs valid Bootstrap 5 dropdowns with proper ARIA attributes.
 */
class Andromeda_Bootstrap_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Start level — open dropdown menu.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
	}

	/**
	 * Start element — output the <li> + <a>.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent      = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$has_children = in_array( 'menu-item-has-children', (array) $item->classes, true );

		$li_classes = array( 'nav-item' );
		if ( $has_children && 0 === $depth ) {
			$li_classes[] = 'dropdown';
		}
		if ( in_array( 'current-menu-item', (array) $item->classes, true ) ) {
			$li_classes[] = 'active';
		}

		$output .= $indent . '<li class="' . esc_attr( implode( ' ', $li_classes ) ) . '">';

		$link_classes = array();
		if ( 0 === $depth ) {
			$link_classes[] = 'nav-link';
			if ( $has_children ) {
				$link_classes[] = 'dropdown-toggle';
			}
		} else {
			$link_classes[] = 'dropdown-item';
		}

		$attrs  = ' class="' . esc_attr( implode( ' ', $link_classes ) ) . '"';
		$attrs .= $item->url ? ' href="' . esc_url( $item->url ) . '"' : ' href="#"';
		$attrs .= $item->target ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attrs .= $item->xfn ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';

		if ( $has_children && 0 === $depth ) {
			$attrs .= ' data-bs-toggle="dropdown" aria-expanded="false" role="button"';
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$output .= '<a' . $attrs . '>' . esc_html( $title ) . '</a>';
	}

	/**
	 * Fallback when no menu is assigned — render a sensible default.
	 *
	 * Reflects the 6-item enterprise IT structure:
	 * Home · Services · Solutions · Insights · About · Contact.
	 */
	public static function fallback( $args ) {
		$about_path = '/' . andromeda_about_page_slug() . '/';
		$pages      = array(
			'/'           => __( 'Home', 'innovare' ),
			'/services/'  => __( 'Services', 'innovare' ),
			'/solutions/' => __( 'Solutions', 'innovare' ),
			'/insights/'  => __( 'Insights', 'innovare' ),
			$about_path   => __( 'About', 'innovare' ),
			'/contact/'   => __( 'Contact', 'innovare' ),
		);

		echo '<ul id="primary-menu" class="navbar-nav ms-auto mb-2 mb-lg-0">';
		foreach ( $pages as $slug => $label ) {
			$is_current = false;
			if ( '/' === $slug ) {
				$is_current = is_front_page();
			} else {
				$page = get_page_by_path( trim( $slug, '/' ) );
				if ( $page && is_page( $page->ID ) ) {
					$is_current = true;
				}
			}
			$active = $is_current ? ' active' : '';
			printf(
				'<li class="nav-item"><a class="nav-link%s"%s href="%s">%s</a></li>',
				esc_attr( $active ),
				$is_current ? ' aria-current="page"' : '',
				esc_url( home_url( $slug ) ),
				esc_html( $label )
			);
		}
		echo '</ul>';
	}
}
