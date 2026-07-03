<?php
/**
 * Front page template.
 *
 * @package BMFitness
 */

get_header();
?>

<!-- Hero -->
<section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-blue-900 text-white">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
		<div class="max-w-2xl">
			<h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6">
				<?php esc_html_e( 'Your Fitness Journey Starts Here', 'bmfitness' ); ?>
			</h1>
			<p class="text-lg text-gray-300 mb-8 leading-relaxed">
				<?php esc_html_e( 'Professional training, personalized programs, and a community that supports your goals.', 'bmfitness' ); ?>
			</p>
			<div class="flex flex-wrap gap-4">
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>"
				   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
					<?php esc_html_e( 'Get Started', 'bmfitness' ); ?>
				</a>
				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'pricelist' ) ) ); ?>"
				   class="inline-flex items-center px-6 py-3 border border-white/30 hover:bg-white/10 text-white font-semibold rounded-lg transition">
					<?php esc_html_e( 'View Pricing', 'bmfitness' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<!-- Services overview -->
<section class="py-20 bg-gray-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="text-center mb-12">
			<h2 class="text-3xl font-bold text-gray-900 mb-4"><?php esc_html_e( 'Our Services', 'bmfitness' ); ?></h2>
			<p class="text-gray-600 max-w-2xl mx-auto"><?php esc_html_e( 'Everything you need to reach your fitness goals under one roof.', 'bmfitness' ); ?></p>
		</div>
		<div class="grid gap-8 md:grid-cols-3">
			<?php
			$services = array(
				array(
					'icon'  => '💪',
					'title' => __( 'Personal Training', 'bmfitness' ),
					'desc'  => __( 'One-on-one sessions tailored to your goals and fitness level.', 'bmfitness' ),
				),
				array(
					'icon'  => '🏋️',
					'title' => __( 'Group Classes', 'bmfitness' ),
					'desc'  => __( 'High-energy group workouts that keep you motivated.', 'bmfitness' ),
				),
				array(
					'icon'  => '🥗',
					'title' => __( 'Nutrition Plans', 'bmfitness' ),
					'desc'  => __( 'Customized meal plans to fuel your training and recovery.', 'bmfitness' ),
				),
			);
			foreach ( $services as $service ) : ?>
				<div class="bg-white rounded-xl p-8 shadow-sm border border-gray-100 text-center hover:shadow-md transition">
					<div class="text-4xl mb-4"><?php echo $service['icon']; ?></div>
					<h3 class="text-xl font-semibold text-gray-900 mb-3"><?php echo esc_html( $service['title'] ); ?></h3>
					<p class="text-gray-600"><?php echo esc_html( $service['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="text-center mt-10">
			<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'services' ) ) ); ?>"
			   class="text-blue-600 font-semibold hover:text-blue-700 transition-colors">
				<?php esc_html_e( 'See all services →', 'bmfitness' ); ?>
			</a>
		</div>
	</div>
</section>

<!-- Google Reviews -->
<?php get_template_part( 'template-parts/google-reviews' ); ?>

<!-- CTA -->
<section class="py-20 bg-blue-600 text-white">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<h2 class="text-3xl font-bold mb-4"><?php esc_html_e( 'Ready to Transform Your Life?', 'bmfitness' ); ?></h2>
		<p class="text-blue-100 text-lg mb-8"><?php esc_html_e( 'Join BM Fitness today and start your journey to a healthier you.', 'bmfitness' ); ?></p>
		<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>"
		   class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100 transition">
			<?php esc_html_e( 'Contact Us', 'bmfitness' ); ?>
		</a>
	</div>
</section>

<?php
get_footer();
