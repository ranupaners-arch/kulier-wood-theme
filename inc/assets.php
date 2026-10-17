<?php
/**
 * Styles and scripts.
 *
 * @package kulier-wood
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'wp_enqueue_scripts',
	function () {
		// Fonts: Caprasimo (display) + Urbanist (body), from the approved design.
		wp_enqueue_style(
			'kulier-fonts',
			'https://fonts.googleapis.com/css2?family=Caprasimo&family=Urbanist:wght@400;500;600&display=swap',
			array(),
			null
		);

		wp_enqueue_style( 'kulier-main', KULIER_URI . '/assets/css/main.css', array( 'kulier-fonts' ), KULIER_VERSION );
		wp_enqueue_style( 'kulier-woo', KULIER_URI . '/assets/css/woocommerce.css', array( 'kulier-main' ), KULIER_VERSION );

		wp_localize_script(
			'kulier-main',
			'kulierData',
			array(
				'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
				'cartUrl'   => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '',
				'cartNonce' => function_exists( 'wp_create_nonce' ) ? wp_create_nonce( 'kulier-cart' ) : '',
			)
		);

		wp_enqueue_script( 'kulier-main', KULIER_URI . '/assets/js/main.js', array(), KULIER_VERSION, true );

		if ( is_woocommerce() || is_cart() || is_checkout() ) {
			wp_enqueue_script( 'kulier-woo', KULIER_URI . '/assets/js/woocommerce.js', array( 'kulier-main' ), KULIER_VERSION, true );
		}
	}
);

add_action(
	'wp_head',
	function () {
		echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
		echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	},
	2
);
