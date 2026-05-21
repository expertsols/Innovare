<?php
/**
 * Site maintenance mode — branded 503 page for public visitors.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default copy for the maintenance screen.
 *
 * @return array<string, string>
 */
function innovare_maintenance_defaults() {
	return array(
		'heading' => __( 'We\'ll be back shortly', 'innovare' ),
		'message' => __( 'We\'re performing scheduled maintenance to improve our services. Please check back soon — or reach out using the contact details below if you need urgent assistance.', 'innovare' ),
	);
}

/**
 * Whether maintenance mode is enabled in the Customizer.
 *
 * @return bool
 */
function innovare_is_maintenance_mode_enabled() {
	return (bool) get_theme_mod( 'innovare_maintenance_mode', false );
}

/**
 * Whether the current request should bypass maintenance mode.
 *
 * @return bool
 */
function innovare_maintenance_mode_bypass() {
	if ( ! innovare_is_maintenance_mode_enabled() ) {
		return true;
	}

	if ( wp_doing_ajax() || wp_doing_cron() ) {
		return true;
	}

	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		return true;
	}

	if ( is_admin() ) {
		return true;
	}

	if ( defined( 'REST_REQUEST' ) && REST_REQUEST && is_user_logged_in() && current_user_can( 'manage_options' ) ) {
		return true;
	}

	if ( current_user_can( 'manage_options' ) ) {
		if ( ! empty( $_GET['innovare_maintenance_preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return false;
		}
		return true;
	}

	return false;
}

/**
 * Show the maintenance template to public visitors.
 */
function innovare_maybe_show_maintenance_page() {
	if ( innovare_maintenance_mode_bypass() ) {
		return;
	}

	status_header( 503 );
	nocache_headers();

	if ( ! headers_sent() ) {
		header( 'Retry-After: 3600' );
	}

	include get_template_directory() . '/maintenance.php';
	exit;
}
add_action( 'template_redirect', 'innovare_maybe_show_maintenance_page', 0 );

/**
 * Admin dashboard notice when maintenance mode is active.
 */
function innovare_maintenance_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) || ! innovare_is_maintenance_mode_enabled() ) {
		return;
	}

	$customize_url = admin_url( 'customize.php?autofocus[section]=innovare_maintenance_section' );
	$preview_url   = add_query_arg( 'innovare_maintenance_preview', '1', home_url( '/' ) );
	?>
	<div class="notice notice-warning">
		<p>
			<strong><?php esc_html_e( 'Innovare maintenance mode is ON.', 'innovare' ); ?></strong>
			<?php esc_html_e( 'Public visitors see the maintenance page. Logged-in administrators still browse the site normally.', 'innovare' ); ?>
			<a href="<?php echo esc_url( $customize_url ); ?>"><?php esc_html_e( 'Customizer settings', 'innovare' ); ?></a>
			|
			<a href="<?php echo esc_url( $preview_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Preview maintenance page', 'innovare' ); ?></a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'innovare_maintenance_admin_notice' );

/**
 * Admin bar indicator for maintenance mode.
 *
 * @param WP_Admin_Bar $admin_bar Admin bar instance.
 */
function innovare_maintenance_admin_bar( $admin_bar ) {
	if ( ! is_admin_bar_showing() || ! current_user_can( 'manage_options' ) || ! innovare_is_maintenance_mode_enabled() ) {
		return;
	}

	$admin_bar->add_node(
		array(
			'id'    => 'innovare-maintenance-mode',
			'title' => __( 'Maintenance ON', 'innovare' ),
			'href'  => admin_url( 'customize.php?autofocus[section]=innovare_maintenance_section' ),
			'meta'  => array(
				'class' => 'innovare-maintenance-admin-bar',
				'title' => __( 'Public visitors see the maintenance page', 'innovare' ),
			),
		)
	);
}
add_action( 'admin_bar_menu', 'innovare_maintenance_admin_bar', 100 );
