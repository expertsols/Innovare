<?php
/**
 * Innovate — WordPress theme bootstrap.
 *
 * Standalone theme (no parent). Loads modular files from /inc.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'INNOVARE_VERSION', '2.0.0' );
define( 'INNOVARE_DIR', trailingslashit( get_template_directory() ) );
define( 'INNOVARE_URI', trailingslashit( get_template_directory_uri() ) );

require_once INNOVARE_DIR . 'inc/theme-setup.php';
require_once INNOVARE_DIR . 'inc/enqueue.php';
require_once INNOVARE_DIR . 'inc/menus.php';
require_once INNOVARE_DIR . 'inc/seo.php';
require_once INNOVARE_DIR . 'inc/helpers.php';
require_once INNOVARE_DIR . 'inc/footer.php';
require_once INNOVARE_DIR . 'inc/maintenance.php';
require_once INNOVARE_DIR . 'inc/insights-rewrites.php';
require_once INNOVARE_DIR . 'inc/customizer.php';
require_once INNOVARE_DIR . 'inc/solutions-data.php';
require_once INNOVARE_DIR . 'inc/team-data.php';
require_once INNOVARE_DIR . 'inc/site-bootstrap.php';
require_once INNOVARE_DIR . 'inc/legal-pages.php';
