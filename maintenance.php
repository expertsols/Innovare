<?php
/**
 * Maintenance mode template (503).
 *
 * Loaded by inc/maintenance.php — not used as a regular page template.
 *
 * @package Innovare
 */

$defaults = innovare_maintenance_defaults();
$heading  = get_theme_mod( 'innovare_maintenance_heading', $defaults['heading'] );
$message  = get_theme_mod( 'innovare_maintenance_message', $defaults['message'] );
$phone    = get_theme_mod( 'innovare_contact_phone', innovare_default_contact_phone() );
$email    = get_theme_mod( 'innovare_contact_email', 'info@innovare.com' );
$hours    = get_theme_mod( 'innovare_contact_hours', 'Mon–Sat · 9:00–18:00' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<meta name="robots" content="noindex, nofollow">
	<title><?php echo esc_html( $heading ); ?> | <?php echo esc_html( get_bloginfo( 'name' ) ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'innovare-maintenance' ); ?>>
<?php wp_body_open(); ?>

<main class="innovare-maintenance-shell" id="site-content">
	<div class="innovare-maintenance-card">
		<div class="innovare-maintenance-brand">
			<?php innovare_brand_logo( 'navbar' ); ?>
		</div>

		<p class="innovare-maintenance-eyebrow"><?php esc_html_e( 'Scheduled maintenance', 'innovare' ); ?></p>
		<h1 class="innovare-maintenance-title"><?php echo esc_html( $heading ); ?></h1>

		<?php if ( $message ) : ?>
			<p class="innovare-maintenance-message"><?php echo esc_html( $message ); ?></p>
		<?php endif; ?>

		<ul class="innovare-maintenance-contact">
			<?php if ( $hours ) : ?>
				<li><?php innovare_icon( 'clock' ); ?> <span><?php echo esc_html( $hours ); ?></span></li>
			<?php endif; ?>
			<?php if ( $phone ) : ?>
				<li><?php innovare_icon( 'phone' ); ?> <a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
			<?php endif; ?>
			<?php if ( $email ) : ?>
				<li><?php innovare_icon( 'mail' ); ?> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
			<?php endif; ?>
		</ul>

		<?php innovare_social_icons( 'innovare-maintenance-socials' ); ?>

		<p class="innovare-maintenance-credit">
			<a href="<?php echo esc_url( innovare_theme_author_uri() ); ?>" target="_blank" rel="noopener noreferrer">
				<?php
				echo esc_html(
					sprintf(
						/* translators: 1: theme name, 2: author */
						__( '%1$s · %2$s', 'innovare' ),
						innovare_theme_name(),
						innovare_theme_author()
					)
				);
				?>
			</a>
		</p>
	</div>
</main>

<?php wp_footer(); ?>
</body>
</html>
