<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'antialiased text-gray-900 bg-white min-h-screen flex flex-col' ); ?>>
<?php wp_body_open(); ?>

<header class="sticky top-0 z-50 bg-gray-800 backdrop-blur shadow" id="site-header">
	<div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex items-center justify-between h-20">

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

			<!-- Desktop nav -->
			<nav class="hidden md:flex items-center gap-16" aria-label="<?php esc_attr_e( 'Primary navigation', 'bmfitness' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'walker'         => new BMFitness_Nav_Walker(),
					'walker_context' => 'desktop',
					'fallback_cb'    => false,
				) );
				?>
			</nav>

			<!-- Mobile menu button -->
			<button
				type="button"
				class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-brand-700 hover:text-brand-600 hover:bg-gray-100 transition cursor-pointer"
				id="mobile-menu-toggle"
				aria-expanded="false"
				aria-controls="mobile-menu"
				aria-label="<?php esc_attr_e( 'Toggle menu', 'bmfitness' ); ?>"
			>
				<!-- Hamburger icon -->
				<svg class="h-6 w-6" id="menu-icon-open" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
				</svg>
				<!-- Close icon (hidden by default) -->
				<svg class="h-6 w-6 hidden" id="menu-icon-close" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
				</svg>
			</button>
		</div>
	</div>

	<!-- Mobile menu -->
	<div class="md:hidden hidden border-t border-gray-100" id="mobile-menu">
		<nav class="px-4 py-4 space-y-2" aria-label="<?php esc_attr_e( 'Mobile navigation', 'bmfitness' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'walker'         => new BMFitness_Nav_Walker(),
				'walker_context' => 'mobile',
				'fallback_cb'    => false,
			) );
			?>
		</nav>
	</div>
</header>

<main id="main-content">
