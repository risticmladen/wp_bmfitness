<?php
/**
 * Template Name: Pricelist
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
	// Pricing tiers — edit to match your actual pricing.
	$plans = array(
		array(
			'name'     => __( 'Basic', 'bmfitness' ),
			'price'    => '€29',
			'period'   => __( '/month', 'bmfitness' ),
			'desc'     => __( 'Perfect for getting started.', 'bmfitness' ),
			'featured' => false,
			'features' => array(
				__( 'Gym access (Mon–Fri)', 'bmfitness' ),
				__( '2 group classes/week', 'bmfitness' ),
				__( 'Locker room access', 'bmfitness' ),
				__( 'Basic body analysis', 'bmfitness' ),
			),
		),
		array(
			'name'     => __( 'Pro', 'bmfitness' ),
			'price'    => '€49',
			'period'   => __( '/month', 'bmfitness' ),
			'desc'     => __( 'Our most popular plan.', 'bmfitness' ),
			'featured' => true,
			'features' => array(
				__( 'Unlimited gym access', 'bmfitness' ),
				__( 'Unlimited group classes', 'bmfitness' ),
				__( '1 PT session/month', 'bmfitness' ),
				__( 'Nutrition plan', 'bmfitness' ),
				__( 'Monthly body analysis', 'bmfitness' ),
			),
		),
		array(
			'name'     => __( 'Premium', 'bmfitness' ),
			'price'    => '€89',
			'period'   => __( '/month', 'bmfitness' ),
			'desc'     => __( 'The full experience.', 'bmfitness' ),
			'featured' => false,
			'features' => array(
				__( 'Everything in Pro', 'bmfitness' ),
				__( '4 PT sessions/month', 'bmfitness' ),
				__( 'Custom nutrition coaching', 'bmfitness' ),
				__( 'Weekly progress check-ins', 'bmfitness' ),
				__( 'Priority class booking', 'bmfitness' ),
				__( 'Guest passes (2/month)', 'bmfitness' ),
			),
		),
	);
	?>

	<div class="grid gap-8 lg:grid-cols-3 items-start">
		<?php foreach ( $plans as $plan ) :
			$card_classes = 'rounded-2xl p-8 border';
			if ( $plan['featured'] ) {
				$card_classes .= ' bg-blue-600 text-white border-blue-600 shadow-xl scale-105';
			} else {
				$card_classes .= ' bg-white text-gray-900 border-gray-200 shadow-sm';
			}
		?>
			<div class="<?php echo esc_attr( $card_classes ); ?>">
				<?php if ( $plan['featured'] ) : ?>
					<span class="inline-block bg-blue-500 text-white text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-wider">
						<?php esc_html_e( 'Most Popular', 'bmfitness' ); ?>
					</span>
				<?php endif; ?>

				<h2 class="text-2xl font-bold mb-2"><?php echo esc_html( $plan['name'] ); ?></h2>
				<p class="<?php echo $plan['featured'] ? 'text-blue-100' : 'text-gray-500'; ?> text-sm mb-6">
					<?php echo esc_html( $plan['desc'] ); ?>
				</p>

				<div class="mb-6">
					<span class="text-4xl font-bold"><?php echo esc_html( $plan['price'] ); ?></span>
					<span class="<?php echo $plan['featured'] ? 'text-blue-200' : 'text-gray-400'; ?>"><?php echo esc_html( $plan['period'] ); ?></span>
				</div>

				<ul class="space-y-3 mb-8">
					<?php foreach ( $plan['features'] as $feature ) : ?>
						<li class="flex items-center gap-2 text-sm">
							<svg class="w-5 h-5 flex-shrink-0 <?php echo $plan['featured'] ? 'text-blue-200' : 'text-green-500'; ?>" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
							</svg>
							<?php echo esc_html( $feature ); ?>
						</li>
					<?php endforeach; ?>
				</ul>

				<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>"
				   class="block text-center px-6 py-3 font-semibold rounded-lg transition <?php echo $plan['featured']
					   ? 'bg-white text-blue-600 hover:bg-gray-100'
					   : 'bg-blue-600 text-white hover:bg-blue-700'; ?>">
					<?php esc_html_e( 'Get Started', 'bmfitness' ); ?>
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<?php
get_footer();
