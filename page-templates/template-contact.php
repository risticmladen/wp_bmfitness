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
			<div class="prose prose-lg max-w-none mb-8">
				<?php the_content(); ?>
			</div>

			<!-- Simple contact form (no plugin needed — handles via mailto or add a plugin later) -->
			<form class="space-y-6" action="mailto:info@bmfitness.hr" method="post" enctype="text/plain">
				<div>
					<label for="name" class="block text-sm font-medium text-gray-700 mb-1"><?php esc_html_e( 'Name', 'bmfitness' ); ?></label>
					<input type="text" id="name" name="name" required
						   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
				</div>
				<div>
					<label for="email" class="block text-sm font-medium text-gray-700 mb-1"><?php esc_html_e( 'Email', 'bmfitness' ); ?></label>
					<input type="email" id="email" name="email" required
						   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
				</div>
				<div>
					<label for="message" class="block text-sm font-medium text-gray-700 mb-1"><?php esc_html_e( 'Message', 'bmfitness' ); ?></label>
					<textarea id="message" name="message" rows="5" required
							  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-y"></textarea>
				</div>
				<button type="submit"
						class="w-full sm:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
					<?php esc_html_e( 'Send Message', 'bmfitness' ); ?>
				</button>
			</form>
		</div>

		<!-- Contact details & map placeholder -->
		<div class="space-y-8">
			<div class="bg-gray-50 rounded-xl p-8 border border-gray-100">
				<h2 class="text-xl font-semibold text-gray-900 mb-6"><?php esc_html_e( 'Get in Touch', 'bmfitness' ); ?></h2>
				<ul class="space-y-4 text-gray-700">
					<li class="flex items-start gap-3">
						<span class="text-xl">📍</span>
						<span>Your Address Here<br>City, Zip Code</span>
					</li>
					<li class="flex items-start gap-3">
						<span class="text-xl">📞</span>
						<a href="tel:+385XXXXXXXX" class="hover:text-blue-600 transition-colors">+385 XX XXX XXXX</a>
					</li>
					<li class="flex items-start gap-3">
						<span class="text-xl">✉️</span>
						<a href="mailto:info@bmfitness.hr" class="hover:text-blue-600 transition-colors">info@bmfitness.hr</a>
					</li>
					<li class="flex items-start gap-3">
						<span class="text-xl">🕐</span>
						<span>Mon–Fri: 06:00 – 22:00<br>Sat: 08:00 – 20:00<br>Sun: 09:00 – 14:00</span>
					</li>
				</ul>
			</div>

			<!-- Google Maps embed placeholder -->
			<div class="bg-gray-200 rounded-xl h-64 flex items-center justify-center text-gray-500">
				<p class="text-center text-sm">
					<?php esc_html_e( 'Google Maps embed — replace this div with an iframe from Google Maps.', 'bmfitness' ); ?>
				</p>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
