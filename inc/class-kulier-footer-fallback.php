<?php
/**
 * Footer menu fallback when no menu is assigned.
 *
 * @package kulier-wood
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Echoes footer links mirroring the approved design.
 */
function kulier_footer_fallback() {
	$links = array(
		array( __( 'Home', 'kulier-wood' ), home_url( '/' ) ),
		array( __( 'Collections', 'kulier-wood' ), get_permalink( wc_get_page_id( 'shop' ) ) ),
		array( __( 'Journal', 'kulier-wood' ), get_permalink( get_option( 'page_for_posts' ) ) ),
		array( __( 'Keranjang', 'kulier-wood' ), wc_get_cart_url() ),
		array( __( 'Kontak', 'kulier-wood' ), home_url( '/#contact' ) ),
	);
	foreach ( $links as $link ) {
		printf( '<a href="%s">%s</a>', esc_url( $link[1] ), esc_html( $link[0] ) );
	}
}
