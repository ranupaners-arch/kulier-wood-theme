<?php
/**
 * Order confirmation — native WooCommerce order-received, design shell.
 * Status wording stays WooCommerce-accurate (e.g. "Menunggu Pembayaran").
 *
 * @package kulier-wood
 */

get_header();

$order = wc_get_order( $wp->query_vars['order-received'] ?? 0 );
?>

<section class="kw-page-head">
	<h1><?php esc_html_e( 'Pesanan diterima', 'kulier-wood' ); ?></h1>
	<?php if ( $order ) : ?>
		<p><?php esc_html_e( 'Terima kasih. Detail pesanan Anda ada di bawah.', 'kulier-wood' ); ?></p>
	<?php endif; ?>
</section>

<div class="kw-thankyou kw-panel">
	<?php
	if ( $order ) :
		?>
		<div class="kw-order-summary-head">
			<div class="kw-spec"><p class="kw-spec__label"><?php esc_html_e( 'Nomor pesanan', 'kulier-wood' ); ?></p><p class="kw-spec__value">#<?php echo esc_html( $order->get_order_number() ); ?></p></div>
			<div class="kw-spec"><p class="kw-spec__label"><?php esc_html_e( 'Tanggal', 'kulier-wood' ); ?></p><p class="kw-spec__value"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></p></div>
			<div class="kw-spec"><p class="kw-spec__label"><?php esc_html_e( 'Status', 'kulier-wood' ); ?></p><p class="kw-spec__value"><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></p></div>
			<div class="kw-spec"><p class="kw-spec__label"><?php esc_html_e( 'Metode pembayaran', 'kulier-wood' ); ?></p><p class="kw-spec__value"><?php echo esc_html( $order->get_payment_method_title() ); ?></p></div>
		</div>
		<?php
	endif;
	do_action( 'woocommerce_thankyou', $order ? $order->get_id() : '' );
	?>
</div>

<?php get_footer(); ?>
