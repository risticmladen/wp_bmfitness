<?php
/**
 * Default page template.
 *
 * @package BMFitness
 */

get_header();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<?php while ( have_posts() ) : the_post(); ?>
		<h1 class="text-4xl font-bold text-gray-900 mb-8"><?php the_title(); ?></h1>
		<div class="prose prose-lg max-w-none">
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
</div>

<?php
get_footer();
