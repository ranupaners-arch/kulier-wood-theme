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
	<?php
	if ( WC()->cart->is_empty() ) :
		?>
		<div class="kw-empty">
			<h2><?php esc_html_e( 'Keranjang masih kosong.', 'kulier-wood' ); ?></h2>
			<p><?php esc_html_e( 'Jelajahi koleksi untuk menemukan perabot yang tepat.', 'kulier-wood' ); ?></p>
			<?php kulier_button( __( 'Lanjut Belanja', 'kulier-wood' ), get_permalink( wc_get_page_id( 'shop' ) ) ); ?>
		</div>
		<?php
	else :
		wc_get_template( 'cart/cart.php' );
	endif;
	?>
</div>

<?php get_footer(); ?>
