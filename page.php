<?php
/** Standard WordPress pages, including native WooCommerce account content. */
get_header();
while ( have_posts() ) : the_post(); ?>
	<article <?php post_class( 'kw-standard-page' ); ?>>
		<h1><?php the_title(); ?></h1>
		<div><?php the_content(); wp_link_pages(); ?></div>
	</article>
<?php endwhile;
get_footer();
