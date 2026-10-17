<?php
/**
 * Theme supports, menus, image sizes.
 *
 * @package kulier-wood
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'kulier-wood', KULIER_DIR . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );

		register_nav_menus(
			array(
				'primary' => __( 'Navigasi Utama', 'kulier-wood' ),
				'footer'  => __( 'Tautan Footer', 'kulier-wood' ),
			)
		);
	}
);

add_action(
	'init',
	function () {
		add_image_size( 'kulier-card', 700, 700, true );
		add_image_size( 'kulier-card-wide', 700, 420, true );
		add_image_size( 'kulier-detail', 1080, 1060, true );
		add_image_size( 'kulier-hero', 1080, 1100, true );
	}
);
