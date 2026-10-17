<?php
/**
 * WooCommerce archive wrapper — Collections page matching the design.
 *
 * @package kulier-wood
 */

if ( is_product() ) {
	require KULIER_DIR . '/single-product.php';
	return;
}

get_header();

global $wp_query, $post;
$catalog_terms = kulier_collection_terms();
$groups        = array();
foreach ( $catalog_terms as $term ) {
	$groups[ $term->term_id ] = array( 'name' => $term->name, 'slug' => $term->slug, 'posts' => array() );
}
foreach ( $wp_query->posts as $catalog_post ) {
	$catalog_product = wc_get_product( $catalog_post->ID );
	if ( ! $catalog_product || ! $catalog_product->is_visible() ) {
		continue;
	}
	$term_ids = wp_get_post_terms( $catalog_post->ID, 'product_cat', array( 'fields' => 'ids' ) );
	$group_id = 0;
	foreach ( $catalog_terms as $term ) {
		if ( ! is_wp_error( $term_ids ) && in_array( $term->term_id, $term_ids, true ) ) {
			$group_id = $term->term_id;
			break;
		}
	}
	if ( ! isset( $groups[ $group_id ] ) ) {
		$groups[ $group_id ] = array( 'name' => __( 'Other pieces', 'kulier-wood' ), 'slug' => 'other', 'posts' => array() );
	}
	$groups[ $group_id ]['posts'][] = $catalog_post;
}
if ( ! isset( $_GET['orderby'] ) && get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) === 'menu_order' ) {
	$demo_order = array_flip( array( 'sora-lounge-chair', 'nara-coffee-table', 'forma-dining-table', 'vale-dining-chair', 'luma-bed-frame', 'aira-bedside-table', 'bespoke-cabinetry', 'hospitality-furniture' ) );
	foreach ( $groups as &$group ) {
		usort( $group['posts'], function ( $a, $b ) use ( $demo_order ) {
			return ( $demo_order[ $a->post_name ] ?? 100 ) <=> ( $demo_order[ $b->post_name ] ?? 100 ) ?: $a->menu_order <=> $b->menu_order;
		} );
	}
	unset( $group );
}
$groups = array_filter( $groups, function ( $group ) { return ! empty( $group['posts'] ); } );

$intro_title    = is_shop() ? 'Objects of purpose.<br>Pieces of character.' : single_term_title( '', false );
$intro_copy     = is_shop() ? __( 'Furniture for contemporary living, shaped by natural materials and thoughtful design.', 'kulier-wood' ) : wp_strip_all_tags( term_description() );
?>

<section class="kw-collections-intro">
	<h1><?php echo wp_kses_post( $intro_title ); ?></h1>
	<?php if ( $intro_copy ) : ?>
		<p><?php echo esc_html( $intro_copy ); ?></p>
	<?php endif; ?>
	<nav class="kw-cat-nav" aria-label="<?php esc_attr_e( 'Navigasi kategori', 'kulier-wood' ); ?>">
		<?php
		printf( '<a class="%s" href="%s">%s</a>', ! is_product_taxonomy() ? 'is-active' : '', esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ), esc_html__( 'All Collections', 'kulier-wood' ) );
		if ( $catalog_terms ) {
			$current = is_product_taxonomy() ? get_queried_object()->term_id : 0;
			foreach ( $catalog_terms as $cat ) {
				if ( is_shop() && ! isset( $groups[ $cat->term_id ] ) ) {
					continue;
				}
				printf(
					'<a class="%s" href="%s">%s</a>',
					$current === $cat->term_id ? 'is-active' : '',
					esc_url( is_shop() ? '#collection-' . $cat->slug : get_term_link( $cat ) ),
					esc_html( $cat->name )
				);
			}
		}
		?>
	</nav>
	<p class="kw-catalog-note"><?php esc_html_e( 'Illustrative catalog · Fictional product names · Specifications available upon confirmation', 'kulier-wood' ); ?></p>
</section>

<div class="kw-catalog">
	<?php woocommerce_output_all_notices(); ?>
	<details class="kw-catalog__options">
		<summary><?php esc_html_e( 'Sort & results', 'kulier-wood' ); ?></summary>
		<div class="kw-catalog__tools"><?php woocommerce_result_count(); woocommerce_catalog_ordering(); ?></div>
	</details>

	<?php if ( $groups ) : ?>
		<?php foreach ( $groups as $group ) : ?>
		<section class="kw-catalog-group" id="collection-<?php echo esc_attr( $group['slug'] ); ?>">
			<h2><?php echo esc_html( $group['name'] ); ?></h2>
			<?php
			woocommerce_product_loop_start();
			foreach ( $group['posts'] as $post ) :
				setup_postdata( $post );
				wc_get_template_part( 'content', 'product' );
			endforeach;
			woocommerce_product_loop_end();
			?>
		</section>
		<?php endforeach; wp_reset_postdata(); ?>
	<?php else : ?>
		<div class="kw-empty">
			<h2><?php esc_html_e( 'Koleksi baru sedang disiapkan.', 'kulier-wood' ); ?></h2>
			<p><?php esc_html_e( 'Belum ada produk dalam kategori ini. Kembali ke All Collections untuk melihat seluruh koleksi.', 'kulier-wood' ); ?></p>
			<?php kulier_button( __( 'All Collections', 'kulier-wood' ), get_permalink( wc_get_page_id( 'shop' ) ) ); ?>
		</div>
	<?php endif; ?>

	<?php woocommerce_pagination(); ?>
</div>

<?php get_template_part( 'template-parts/contact' ); get_footer(); ?>
