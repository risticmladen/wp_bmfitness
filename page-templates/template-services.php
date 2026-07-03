<?php
/**
 * Template Name: Services
 *
 * @package BMFitness
 */

get_header();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<div class="text-center mb-16">
		<h1 class="text-4xl font-bold text-gray-900 mb-4"><?php the_title(); ?></h1>
		<div class="prose prose-lg max-w-2xl mx-auto text-center">
			<?php the_content(); ?>
		</div>
	</div>

	<?php
	// Services list — edit these to match your actual offerings.
	$services = array(
		array(
			'icon'  => '💪',
			'title' => __( 'Personal Training', 'bmfitness' ),
			'desc'  => __( 'Work one-on-one with a certified trainer who will create a personalized workout plan, monitor your form, and push you to achieve your best results.', 'bmfitness' ),
		),
		array(
			'icon'  => '🏋️',
			'title' => __( 'Group Classes', 'bmfitness' ),
			'desc'  => __( 'Join our energizing group sessions including HIIT, strength training, yoga, and more. Perfect for staying motivated with a community.', 'bmfitness' ),
		),
		array(
			'icon'  => '🥗',
			'title' => __( 'Nutrition Coaching', 'bmfitness' ),
			'desc'  => __( 'Get a customized meal plan designed to complement your training goals. Our nutrition experts will guide you every step of the way.', 'bmfitness' ),
		),
		array(
			'icon'  => '📋',
			'title' => __( 'Custom Programs', 'bmfitness' ),
			'desc'  => __( 'Whether you\'re training for a sport, recovering from injury, or just getting started — we\'ll build a program tailored to you.', 'bmfitness' ),
		),
		array(
			'icon'  => '🧘',
			'title' => __( 'Yoga & Mobility', 'bmfitness' ),
			'desc'  => __( 'Improve flexibility, reduce stress, and support recovery with our dedicated yoga and mobility sessions.', 'bmfitness' ),
		),
		array(
			'icon'  => '📊',
			'title' => __( 'Body Composition Analysis', 'bmfitness' ),
			'desc'  => __( 'Track your progress with detailed body composition measurements and regular progress check-ins.', 'bmfitness' ),
		),
	);
	?>

	<div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
		<?php foreach ( $services as $service ) : ?>
			<div class="bg-white rounded-xl p-8 shadow-sm border border-gray-100 hover:shadow-md transition">
				<div class="text-4xl mb-4"><?php echo $service['icon']; ?></div>
				<h2 class="text-xl font-semibold text-gray-900 mb-3"><?php echo esc_html( $service['title'] ); ?></h2>
				<p class="text-gray-600 leading-relaxed"><?php echo esc_html( $service['desc'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>

	<!-- CTA -->
	<div class="text-center mt-16 bg-gray-50 rounded-2xl p-12">
		<h2 class="text-2xl font-bold text-gray-900 mb-4"><?php esc_html_e( 'Not sure which service is right for you?', 'bmfitness' ); ?></h2>
		<p class="text-gray-600 mb-6"><?php esc_html_e( 'Contact us for a free consultation and we\'ll help you find the perfect fit.', 'bmfitness' ); ?></p>
		<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>"
		   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
			<?php esc_html_e( 'Get in Touch', 'bmfitness' ); ?>
		</a>
	</div>
</div>

<?php
get_footer();
