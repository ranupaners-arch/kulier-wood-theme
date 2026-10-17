<?php
/**
 * Homepage — reproduces the approved "Home · Desktop" frame section by section.
 *
 * @package kulier-wood
 */

get_header();

$collection_images = array( 'living' => 'generated.jpg', 'dining' => 'generated-9.jpg', 'bedroom' => 'generated-3.jpg', 'custom' => 'generated-7.jpg' );
$collection_copy   = array( 'living' => 'Objects for relaxed, considered living.', 'dining' => 'Natural character. Shared moments.', 'bedroom' => 'A quiet place to begin and end the day.', 'custom' => 'Furniture shaped around your space.' );
?>

<!-- Hero showroom -->
<section class="kw-hero">
	<div class="kw-hero__row">
		<div class="kw-hero__intro">
			<h1 class="kw-hero__title">Shaped by craft.<br>Designed for living.</h1>
			<div class="kw-hero__intro-col">
				<p class="kw-hero__desc"><?php echo esc_html( get_theme_mod( 'kulier_hero_copy', 'Thoughtfully designed wooden furniture for spaces that value material, form, and lasting character.' ) ); ?></p>
				<?php kulier_button( __( 'Explore Our Collections', 'kulier-wood' ), get_permalink( wc_get_page_id( 'shop' ) ) ); ?>
			</div>
		</div>
		<div class="kw-hero__media kw-reveal">
			<?php
			$hero = kulier_design_image( get_theme_mod( 'kulier_hero_image' ), 'generated.jpg' );
			if ( $hero ) {
				printf( '<img src="%s" alt="%s" width="1376" height="768" loading="eager" fetchpriority="high">', esc_url( $hero ), esc_attr__( 'Editorial wooden furniture interior', 'kulier-wood' ) );
			}
			?>
		</div>
	</div>
	<div class="kw-hero__caption">
		<p>For homes, hospitality &amp; considered spaces</p>
		<a class="kw-hero__link" href="<?php echo esc_url( home_url( '/#philosophy' ) ); ?>"><?php esc_html_e( 'Discover Our Approach', 'kulier-wood' ); ?></a>
	</div>
</section>

<!-- Our studio -->
<section class="kw-studio" id="studio">
	<div class="kw-studio__copy">
		<h2>A considered approach<br>to furniture.</h2>
		<p class="kw-studio__body"><?php echo esc_html( get_theme_mod( 'kulier_studio_copy', 'KULIER WOOD explores the relationship between natural materials, contemporary forms, and the spaces we inhabit. Our collections bring warmth, clarity, and character to residential and commercial interiors.' ) ); ?></p>
		<p class="kw-studio__focus">For homeowners, architects and interior professionals.</p>
	</div>
	<div class="kw-studio__media kw-reveal">
		<?php
		$studio = kulier_design_image( get_theme_mod( 'kulier_studio_image' ), 'generated-5.jpg' );
		if ( $studio ) {
			printf( '<img src="%s" alt="%s" width="1200" height="896" loading="lazy" decoding="async">', esc_url( $studio ), esc_attr__( 'Wooden chair in an architectural setting', 'kulier-wood' ) );
		}
		?>
	</div>
</section>

