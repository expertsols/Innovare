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
 * Register Innovate contact + social sections.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function andromeda_customizer_register( $wp_customize ) {

	$mod_defaults = andromeda_theme_mod_defaults();

	$wp_customize->add_section( 'andromeda_contact_section', array(
		'title'    => __( 'Innovate — Contact', 'innovare' ),
		'priority' => 30,
	) );

	$contact_fields = array(
		'andromeda_contact_phone'    => array( 'label' => __( 'Phone Number', 'innovare' ),    'default' => $mod_defaults['andromeda_contact_phone'] ),
		'andromeda_contact_email'    => array( 'label' => __( 'Email Address', 'innovare' ),   'default' => $mod_defaults['andromeda_contact_email'] ),
		'andromeda_contact_whatsapp' => array( 'label' => __( 'WhatsApp Number', 'innovare' ), 'default' => $mod_defaults['andromeda_contact_whatsapp'] ),
		'andromeda_contact_hours'    => array( 'label' => __( 'Working Hours', 'innovare' ),   'default' => $mod_defaults['andromeda_contact_hours'] ),
		'andromeda_contact_address'  => array( 'label' => __( 'Address', 'innovare' ),         'default' => $mod_defaults['andromeda_contact_address'] ),
		'andromeda_contact_map'      => array( 'label' => __( 'Google Maps Embed URL', 'innovare' ), 'default' => $mod_defaults['andromeda_contact_map'] ),
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
		'title'    => __( 'Innovate — Social Links', 'innovare' ),
		'priority' => 31,
	) );

	$socials = array(
		'andromeda_social_facebook'  => array( 'label' => __( 'Facebook URL', 'innovare' ),   'default' => $mod_defaults['andromeda_social_facebook'] ),
		'andromeda_social_linkedin'  => array( 'label' => __( 'LinkedIn URL', 'innovare' ),   'default' => $mod_defaults['andromeda_social_linkedin'] ),
		'andromeda_social_instagram' => array( 'label' => __( 'Instagram URL', 'innovare' ),  'default' => $mod_defaults['andromeda_social_instagram'] ),
		'andromeda_social_tiktok'    => array( 'label' => __( 'TikTok URL', 'innovare' ),     'default' => $mod_defaults['andromeda_social_tiktok'] ),
		'andromeda_social_twitter'   => array( 'label' => __( 'X / Twitter URL', 'innovare' ), 'default' => $mod_defaults['andromeda_social_twitter'] ),
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

	$maintenance_defaults = andromeda_maintenance_defaults();

	$wp_customize->add_section(
		'andromeda_maintenance_section',
		array(
			'title'       => __( 'Innovate — Maintenance', 'innovare' ),
			'description' => __( 'Show a branded maintenance page (HTTP 503) to public visitors. Administrators can still browse and edit the site. Preview: add ?andromeda_maintenance_preview=1 to any front-end URL while logged in.', 'innovare' ),
			'priority'    => 32,
		)
	);

	$wp_customize->add_setting(
		'andromeda_maintenance_mode',
		array(
			'default'           => false,
			'sanitize_callback' => 'andromeda_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'andromeda_maintenance_mode',
		array(
			'label'   => __( 'Enable maintenance mode', 'innovare' ),
			'section' => 'andromeda_maintenance_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'andromeda_maintenance_heading',
		array(
			'default'           => $maintenance_defaults['heading'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'andromeda_maintenance_heading',
		array(
			'label'   => __( 'Maintenance heading', 'innovare' ),
			'section' => 'andromeda_maintenance_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'andromeda_maintenance_message',
		array(
			'default'           => $maintenance_defaults['message'],
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'andromeda_maintenance_message',
		array(
			'label'   => __( 'Maintenance message', 'innovare' ),
			'section' => 'andromeda_maintenance_section',
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
function andromeda_sanitize_checkbox( $value ) {
	return (bool) $value;
}
add_action( 'customize_register', 'andromeda_customizer_register' );
