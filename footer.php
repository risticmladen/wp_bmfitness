</main><!-- #main-content -->

<footer class="bg-gray-900 text-gray-300 mt-auto">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-8">

			<!-- Brand -->
			<div>
				<h2 class="text-xl font-bold text-white mb-3"><?php bloginfo( 'name' ); ?></h2>
				<p class="text-gray-400 text-sm leading-relaxed">
					<?php bloginfo( 'description' ); ?>
				</p>
			</div>

			<!-- Footer nav -->
			<div>
				<h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-3">
					<?php esc_html_e( 'Quick Links', 'bmfitness' ); ?>
				</h3>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'items_wrap'     => '<ul class="space-y-2 text-sm">%3$s</ul>',
					'walker'         => new BMFitness_Nav_Walker(),
					'fallback_cb'    => false,
				) );
				?>
			</div>

			<!-- Contact info placeholder -->
			<div>
				<h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-3">
					<?php esc_html_e( 'Contact', 'bmfitness' ); ?>
				</h3>
				<ul class="space-y-2 text-sm text-gray-400">
					<li>📍<a href="https://maps.app.goo.gl/hBCU2cHQTZGJc5L39">Ulica Republike 2, 31300 Beli Manastir</a></li>
					<li>📞 +385 XX XXX XXXX</li>
					<li>✉️ info@bmfitness.hr</li>
				</ul>
			</div>
		</div>

		<div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-500">
			<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'bmfitness' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