<!-- Featured collections: pulls live WooCommerce product categories -->
<section class="kw-collections">
	<div class="kw-collections__heading">
		<h2><?php esc_html_e( 'Pieces for spaces that matter.', 'kulier-wood' ); ?></h2>
		<p>Furniture for the way we live, gather and retreat.</p>
	</div>
	<?php
	$terms = array_slice( kulier_collection_terms(), 0, 4 );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
		?>
		<div class="kw-collections__bento">
			<?php
			$idx = 0;
			foreach ( $terms as $term ) :
				$idx++;
				$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
				$img      = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'kulier-card' ) : '';
				if ( isset( $collection_images[ $term->slug ] ) ) {
					$img = kulier_design_image( $img, $collection_images[ $term->slug ] );
				}
				$wide     = ( $idx <= 2 );
				?>
				<a class="kw-collection-card<?php echo $wide ? ' is-wide' : ''; ?>" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
					<div class="kw-collection-card__media kw-reveal">
						<?php
						if ( $img ) {
							printf( '<img src="%s" alt="%s" loading="lazy">', esc_url( $img ), esc_attr( $term->name ) );
						}
						?>
					</div>
					<div class="kw-collection-card__copy">
						<h3><?php echo esc_html( $term->name ); ?></h3>
					<p class="kw-collection-card__desc">
						<?php
						$desc = get_theme_mod( 'kulier_cat_desc_' . $term->slug, '' );
						echo esc_html( $desc ?: ( $collection_copy[ $term->slug ] ?? wp_strip_all_tags( $term->description ) ) );
						?>
					</p>
					<span class="kw-collection-card__link">Explore Collection</span>
					</div>
				</a>
				<?php
			endforeach;
			?>
		</div>
	<?php endif; ?>
</section>

<!-- Design philosophy -->
<section class="kw-philosophy" id="philosophy">
	<div class="kw-philosophy__heading">
		<h2>Where material<br>meets meaning.</h2>
		<p>Purposeful forms. Natural textures. Spaces that feel welcoming and enduring.</p>
	</div>
	<div class="kw-philosophy__cols">
		<div class="kw-philosophy__col">
			<h3>Material</h3>
			<p>The texture and visual character of wood, allowed to speak.</p>
		</div>
		<div class="kw-philosophy__col">
			<h3>Form</h3>
			<p>Balanced proportions and contemporary silhouettes.</p>
		</div>
		<div class="kw-philosophy__col">
			<h3>Function</h3>
			<p>Considered around the practical needs of everyday spaces.</p>
		</div>
	</div>
</section>

<!-- Craftsmanship -->
<section class="kw-craft">
	<div class="kw-craft__media kw-reveal">
		<?php
		$craft = kulier_design_image( get_theme_mod( 'kulier_craft_image' ), 'https://images.unsplash.com/photo-1720391793902-06a80038b1ed?auto=format&fit=crop&q=80&w=1080' );
		if ( $craft ) {
			printf( '<img src="%s" alt="%s" loading="lazy">', esc_url( $craft ), esc_attr__( 'Detail joinery dan kayu', 'kulier-wood' ) );
		}
		?>
	</div>
	<div class="kw-craft__copy">
		<h2>The beauty is<br>in the details.</h2>
		<p class="kw-craft__body"><?php echo esc_html( get_theme_mod( 'kulier_craft_copy', 'From the character of the wood to the proportions of each piece, small details shape the way furniture is experienced.' ) ); ?></p>
		<p class="kw-craft__note">Materials, finishes and specifications are confirmed per inquiry.</p>
	</div>
</section>

<!-- Applications -->
<section class="kw-applications">
	<div class="kw-applications__heading">
		<h2>Different spaces.<br>The same considered eye.</h2>
		<p>Illustrative applications. Service availability to be confirmed.</p>
	</div>
	<div class="kw-applications__grid">
		<?php
		$apps = array(
			array( 'Residential', 'Homes & personal spaces' ),
			array( 'Hospitality', 'Hotels & retreats' ),
			array( 'Food & Beverage', 'Restaurants & cafés' ),
			array( 'Commercial', 'Offices & studios' ),
		);
		foreach ( $apps as $app ) :
			?>
			<div class="kw-app-card">
				<h3><?php echo esc_html( $app[0] ); ?></h3>
				<p><?php echo esc_html( $app[1] ); ?></p>
			</div>
			<?php
		endforeach;
		?>
	</div>
</section>

<!-- Contact / project inquiry -->
<?php get_template_part( 'template-parts/contact' ); ?>

<?php get_footer(); ?>
