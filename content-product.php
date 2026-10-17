<?php
/**
 * Product card for the shop loop, matching the approved Collections design.
 *
 * @package kulier-wood
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'kw-card', $product ); ?>>
	<a class="kw-card__link" href="<?php the_permalink(); ?>">
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
	</a>
</li>
