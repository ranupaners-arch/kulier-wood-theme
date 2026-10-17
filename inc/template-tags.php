<?php
/**
 * Shared template tags: header/footer/nav helpers.
 *
 * @package kulier-wood
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Site wordmark from the approved design.
 */
function kulier_wordmark() {
	?>
	<a class="kw-wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>">KULIER WOOD</a>
	<?php
}

/**
 * Primary navigation with active-state highlight.
 */
function kulier_nav() {
	?>
	<nav class="kw-nav" aria-label="<?php esc_attr_e( 'Navigasi Utama', 'kulier-wood' ); ?>">
		<?php
		$items = array(
			array( 'home', __( 'Home', 'kulier-wood' ), home_url( '/' ) ),
			array( 'collections', __( 'Collections', 'kulier-wood' ), get_permalink( wc_get_page_id( 'shop' ) ) ),
			array( 'journal', __( 'Journal', 'kulier-wood' ), get_permalink( get_option( 'page_for_posts' ) ? get_option( 'page_for_posts' ) : get_page_by_path( 'journal' ) ) ),
		);
		foreach ( $items as $item ) {
			list( $slug, $label, $url ) = $item;
			$active                     = ( 'home' === $slug && is_front_page() )
				|| ( 'collections' === $slug && ( is_shop() || is_product_taxonomy() || is_product() ) )
				|| ( 'journal' === $slug && is_home() || is_singular( 'post' ) );
			printf(
				'<a class="kw-nav-link%1$s" href="%2$s">%3$s</a>',
				$active ? ' is-active' : '',
				esc_url( $url ),
				esc_html( $label )
			);
		}
		?>
	</nav>
	<?php
}

/**
 * Cart button with live count, plus mobile menu button.
 */
function kulier_header_actions() {
	$count = function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	?>
	<div class="kw-header-actions">
		<a class="kw-cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'Keranjang', 'kulier-wood' ); ?>">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="9" cy="20" r="1.4"/><circle cx="17" cy="20" r="1.4"/><path d="M3 4h2l2.4 11.2a1.6 1.6 0 0 0 1.6 1.3h7.9a1.6 1.6 0 0 0 1.6-1.2L20.6 8H6"/></svg>
			<span class="kw-cart-count<?php echo $count ? '' : ' is-empty'; ?>" data-count><?php echo esc_html( $count ); ?></span>
		</a>
		<button class="kw-menu-toggle" type="button" aria-expanded="false" aria-controls="kw-mobile-menu" aria-label="<?php esc_attr_e( 'Buka menu', 'kulier-wood' ); ?>">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
		</button>
	</div>
	<?php
}

/**
 * Mobile menu (mirrors "Mobile navigation · Open state" frame).
 */
function kulier_mobile_menu() {
	?>
	<div class="kw-mobile-menu" id="kw-mobile-menu" hidden>
		<div class="kw-mobile-menu__head">
			<a class="kw-wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>">KULIER WOOD</a>
			<button class="kw-menu-close" type="button" aria-label="<?php esc_attr_e( 'Tutup menu', 'kulier-wood' ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
			</button>
		</div>
		<nav class="kw-mobile-menu__links" aria-label="<?php esc_attr_e( 'Navigasi Utama', 'kulier-wood' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'kulier-wood' ); ?></a>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Collections', 'kulier-wood' ); ?></a>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Journal', 'kulier-wood' ); ?></a>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'Keranjang', 'kulier-wood' ); ?></a>
			<a href="#contact"><?php esc_html_e( 'Contact', 'kulier-wood' ); ?></a>
		</nav>
	</div>
	<?php
}

/**
 * Primary CTA button (ink block) from the design.
 */
function kulier_button( $label, $url, $class = '' ) {
	printf(
		'<a class="kw-btn%1$s" href="%2$s">%3$s</a>',
		$class ? ' ' . esc_attr( $class ) : '',
		esc_url( $url ),
		esc_html( $label )
	);
}
