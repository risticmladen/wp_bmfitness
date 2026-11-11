<?php
/**
 * Homepage partner logo carousel.
 *
 * @package BMFitness
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$partners = get_posts( array(
	'post_type'      => 'bmfitness_partner',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC', 'ID' => 'ASC' ),
) );

$partner_logos = array();
foreach ( $partners as $partner ) {
	$image = get_the_post_thumbnail( $partner->ID, 'medium', array(
		'class'    => 'partners-logo',
		'alt'      => get_the_title( $partner ),
		'loading'  => 'lazy',
		'decoding' => 'async',
	) );
	if ( $image ) {
		$partner_logos[] = array(
			'image' => $image,
			'url'   => esc_url( get_post_meta( $partner->ID, '_bmfitness_partner_url', true ), array( 'http', 'https' ) ),
		);
	}
}

if ( ! $partner_logos ) {
	return;
}

$heading_id = wp_unique_id( 'partners-heading-' );
$track_id   = wp_unique_id( 'partners-track-' );
?>
<section class="bg-gray-900 partners-slider py-20 border-b border-gray-800" data-partners-slider aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 ">
		<h2 id="<?php echo esc_attr( $heading_id ); ?>" class="text-2xl lg:text-3xl font-bold text-white text-center mb-8"><?php esc_html_e( 'Naši partneri', 'bmfitness' ); ?></h2>
		<ul id="<?php echo esc_attr( $track_id ); ?>" class="partners-track" tabindex="0" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
			<?php foreach ( $partner_logos as $partner_logo ) : ?>
				<li class="partners-slide">
					<?php if ( $partner_logo['url'] ) : ?>
						<a class="partners-link" href="<?php echo esc_url( $partner_logo['url'] ); ?>">
							<?php echo $partner_logo['image']; // WordPress-generated image markup. ?>
						</a>
					<?php else : ?>
						<div class="partners-link"><?php echo $partner_logo['image']; ?></div>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
