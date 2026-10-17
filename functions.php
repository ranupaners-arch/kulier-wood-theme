<?php
/**
 * Kulier Wood theme bootstrap.
 *
 * @package kulier-wood
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KULIER_VERSION', '1.0.0' );
define( 'KULIER_DIR', get_template_directory() );
define( 'KULIER_URI', get_template_directory_uri() );

require_once KULIER_DIR . '/inc/theme-setup.php';
require_once KULIER_DIR . '/inc/assets.php';
require_once KULIER_DIR . '/inc/woocommerce.php';
require_once KULIER_DIR . '/inc/template-tags.php';
require_once KULIER_DIR . '/inc/class-kulier-footer-fallback.php';

/**
 * AJAX endpoint returning the live WooCommerce cart count.
 */
add_action(
	'wp_ajax_kulier_cart_count',
	function () {
		check_ajax_referer( 'kulier-cart', 'nonce' );
		wp_send_json_success(
			array(
				'count' => WC()->cart ? WC()->cart->get_cart_contents_count() : 0,
			)
		);
	}
);
