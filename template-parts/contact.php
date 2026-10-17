<?php
/** Shared project inquiry from the approved Home and Collections layouts. */
defined( 'ABSPATH' ) || exit;
$contact_url = kulier_contact_url();
?>
<section class="kw-contact" id="contact">
	<div class="kw-contact__invite">
		<h2><?php echo esc_html( get_theme_mod( 'kulier_contact_heading', 'Let’s create something meaningful for your space.' ) ); ?></h2>
		<p>For your home, business or next interior project. Tell us what you have in mind.</p>
		<?php if ( $contact_url ) : ?>
			<?php kulier_button( __( 'Discuss Your Project', 'kulier-wood' ), $contact_url, 'kw-btn--light' ); ?>
			<a class="kw-contact__alt" href="<?php echo esc_url( $contact_url ); ?>">Contact Our Team</a>
		<?php else : ?>
			<button class="kw-btn kw-btn--light" type="button" disabled>Contact details pending</button>
			<span class="kw-contact__alt" aria-disabled="true">Contact Our Team</span>
		<?php endif; ?>
	</div>
	<div class="kw-contact__details" id="contact-details">
		<?php foreach ( array( 'whatsapp' => '[WHATSAPP NUMBER]', 'email' => '[BUSINESS EMAIL]', 'address' => '[COMPANY ADDRESS]', 'location' => '[COMPANY LOCATION]' ) as $field => $placeholder ) : ?>
			<p><?php echo esc_html( get_theme_mod( 'kulier_contact_' . $field, $placeholder ) ?: $placeholder ); ?></p>
		<?php endforeach; ?>
		<?php if ( ! $contact_url ) : ?><p class="kw-contact__note">Demo: contact actions require verified business details.</p><?php endif; ?>
	</div>
</section>
