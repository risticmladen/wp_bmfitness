<?php
/**
 * Partner logo management.
 *
 * @package BMFitness
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bmfitness_register_partners() {
	register_post_type( 'bmfitness_partner', array(
		'labels' => array(
			'name'                  => __( 'Partners', 'bmfitness' ),
			'singular_name'         => __( 'Partner', 'bmfitness' ),
			'add_new_item'          => __( 'Add New Partner', 'bmfitness' ),
			'edit_item'             => __( 'Edit Partner', 'bmfitness' ),
			'all_items'             => __( 'All Partners', 'bmfitness' ),
			'not_found'             => __( 'No partners found.', 'bmfitness' ),
			'featured_image'        => __( 'Partner logo', 'bmfitness' ),
			'set_featured_image'    => __( 'Set partner logo', 'bmfitness' ),
			'remove_featured_image' => __( 'Remove partner logo', 'bmfitness' ),
			'use_featured_image'    => __( 'Use as partner logo', 'bmfitness' ),
		),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'rewrite'         => false,
		'menu_icon'       => 'dashicons-groups',
		'menu_position'   => 22,
		'supports'        => array( 'title', 'thumbnail', 'page-attributes' ),
	) );
}
add_action( 'init', 'bmfitness_register_partners' );

function bmfitness_partner_meta_boxes() {
	add_meta_box(
		'bmfitness_partner_details',
		__( 'Partner details', 'bmfitness' ),
		'bmfitness_partner_details_html',
		'bmfitness_partner',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_bmfitness_partner', 'bmfitness_partner_meta_boxes' );

function bmfitness_partner_details_html( $post ) {
	wp_nonce_field( 'bmfitness_save_partner', 'bmfitness_partner_nonce' );
	?>
	<p>
		<label for="bmfitness-partner-url"><?php esc_html_e( 'Partner website URL', 'bmfitness' ); ?></label>
		<input type="url" class="widefat" id="bmfitness-partner-url" name="bmfitness_partner_url"
			value="<?php echo esc_attr( get_post_meta( $post->ID, '_bmfitness_partner_url', true ) ); ?>"
			placeholder="https://example.com">
	</p>
	<p class="description"><?php esc_html_e( 'Set a partner name and logo. The website link is optional. Only published partners with a logo appear on the homepage.', 'bmfitness' ); ?></p>
	<p class="description"><?php esc_html_e( 'Use the Order field in Attributes to change the logo position (lower numbers appear first). Partners with the same order are sorted by name. Use Move to Trash to remove a partner.', 'bmfitness' ); ?></p>
	<?php
}

function bmfitness_save_partner( $post_id ) {
	if ( ! isset( $_POST['bmfitness_partner_nonce'] ) || ! is_string( $_POST['bmfitness_partner_nonce'] )
		|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bmfitness_partner_nonce'] ) ), 'bmfitness_save_partner' )
		|| ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		|| wp_is_post_revision( $post_id )
		|| ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['bmfitness_partner_url'] ) && is_string( $_POST['bmfitness_partner_url'] ) ) {
		$url = esc_url_raw( trim( wp_unslash( $_POST['bmfitness_partner_url'] ) ), array( 'http', 'https' ) );
		update_post_meta( $post_id, '_bmfitness_partner_url', $url );
	}
}
add_action( 'save_post_bmfitness_partner', 'bmfitness_save_partner' );

function bmfitness_partner_columns( $columns ) {
	$columns['partner_logo']  = __( 'Logo', 'bmfitness' );
	$columns['partner_order'] = __( 'Order', 'bmfitness' );
	return $columns;
}
add_filter( 'manage_bmfitness_partner_posts_columns', 'bmfitness_partner_columns' );

function bmfitness_partner_column_content( $column, $post_id ) {
	if ( 'partner_logo' === $column ) {
		echo get_the_post_thumbnail( $post_id, array( 80, 50 ), array( 'style' => 'max-width:80px;height:50px;object-fit:contain;' ) );
	} elseif ( 'partner_order' === $column ) {
		echo esc_html( get_post_field( 'menu_order', $post_id ) );
	}
}
add_action( 'manage_bmfitness_partner_posts_custom_column', 'bmfitness_partner_column_content', 10, 2 );

function bmfitness_partner_admin_order( $query ) {
	if ( is_admin() && $query->is_main_query() && 'bmfitness_partner' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
		$query->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC', 'ID' => 'ASC' ) );
	}
}
add_action( 'pre_get_posts', 'bmfitness_partner_admin_order' );
