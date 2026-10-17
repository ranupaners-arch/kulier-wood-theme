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
		array( __( 'Collections', 'kulier-wood' ), kulier_shop_url() ),
		array( __( 'Journal', 'kulier-wood' ), kulier_journal_url() ),
		array( __( 'About', 'kulier-wood' ), home_url( '/#studio' ) ),
		array( __( 'Contact', 'kulier-wood' ), home_url( '/#contact' ) ),
	);
	foreach ( $links as $link ) {
		printf( '<a href="%s">%s</a>', esc_url( $link[1] ), esc_html( $link[0] ) );
	}
}
