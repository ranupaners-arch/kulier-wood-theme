<?php
/** Reusable Journal article: opening, full image, reading column and related stories. */
get_header();
while ( have_posts() ) :
	the_post();
	$image = kulier_journal_image( get_the_ID(), 'full' );
	?>
	<article <?php post_class( 'kw-article' ); ?>>
		<header class="kw-article__opening">
			<a class="kw-read-article" href="<?php echo esc_url( kulier_journal_url() ); ?>">Back to Journal</a>
			<p class="kw-article-meta"><?php kulier_journal_meta(); ?></p>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?><p class="kw-article__standfirst"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
		</header>
		<?php if ( $image ) : ?><div class="kw-article__image"><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ?: get_the_title() ); ?>" width="1376" height="768" loading="eager" fetchpriority="high"></div><?php endif; ?>
		<div class="kw-article__body"><?php the_content(); wp_link_pages(); ?></div>
	</article>
	<?php
	$related = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 2, 'post__not_in' => array( get_the_ID() ), 'category__in' => wp_get_post_categories( get_the_ID() ), 'ignore_sticky_posts' => true, 'no_found_rows' => true ) );
	if ( $related->have_posts() ) : ?>
		<nav class="kw-article__related" aria-label="<?php esc_attr_e( 'Related stories', 'kulier-wood' ); ?>"><h2>Continue reading</h2>
			<?php while ( $related->have_posts() ) : $related->the_post(); ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php endwhile; ?>
		</nav>
	<?php endif; wp_reset_postdata();
endwhile;
get_footer();
