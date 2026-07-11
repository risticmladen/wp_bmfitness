</main><!-- #main-content -->

<footer class="bg-gray-900 text-gray-300 mt-auto">
	<div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div>
			<!-- Brand -->
			<!-- Logo / Site name -->
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3">
                    <span class="text-2xl font-bold tracking-tight text-gray-900">
                        <?php bloginfo( 'name' ); ?>
                    </span>
                </a>
            <?php endif; ?>
				<p class="text-gray-400 text-sm leading-relaxed">
					<?php bloginfo( 'description' ); ?>
				</p>

                <address class="not-italic mt-2">
                    <a href="https://share.google/NEvt8zUOmnkp7xef0" target="_blank">
                        <?php esc_html_e( 'Ulica Republike br. 2', 'bmfitness' ); ?> <br/>
                        <?php esc_html_e( '31300 Beli Manastir', 'bmfitness' ); ?>
                    </a>
                </address>
			</div>

			<div>
				<h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-3">
					<?php esc_html_e( 'Fitness Centar', 'bmfitness' ); ?>
				</h3>
				<ul class="space-y-2 text-sm text-gray-400">
                	<li>Radno vrijeme: 0-24h</li>
                	<li>Pult:</li>
                	<li>Pon-Sub: 08:00-20:00h</li>
                    <li><a href="tel:+385976465977">+385 97 6465977</a></li>
                    <li><a href="mailto:info@bmfitness.hr">info@bmfitness.hr</a></li>
                    <li>
                        <ul class="flex flex-row items-center gap-3 mt-2">
                            <li>
                                <a href="https://www.instagram.com/bm_fitness_centar/" target="_blank" rel="noopener"
                                   class="text-gray-400 hover:text-white transition-colors" aria-label="Instagram">
                                    <?php bmfitness_icon( 'instagram', 'w-5 h-5' ); ?>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/share/1YCqdeJsqU" target="_blank" rel="noopener"
                                   class="text-gray-400 hover:text-white transition-colors" aria-label="Facebook">
                                    <?php bmfitness_icon( 'facebook', 'w-5 h-5' ); ?>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.tiktok.com/@bm.fitness8" target="_blank" rel="noopener"
                                   class="text-gray-400 hover:text-white transition-colors" aria-label="TikTok">
                                    <?php bmfitness_icon( 'tiktok-social', 'w-4 h-4' ); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
			</div>

			<div>
				<h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-3">
					<?php esc_html_e( 'Wellness', 'bmfitness' ); ?>
				</h3>
				<ul class="space-y-2 text-sm text-gray-400">
                    <li>Radno vrijeme:</li>
                	<li>Pon-Sub: 08:00-20:00h</li>
                    <li><a href="tel:+385976039033">+385 97 603 9033</a> (rezervacije)</li>
                    <li><a href="mailto:wellness@bmfitness.hr">wellness@bmfitness.hr</a></li>
                    <li>
                        <ul class="flex flex-row items-center gap-3 mt-2">
                            <li>
                                <a href="https://www.instagram.com/bm.wellness/" target="_blank" rel="noopener"
                                   class="text-gray-400 hover:text-white transition-colors" aria-label="Instagram">
                                    <?php bmfitness_icon( 'instagram', 'w-5 h-5' ); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
				</ul>
			</div>
		</div>

		<div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-500">
			<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Sva prava pridržana.', 'bmfitness' ); ?></p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
