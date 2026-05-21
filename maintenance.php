<?php
/**
 * Maintenance mode template (503).
 *
 * Loaded by inc/maintenance.php — not used as a regular page template.
 *
 * @package Innovare
 */

$defaults = andromeda_maintenance_defaults();
$heading  = get_theme_mod( 'andromeda_maintenance_heading', $defaults['heading'] );
$message  = get_theme_mod( 'andromeda_maintenance_message', $defaults['message'] );
$phone    = get_theme_mod( 'andromeda_contact_phone', andromeda_default_contact_phone() );
$email    = get_theme_mod( 'andromeda_contact_email', 'info@innovate.com' );
$hours    = get_theme_mod( 'andromeda_contact_hours', 'Mon–Sat · 9:00–18:00' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<meta name="robots" content="noindex, nofollow">
	<title><?php echo esc_html( $heading ); ?> | <?php echo esc_html( get_bloginfo( 'name' ) ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'andromeda-maintenance' ); ?>>
<?php wp_body_open(); ?>

<main class="andromeda-maintenance-shell" id="site-content">
	<div class="andromeda-maintenance-card">
		<div class="andromeda-maintenance-brand">
			<?php andromeda_brand_logo( 'navbar' ); ?>
		</div>

		<p class="andromeda-maintenance-eyebrow"><?php esc_html_e( 'Scheduled maintenance', 'innovare' ); ?></p>
		<h1 class="andromeda-maintenance-title"><?php echo esc_html( $heading ); ?></h1>

		<?php if ( $message ) : ?>
			<p class="andromeda-maintenance-message"><?php echo esc_html( $message ); ?></p>
		<?php endif; ?>

		<ul class="andromeda-maintenance-contact">
			<?php if ( $hours ) : ?>
				<li><?php andromeda_icon( 'clock' ); ?> <span><?php echo esc_html( $hours ); ?></span></li>
			<?php endif; ?>
			<?php if ( $phone ) : ?>
				<li><?php andromeda_icon( 'phone' ); ?> <a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
			<?php endif; ?>
			<?php if ( $email ) : ?>
				<li><?php andromeda_icon( 'mail' ); ?> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
			<?php endif; ?>
		</ul>

		<?php andromeda_social_icons( 'andromeda-maintenance-socials' ); ?>
	</div>
</main>

<?php wp_footer(); ?>
</body>
</html>
