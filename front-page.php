<?php
/**
 * Homepage — reproduces the approved "Home · Desktop" frame section by section.
 *
 * @package kulier-wood
 */

get_header();

$assets = KULIER_URI . '/assets/images';
?>

<!-- Hero showroom -->
<section class="kw-hero">
	<div class="kw-hero__row">
		<div class="kw-hero__intro">
			<h1 class="kw-hero__title">Shaped by craft.<br>Designed for living.</h1>
			<div class="kw-hero__intro-col">
				<p class="kw-hero__desc"><?php esc_html_e( 'Perabot kayu yang dirancang dengan penuh pertimbangan untuk ruang yang menghargai material, bentuk, dan karakter yang bertahan lama.', 'kulier-wood' ); ?></p>
				<?php kulier_button( __( 'Explore Our Collections', 'kulier-wood' ), get_permalink( wc_get_page_id( 'shop' ) ) ); ?>
			</div>
		</div>
		<div class="kw-hero__media kw-reveal">
			<?php
			$hero = get_theme_mod( 'kulier_hero_image' );
			if ( $hero ) {
				printf( '<img src="%s" alt="%s" loading="eager">', esc_url( $hero ), esc_attr__( 'Interior perabot kayu', 'kulier-wood' ) );
			}
			?>
		</div>
	</div>
	<div class="kw-hero__caption">
		<p><?php esc_html_e( 'Untuk rumah, perhotelan & ruang yang penuh pertimbangan', 'kulier-wood' ); ?></p>
		<a class="kw-hero__link" href="<?php echo esc_url( home_url( '/#philosophy' ) ); ?>"><?php esc_html_e( 'Discover Our Approach', 'kulier-wood' ); ?></a>
	</div>
</section>

<!-- Our studio -->
<section class="kw-studio">
	<div class="kw-studio__copy">
		<h2>A considered approach<br>to furniture.</h2>
		<p class="kw-studio__body"><?php esc_html_e( 'KULIER WOOD mengeksplorasi hubungan antara material alami, bentuk kontemporer, dan ruang yang kita huni. Koleksi kami mengutamakan kejujuran material dan keterampilan tangan.', 'kulier-wood' ); ?></p>
		<p class="kw-studio__focus"><?php esc_html_e( 'Untuk pemilik rumah, arsitek, dan profesional interior.', 'kulier-wood' ); ?></p>
	</div>
	<div class="kw-studio__media kw-reveal">
		<?php
		$studio = get_theme_mod( 'kulier_studio_image' );
		if ( $studio ) {
			printf( '<img src="%s" alt="%s" loading="lazy">', esc_url( $studio ), esc_attr__( 'Kursi kayu dalam lanskap arsitektural', 'kulier-wood' ) );
		}
		?>
	</div>
</section>

<!-- Featured collections: pulls live WooCommerce product categories -->
<section class="kw-collections">
	<div class="kw-collections__heading">
		<h2><?php esc_html_e( 'Pieces for spaces that matter.', 'kulier-wood' ); ?></h2>
		<p><?php esc_html_e( 'Perabot untuk cara kita hidup, berkumpul, dan beristirahat.', 'kulier-wood' ); ?></p>
	</div>
	<?php
	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'exclude'    => array( get_term_by( 'slug', 'uncategorized', 'product_cat' ) ? get_term_by( 'slug', 'uncategorized', 'product_cat' )->term_id : 0 ),
			'number'     => 4,
		)
	);
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
		?>
		<div class="kw-collections__bento">
			<?php
			$idx = 0;
			foreach ( $terms as $term ) :
				$idx++;
				$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
				$img      = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'kulier-card' ) : '';
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
					<div class="kw-collection-card__heading">
						<h3><?php echo esc_html( $term->name ); ?></h3>
					</div>
					<p class="kw-collection-card__desc">
						<?php
						$desc = get_theme_mod( 'kulier_cat_desc_' . $term->slug, '' );
						echo esc_html( $desc ? $desc : wp_strip_all_tags( $term->description ) );
						?>
					</p>
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
		<p><?php esc_html_e( 'Bentuk yang bermakna. Tekstur alami. Ruang yang terasa hangat dan abadi.', 'kulier-wood' ); ?></p>
	</div>
	<div class="kw-philosophy__cols">
		<div class="kw-philosophy__col">
			<h3>Material</h3>
			<p><?php esc_html_e( 'Tekstur dan karakter visual kayu, dibiarkan berbicara.', 'kulier-wood' ); ?></p>
		</div>
		<div class="kw-philosophy__col">
			<h3>Form</h3>
			<p><?php esc_html_e( 'Proporsi seimbang dan siluet kontemporer.', 'kulier-wood' ); ?></p>
		</div>
		<div class="kw-philosophy__col">
			<h3>Function</h3>
			<p><?php esc_html_e( 'Dirancang sesuai kebutuhan praktis ruang sehari-hari.', 'kulier-wood' ); ?></p>
		</div>
	</div>
