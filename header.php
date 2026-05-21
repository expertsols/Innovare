<?php
/**
 * Header template with sticky Bootstrap 5 navbar.
 *
 * @package Innovare
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="visually-hidden-focusable skip-link" href="#site-content"><?php esc_html_e( 'Skip to content', 'innovare' ); ?></a>

<header id="masthead" class="site-header innovare-header">

	<?php innovare_topbar(); ?>

	<nav class="navbar navbar-expand-lg innovare-navbar" aria-label="<?php esc_attr_e( 'Primary navigation', 'innovare' ); ?>">
		<div class="container">

			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<?php innovare_brand_logo( 'navbar' ); ?>
			</a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#innovare-primary-nav" aria-controls="innovare-primary-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'innovare' ); ?>">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="innovare-primary-nav">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( array(
						'theme_location'  => 'primary',
						'container'       => false,
						'menu_id'         => 'primary-menu',
						'menu_class'      => 'navbar-nav ms-auto mb-2 mb-lg-0',
						'fallback_cb'     => array( 'Innovare_Bootstrap_Nav_Walker', 'fallback' ),
						'walker'          => new Innovare_Bootstrap_Nav_Walker(),
						'depth'           => 2,
					) );
				} else {
					Innovare_Bootstrap_Nav_Walker::fallback( array() );
				}
				?>
				<div class="navbar-cta">
					<a class="btn btn-primary btn-sm rounded-pill px-3" href="<?php echo esc_url( innovare_page_url( 'contact' ) ); ?>?type=quote">
						<?php esc_html_e( 'Get a Quote', 'innovare' ); ?>
						<i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
	</nav>

</header>

<main id="site-content" class="site-main innovare-main">
