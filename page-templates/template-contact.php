<?php
/**
 * Template Name: Contact
 *
 * @package BMFitness
 */

get_header();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<h1 class="text-4xl font-bold text-gray-900 mb-12"><?php the_title(); ?></h1>

	<div class="grid gap-12 lg:grid-cols-2">
		<!-- Contact form area -->
		<div>

			<?php
			// Submission status from the POST-redirect-GET handler.
			$contact_status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : '';
			if ( 'sent' === $contact_status ) : ?>
				<div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800" role="status">
					<?php esc_html_e( 'Thank you! Your message has been sent.', 'bmfitness' ); ?>
				</div>
			<?php elseif ( 'invalid' === $contact_status ) : ?>
				<div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800" role="alert">
					<?php esc_html_e( 'Please fill in all fields with a valid email address.', 'bmfitness' ); ?>
				</div>
			<?php elseif ( 'error' === $contact_status ) : ?>
				<div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800" role="alert">
					<?php esc_html_e( 'Sorry, something went wrong. Please try again later.', 'bmfitness' ); ?>
				</div>
			<?php endif; ?>

			<!-- Secure contact form — submits to admin-post.php and sends via wp_mail(). -->
			<form class="space-y-6" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
				<input type="hidden" name="action" value="bmfitness_contact">
				<?php wp_nonce_field( 'bmfitness_contact', 'bmfitness_contact_nonce' ); ?>

				<!-- Honeypot: hidden from users; bots that fill it are silently dropped. -->
				<div class="hidden" aria-hidden="true">
					<label for="website"><?php esc_html_e( 'Website', 'bmfitness' ); ?></label>
					<input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
				</div>

				<div>
					<label for="name" class="block text-sm font-medium text-gray-700 mb-1"><?php esc_html_e( 'Name', 'bmfitness' ); ?></label>
					<input type="text" id="name" name="name" required
						   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
				</div>
				<div>
					<label for="email" class="block text-sm font-medium text-gray-700 mb-1"><?php esc_html_e( 'Email', 'bmfitness' ); ?></label>
					<input type="email" id="email" name="email" required
						   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition">
				</div>
				<div>
					<label for="message" class="block text-sm font-medium text-gray-700 mb-1"><?php esc_html_e( 'Message', 'bmfitness' ); ?></label>
					<textarea id="message" name="message" rows="5" required
							  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition resize-y"></textarea>
				</div>
				<button type="submit"
						class="w-full sm:w-auto px-8 py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-lg transition cursor-pointer">
					<?php esc_html_e( 'Pošalji nam poruku', 'bmfitness' ); ?>
				</button>
			</form>

            <div class="prose prose-lg max-w-none">
                <?php the_content(); ?>
            </div>
		</div>

		<!-- Contact details & map placeholder -->
		<div class="space-y-8">
			<div class="bg-gray-50 rounded-xl p-8 border border-gray-100">
				<h2 class="text-xl font-semibold text-gray-900 mb-6"><?php esc_html_e( 'Naši kontakt podatci', 'bmfitness' ); ?></h2>
				<ul class="space-y-4 text-gray-700">
					<li class="flex items-start gap-3">
						<span class="text-xl">📍</span>
						<span>Ulica Republike br.2<br>31300 Beli Manastir</span>
					</li>
					<li class="flex items-start gap-3">
						<span class="text-xl">📞</span>
						<a href="tel:+385976465977" class="hover:text-brand-600 transition-colors">+385 97 6465977</a>
					</li>
					<li class="flex items-start gap-3">
						<span class="text-xl">✉️</span>
						<a href="mailto:info@bmfitness.hr" class="hover:text-brand-600 transition-colors">info@bmfitness.hr</a>
					</li>
					<li class="flex items-start gap-3">
						<span class="text-xl">🕐</span>
						<span>Radno vrijeme: 0-24h <br>
                              Pult, Pon-Sub: 08:00-20:00h</span>
					</li>
				</ul>
			</div>
		</div>
</div>

       <!-- Google Maps embed placeholder -->
        <div class="bg-gray-200 rounded-xl h-72 flex items-center justify-center text-gray-500 mt-12 lg:mt-20">
            <gmp-map center="45.771049597998534, 18.5989996967285" zoom="18" map-id="bmfitness">
              <gmp-advanced-marker position="45.771049597998534, 18.5989996967285" title="BM Fitness"></gmp-advanced-marker>
            </gmp-map>
        </div>
	</div>

<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoVOXcmSn0WMvdoC7LaMe3qWpsSJpyd3E&callback=console.debug&libraries=maps,marker&v=beta"></script>

<?php
get_footer();
