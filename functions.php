<?php
/**
 * Kulier Wood theme bootstrap.
 *
 * @package kulier-wood
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KULIER_VERSION', '1.1.0' );
define( 'KULIER_DIR', get_template_directory() );
define( 'KULIER_URI', get_template_directory_uri() );

require_once KULIER_DIR . '/inc/theme-setup.php';
require_once KULIER_DIR . '/inc/assets.php';
require_once KULIER_DIR . '/inc/woocommerce.php';
require_once KULIER_DIR . '/inc/template-tags.php';
require_once KULIER_DIR . '/inc/customizer.php';
require_once KULIER_DIR . '/inc/class-kulier-footer-fallback.php';

/** The count is public; WooCommerce resolves the visitor's own cart session. */
function kulier_cart_count() {
	wp_send_json_success( array( 'count' => function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ) );
}
add_action( 'wp_ajax_kulier_cart_count', 'kulier_cart_count' );
add_action( 'wp_ajax_nopriv_kulier_cart_count', 'kulier_cart_count' );
