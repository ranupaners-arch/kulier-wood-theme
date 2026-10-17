<?php
/**
 * Single product — mirrors the "Product detail · Overlay presentation" frame.
 *
 * @package kulier-wood
 */

get_header();

while ( have_posts() ) :
	the_post();
	global $product;
	?>

	<div class="kw-detail">
		<div class="kw-detail__nav">
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php esc_html_e( 'Back to Collections', 'kulier-wood' ); ?></a>
		</div>

		<div class="kw-detail__row">
			<div class="kw-detail__media kw-reveal">
				<?php woocommerce_show_product_images(); ?>
			</div>

			<div class="kw-detail__info">
				<p class="kw-detail__collection">
					<?php
					$terms = get_the_terms( get_the_ID(), 'product_cat' );
					if ( $terms && ! is_wp_error( $terms ) ) {
						$cat = array_shift( $terms );
						printf( '%s · %s', esc_html( $cat->name ), esc_html__( 'Produk demonstrasi', 'kulier-wood' ) );
					}
					?>
				</p>
				<h1 class="kw-detail__name"><?php the_title(); ?></h1>
				<div class="kw-detail__desc"><?php the_excerpt(); ?></div>

				<div class="kw-detail__specs">
					<?php if ( $product->get_sku() ) : ?>
						<div class="kw-spec"><p class="kw-spec__label">SKU</p><p class="kw-spec__value"><?php echo esc_html( $product->get_sku() ); ?></p></div>
					<?php endif; ?>
					<div class="kw-spec">
						<p class="kw-spec__label"><?php esc_html_e( 'Ketersediaan', 'kulier-wood' ); ?></p>
						<p class="kw-spec__value"><?php echo wp_kses_post( wc_get_stock_html( $product ) ); ?></p>
					</div>
					<div class="kw-spec">
						<p class="kw-spec__label"><?php esc_html_e( 'Harga', 'kulier-wood' ); ?></p>
						<p class="kw-spec__value kw-detail__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
					</div>
					<?php
					$attributes = $product->get_attributes();
					foreach ( $attributes as $attribute ) :
						if ( $attribute->get_visible() ) :
							?>
							<div class="kw-spec">
								<p class="kw-spec__label"><?php echo esc_html( wc_attribute_label( $attribute->get_name() ) ); ?></p>
								<p class="kw-spec__value">
									<?php
									$values = $attribute->is_taxonomy() ? wc_get_product_terms( get_the_ID(), $attribute->get_name(), array( 'fields' => 'names' ) ) : $attribute->get_options();
									echo esc_html( implode( ', ', $values ) );
									?>
								</p>
							</div>
							<?php
						endif;
					endforeach;
					?>
				</div>

				<div class="kw-detail__cart">
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>

				<p class="kw-detail__note"><?php esc_html_e( 'Gambar ilustratif dan produk fiktif. Spesifikasi dikonfirmasi per inquiry.', 'kulier-wood' ); ?></p>
			</div>
		</div>

		<div class="kw-detail__content">
			<?php woocommerce_output_product_data_tabs(); ?>
		</div>
	</div>

	<?php
	woocommerce_upsell_display();
	woocommerce_output_related_products();
endwhile;

get_footer();
