<?php
/**
 * Single product — mirrors the "Product detail · Overlay presentation" frame.
 *
 * @package kulier-wood
 */

get_header();
woocommerce_output_all_notices();

while ( have_posts() ) :
	the_post();
	global $product;
	?>

	<div <?php wc_product_class( 'kw-detail', $product ); ?>>
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
						printf( '%s Collection · %s', esc_html( $cat->name ), esc_html__( 'Demonstration product', 'kulier-wood' ) );
					}
					?>
				</p>
				<h1 class="kw-detail__name"><?php the_title(); ?></h1>
				<div class="kw-detail__desc"><?php the_excerpt(); ?></div>

				<div class="kw-detail__specs">
					<?php
					$attributes = $product->get_attributes();
					if ( ! $attributes ) :
						$specs = array( 'Product type' => $product->get_slug() === 'sora-lounge-chair' ? 'Lounge chair' : '[To be confirmed]', 'Material & finish' => '[To be confirmed]', 'Dimensions' => '[To be confirmed]' );
						foreach ( $specs as $label => $value ) : ?>
							<div class="kw-spec"><p class="kw-spec__label"><?php echo esc_html( $label ); ?></p><p class="kw-spec__value"><?php echo esc_html( $value ); ?></p></div>
						<?php endforeach;
					endif;
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

				<?php kulier_button( __( 'Inquire About This Piece', 'kulier-wood' ), kulier_contact_url() ?: home_url( '/#contact' ) ); ?>

				<div class="kw-detail__commerce">
					<p class="kw-detail__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
					<?php echo wp_kses_post( wc_get_stock_html( $product ) ); ?>
					<div class="kw-detail__cart">
					<?php woocommerce_template_single_add_to_cart(); ?>
					</div>
				</div>
			</div>
		</div>
		<p class="kw-detail__note">Illustrative image and fictional product. Materials, finishes and specifications are confirmed per inquiry.</p>

		<div class="kw-detail__content">
			<?php woocommerce_output_product_data_tabs(); ?>
		</div>
	</div>

	<?php
	woocommerce_upsell_display();
	woocommerce_output_related_products();
endwhile;

get_footer();