</section>

<!-- Craftsmanship -->
<section class="kw-craft">
	<div class="kw-craft__media kw-reveal">
		<?php
		$craft = get_theme_mod( 'kulier_craft_image' );
		if ( $craft ) {
			printf( '<img src="%s" alt="%s" loading="lazy">', esc_url( $craft ), esc_attr__( 'Detail joinery dan kayu', 'kulier-wood' ) );
		}
		?>
	</div>
	<div class="kw-craft__copy">
		<h2>The beauty is<br>in the details.</h2>
		<p class="kw-craft__body"><?php esc_html_e( 'Dari karakter kayu hingga proporsi setiap potongan, detail kecil membentuk cara perabot dirasakan.', 'kulier-wood' ); ?></p>
		<p class="kw-craft__note"><?php esc_html_e( 'Material, finishing, dan spesifikasi dikonfirmasi per inquiry.', 'kulier-wood' ); ?></p>
	</div>
</section>

<!-- Applications -->
<section class="kw-applications">
	<div class="kw-applications__heading">
		<h2>Different spaces.<br>The same considered eye.</h2>
		<p><?php esc_html_e( 'Aplikasi ilustratif. Ketersediaan layanan akan dikonfirmasi.', 'kulier-wood' ); ?></p>
	</div>
	<div class="kw-applications__grid">
		<?php
		$apps = array(
			array( 'Residential', __( 'Rumah & ruang personal', 'kulier-wood' ) ),
			array( 'Hospitality', __( 'Hotel & retreat', 'kulier-wood' ) ),
			array( 'Food & Beverage', __( 'Restoran & kafe', 'kulier-wood' ) ),
			array( 'Commercial', __( 'Kantor & studio', 'kulier-wood' ) ),
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
<section class="kw-contact">
	<div class="kw-contact__invite">
		<h2><?php esc_html_e( 'Let’s create something meaningful for your space.', 'kulier-wood' ); ?></h2>
		<p><?php esc_html_e( 'Untuk rumah, bisnis, atau proyek interior Anda berikutnya. Sampaikan rencana Anda.', 'kulier-wood' ); ?></p>
		<?php kulier_button( __( 'Discuss Your Project', 'kulier-wood' ), home_url( '/#contact' ), 'kw-btn--light' ); ?>
		<span class="kw-contact__alt"><?php esc_html_e( 'Contact Our Team', 'kulier-wood' ); ?></span>
	</div>
	<div class="kw-contact__details">
		<p>[NOMOR WHATSAPP]</p>
		<p>[BISNIS EMAIL]</p>
		<p>[ALAMAT PERUSAHAAN]</p>
		<p>[LOKASI PERUSAHAAN]</p>
		<p class="kw-contact__note"><?php esc_html_e( 'Demo: tindakan kontak memerlukan detail bisnis terverifikasi.', 'kulier-wood' ); ?></p>
	</div>
</section>

<?php get_footer(); ?>
