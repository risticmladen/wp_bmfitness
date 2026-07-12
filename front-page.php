<?php
/**
 * Front page template.
 *
 * Structure:
 *  1. Fitness Hero  →  Fitness Pricing  →  Fitness Gallery
 *  2. Wellness Hero →  Wellness Pricing →  Wellness Gallery
 *  3. Google Reviews
 *  4. CTA
 *
 * @package BMFitness
 */

get_header();

/* ═══════════════════════════════════════════════════════════════ FITNESS */
?>
<h1 class="sr-only"><?php esc_html_e( 'BM Fitness - Fitness centar i wellness u Belom Manastiru', 'bmfitness' ); ?></h1>

<!-- Fitness Hero -->
<?php bmfitness_render_hero( 'fitness' ); ?>

<!-- Fitness Pricing -->
<?php
$fit_pricing_title = get_theme_mod( 'pricing_fitness_title', '' );
$fit_pricing_text  = get_theme_mod( 'pricing_fitness_text', '' );
?>
<section class="pb-25 -mt-20 relative z-10">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<?php bmfitness_render_pricing_grid( 'fitness' ); ?>
		<?php if ( $fit_pricing_title || $fit_pricing_text ) : ?>
			<div class="text-center mt-20">
				<?php if ( $fit_pricing_title ) : ?>
					<h2 class="text-2xl lg:text-3xl font-bold text-brand-600 text-shadow-2xs mb-5"><?php echo esc_html( $fit_pricing_title ); ?></h2>
				<?php endif; ?>
				<?php if ( $fit_pricing_text ) : ?>
					<p class="text-gray-600 max-w-2xl mx-auto text-base lg:text-xl"><?php echo nl2br( esc_html( $fit_pricing_text ) ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- Fitness Gallery -->
<?php
$fit_gal_title     = get_theme_mod( 'gallery_fitness_title', '' );
$fit_gal_text      = get_theme_mod( 'gallery_fitness_text', '' );
$fit_gal_btn_label = get_theme_mod( 'gallery_fitness_btn_label', '' );
$fit_gal_btn_url   = get_theme_mod( 'gallery_fitness_btn_url', '' );
?>
<section class="py-10 md:py-25 bg-gray-100">
	<div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="grid gap-10 md:grid-cols-5 items-start">
            <div class="md:col-span-3">
				<?php bmfitness_render_gallery_slider( 'fitness' ); ?>
			</div>
			<div class="md:col-span-2 flex flex-col justify-center">
				<?php if ( $fit_gal_title ) : ?>
					<h3 class="text-2xl font-bold text-gray-900 mb-4"><?php echo esc_html( $fit_gal_title ); ?></h3>
				<?php endif; ?>
				<?php if ( $fit_gal_text ) : ?>
					<p class="text-gray-600 leading-relaxed mb-6"><?php echo nl2br( esc_html( $fit_gal_text ) ); ?></p>
				<?php endif; ?>
				<?php if ( $fit_gal_btn_label && $fit_gal_btn_url ) : ?>
					<a href="<?php echo esc_url( $fit_gal_btn_url ); ?>"
					   class="inline-flex items-center px-6 py-3 bg-brand-600 text-white font-semibold rounded-lg hover:bg-brand-700 transition-colors max-w-fit uppercase">
						<?php echo esc_html( $fit_gal_btn_label ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php /* ══════════════════════════════════════════════════════════════ WELLNESS */ ?>

<!-- Wellness Hero -->
<?php bmfitness_render_hero( 'wellness' ); ?>

<!-- Wellness Pricing -->
<?php
$well_pricing_title = get_theme_mod( 'pricing_wellness_title', '' );
$well_pricing_text  = get_theme_mod( 'pricing_wellness_text', '' );
?>
<section class="pb-25 -mt-20 relative z-10">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<?php bmfitness_render_pricing_grid( 'wellness' ); ?>
		<?php if ( $well_pricing_title || $well_pricing_text ) : ?>
			<div class="text-center mt-20">
				<?php if ( $well_pricing_title ) : ?>
					<h2 class="text-2xl lg:text-3xl font-bold text-brand-600 text-shadow-2xs mb-5"><?php echo esc_html( $well_pricing_title ); ?></h2>
				<?php endif; ?>
				<?php if ( $well_pricing_text ) : ?>
					<p class="text-gray-600 max-w-2xl mx-auto text-base lg:text-xl"><?php echo nl2br( esc_html( $well_pricing_text ) ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- Wellness Gallery -->
<?php
$well_gal_title     = get_theme_mod( 'gallery_wellness_title', '' );
$well_gal_text      = get_theme_mod( 'gallery_wellness_text', '' );
$well_gal_btn_label = get_theme_mod( 'gallery_wellness_btn_label', '' );
$well_gal_btn_url   = get_theme_mod( 'gallery_wellness_btn_url', '' );
?>
<section class="py-10 md:py-25 bg-gray-100">
	<div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="grid gap-10 md:grid-cols-5 items-start">
            <div class="md:col-span-3">
                <?php bmfitness_render_gallery_slider( 'wellness' ); ?>
            </div>
			<div class="md:col-span-2 flex flex-col justify-center">
				<?php if ( $well_gal_title ) : ?>
					<h3 class="text-2xl font-bold text-gray-900 mb-4"><?php echo esc_html( $well_gal_title ); ?></h3>
				<?php endif; ?>
				<?php if ( $well_gal_text ) : ?>
					<p class="text-gray-600 leading-relaxed mb-6"><?php echo nl2br( esc_html( $well_gal_text ) ); ?></p>
				<?php endif; ?>
				<?php if ( $well_gal_btn_label && $well_gal_btn_url ) : ?>
					<a href="<?php echo esc_url( $well_gal_btn_url ); ?>"
					   class="inline-flex items-center px-6 py-3 bg-brand-600 text-white font-semibold rounded-lg hover:bg-brand-700 transition-colors max-w-fit uppercase">
						<?php echo esc_html( $well_gal_btn_label ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<!-- Google Reviews -->
<?php get_template_part( 'template-parts/google-reviews' ); ?>

<!-- CTA -->
<section class="py-20 bg-brand-600 text-white">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<h2 class="text-2xl lg:text-3xl font-bold mb-4"><?php esc_html_e( 'Ostvari svoje ciljeve!', 'bmfitness' ); ?></h2>
		<p class="text-base lg:text-xl mb-8"><?php esc_html_e( 'Pridruži se BM Fitness zajednici i počni živjeti zdravije!', 'bmfitness' ); ?></p>
		<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>"
		   class="inline-flex items-center px-8 py-4 bg-white text-black font-bold rounded-lg hover:bg-gray-100 transition">
			<?php esc_html_e( 'Pridruži nam se', 'bmfitness' ); ?>
		</a>
	</div>
</section>

<?php
get_footer();
