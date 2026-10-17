<?php
/**
 * Checkout page wrapper — native WooCommerce checkout engine.
 *
 * @package kulier-wood
 */

get_header();

woocommerce_breadcrumb();
?>

<section class="kw-page-head">
	<h1><?php esc_html_e( 'Pembayaran', 'kulier-wood' ); ?></h1>
	<p><?php esc_html_e( 'Lengkapi detail pengiriman dan pilih metode pembayaran.', 'kulier-wood' ); ?></p>
</section>

<div class="kw-checkout kw-panel">
	<?php echo do_shortcode( '[woocommerce_checkout]' ); ?>
</div>

<?php get_footer(); ?>
