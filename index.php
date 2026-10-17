<?php
/**
 * Fallback template: blog listing styled as the Journal design.
 *
 * @package kulier-wood
 */

get_header();
$has_stories = have_posts();
?>

<section class="kw-journal-intro">
	<h1><?php if ( is_category() || is_tag() ) { single_term_title(); } elseif ( is_search() ) { echo esc_html( sprintf( __( 'Search: %s', 'kulier-wood' ), get_search_query() ) ); } else { echo 'Stories of material,<br>space, and design.'; } ?></h1>
	<p>Perspectives on furniture, contemporary interiors and thoughtful living.</p>
</section>

<?php if ( $has_stories && is_home() && ! is_paged() ) : the_post(); get_template_part( 'template-parts/journal-featured' ); endif; ?>

<section class="kw-journal-listing" aria-label="<?php esc_attr_e( 'Journal stories', 'kulier-wood' ); ?>">
<nav class="kw-journal-categories" aria-label="<?php esc_attr_e( 'Story categories', 'kulier-wood' ); ?>">
	<a href="<?php echo esc_url( kulier_journal_url() ); ?>"<?php if ( is_home() ) echo ' aria-current="page"'; ?>>All Stories</a>
	<?php foreach ( get_categories( array( 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_category' ) ) ) ) as $category ) : ?>
		<a href="<?php echo esc_url( get_category_link( $category ) ); ?>"<?php if ( is_category( $category->term_id ) ) echo ' aria-current="page"'; ?>><?php echo esc_html( $category->name ); ?></a>
	<?php endforeach; ?>
</nav>
<div class="kw-article-grid">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<?php get_template_part( 'template-parts/journal-card' ); ?>
		<?php
	endwhile;
	?>
</div>

<?php if ( ! $has_stories ) : ?>
	<div class="kw-empty"><h2>A new story is taking shape.</h2><p>No articles in this category yet. Return to All Stories.</p><?php kulier_button( __( 'All Stories', 'kulier-wood' ), kulier_journal_url() ); ?></div>
<?php endif; ?>

<?php
the_posts_pagination(
	array(
		'mid_size'  => 1,
		'class'     => 'kw-pagination',
		'prev_text' => __( '← Sebelumnya', 'kulier-wood' ),
		'next_text' => __( 'Selanjutnya →', 'kulier-wood' ),
	)
);
if ( $has_stories ) : ?>
	<div class="kw-journal-count"><p><?php global $wp_query; echo esc_html( sprintf( _n( '%s story', '%s stories', $wp_query->found_posts, 'kulier-wood' ), number_format_i18n( $wp_query->found_posts ) ) ); ?></p><?php if ( $wp_query->max_num_pages <= 1 ) : ?><p>End of Journal</p><?php endif; ?></div>
<?php endif; ?>
</section>
<?php
get_footer();
