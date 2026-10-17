<?php
/**
 * Shared footer from the approved design.
 *
 * @package kulier-wood
 */
?>
</main>

<footer class="kw-footer" id="contact">
	<div class="kw-footer__identity">
		<a class="kw-footer__wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>">KULIER WOOD</a>
		<nav class="kw-footer__links" aria-label="<?php esc_attr_e( 'Tautan Footer', 'kulier-wood' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'fallback_cb'    => 'kulier_footer_fallback',
					'depth'          => 1,
				)
			);
			?>
		</nav>
	</div>
	<p class="kw-footer__contact">
		<?php
		$email    = get_theme_mod( 'kulier_contact_email', '[BISNIS EMAIL]' );
		$whatsapp = get_theme_mod( 'kulier_contact_whatsapp', '[NOMOR WHATSAPP]' );
		echo esc_html( $email ) . '  ·  ' . esc_html( $whatsapp );
		?>
	</p>
	<div class="kw-footer__demo">
		<p class="kw-footer__signature"><?php esc_html_e( 'Perabot penuh pertimbangan. Karakter yang bertahan lama.', 'kulier-wood' ); ?></p>
		<p class="kw-footer__notice"><?php esc_html_e( 'Merek demo fiktif · Gambar & konten contoh', 'kulier-wood' ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
