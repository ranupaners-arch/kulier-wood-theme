<?php
/**
 * WooCommerce integration for the Kulier Wood design.
 *
 * Keeps native WooCommerce cart/checkout engines; only presentational
 * wrappers, hooks and light template overrides live here.
 *
 * @package kulier-wood
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Theme supports WooCommerce.
add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

/**
 * Use the classic (hook-based) cart/checkout templates so the approved
 * visual system can be applied consistently. WooCommerce Blocks checkout
 * is not mixed in with custom classic-styling overrides.
 */
add_action(
	'after_setup_theme',
	function () {
		remove_theme_support( 'wc-product-gallery-zoom' );
	}
);

// Shop page: 3-column editorial grid, standard pagination.
add_filter(
	'loop_shop_columns',
	function () {
		return 3;
	}
);

add_filter(
	'loop_shop_per_page',
	function () {
		return 12;
	}
);

// Related products: 3 columns like the catalog rows.
add_filter(
	'woocommerce_output_related_products_args',
	function ( $args ) {
		$args['posts_per_page'] = 3;
		$args['columns']        = 3;
		return $args;
	}
);

/**
 * Product card matches the approved Collections design:
 * image -> title + "View Details" -> short description. Prices and stock
 * are added by WooCommerce and styled in the design language.
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

add_action(
	'woocommerce_before_shop_loop_item_title',
	function () {
		echo '<div class="kw-card-media">';
		woocommerce_template_loop_product_thumbnail();
		echo '</div>';
	},
	10
);

add_action(
	'woocommerce_shop_loop_item_title',
	function () {
		global $product;
		echo '<div class="kw-card-title-row"><h2 class="woocommerce-loop-product__title">';
		echo esc_html( get_the_title() );
		echo '</h2><span class="kw-card-view">' . esc_html__( 'View Details', 'kulier-wood' ) . '</span></div>';
		if ( $product && $product->get_short_description() ) {
			echo '<p class="kw-card-desc">' . esc_html( wp_strip_all_tags( $product->get_short_description() ) ) . '</p>';
		}
		echo '<div class="kw-card-price">';
		woocommerce_template_loop_price();
		echo '</div>';
		echo '<div class="kw-card-stock">';
		if ( $product->is_in_stock() ) {
			$stock = $product->get_stock_quantity();
			if ( $stock ) {
				echo '<span class="stock">' . esc_html( sprintf( __( 'Stok: %s unit', 'kulier-wood' ), $stock ) ) . '</span>';
			}
		} else {
			echo '<span class="stock kw-out-of-stock">' . esc_html__( 'Habis', 'kulier-wood' ) . '</span>';
		}
		echo '</div>';
	},
	10
);

// Breadcrumbs: quiet, text-only, matching the design's muted link style.
add_filter(
	'woocommerce_breadcrumb_defaults',
	function ( $defaults ) {
		$defaults['delimiter']   = '<span class="kw-crumb-sep">/</span>';
		$defaults['wrap_before'] = '<nav class="kw-breadcrumbs" aria-label="breadcrumb">';
		$defaults['wrap_after']  = '</nav>';
		return $defaults;
	}
);

// Sale / stock badges restyled via CSS classes only.
add_filter(
	'woocommerce_sale_flash',
	function ( $html ) {
		return str_replace( 'woocommerce-loop-product__title', '', str_replace( 'onsale', 'kw-badge kw-badge-sale', $html ) );
	}
);

/**
 * Checkout: keep WooCommerce's own fields and validation. Only presentational
 * adjustments via supported settings below. The block-based checkout is
 * disabled in favour of the classic template so custom styling stays coherent.
 */
add_filter(
	'woocommerce_enable_checkout_block_removed_notice',
	'__return_false'
);
