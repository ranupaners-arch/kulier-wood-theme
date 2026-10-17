<?php
/**
 * Shared footer from the approved design.
 *
 * @package kulier-wood
 */
?>
</main>

<footer class="kw-footer" id="site-footer">
	<div class="kw-footer__identity">
		<a class="kw-footer__wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>">KULIER WOOD</a>
		<nav class="kw-footer__links" aria-label="<?php esc_attr_e( 'Tautan Footer', 'kulier-wood' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'items_wrap'     => '<ul>%3$s</ul>',
					'fallback_cb'    => 'kulier_footer_fallback',
					'depth'          => 1,
				)
			);
			?>
		</nav>
	</div>
	<p class="kw-footer__contact">
		<?php
		$email    = get_theme_mod( 'kulier_contact_email', '[BUSINESS EMAIL]' ) ?: '[BUSINESS EMAIL]';
		$whatsapp = get_theme_mod( 'kulier_contact_whatsapp', '[WHATSAPP NUMBER]' ) ?: '[WHATSAPP NUMBER]';
		echo esc_html( $email ) . '  ·  ' . esc_html( $whatsapp );
		?>
	</p>
	<div class="kw-footer__demo">
		<p class="kw-footer__signature">Considered furniture. Lasting character.</p>
		<p class="kw-footer__notice">Fictional demo brand · Sample imagery &amp; content</p>
	</div>
</footer>

<?php if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() ) ) : ?>
<dialog class="kw-product-dialog" aria-label="<?php esc_attr_e( 'Product details', 'kulier-wood' ); ?>">
	<button class="kw-detail-close" type="button" aria-label="<?php esc_attr_e( 'Close product details', 'kulier-wood' ); ?>">
		<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
	</button>
	<div class="kw-product-dialog__body" aria-live="polite"></div>
</dialog>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
