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
function innovare_customizer_register( $wp_customize ) {

	$mod_defaults = innovare_theme_mod_defaults();

	$wp_customize->add_section( 'innovare_contact_section', array(
		'title'    => __( 'Innovare — Contact', 'innovare' ),
		'priority' => 30,
	) );

	$contact_fields = array(
		'innovare_contact_phone'    => array( 'label' => __( 'Phone Number', 'innovare' ),    'default' => $mod_defaults['innovare_contact_phone'] ),
		'innovare_contact_email'    => array( 'label' => __( 'Email Address', 'innovare' ),   'default' => $mod_defaults['innovare_contact_email'] ),
		'innovare_contact_whatsapp' => array( 'label' => __( 'WhatsApp Number', 'innovare' ), 'default' => $mod_defaults['innovare_contact_whatsapp'] ),
		'innovare_contact_hours'    => array( 'label' => __( 'Working Hours', 'innovare' ),   'default' => $mod_defaults['innovare_contact_hours'] ),
		'innovare_contact_address'  => array( 'label' => __( 'Address', 'innovare' ),         'default' => $mod_defaults['innovare_contact_address'] ),
		'innovare_contact_map'      => array( 'label' => __( 'Google Maps Embed URL', 'innovare' ), 'default' => $mod_defaults['innovare_contact_map'] ),
	);

	foreach ( $contact_fields as $id => $cfg ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $cfg['default'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $cfg['label'],
			'section' => 'innovare_contact_section',
			'type'    => 'text',
		) );
	}

	$wp_customize->add_section( 'innovare_social_section', array(
		'title'    => __( 'Innovare — Social Links', 'innovare' ),
		'priority' => 31,
	) );

	$socials = array(
		'innovare_social_facebook'  => array( 'label' => __( 'Facebook URL', 'innovare' ),   'default' => $mod_defaults['innovare_social_facebook'] ),
		'innovare_social_linkedin'  => array( 'label' => __( 'LinkedIn URL', 'innovare' ),   'default' => $mod_defaults['innovare_social_linkedin'] ),
		'innovare_social_instagram' => array( 'label' => __( 'Instagram URL', 'innovare' ),  'default' => $mod_defaults['innovare_social_instagram'] ),
		'innovare_social_tiktok'    => array( 'label' => __( 'TikTok URL', 'innovare' ),     'default' => $mod_defaults['innovare_social_tiktok'] ),
		'innovare_social_twitter'   => array( 'label' => __( 'X / Twitter URL', 'innovare' ), 'default' => $mod_defaults['innovare_social_twitter'] ),
	);

	foreach ( $socials as $id => $cfg ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $cfg['default'],
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $cfg['label'],
			'section' => 'innovare_social_section',
			'type'    => 'url',
		) );
	}

	$maintenance_defaults = innovare_maintenance_defaults();

	$wp_customize->add_section(
		'innovare_maintenance_section',
		array(
			'title'       => __( 'Innovare — Maintenance', 'innovare' ),
			'description' => __( 'Show a branded maintenance page (HTTP 503) to public visitors. Administrators can still browse and edit the site. Preview: add ?innovare_maintenance_preview=1 to any front-end URL while logged in.', 'innovare' ),
			'priority'    => 32,
		)
	);

	$wp_customize->add_setting(
		'innovare_maintenance_mode',
		array(
			'default'           => false,
			'sanitize_callback' => 'innovare_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'innovare_maintenance_mode',
		array(
			'label'   => __( 'Enable maintenance mode', 'innovare' ),
			'section' => 'innovare_maintenance_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'innovare_maintenance_heading',
		array(
			'default'           => $maintenance_defaults['heading'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'innovare_maintenance_heading',
		array(
			'label'   => __( 'Maintenance heading', 'innovare' ),
			'section' => 'innovare_maintenance_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'innovare_maintenance_message',
		array(
			'default'           => $maintenance_defaults['message'],
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'innovare_maintenance_message',
		array(
			'label'   => __( 'Maintenance message', 'innovare' ),
			'section' => 'innovare_maintenance_section',
			'type'    => 'textarea',
		)
	);
}

/**
 * Sanitize Customizer checkbox values.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function innovare_sanitize_checkbox( $value ) {
	return (bool) $value;
}
add_action( 'customize_register', 'innovare_customizer_register' );
