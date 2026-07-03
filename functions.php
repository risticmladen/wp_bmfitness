<?php
/**
 * BM Fitness theme functions and definitions.
 *
 * @package BMFitness
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BMFITNESS_VERSION', '1.0.0' );
define( 'BMFITNESS_DIR', get_template_directory() );
define( 'BMFITNESS_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function bmfitness_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 250,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'bmfitness' ),
		'footer'  => __( 'Footer Menu', 'bmfitness' ),
	) );
}
add_action( 'after_setup_theme', 'bmfitness_setup' );

/**
 * Enqueue styles and scripts.
 */
function bmfitness_enqueue_assets() {
	// Tailwind compiled CSS.
	wp_enqueue_style(
		'bmfitness-style',
		BMFITNESS_URI . '/assets/css/app.css',
		array(),
		filemtime( BMFITNESS_DIR . '/assets/css/app.css' )
	);

	// Main JS.
	wp_enqueue_script(
		'bmfitness-script',
		BMFITNESS_URI . '/assets/js/app.js',
		array(),
		filemtime( BMFITNESS_DIR . '/assets/js/app.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'bmfitness_enqueue_assets' );

/**
 * Custom nav walker for Tailwind-friendly markup.
 */
class BMFitness_Nav_Walker extends Walker_Nav_Menu {
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = 'text-white hover:text-brand-600 transition-colors font-medium';
		if ( in_array( 'current-menu-item', $item->classes, true ) ) {
			$classes .= ' text-brand-600';
		}
		$output .= '<li class="list-none">';
		$output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $classes ) . '">';
		$output .= esc_html( $item->title );
		$output .= '</a>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}

/**
 * Register widget areas.
 */
function bmfitness_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'bmfitness' ),
		'id'            => 'footer-widgets',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="text-lg font-semibold mb-3">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'bmfitness_widgets_init' );
