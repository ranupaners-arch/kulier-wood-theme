<?php
/** Journal card shared by the landing page and category archives. */
defined( 'ABSPATH' ) || exit;
$image = kulier_journal_image( get_the_ID() );
?>
<article <?php post_class( 'kw-article-card' ); ?>>
	<a href="<?php the_permalink(); ?>">
		<div class="kw-article-card__media"><?php if ( $image ) : ?><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ?: get_the_title() ); ?>" width="1200" height="896" loading="lazy" decoding="async"><?php else : ?><span class="kw-image-error">Image pending</span><?php endif; ?></div>
		<p class="kw-article-meta"><?php $categories = get_the_category(); echo $categories ? esc_html( $categories[0]->name ) : ''; ?></p>
		<h2><?php the_title(); ?></h2>
		<p class="kw-article-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
		<p class="kw-article-date"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
		<span class="kw-read-article">Read Article<span class="screen-reader-text">: <?php the_title(); ?></span></span>
	</a>
</article>
