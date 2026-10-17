<?php
/** First story on the Journal landing page; sticky posts retain WordPress priority. */
defined( 'ABSPATH' ) || exit;
$image = kulier_journal_image( get_the_ID(), 'full' );
?>
<article class="kw-journal-featured">
	<a class="kw-journal-featured__media" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
		<?php if ( $image ) : ?><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ?: get_the_title() ); ?>" width="1200" height="896" loading="eager" fetchpriority="high"><?php else : ?><span class="kw-image-error">Image pending</span><?php endif; ?>
	</a>
	<div class="kw-journal-featured__copy">
		<p class="kw-article-meta"><?php kulier_journal_meta(); ?></p>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p class="kw-journal-featured__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 30 ) ); ?></p>
		<a class="kw-read-article" href="<?php the_permalink(); ?>">Read Article<span class="screen-reader-text">: <?php the_title(); ?></span></a>
	</div>
</article>
