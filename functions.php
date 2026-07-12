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
	add_image_size( 'pricing-plan', 800, 500, true ); // Hard-cropped for plan cards.

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
 * Output LocalBusiness JSON-LD structured data for better Google visibility.
 * Edit the details below to match the real business info.
 */
function bmfitness_local_business_schema() {
	if ( ! is_front_page() ) {
		return;
	}
	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'HealthAndBeautyBusiness',
		'name'            => get_bloginfo( 'BM Fitness' ),
		'url'             => home_url('https://bmfitness.hr/'),
		'telephone'       => '+385 97 6465977',
		'email'           => 'info@bmfitness.hr',
		'address'         => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Ulica Republike br. 2',
			'addressLocality' => 'Beli Manastir',
			'postalCode'      => '31300',
			'addressCountry'  => 'HR',
		),
		'openingHoursSpecification' => array(
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday','Tuesday','Wednesday','Thursday','Friday' ),
				'opens'     => '00:00',
				'closes'    => '24:00',
			)
		),
		'sameAs' => array(
			'https://www.instagram.com/bm_fitness_centar/',
			'https://www.instagram.com/bm.wellness/',
			'https://www.facebook.com/share/1YCqdeJsqU',
		),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}
add_action( 'wp_head', 'bmfitness_local_business_schema' );

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
 * Add the page slug as a body class (e.g. "page-wellness", "page-fitness")
 * so templates and CSS can target individual pages.
 */
function bmfitness_body_class_slug( $classes ) {
	if ( is_page() ) {
		$queried = get_queried_object();
		if ( $queried instanceof WP_Post && $queried->post_name ) {
			$classes[] = 'page-' . sanitize_html_class( $queried->post_name );
		}
	}
	return $classes;
}
add_filter( 'body_class', 'bmfitness_body_class_slug' );

/**
 * Custom nav walker for Tailwind-friendly markup.
 *
 * Supports two contexts via the `walker_context` arg passed to wp_nav_menu():
 *  - 'desktop' : hover-triggered dropdown (CSS group-hover)
 *  - 'mobile'  : click-toggled accordion (JS + hidden class)
 */
class BMFitness_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$context = $args->walker_context ?? 'desktop';
		if ( 'desktop' === $context ) {
			$output .= '<ul class="nav-dropdown-menu absolute top-full left-0 mt-1 w-52 bg-white rounded-lg shadow-xl hidden py-2 z-50">';
		} else {
			$output .= '<ul class="mobile-submenu hidden pl-4 mt-1 space-y-1 border-l-2 border-gray-600 ml-2">';
		}
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$context      = $args->walker_context ?? 'desktop';
		$has_children = in_array( 'menu-item-has-children', $item->classes, true );
		$is_current   = in_array( 'current-menu-item', $item->classes, true );

		if ( 'desktop' === $context ) {
			if ( 0 === $depth ) {
				// Top-level item.
				$li_class = 'list-none' . ( $has_children ? ' relative nav-dropdown-parent' : '' );
				$output  .= '<li class="' . esc_attr( $li_class ) . '">';

				$link_class = 'text-white hover:text-brand-600 transition-colors font-medium flex items-center gap-1 uppercase text-sm font-semibold tracking-wider';
				if ( $is_current ) {
					$link_class .= ' text-brand-600';
				}

				$output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . '">';
				$output .= esc_html( $item->title );
				if ( $has_children ) {
					$output .= '<svg class="nav-dropdown-chevron w-4 h-4 flex-shrink-0 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>';
				}
				$output .= '</a>';
			} else {
				// Dropdown item.
				$output .= '<li class="list-none">';

				$link_class = 'block px-4 py-2 text-md text-gray-700 hover:text-brand-600 hover:bg-gray-50 transition-colors';
				if ( $is_current ) {
					$link_class .= ' text-brand-600';
				}

				$output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . '">';
				$output .= esc_html( $item->title );
				$output .= '</a>';
			}
		} else {
			// Mobile context.
			if ( 0 === $depth ) {
				$output .= '<li class="list-none">';

				$link_class = 'text-white hover:text-brand-600 transition-colors py-3 uppercase text-sm font-semibold tracking-wider block w-full';
				if ( $is_current ) {
					$link_class .= ' text-brand-600';
				}

				if ( $has_children ) {
					// Wrap link + toggle button; close div before start_lvl adds the <ul>.
					$output .= '<div class="flex items-center justify-between">';
					$output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . ' mobile-submenu-link" aria-expanded="false">' . esc_html( $item->title ) . '</a>';
					$output .= '<button type="button" class="mobile-submenu-toggle py-1 pl-1 pr-3 text-gray-400 hover:text-white transition-colors" aria-expanded="false">';
					$output .= '<svg class="w-5 h-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>';
					$output .= '</button>';
					$output .= '</div>';
				} else {
					$output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . '">' . esc_html( $item->title ) . '</a>';
				}
			} else {
				// Mobile submenu item.
				$output .= '<li class="list-none">';

				$link_class = 'block py-3 lg:py-2 text-sm text-gray-300 hover:text-brand-600 transition-colors';
				if ( $is_current ) {
					$link_class .= ' text-brand-600';
				}

				$output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . '">' . esc_html( $item->title ) . '</a>';
			}
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}

