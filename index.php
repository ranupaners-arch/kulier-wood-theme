<?php
/**
 * Fallback template: blog listing styled as the Journal design.
 *
 * @package kulier-wood
 */

get_header();
?>

<section class="kw-journal-intro">
	<h1><?php esc_html_e( 'Cerita dari studio.', 'kulier-wood' ); ?></h1>
	<p><?php esc_html_e( 'Wawasan tentang material, bentuk, dan ruang yang kita huni.', 'kulier-wood' ); ?></p>
</section>

<div class="kw-article-grid">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'kw-article-card' ); ?>>
			<a href="<?php the_permalink(); ?>">
				<div class="kw-article-card__media"><?php the_post_thumbnail( 'kulier-card-wide' ); ?></div>
				<h2><?php the_title(); ?></h2>
				<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
			</a>
		</article>
		<?php
	endwhile;
	?>
</div>

<?php
the_posts_pagination(
	array(
		'mid_size'  => 1,
		'class'     => 'kw-pagination',
		'prev_text' => __( '← Sebelumnya', 'kulier-wood' ),
		'next_text' => __( 'Selanjutnya →', 'kulier-wood' ),
	)
);
get_footer();
