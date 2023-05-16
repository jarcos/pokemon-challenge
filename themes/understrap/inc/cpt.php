<?php
/**
 * Custom Post Type definitions
 *
 * @package Understrap
 * @since 1.0.0
 */

/**
 * Register Custom Post Type
 *
 * @return void
 */
function understrap_register_cpt() {
	$labels = array(
		'name'                  => _x( 'Pokémon', 'Post Type General Name', 'understrap' ),
		'singular_name'         => _x( 'Pokémon', 'Post Type Singular Name', 'understrap' ),
		'menu_name'             => __( 'Pokémon', 'understrap' ),
		'name_admin_bar'        => __( 'Pokémon', 'understrap' ),
		'archives'              => __( 'Pokémon Archives', 'understrap' ),
		'attributes'            => __( 'Pokémon Attributes', 'understrap' ),
		'parent_item_colon'     => __( 'Parent Pokémon:', 'understrap' ),
		'all_items'             => __( 'All Pokémon', 'understrap' ),
		'add_new_item'          => __( 'Add New Pokémon', 'understrap' ),
		'add_new'               => __( 'Add New', 'understrap' ),
		'new_item'              => __( 'New Pokémon', 'understrap' ),
		'edit_item'             => __( 'Edit Pokémon', 'understrap' ),
		'update_item'           => __( 'Update Pokémon', 'understrap' ),
		'view_item'             => __( 'View Pokémon', 'understrap' ),
		'view_items'            => __( 'View Pokémon', 'understrap' ),
		'search_items'          => __( 'Search Pokémon', 'understrap' ),
		'not_found'             => __( 'Not found', 'understrap' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'understrap' ),
		'featured_image'        => __( 'Featured Image', 'understrap' ),
		'set_featured_image'    => __( 'Set featured image', 'understrap' ),
		'remove_featured_image' => __( 'Remove featured image', 'understrap' ),
		'use_featured_image'    => __( 'Use as featured image', 'understrap' ),
		'insert_into_item'      => __( 'Insert into Pokémon', 'understrap' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Pokémon', 'understrap' ),
		'items_list'            => __( 'Pokémon list', 'understrap' ),
		'items_list_navigation' => __( 'Pokémon list navigation', 'understrap' ),
		'filter_items_list'     => __( 'Filter Pokémon list', 'understrap' ),
	);
	$args   = array(
		'label'               => __( 'Pokémon', 'understrap' ),
		'description'         => __( 'A custom post type for Pokémon', 'understrap' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'taxonomies'          => array( 'type', 'region' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-smiley',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => array( 'slug' => 'pokemon' ),
		'capability_type'     => 'post',
	);
	register_post_type( 'pokemon', $args );

	// Register custom taxonomies
	$labels = array(
		'name'                       => 'Attacks',
		'singular_name'              => 'Attack',
		'menu_name'                  => 'Attacks',
		'all_items'                  => 'All Attacks',
		'parent_item'                => 'Parent Attack',
		'parent_item_colon'          => 'Parent Attack:',
		'new_item_name'              => 'New Attack Name',
		'add_new_item'               => 'Add New Attack',
		'edit_item'                  => 'Edit Attack',
		'update_item'                => 'Update Attack',
		'view_item'                  => 'View Attack',
		'separate_items_with_commas' => 'Separate attacks with commas',
		'add_or_remove_items'        => 'Add or remove attacks',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Attacks',
		'search_items'               => 'Search Attacks',
		'not_found'                  => 'No attacks found',
		'no_terms'                   => 'No attacks',
		'items_list'                 => 'Attacks list',
		'items_list_navigation'      => 'Attacks list navigation',
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
	);

	register_taxonomy( 'attack', array( 'pokemon' ), $args );

	$primary_args = array(
		'hierarchical'      => true,
		'labels'            => array(
			'name'              => _x( 'Primary Types', 'taxonomy general name', 'understrap' ),
			'singular_name'     => _x( 'Primary Type', 'taxonomy singular name', 'understrap' ),
			'search_items'      => __( 'Search Primary Types', 'understrap' ),
			'all_items'         => __( 'All Primary Types', 'understrap' ),
			'parent_item'       => __( 'Parent Primary Type', 'understrap' ),
			'parent_item_colon' => __( 'Parent Primary Type:', 'understrap' ),
			'edit_item'         => __( 'Edit Primary Type', 'understrap' ),
			'update_item'       => __( 'Update Primary Type', 'understrap' ),
			'add_new_item'      => __( 'Add New Primary Type', 'understrap' ),
			'new_item_name'     => __( 'New Primary Type Name', 'understrap' ),
			'menu_name'         => __( 'Primary Types', 'understrap' ),
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'primary-type' ),
	);

	register_taxonomy( 'primary-type', array( 'pokemon' ), $primary_args );

	$secondary_args = array(
		'hierarchical'      => true,
		'labels'            => array(
			'name'              => _x( 'Secondary Types', 'taxonomy general name', 'understrap' ),
			'singular_name'     => _x( 'Secondary Type', 'taxonomy singular name', 'understrap' ),
			'search_items'      => __( 'Search Secondary Types', 'understrap' ),
			'all_items'         => __( 'All Secondary Types', 'understrap' ),
			'parent_item'       => __( 'Parent Secondary Type', 'understrap' ),
			'parent_item_colon' => __( 'Parent Secondary Type:', 'understrap' ),
			'edit_item'         => __( 'Edit Secondary Type', 'understrap' ),
			'update_item'       => __( 'Update Secondary Type', 'understrap' ),
			'add_new_item'      => __( 'Add New Secondary Type', 'understrap' ),
			'new_item_name'     => __( 'New Secondary Type Name', 'understrap' ),
			'menu_name'         => __( 'Secondary Types', 'understrap' ),
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'secondary-type' ),
	);

	register_taxonomy( 'secondary-type', array( 'pokemon' ), $secondary_args );

}
add_action( 'init', 'understrap_register_cpt' );

/**
 * Register the new menu item under the Pokémons CPT
 *
 * @return void
 */
function understrap_register_menu() {
	add_submenu_page(
		'edit.php?post_type=pokemon',
		__( 'Fetch Pokémons', 'understrap' ),
		__( 'Fetch Pokémons', 'understrap' ),
		'manage_options',
		'fetch-pokemon',
		'understrap_fetch_pokemon_page'
	);
}
add_action( 'admin_menu', 'understrap_register_menu' );

/**
 * Draws the HTML on the menu page
 *
 * @return void
 */
function understrap_fetch_pokemon_page() {
	echo '<div class="wrap">';
	echo '<h2>Fetch Pokémons</h2>';
	echo '<br>';
	echo '<table id="pokemonList" class="widefat"><thead><th class="row-title">ID</th><th class="row-title">Pokemon</th><th class="row-title">Image</th><th class="row-title">Description</th><th class="row-title">Primary Type</th><th class="row-title">Secondary Type</th><th class="row-title">Attacks</th><th class="row-title">Weight</th><th class="row-title">Old Pokedex Version</th><th class="row-title">New Pokedex Version</th></thead><tbody></tbody></table>';
	echo '<input id="fetchPokemonsBtn" class="button-primary" type="submit" name="fetch" value="' . esc_attr( 'Fetch from PokeAPI' ) . '" />';
	echo '<p>Please, be aware that every time you click this button, three new Pokémons will be added to the database.</p>';
	echo '<div class="spinner" style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:15px 0;"></div>';
	echo '</div>';
}

/**
 * Add the Pokémon properties meta box
 *
 * @return void
 */
function add_pokemon_meta_boxes() {
	add_meta_box( 'pokemon_properties', 'Pokémon Properties', 'pokemon_properties_callback', 'pokemon', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'add_pokemon_meta_boxes' );

/**
 * Callback function to draw the HTML for the Pokémon properties meta box
 *
 * @param object $post Post object
 * @return void
 */
function pokemon_properties_callback( $post ) {
	// Retrieve the current values of Pokémon properties
	$pokemon_id                 = get_post_meta( $post->ID, 'pokemon_id', true );
	$pokemon_weight             = get_post_meta( $post->ID, 'pokemon_weight', true );
	$pokemon_old_pokedex_number = get_post_meta( $post->ID, 'pokemon_old_pokedex_number', true );
	$pokemon_new_pokedex_number = get_post_meta( $post->ID, 'pokemon_new_pokedex_number', true );

	// Output the Pokémon properties fields
	?>
	<table class="form-table">
		<tr>
			<th scope="row">
				<label for="pokemon-id"><?php esc_html_e( 'ID:', 'understrap' ); ?></label>
			</th>
			<td>
				<input type="text" name="pokemon_id" id="pokemon-id" value="<?php echo esc_attr( $pokemon_id ); ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pokemon-weight"><?php esc_html_e( 'Weight:', 'understrap' ); ?></label>
			</th>
			<td>
				<input type="text" name="pokemon_weight" id="pokemon-weight" value="<?php echo esc_attr( $pokemon_weight ); ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pokemon-old-pokedex-number"><?php esc_html_e( 'Pokedex Number (Old Version):', 'understrap' ); ?></label>
			</th>
			<td>
				<input type="text" name="pokemon_old_pokedex_number" id="pokemon-old-pokedex-number" value="<?php echo esc_attr( $pokemon_old_pokedex_number ); ?>" />
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="pokemon-new-pokedex-number"><?php esc_html_e( 'Pokedex Number (New Version):', 'understrap' ); ?></label>
			</th>
			<td>
				<input type="text" name="pokemon_new_pokedex_number" id="pokemon-new-pokedex-number" value="<?php echo esc_attr( $pokemon_new_pokedex_number ); ?>" />
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Saves the Pokémon properties when the post is saved or updated
 *
 * @param int $post_id The ID of the post being saved
 * @return void
 */
function save_pokemon_properties( $post_id ) {
	// Save the Pokémon properties when the post is saved or updated
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Make sure the user has permission to save the post
	if ( isset( $_POST['post_type'] ) && 'pokemon' === $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Save the Pokémon properties
		if ( isset( $_POST['pokemon_photo'] ) ) {
			update_post_meta( $post_id, 'pokemon_photo', sanitize_text_field( $_POST['pokemon_photo'] ) );
		}

		if ( isset( $_POST['pokemon_name'] ) ) {
			update_post_meta( $post_id, 'pokemon_name', sanitize_text_field( $_POST['pokemon_name'] ) );
		}

		if ( isset( $_POST['pokemon_description'] ) ) {
			update_post_meta( $post_id, 'pokemon_description', sanitize_textarea_field( $_POST['pokemon_description'] ) );
		}

		if ( isset( $_POST['pokemon_primary_type'] ) ) {
			update_post_meta( $post_id, 'pokemon_primary_type', sanitize_text_field( $_POST['pokemon_primary_type'] ) );
		}

		if ( isset( $_POST['pokemon_secondary_type'] ) ) {
			update_post_meta( $post_id, 'pokemon_secondary_type', sanitize_text_field( $_POST['pokemon_secondary_type'] ) );
		}

		if ( isset( $_POST['pokemon_weight'] ) ) {
			update_post_meta( $post_id, 'pokemon_weight', sanitize_text_field( $_POST['pokemon_weight'] ) );
		}

		if ( isset( $_POST['pokemon_old_pokedex_number'] ) ) {
			update_post_meta( $post_id, 'pokemon_old_pokedex_number', sanitize_text_field( $_POST['pokemon_old_pokedex_number'] ) );
		}

		if ( isset( $_POST['pokemon_new_pokedex_number'] ) ) {
			update_post_meta( $post_id, 'pokemon_new_pokedex_number', sanitize_text_field( $_POST['pokemon_new_pokedex_number'] ) );
		}

		if ( isset( $_POST['pokemon_attacks'] ) ) {
			update_post_meta( $post_id, 'pokemon_attacks', sanitize_textarea_field( $_POST['pokemon_attacks'] ) );
		}
	}
}
