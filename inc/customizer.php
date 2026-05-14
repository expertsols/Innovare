<?php
/**
 * Lightweight Customizer additions — contact details + social URLs.
 *
 * Kept intentionally small so the admin remains uncomplicated.
 *
 * @package Innovare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Innovare contact + social sections.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function andromeda_customizer_register( $wp_customize ) {

	$wp_customize->add_section( 'andromeda_contact_section', array(
		'title'    => __( 'Innovare — Contact', 'innovare' ),
		'priority' => 30,
	) );

	$contact_fields = array(
		'andromeda_contact_phone'    => array( 'label' => __( 'Phone Number', 'innovare' ),    'default' => '+92 345 4243541' ),
		'andromeda_contact_email'    => array( 'label' => __( 'Email Address', 'innovare' ),   'default' => 'info@andromedalinks.com' ),
		'andromeda_contact_whatsapp' => array( 'label' => __( 'WhatsApp Number', 'innovare' ), 'default' => '+92 345 4243541' ),
		'andromeda_contact_hours'    => array( 'label' => __( 'Working Hours', 'innovare' ),   'default' => 'Mon–Sat · 9:00–18:00' ),
		'andromeda_contact_address'  => array( 'label' => __( 'Address', 'innovare' ),         'default' => 'P-46, Siddiq Trade Center, Gulberg II, Lahore' ),
		'andromeda_contact_map'      => array( 'label' => __( 'Google Maps Embed URL', 'innovare' ), 'default' => 'https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3400.7399635671154!2d74.35023902484548!3d31.53130122420893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sP-198%2C%20Siddique%20Trade%20Center%2C%20Gulberg%20II%2C%20Lahore%2C%20Pakistan!5e0!3m2!1sen!2s!4v1771649949690!5m2!1sen!2s' ),
	);

	foreach ( $contact_fields as $id => $cfg ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $cfg['default'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $cfg['label'],
			'section' => 'andromeda_contact_section',
			'type'    => 'text',
		) );
	}

	$wp_customize->add_section( 'andromeda_social_section', array(
		'title'    => __( 'Innovare — Social Links', 'innovare' ),
		'priority' => 31,
	) );

	$socials = array(
		'andromeda_social_facebook'  => array( 'label' => __( 'Facebook URL', 'innovare' ),   'default' => 'https://www.facebook.com/AndromedaLinks' ),
		'andromeda_social_linkedin'  => array( 'label' => __( 'LinkedIn URL', 'innovare' ),   'default' => 'https://www.linkedin.com/company/andromedalinks/' ),
		'andromeda_social_instagram' => array( 'label' => __( 'Instagram URL', 'innovare' ),  'default' => 'https://www.instagram.com/andromeda.links/' ),
		'andromeda_social_tiktok'    => array( 'label' => __( 'TikTok URL', 'innovare' ),     'default' => 'https://www.tiktok.com/@andromedalinks' ),
		'andromeda_social_twitter'   => array( 'label' => __( 'X / Twitter URL', 'innovare' ), 'default' => 'https://x.com/LinksAndromeda' ),
	);

	foreach ( $socials as $id => $cfg ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $cfg['default'],
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $cfg['label'],
			'section' => 'andromeda_social_section',
			'type'    => 'url',
		) );
	}
}
add_action( 'customize_register', 'andromeda_customizer_register' );
