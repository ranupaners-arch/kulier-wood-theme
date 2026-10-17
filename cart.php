<?php
/**
 * Cart page wrapper — native WooCommerce cart engine, design-language shell.
 *
 * @package kulier-wood
 */

get_header();

woocommerce_breadcrumb();
?>

<section class="kw-page-head">
	<h1><?php esc_html_e( 'Keranjang', 'kulier-wood' ); ?></h1>
	<p><?php esc_html_e( 'Tinjau pilihan Anda sebelum melanjutkan ke pembayaran.', 'kulier-wood' ); ?></p>
</section>

<div class="kw-cart kw-panel">
	<?php echo do_shortcode( '[woocommerce_cart]' ); ?>
</div>

<?php get_footer(); ?>
