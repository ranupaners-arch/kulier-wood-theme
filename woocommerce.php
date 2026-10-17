<?php
/**
 * WooCommerce archive wrapper — Collections page matching the design.
 *
 * @package kulier-wood
 */

get_header();

$intro_title    = is_shop() ? 'Objects of purpose.<br>Pieces of character.' : single_term_title( '', false );
$intro_copy     = is_shop() ? __( 'Perabot untuk kehidupan kontemporer, dibentuk oleh material alami dan desain yang penuh pertimbangan.', 'kulier-wood' ) : wp_strip_all_tags( term_description() );
?>

<section class="kw-collections-intro">
	<h1><?php echo wp_kses_post( $intro_title ); ?></h1>
	<?php if ( $intro_copy ) : ?>
		<p><?php echo esc_html( $intro_copy ); ?></p>
	<?php endif; ?>
	<nav class="kw-cat-nav" aria-label="<?php esc_attr_e( 'Navigasi kategori', 'kulier-wood' ); ?>">
		<?php
		$active_cats = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
				'exclude'    => array( get_term_by( 'slug', 'uncategorized', 'product_cat' ) ? get_term_by( 'slug', 'uncategorized', 'product_cat' )->term_id : 0 ),
			)
		);
		printf( '<a class="%s" href="%s">%s</a>', ! is_product_taxonomy() ? 'is-active' : '', esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ), esc_html__( 'All Collections', 'kulier-wood' ) );
		if ( ! empty( $active_cats ) && ! is_wp_error( $active_cats ) ) {
			$current = is_product_taxonomy() ? get_queried_object()->term_id : 0;
			foreach ( $active_cats as $cat ) {
				printf(
					'<a class="%s" href="%s">%s</a>',
					$current === $cat->term_id ? 'is-active' : '',
					esc_url( get_term_link( $cat ) ),
					esc_html( $cat->name )
				);
			}
		}
		?>
	</nav>
	<p class="kw-catalog-note"><?php esc_html_e( 'Katalog ilustratif · Nama produk fiktif · Spesifikasi tersedia setelah konfirmasi', 'kulier-wood' ); ?></p>
</section>

<div class="kw-catalog">
	<?php if ( woocommerce_product_archive_description() || true ) : ?>
		<div class="kw-catalog__tools">
			<?php woocommerce_result_count(); ?>
			<?php woocommerce_catalog_ordering(); ?>
		</div>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<ul class="kw-product-grid">
			<?php
			woocommerce_product_loop_start();
			while ( have_posts() ) :
				the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile;
			woocommerce_product_loop_end();
			?>
		</ul>
	<?php else : ?>
		<div class="kw-empty">
			<h2><?php esc_html_e( 'Koleksi baru sedang disiapkan.', 'kulier-wood' ); ?></h2>
			<p><?php esc_html_e( 'Belum ada produk dalam kategori ini. Kembali ke All Collections untuk melihat seluruh koleksi.', 'kulier-wood' ); ?></p>
			<?php kulier_button( __( 'All Collections', 'kulier-wood' ), get_permalink( wc_get_page_id( 'shop' ) ) ); ?>
		</div>
	<?php endif; ?>

	<?php woocommerce_pagination(); ?>
</div>

<?php get_footer(); ?>
