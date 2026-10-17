<?php
/**
 * Header matching the approved design: wordmark, nav, CTA.
 *
 * @package kulier-wood
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Lewati ke konten', 'kulier-wood' ); ?></a>

<header class="kw-header">
	<?php kulier_wordmark(); ?>
	<?php kulier_nav(); ?>
	<div class="kw-header-cta">
		<?php kulier_button( __( 'Discuss a Project', 'kulier-wood' ), home_url( '/#contact' ) ); ?>
	</div>
	<?php kulier_header_actions(); ?>
</header>

<?php kulier_mobile_menu(); ?>

<main id="content" class="kw-site-main">
