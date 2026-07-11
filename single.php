<?php
/**
 * Single post template.
 *
 * @package BMFitness
 */

get_header();
?>

<article class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="mb-8 rounded-xl overflow-hidden max-h-[700px]">
				<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto' ) ); ?>
			</div>
		<?php endif; ?>

		<header class="mb-8">
			<h1 class="text-4xl font-bold text-gray-900 mb-4"><?php the_title(); ?></h1>
			<div class="flex items-center gap-4 text-sm text-gray-500">
				<time datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
				<span>·</span>
				<span><?php echo esc_html( get_the_author() ); ?></span>
			</div>
		</header>

		<div class="prose prose-lg max-w-none">
			<?php the_content(); ?>
		</div>

		<nav class="mt-12 pt-8 border-t border-gray-200 flex justify-between">
			<div class="max-w-[33%]">
				<?php previous_post_link( '%link', '← Prethodni blog post' ); ?>
			</div>
			<div class="max-w-[33%]">
				<?php next_post_link( '%link', 'Idući blog post →' ); ?>
			</div>
		</nav>
	<?php endwhile; ?>
</article>

<?php
get_footer();
