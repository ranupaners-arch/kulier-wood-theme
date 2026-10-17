<?php
/**
 * Order confirmation — native WooCommerce order-received, design shell.
 * Status wording stays WooCommerce-accurate (e.g. "Menunggu Pembayaran").
 *
 * @package kulier-wood
 */

get_header();

?>

<section class="kw-page-head">
	<h1><?php esc_html_e( 'Pesanan diterima', 'kulier-wood' ); ?></h1>
</section>

<div class="kw-thankyou kw-panel">
	<?php echo do_shortcode( '[woocommerce_checkout]' ); ?>
</div>

<?php get_footer(); ?>
