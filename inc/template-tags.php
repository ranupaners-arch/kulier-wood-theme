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

/** Collection order follows the showroom; additional categories remain available. */
function kulier_collection_terms() {
	$terms = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
	if ( is_wp_error( $terms ) ) {
		return array();
	}
	$order = array( 'living' => 0, 'dining' => 1, 'bedroom' => 2, 'custom' => 3 );
	usort( $terms, function ( $a, $b ) use ( $order ) {
		return ( $order[ $a->slug ] ?? 10 ) <=> ( $order[ $b->slug ] ?? 10 ) ?: strcasecmp( $a->name, $b->name );
	} );
	return $terms;
}

function kulier_shop_url() {
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/collections/' );
}

function kulier_journal_url() {
	$page_id = (int) get_option( 'page_for_posts' );
	$page    = $page_id ? get_post( $page_id ) : get_page_by_path( 'journal' );
	return $page ? get_permalink( $page ) : home_url( '/journal/' );
}

function kulier_journal_image( $post_id, $size = 'large' ) {
	$images = array(
		'The timeless appeal of natural wood in contemporary interiors' => 'generated-9.jpg',
		'Choosing the right dining table for your space' => 'generated-2.jpg',
		'Understanding wood finishes and furniture character' => 'https://images.unsplash.com/photo-1720391793902-06a80038b1ed?auto=format&fit=crop&q=80&w=1080',
		'Creating warm and minimal living spaces' => 'generated.jpg',
		'Furniture proportions and the art of interior balance' => 'generated-8.jpg',
		'Simple ways to care for wooden furniture' => 'generated-5.jpg',
	);
	$title  = get_the_title( $post_id );
	$source = get_the_post_thumbnail_url( $post_id, $size );
	return isset( $images[ $title ] ) ? kulier_design_image( $source, $images[ $title ] ) : $source;
}

function kulier_journal_meta() {
	$categories = get_the_category();
	if ( $categories ) {
		echo esc_html( $categories[0]->name ) . ' · ';
	}
	printf( '<time datetime="%s">%s</time>', esc_attr( get_the_date( DATE_W3C ) ), esc_html( get_the_date() ) );
}

/** Keep company uploads; replace the legacy demo placeholders with approved assets. */
function kulier_design_image( $source, $fallback ) {
	if ( ! $source || preg_match( '~/(?:generated(?:-\d+)?)(?:-\d+x\d+)?\.(?:png|jpe?g|webp)(?:\?.*)?$~i', $source ) ) {
		return str_starts_with( $fallback, 'https://' ) ? $fallback : KULIER_URI . '/assets/images/' . $fallback;
	}
	return $source;
}

function kulier_product_image( $product, $size = 'large' ) {
	$images = array( 'sora-lounge-chair' => 'generated-5.jpg', 'nara-coffee-table' => 'generated-8.jpg', 'forma-dining-table' => 'generated-2.jpg', 'vale-dining-chair' => 'generated-4.jpg', 'luma-bed-frame' => 'generated-3.jpg', 'aira-bedside-table' => 'generated-6.jpg', 'bespoke-cabinetry' => 'generated-7.jpg', 'hospitality-furniture' => 'generated-1.jpg', 'nara-coffee-table-studio-edition' => 'generated-8.jpg' );
	$source = wp_get_attachment_image_url( $product->get_image_id(), $size );
	return isset( $images[ $product->get_slug() ] ) ? kulier_design_image( $source, $images[ $product->get_slug() ] ) : ( $source ?: wc_placeholder_img_src( $size ) );
}

function kulier_contact_url() {
	$phone = preg_replace( '/\D/', '', get_theme_mod( 'kulier_contact_whatsapp', '' ) );
	if ( preg_match( '/^[1-9][0-9]{7,14}$/', $phone ) ) {
		return 'https://wa.me/' . $phone;
	}
	$email = sanitize_email( get_theme_mod( 'kulier_contact_email', '' ) );
	return is_email( $email ) ? 'mailto:' . $email : '';
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
			array( 'collections', __( 'Collections', 'kulier-wood' ), kulier_shop_url() ),
			array( 'journal', __( 'Journal', 'kulier-wood' ), kulier_journal_url() ),
		);
		foreach ( $items as $item ) {
			list( $slug, $label, $url ) = $item;
			$active                     = ( 'home' === $slug && is_front_page() )
				|| ( 'collections' === $slug && function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() || is_product() ) )
				|| ( 'journal' === $slug && ( is_home() || is_singular( 'post' ) || is_category() || is_tag() ) );
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
		<?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
		<a class="kw-cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'Keranjang', 'kulier-wood' ); ?>">
			<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="9" cy="20" r="1.4"/><circle cx="17" cy="20" r="1.4"/><path d="M3 4h2l2.4 11.2a1.6 1.6 0 0 0 1.6 1.3h7.9a1.6 1.6 0 0 0 1.6-1.2L20.6 8H6"/></svg>
			<span class="kw-cart-count<?php echo $count ? '' : ' is-empty'; ?>" data-count><?php echo esc_html( $count ); ?></span>
		</a>
		<?php endif; ?>
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
	<div class="kw-mobile-menu" id="kw-mobile-menu" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Navigasi utama', 'kulier-wood' ); ?>" hidden>
		<div class="kw-mobile-menu__head">
			<a class="kw-wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>">KULIER WOOD</a>
			<button class="kw-menu-close" type="button" aria-label="<?php esc_attr_e( 'Tutup menu', 'kulier-wood' ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
			</button>
		</div>
		<nav class="kw-mobile-menu__links" aria-label="<?php esc_attr_e( 'Navigasi Utama', 'kulier-wood' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'kulier-wood' ); ?></a>
			<a href="<?php echo esc_url( kulier_shop_url() ); ?>"><?php esc_html_e( 'Collections', 'kulier-wood' ); ?></a>
			<a href="<?php echo esc_url( kulier_journal_url() ); ?>"><?php esc_html_e( 'Journal', 'kulier-wood' ); ?></a>
		</nav>
		<nav class="kw-mobile-menu__anchors" aria-label="<?php esc_attr_e( 'Studio dan kontak', 'kulier-wood' ); ?>">
			<a href="<?php echo esc_url( home_url( '/#studio' ) ); ?>">About our studio</a>
			<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">Contact our team</a>
			<?php if ( function_exists( 'wc_get_cart_url' ) ) : ?><a href="<?php echo esc_url( wc_get_cart_url() ); ?>">Keranjang</a><?php endif; ?>
		</nav>
		<div class="kw-mobile-menu__inquiry"><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">Discuss a Project</a><p>Demo: verified contact details required.</p></div>
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
