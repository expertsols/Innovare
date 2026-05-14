<?php
/**
 * Front Page — Innovare homepage.
 *
 * Modular sections per the enterprise IT brief:
 *
 *  1. Hero
 *  2. Core Services
 *  3. Solutions
 *  4. Industries
 *  5. Follow Our Work (operational social proof)
 *  6. Insights (latest articles)
 *  7. Final CTA
 *
 * Each section lives in its own template part so it can be reused or
 * reordered independently.
 *
 * @package Innovare
 */

get_header();
?>

<?php get_template_part( 'template-parts/home/hero' ); ?>
<?php get_template_part( 'template-parts/home/services-grid' ); ?>
<?php get_template_part( 'template-parts/home/solutions' ); ?>
<?php get_template_part( 'template-parts/home/industries' ); ?>
<?php get_template_part( 'template-parts/home/social-proof' ); ?>
<?php get_template_part( 'template-parts/home/insights' ); ?>
<?php get_template_part( 'template-parts/home/final-cta' ); ?>

<?php
get_footer();
