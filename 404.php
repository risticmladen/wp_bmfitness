<?php
/**
 * 404 error page template.
 *
 * @package BMFitness
 */

get_header();
?>

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
	<h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
	<p class="text-xl text-gray-600 mb-8"><?php esc_html_e( 'Page not found. It might have been moved or no longer exists.', 'bmfitness' ); ?></p>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
	   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
		<?php esc_html_e( '← Back to Home', 'bmfitness' ); ?>
	</a>
</div>

<?php
get_footer();
