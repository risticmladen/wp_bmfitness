<?php
/**
 * Blog posts listing template.
 *
 * @package BMFitness
 */

get_header();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<h1 class="text-4xl font-bold text-gray-900 mb-12"><?php esc_html_e( 'Blog', 'bmfitness' ); ?></h1>

	<?php if ( have_posts() ) : ?>
		<div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-48 object-cover' ) ); ?>
						</a>
					<?php endif; ?>
					<div class="p-6">
						<div class="text-xs text-gray-400 mb-2"><?php echo get_the_date(); ?></div>
						<h2 class="text-xl font-semibold mb-2">
							<a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-blue-600 transition-colors">
								<?php the_title(); ?>
							</a>
						</h2>
						<p class="text-gray-600 text-sm mb-4"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
						<a href="<?php the_permalink(); ?>" class="text-blue-600 text-sm font-medium hover:text-blue-700">
							<?php esc_html_e( 'Read more →', 'bmfitness' ); ?>
						</a>
					</div>
				</article>
			<?php endwhile; ?>
		</div>

		<div class="mt-12">
			<?php the_posts_pagination( array(
				'mid_size'  => 2,
				'prev_text' => '← ' . __( 'Previous', 'bmfitness' ),
				'next_text' => __( 'Next', 'bmfitness' ) . ' →',
			) ); ?>
		</div>
	<?php else : ?>
		<p class="text-gray-500"><?php esc_html_e( 'No posts yet. Check back soon!', 'bmfitness' ); ?></p>
	<?php endif; ?>
</div>

<?php
get_footer();
