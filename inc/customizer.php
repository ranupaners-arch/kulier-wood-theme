<?php
/** Editable company copy, photography and contact configuration. */
defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', function ( $customizer ) {
	$customizer->add_section( 'kulier_company', array( 'title' => __( 'Kulier Wood — Perusahaan', 'kulier-wood' ), 'priority' => 30 ) );
	foreach ( array( 'hero' => 'Hero showroom', 'studio' => 'Our studio', 'craft' => 'Craftsmanship' ) as $key => $label ) {
		$id = 'kulier_' . $key . '_image';
		$customizer->add_setting( $id, array( 'sanitize_callback' => 'esc_url_raw' ) );
		$customizer->add_control( new WP_Customize_Image_Control( $customizer, $id, array( 'label' => $label . ' — gambar', 'section' => 'kulier_company' ) ) );
	}
	foreach ( array( 'hero' => 'Thoughtfully designed wooden furniture for spaces that value material, form, and lasting character.', 'studio' => 'KULIER WOOD explores the relationship between natural materials, contemporary forms, and the spaces we inhabit. Our collections bring warmth, clarity, and character to residential and commercial interiors.', 'craft' => 'From the character of the wood to the proportions of each piece, small details shape the way furniture is experienced.' ) as $key => $default ) {
		$id = 'kulier_' . $key . '_copy';
		$customizer->add_setting( $id, array( 'default' => $default, 'sanitize_callback' => 'sanitize_textarea_field' ) );
		$customizer->add_control( $id, array( 'label' => ucfirst( $key ) . ' — teks', 'section' => 'kulier_company', 'type' => 'textarea' ) );
	}
	foreach ( array( 'email' => 'Email bisnis', 'whatsapp' => 'WhatsApp (kode negara, contoh format: 62…)', 'address' => 'Alamat perusahaan', 'location' => 'Lokasi perusahaan', 'heading' => 'Judul ajakan proyek' ) as $key => $label ) {
		$id = 'kulier_contact_' . $key;
		$customizer->add_setting( $id, array( 'sanitize_callback' => $key === 'email' ? 'sanitize_email' : 'sanitize_text_field' ) );
		$customizer->add_control( $id, array( 'label' => $label, 'section' => 'kulier_company', 'type' => $key === 'email' ? 'email' : 'text' ) );
	}
} );