/**
 * Theme Customizer settings.
 */
function bmfitness_customize_register( $wp_customize ) {

	// ── Helper: add image + opacity slider for a hero section ──────────────
	$bmf_add_hero = function( $section_id, $label, $priority ) use ( $wp_customize ) {
		$wp_customize->add_section( $section_id, array( 'title' => $label, 'priority' => $priority ) );
		$img_key = str_replace( 'bmfitness_', '', $section_id ) . '_background_image';
		$op_key  = str_replace( 'bmfitness_', '', $section_id ) . '_overlay_opacity';
		$wp_customize->add_setting( $img_key, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $img_key, array( 'label' => __( 'Background Image', 'bmfitness' ), 'section' => $section_id ) ) );
		$wp_customize->add_setting( $op_key, array( 'default' => 55, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
		$wp_customize->add_control( $op_key, array( 'label' => __( 'Overlay darkness (%)', 'bmfitness' ), 'description' => __( 'Dark overlay so text stays readable.', 'bmfitness' ), 'section' => $section_id, 'type' => 'range', 'input_attrs' => array( 'min' => 0, 'max' => 90, 'step' => 5 ) ) );
	};

	$bmf_add_hero( 'bmfitness_hero_fitness',  __( 'Hero — Fitness',  'bmfitness' ), 30 );
	$bmf_add_hero( 'bmfitness_hero_wellness', __( 'Hero — Wellness', 'bmfitness' ), 31 );

	// ── Pricing info text (per service) ──────────────────────────────────
	foreach ( array(
		array( 'id' => 'bmfitness_pricing_fitness',  'label' => __( 'Pricing — Fitness',  'bmfitness' ), 'priority' => 32, 'prefix' => 'pricing_fitness' ),
		array( 'id' => 'bmfitness_pricing_wellness', 'label' => __( 'Pricing — Wellness', 'bmfitness' ), 'priority' => 33, 'prefix' => 'pricing_wellness' ),
	) as $ps ) {
		$wp_customize->add_section( $ps['id'], array( 'title' => $ps['label'], 'priority' => $ps['priority'] ) );
		foreach ( array(
			$ps['prefix'] . '_title' => array( 'label' => __( 'Heading', 'bmfitness' ),          'type' => 'text',     'sanitize' => 'sanitize_text_field' ),
			$ps['prefix'] . '_text'  => array( 'label' => __( 'Note / description', 'bmfitness' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
		) as $key => $ctrl ) {
			$wp_customize->add_setting( $key, array( 'default' => '', 'sanitize_callback' => $ctrl['sanitize'], 'transport' => 'refresh' ) );
			$wp_customize->add_control( $key, array( 'label' => $ctrl['label'], 'section' => $ps['id'], 'type' => $ctrl['type'] ) );
		}
	}

	// ── Fitness gallery sidebar ───────────────────────────────────────────────
	$wp_customize->add_section( 'bmfitness_gallery_fitness', array(
	'title'    => __( 'Gallery — Fitness', 'bmfitness' ),
		'priority' => 34,
	) );
	foreach ( array(
		'gallery_fitness_title'     => array( 'label' => __( 'Heading', 'bmfitness' ),     'type' => 'text',     'sanitize' => 'sanitize_text_field' ),
		'gallery_fitness_text'      => array( 'label' => __( 'Description', 'bmfitness' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
		'gallery_fitness_btn_label' => array( 'label' => __( 'Button label', 'bmfitness' ),'type' => 'text',     'sanitize' => 'sanitize_text_field' ),
		'gallery_fitness_btn_url'   => array( 'label' => __( 'Button URL', 'bmfitness' ),  'type' => 'url',      'sanitize' => 'esc_url_raw' ),
	) as $key => $args ) {
		$wp_customize->add_setting( $key, array( 'default' => '', 'sanitize_callback' => $args['sanitize'], 'transport' => 'refresh' ) );
		$wp_customize->add_control( $key, array( 'label' => $args['label'], 'section' => 'bmfitness_gallery_fitness', 'type' => $args['type'] ) );
	}

	// ── Wellness gallery sidebar ──────────────────────────────────────────────
	$wp_customize->add_section( 'bmfitness_gallery_wellness', array(
	'title'    => __( 'Gallery — Wellness', 'bmfitness' ),
		'priority' => 35,
	) );
	foreach ( array(
		'gallery_wellness_title'     => array( 'label' => __( 'Heading', 'bmfitness' ),     'type' => 'text',     'sanitize' => 'sanitize_text_field' ),
		'gallery_wellness_text'      => array( 'label' => __( 'Description', 'bmfitness' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
		'gallery_wellness_btn_label' => array( 'label' => __( 'Button label', 'bmfitness' ),'type' => 'text',     'sanitize' => 'sanitize_text_field' ),
		'gallery_wellness_btn_url'   => array( 'label' => __( 'Button URL', 'bmfitness' ),  'type' => 'url',      'sanitize' => 'esc_url_raw' ),
	) as $key => $args ) {
		$wp_customize->add_setting( $key, array( 'default' => '', 'sanitize_callback' => $args['sanitize'], 'transport' => 'refresh' ) );
		$wp_customize->add_control( $key, array( 'label' => $args['label'], 'section' => 'bmfitness_gallery_wellness', 'type' => $args['type'] ) );
	}
}
add_action( 'customize_register', 'bmfitness_customize_register' );

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

/**
 * Gallery Image custom post type.
 *
 * Client manages slides via WP Admin → Gallery → Add New.
 * Set a title and a Featured Image — that's all that's needed.
 * Use the "Order" field (page-attributes) to control slide order.
 */
function bmfitness_register_gallery_cpt() {
	register_post_type( 'gallery_image', array(
		'labels'        => array(
			'name'               => __( 'Gallery', 'bmfitness' ),
			'singular_name'      => __( 'Gallery Image', 'bmfitness' ),
			'add_new_item'       => __( 'Add New Image', 'bmfitness' ),
			'edit_item'          => __( 'Edit Image', 'bmfitness' ),
			'all_items'          => __( 'All Images', 'bmfitness' ),
			'search_items'       => __( 'Search Gallery', 'bmfitness' ),
			'not_found'          => __( 'No images found.', 'bmfitness' ),
			'not_found_in_trash' => __( 'No images found in trash.', 'bmfitness' ),
		),
		'public'        => false,
		'show_ui'       => true,
		'show_in_menu'  => true,
		'menu_icon'     => 'dashicons-format-gallery',
		'menu_position' => 20,
		// 'title' for the slide label, 'thumbnail' for the image,
		// 'page-attributes' exposes the Order field for drag-reordering.
		'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
	) );
}
add_action( 'init', 'bmfitness_register_gallery_cpt' );

/**
 * Taxonomy: Gallery Section.
 *
 * Adds a "Gallery Section" checkbox panel to every Gallery Image edit screen.
 * Default terms (Fitness, Wellness) are seeded automatically on first load.
 */
function bmfitness_register_gallery_taxonomy() {
	register_taxonomy( 'gallery_section', 'gallery_image', array(
		'labels'            => array(
			'name'          => __( 'Gallery Sections', 'bmfitness' ),
			'singular_name' => __( 'Gallery Section', 'bmfitness' ),
			'all_items'     => __( 'All Sections', 'bmfitness' ),
			'edit_item'     => __( 'Edit Section', 'bmfitness' ),
			'add_new_item'  => __( 'Add New Section', 'bmfitness' ),
		),
		'hierarchical'      => true,  // shows as checkboxes (like categories)
		'show_ui'           => true,
		'show_admin_column' => true,  // visible in the Gallery list table
		'public'            => false,
		'rewrite'           => false,
	) );

	// Seed the two default terms if they do not exist yet.
	foreach ( array(
		array( 'name' => __( 'Fitness', 'bmfitness' ),  'slug' => 'fitness' ),
		array( 'name' => __( 'Wellness', 'bmfitness' ), 'slug' => 'wellness' ),
	) as $term ) {
		if ( ! term_exists( $term['slug'], 'gallery_section' ) ) {
			wp_insert_term( $term['name'], 'gallery_section', array( 'slug' => $term['slug'] ) );
		}
	}
}
add_action( 'init', 'bmfitness_register_gallery_taxonomy' );

/**
 * Render a hero banner section for the given service.
 * Reads hero_{service_key}_background_image and hero_{service_key}_overlay_opacity from Customizer.
 *
 * @param string $service_key 'fitness' or 'wellness'.
 */
function bmfitness_render_hero( $service_key ) {
	$image   = get_theme_mod( 'hero_' . $service_key . '_background_image', '' );
	$opacity = absint( get_theme_mod( 'hero_' . $service_key . '_overlay_opacity', 55 ) ) / 100;
	?>
	<section
		class="relative min-h-[220px] md:min-h-[520px] text-white<?php echo $image ? '' : ' bg-gradient-to-br from-gray-900 via-gray-800 to-blue-900'; ?>"
		<?php if ( $image ) : ?>
			style="background-image: url('<?php echo esc_url( $image ); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;"
		<?php endif; ?>
	>
		<?php if ( $image ) : ?>
			<div style="position:absolute;inset:0;background:#000;opacity:<?php echo esc_attr( $opacity ); ?>;pointer-events:none;"></div>
		<?php endif; ?>
	</section>
	<?php
}

/**
 * Pricing Plan custom post type.
 *
 * Client manages plans via WP Admin → Pricing Plans → Add New.
 * Set: Title (plan name), Pricing Section (Fitness/Wellness), Original price, Sale price, Order.
 */
function bmfitness_register_pricing_cpt() {
	register_post_type( 'pricing_plan', array(
		'labels'        => array(
			'name'               => __( 'Pricing Plans', 'bmfitness' ),
			'singular_name'      => __( 'Pricing Plan', 'bmfitness' ),
			'add_new_item'       => __( 'Add New Plan', 'bmfitness' ),
			'edit_item'          => __( 'Edit Plan', 'bmfitness' ),
			'all_items'          => __( 'All Plans', 'bmfitness' ),
			'not_found'          => __( 'No plans found.', 'bmfitness' ),
			'not_found_in_trash' => __( 'No plans found in trash.', 'bmfitness' ),
		),
		'public'        => false,
		'show_ui'       => true,
		'show_in_menu'  => true,
		'show_in_rest'  => true, // Required for the block editor to fetch plans.
		'menu_icon'     => 'dashicons-money-alt',
		'menu_position' => 21,
		// page-attributes adds the Order field so the client can reorder plans.
		// thumbnail enables the Featured Image meta box so a plan image can be set.
		'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
	) );
}
add_action( 'init', 'bmfitness_register_pricing_cpt' );

/**
 * Taxonomy: Pricing Section.
 * Fitness / Wellness checkboxes appear on the Pricing Plan edit screen.
 */
function bmfitness_register_pricing_taxonomy() {
	register_taxonomy( 'pricing_section', 'pricing_plan', array(
		'labels'            => array(
			'name'          => __( 'Pricing Sections', 'bmfitness' ),
			'singular_name' => __( 'Pricing Section', 'bmfitness' ),
			'all_items'     => __( 'All Sections', 'bmfitness' ),
		),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'public'            => false,
		'rewrite'           => false,
	) );

	foreach ( array(
		array( 'name' => __( 'Fitness', 'bmfitness' ),  'slug' => 'fitness' ),
		array( 'name' => __( 'Wellness', 'bmfitness' ), 'slug' => 'wellness' ),
	) as $term ) {
		if ( ! term_exists( $term['slug'], 'pricing_section' ) ) {
			wp_insert_term( $term['name'], 'pricing_section', array( 'slug' => $term['slug'] ) );
		}
	}
}
add_action( 'init', 'bmfitness_register_pricing_taxonomy' );

/**
 * Meta box: Original price and sale price for a Pricing Plan.
 */
function bmfitness_add_pricing_meta_box() {
	add_meta_box(
		'bmfitness_plan_prices',
		__( 'Plan details', 'bmfitness' ),
		'bmfitness_pricing_meta_box_html',
		'pricing_plan',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'bmfitness_add_pricing_meta_box' );

function bmfitness_pricing_meta_box_html( $post ) {
	wp_nonce_field( 'bmfitness_save_plan_prices', 'bmfitness_plan_nonce' );
	$description = get_post_meta( $post->ID, '_plan_description', true );
	$breakdown   = get_post_meta( $post->ID, '_plan_price_breakdown', true );
	$url         = get_post_meta( $post->ID, '_plan_url', true );
	$old         = get_post_meta( $post->ID, '_old_price', true );
	$new         = get_post_meta( $post->ID, '_new_price', true );
	?>
	<table class="form-table" style="margin:0;">
		<tr>
			<th style="width:44%;padding:8px 0;"><label for="bm_plan_description"><?php esc_html_e( 'Description (shown under the title)', 'bmfitness' ); ?></label></th>
			<td style="padding:8px 0;"><textarea id="bm_plan_description" name="bm_plan_description" rows="3" class="large-text" placeholder="<?php esc_attr_e( 'Short description of the plan', 'bmfitness' ); ?>"><?php echo esc_textarea( $description ); ?></textarea></td>
		</tr>
		<tr>
			<th style="width:44%;padding:8px 0;"><label for="bm_plan_price_breakdown"><?php esc_html_e( 'Price breakdown', 'bmfitness' ); ?></label></th>
			<td style="padding:8px 0;"><input type="text" id="bm_plan_price_breakdown" name="bm_plan_price_breakdown" value="<?php echo esc_attr( $breakdown ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'e.g. 3 x 30€ / month', 'bmfitness' ); ?>"></td>
		</tr>
		<tr>
			<th style="padding:8px 0;"><label for="bm_plan_url"><?php esc_html_e( 'Link URL (wraps the card)', 'bmfitness' ); ?></label></th>
			<td style="padding:8px 0;">
				<span style="color:#646970;"><?php echo esc_html( trailingslashit( home_url() ) ); ?></span><input type="text" id="bm_plan_url" name="bm_plan_url" value="<?php echo esc_attr( $url ); ?>" class="regular-text" style="width:auto;" placeholder="<?php esc_attr_e( 'membership', 'bmfitness' ); ?>">
				<p class="description"><?php esc_html_e( 'Enter a path on this site (e.g. “membership” or “wellness/spa”). For an external link, paste the full https:// URL.', 'bmfitness' ); ?></p>
			</td>
		</tr>
		<tr>
			<th style="width:44%;padding:8px 0;"><label for="bm_old_price"><?php esc_html_e( 'Original price (shown crossed out)', 'bmfitness' ); ?></label></th>
			<td style="padding:8px 0;"><input type="text" id="bm_old_price" name="bm_old_price" value="<?php echo esc_attr( $old ); ?>" class="regular-text" placeholder="e.g. 105"></td>
		</tr>
		<tr>
			<th style="padding:8px 0;"><label for="bm_new_price"><?php esc_html_e( 'Sale price', 'bmfitness' ); ?></label></th>
			<td style="padding:8px 0;"><input type="text" id="bm_new_price" name="bm_new_price" value="<?php echo esc_attr( $new ); ?>" class="regular-text" placeholder="e.g. 90"></td>
		</tr>
	</table>
	<?php
}

function bmfitness_save_plan_prices( $post_id ) {
	if ( ! isset( $_POST['bmfitness_plan_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['bmfitness_plan_nonce'], 'bmfitness_save_plan_prices' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	if ( isset( $_POST['bm_plan_description'] ) ) {
		update_post_meta( $post_id, '_plan_description', sanitize_textarea_field( wp_unslash( $_POST['bm_plan_description'] ) ) );
	}
	if ( isset( $_POST['bm_plan_price_breakdown'] ) ) {
		update_post_meta( $post_id, '_plan_price_breakdown', sanitize_text_field( wp_unslash( $_POST['bm_plan_price_breakdown'] ) ) );
	}
	if ( isset( $_POST['bm_plan_url'] ) ) {
		$raw = trim( wp_unslash( $_POST['bm_plan_url'] ) );
		if ( '' === $raw ) {
			$plan_url = '';
		} elseif ( preg_match( '#^(https?:)?//#i', $raw ) ) {
			$plan_url = esc_url_raw( $raw ); // Full/external URL.
		} else {
			$plan_url = ltrim( sanitize_text_field( $raw ), '/' ); // Relative path on this site.
		}
		update_post_meta( $post_id, '_plan_url', $plan_url );
	}
	if ( isset( $_POST['bm_old_price'] ) ) {
		update_post_meta( $post_id, '_old_price', sanitize_text_field( wp_unslash( $_POST['bm_old_price'] ) ) );
	}
	if ( isset( $_POST['bm_new_price'] ) ) {
		update_post_meta( $post_id, '_new_price', sanitize_text_field( wp_unslash( $_POST['bm_new_price'] ) ) );
	}
}
add_action( 'save_post_pricing_plan', 'bmfitness_save_plan_prices' );

/**
 * Resolve a stored plan URL to a full URL.
 *
 * A relative path (e.g. "membership") is treated as a path on this site and
 * expanded to home_url('/membership'). Absolute or protocol-relative URLs are
 * returned unchanged so external links keep working.
 *
 * @param string $value Stored _plan_url meta value.
 * @return string Full URL, or '' when empty.
 */
function bmfitness_resolve_plan_url( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value ) {
		return '';
	}
	if ( preg_match( '#^(https?:)?//#i', $value ) ) {
		return $value;
	}
	return home_url( '/' . ltrim( $value, '/' ) );
}

/**
 * Render a 3-column pricing grid filtered by pricing_section taxonomy slug.
 *
 * @param string $section_slug 'fitness' or 'wellness'.
 */
function bmfitness_render_pricing_grid( $section_slug, $plan_ids = array() ) {
	$query_args = array(
		'post_type'      => 'pricing_plan',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
	);

	if ( ! empty( $plan_ids ) ) {
		// Show only the hand-picked plans, preserving selection order.
		$query_args['post__in'] = array_map( 'absint', $plan_ids );
		$query_args['orderby']  = 'post__in';
	} else {
		// Default: show all plans for the given section.
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'pricing_section',
				'field'    => 'slug',
				'terms'    => sanitize_key( $section_slug ),
			),
		);
	}

	$query = new WP_Query( $query_args );

	$plan_count = $query->found_posts;

	if ( ! $query->have_posts() ) {
		?>
		<div class="grid gap-8 md:grid-cols-3">
			<div class="md:col-span-3 bg-white rounded-xl px-8 py-10 shadow-sm border border-gray-100 text-center text-gray-400 text-sm">
				<?php esc_html_e( 'No pricing plans yet — add some via WP Admin → Pricing Plans.', 'bmfitness' ); ?>
			</div>
		</div>
		<?php
		return;
	}

	// Map plan count to a Tailwind column class.
	// Full class strings (not concatenated) so Tailwind's scanner compiles them all.
	$cols_map = array(
		1 => 'md:grid-cols-1',
		2 => 'md:grid-cols-2',
		3 => 'md:grid-cols-3',
		4 => 'md:grid-cols-4',
	);
	$cols_class = isset( $cols_map[ $plan_count ] ) ? $cols_map[ $plan_count ] : 'md:grid-cols-3';
	?>
	<div class="grid gap-5 md:gap-12 lg:gap-24 <?php echo esc_attr( $cols_class ); ?>">
		<?php while ( $query->have_posts() ) : $query->the_post();
			$description = get_post_meta( get_the_ID(), '_plan_description', true );
			$breakdown   = get_post_meta( get_the_ID(), '_plan_price_breakdown', true );
			$plan_url    = bmfitness_resolve_plan_url( get_post_meta( get_the_ID(), '_plan_url', true ) );
			$old_price   = get_post_meta( get_the_ID(), '_old_price', true );
			$new_price   = get_post_meta( get_the_ID(), '_new_price', true );
		?>
		<div class="relative bg-gray-50 rounded-xl overflow-hidden shadow-sm border border-gray-100 text-center hover:shadow-md transition">
				<?php if ( $plan_url ) : ?>
					<a href="<?php echo esc_url( $plan_url ); ?>" class="absolute inset-0 z-10 w-full h-full">
						<span class="sr-only"><?php the_title(); ?></span>
					</a>
				<?php endif; ?>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="w-full overflow-hidden flex items-center justify-center md:max-w-none bg-white">
					<?php the_post_thumbnail( 'pricing-plan', array(
						'class' => 'w-auto h-full object-cover',
						'alt'   => esc_attr( get_the_title() ),
					) ); ?>
					</div>
				<?php endif; ?>
				<div class="p-3 md:px-8 md:py-8">
					<h3 class="text-lg lg:text-xl font-semibold text-gray-900 mb-1 mx-auto"><?php the_title(); ?></h3>
					<?php if ( $description ) : ?>
						<p class="text-gray-500 mt-1"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>
					<?php if ( $breakdown ) : ?>
						<p class="text-gray-500 lg:text-xl mt-2 mb-2"><?php echo esc_html( $breakdown ); ?></p>
					<?php endif; ?>
					<?php if ( $old_price ) : ?>
						<p class="text-gray-400 line-through mb-2"><?php echo esc_html( $old_price ); ?>&euro;</p>
					<?php endif; ?>
					<?php if ( $new_price ) : ?>
						<p class="text-gray-600 text-2xl lg:text-5xl font-semibold"><?php echo esc_html( $new_price ); ?>&euro;</p>
					<?php endif; ?>
				</div>
			</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
	<?php
}

/**
 * Render a gallery slider filtered by gallery_section taxonomy slug.
 *
 * @param string $section_slug 'fitness' or 'wellness'.
 */
function bmfitness_render_gallery_slider( $section_slug ) {
	$query = new WP_Query( array(
		'post_type'      => 'gallery_image',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'gallery_section',
				'field'    => 'slug',
				'terms'    => sanitize_key( $section_slug ),
			),
		),
	) );
	$slide_count = $query->found_posts;

	if ( $query->have_posts() ) : ?>
		<div class="gallery-slider" style="position:relative;overflow:hidden;border-radius:0.75rem;">
			<div class="gallery-track" style="display:flex;transition:transform 0.5s ease;will-change:transform;">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<div class="gallery-slide" style="min-width:100%;flex-shrink:0;">
						<?php the_post_thumbnail( 'large', array(
							'class' => 'w-full object-cover',
							'style' => 'height:440px;display:block;',
							'alt'   => esc_attr( get_the_title() ),
						) ); ?>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<?php if ( $slide_count > 1 ) : ?>
				<button class="gallery-prev"
					style="position:absolute;left:0;height:100%;top:0;background:rgba(0,0,0,0.15);color:#fff;border:none;border-radius:12px;padding:10px;cursor:pointer;display:flex;align-items:center;"
					aria-label="<?php esc_attr_e( 'Previous slide', 'bmfitness' ); ?>">
					<svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
				</button>
				<button class="gallery-next"
					style="position:absolute;right:0;height:100%;top:0;background:rgba(0,0,0,0.15);color:#fff;border:none;border-radius:12px;padding:10px;cursor:pointer;display:flex;align-items:center;"
					aria-label="<?php esc_attr_e( 'Next slide', 'bmfitness' ); ?>">
					<svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
				</button>
				<div class="gallery-dots" style="position:absolute;bottom:14px;left:0;right:0;display:flex;justify-content:center;gap:8px;">
					<?php for ( $i = 0; $i < $slide_count; $i++ ) : ?>
						<button class="gallery-dot"
							style="width:10px;height:10px;border-radius:9999px;background:#fff;opacity:<?php echo 0 === $i ? '1' : '0.2'; ?>;border:none;padding:0;cursor:pointer;"
							data-index="<?php echo esc_attr( $i ); ?>"
							aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'bmfitness' ), $i + 1 ) ); ?>">
						</button>
					<?php endfor; ?>
				</div>
			<?php endif; ?>
		</div>
	<?php else : ?>
		<div style="height:440px;background:#e5e7eb;border-radius:0.75rem;display:flex;align-items:center;justify-content:center;">
			<p class="text-gray-500 text-sm"><?php esc_html_e( 'No images yet — add some via WP Admin → Gallery.', 'bmfitness' ); ?></p>
		</div>
	<?php endif;
}

/**
 * Output an inline theme SVG icon so it can be styled with CSS/Tailwind.
 *
 * The SVG files in assets/images use fill/stroke="currentColor", so the icon
 * colour is inherited from the surrounding text colour (e.g. Tailwind text-*).
 *
 * @param string $name    Icon filename without extension (e.g. 'instagram').
 * @param string $classes CSS classes applied to the root <svg> element.
 */
function bmfitness_icon( $name, $classes = 'w-6 h-6' ) {
	$name = preg_replace( '/[^a-z0-9\-]/', '', strtolower( $name ) );
	$file = get_theme_file_path( "assets/images/{$name}.svg" );

	if ( ! $name || ! file_exists( $file ) ) {
		return;
	}

	$svg = file_get_contents( $file );

	// Drop the XML prolog (not needed for inline SVG) and inject classes.
	$svg = preg_replace( '/<\?xml.*?\?>\s*/s', '', $svg );
	$svg = preg_replace( '/<svg\b/', '<svg class="' . esc_attr( $classes ) . '"', $svg, 1 );

	echo $svg; // Trusted local theme asset.
}

/**
 * Register the "Pricing Plans" Gutenberg block.
 *
 * This is a dynamic (server-side rendered) block. The editor shows a live
 * preview via ServerSideRender; the frontend output is identical to
 * bmfitness_render_pricing_grid().
 *
 * Usage: in the block editor, open the Block Inserter → Theme → Pricing Plans.
 * Pick the section (Fitness or Wellness) in the sidebar panel.
 */
function bmfitness_register_pricing_block() {
	wp_register_script(
		'bmfitness-pricing-block',
		BMFITNESS_URI . '/assets/js/block-pricing-plans.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n', 'wp-server-side-render', 'wp-data' ),
		BMFITNESS_VERSION,
		true
	);

	register_block_type( 'bmfitness/pricing-plans', array(
		'editor_script'   => 'bmfitness-pricing-block',
		'render_callback' => 'bmfitness_pricing_block_render',
		'attributes'      => array(
			'section_slug' => array(
				'type'    => 'string',
				'default' => 'fitness',
			),
			'plan_ids'     => array(
				'type'    => 'array',
				'default' => array(),
				'items'   => array( 'type' => 'integer' ),
			),
		),
	) );
}
add_action( 'init', 'bmfitness_register_pricing_block' );

/**
 * Server-side render callback for the bmfitness/pricing-plans block.
 *
 * @param array $attributes Block attributes.
 * @return string Rendered pricing grid HTML.
 */
function bmfitness_pricing_block_render( $attributes ) {
	$section_slug = isset( $attributes['section_slug'] ) ? sanitize_key( $attributes['section_slug'] ) : 'fitness';
	$plan_ids     = ( isset( $attributes['plan_ids'] ) && is_array( $attributes['plan_ids'] ) )
		? array_map( 'absint', $attributes['plan_ids'] )
		: array();

	// Apply any extra CSS classes set via the block editor's "Additional CSS class(es)" field.
	$classes = 'bmfitness-pricing-plans';
	if ( ! empty( $attributes['className'] ) ) {
		$classes .= ' ' . $attributes['className'];
	}

	ob_start();
	echo '<div class="' . esc_attr( $classes ) . '">';
	bmfitness_render_pricing_grid( $section_slug, $plan_ids );
	echo '</div>';
	return ob_get_clean();
}

/**
 * Recipient for contact form submissions.
 *
 * Locally, DDEV routes all outbound mail to Mailpit regardless of this address,
 * so it lands in the Mailpit inbox. In production it emails this address.
 * Change the default (or hook the filter) when going live.
 *
 * @return string
 */
function bmfitness_contact_recipient() {
	return apply_filters( 'bmfitness_contact_recipient', 'info@bmfitness.hr' );
}

/**
 * Handle contact form submissions securely via admin-post.php.
 *
 * Security: verifies a nonce (CSRF), uses a honeypot for bots, sanitizes and
 * validates all input, and sends via wp_mail() with a same-domain From header
 * plus a Reply-To for the sender. Uses the POST-redirect-GET pattern so a
 * refresh does not resubmit.
 */
function bmfitness_handle_contact_form() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	// CSRF protection.
	if ( ! isset( $_POST['bmfitness_contact_nonce'] )
		|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bmfitness_contact_nonce'] ) ), 'bmfitness_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', $redirect ) );
		exit;
	}

	// Honeypot: real users leave this hidden field empty; bots fill it.
	// Pretend success so bots do not learn they were caught.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'sent', $redirect ) );
		exit;
	}

	// Sanitize input.
	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	// Validate.
	if ( '' === $name || '' === $message || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'invalid', $redirect ) );
		exit;
	}

	$to      = bmfitness_contact_recipient();
	$subject = sprintf(
		/* translators: %s: sender name */
		__( 'Contact form: %s', 'bmfitness' ),
		$name
	);
	$body = sprintf(
		"Name: %s\nEmail: %s\n\nMessage:\n%s\n",
		$name,
		$email,
		$message
	);

	// From must be on the site domain (SPF/DMARC); Reply-To carries the sender.
	$domain  = wp_parse_url( home_url(), PHP_URL_HOST );
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		sprintf( 'From: %s <no-reply@%s>', get_bloginfo( 'name' ), $domain ),
		sprintf( 'Reply-To: %s <%s>', $name, $email ),
	);

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'contact', $sent ? 'sent' : 'error', $redirect ) );
	exit;
}
add_action( 'admin_post_nopriv_bmfitness_contact', 'bmfitness_handle_contact_form' );
add_action( 'admin_post_bmfitness_contact', 'bmfitness_handle_contact_form' );
