<?php
/**
 * Ajax Request handler
 *
 * @package Understrap
 * @since 1.0.0
 */

function understrap_fetch_pokemon() {
	// Verify the nonce
	$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
	if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
		die( 'You are not allowed to see this page!' );
	}

	// Access the body data
	$pokemonListJson = isset( $_POST['pokemonList'] ) ? sanitize_text_field( $_POST['pokemonList'] ) : '';

	// Decode the JSON data
	$pokemonList = json_decode( stripslashes( $pokemonListJson ), true );
	// Insert pokemon in the database
	$pokemon_data = array();

	foreach ( $pokemonList as $pokemon ) {
		// Check if the pokemon already exists
		$pokemonExists = new WP_Query(
			array(
				'post_type'      => 'pokemon',
				'posts_per_page' => 1,
				'meta_key'       => 'pokemon_id',
				'meta_value'     => $pokemon['id'],
			)
		);
		if ( ! empty( $pokemonExists->posts ) ) {
			continue; // Skip this iteration if the Pokemon already exists
		}

		// Create the post object
		$my_post = array(
			'post_title'   => sanitize_text_field( $pokemon['name'] ),
			'post_type'    => 'pokemon',
			'post_status'  => 'publish',
			'post_content' => sanitize_textarea_field( $pokemon['description'] ),
			'meta_input'   => array(
				'pokemon_id'                 => absint( $pokemon['id'] ),
				'pokemon_weight'             => sanitize_text_field( $pokemon['weight'] ),
				'pokemon_old_pokedex_number' => sanitize_text_field( $pokemon['oldVersionPokedexNumber'] ),
				'pokemon_new_pokedex_number' => sanitize_text_field( $pokemon['newVersionPokedexNumber'] ),
			),
		);

		// Insert the post into the database
		$new_pokemon_id = wp_insert_post( $my_post );

		if ( ! is_wp_error( $new_pokemon_id ) ) {
			// Set the featured image
			$pokemon_image = media_sideload_image( $pokemon['url'], $new_pokemon_id, sanitize_title( $pokemon['name'] ), 'id' );
			if ( ! is_wp_error( $pokemon_image ) ) {
				set_post_thumbnail( $new_pokemon_id, $pokemon_image );
			}

			// Set object terms and update term meta for attacks
			wp_set_object_terms( $new_pokemon_id, sanitize_text_field( $pokemon['primaryType'] ), 'primary-type' );
			wp_set_object_terms( $new_pokemon_id, sanitize_text_field( $pokemon['secondaryType'] ), 'secondary-type' );

			foreach ( $pokemon['attacks'] as $attack ) {
				$term_name = sanitize_text_field( $attack[0] );
				$term_exists = term_exists( $term_name, 'attack' );

				if ( $term_exists ) {
					$term_id = $term_exists['term_id'];
				} else {
					$term = wp_insert_term( $term_name, 'attack', array('description' => $attack[1]) );
				}

				wp_set_object_terms( $new_pokemon_id, $attack[0], 'attack', true );
			}


			$pokemon_data[] = array(
				'id'   => $new_pokemon_id,
				'name' => $pokemon['name'],
			);
		} else {
			// Error occurred during media sideloading
			$pokemon_data[] = array(
				'id'      => 0,
				'name'    => $pokemon['name'],
				'message' => 'Error occurred while setting the featured image.',
			);
		}
	}

	// Send the JSON response after the loop finishes
	if ( ! empty( $pokemon_data ) ) {
		wp_send_json_success( $pokemon_data );
	} else {
		wp_send_json_error( array( 'message' => 'No new Pokémon added.' ) );
	}

	wp_die();
}

add_action( 'wp_ajax_understrap_fetch_pokemon_ajax', 'understrap_fetch_pokemon' );
add_action( 'wp_ajax_nopriv_understrap_fetch_pokemon_ajax', 'understrap_fetch_pokemon' );


/**
 * Fetch the old pokedex number for a pokemon
 *
 * @return void
 */
function understrap_fetch_pokedex_num() {
	// Verify the nonce
	$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
	if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
		die( 'You are not allowed to see this page!' );
	}

	// Get the pokedex number
	$pokemon_old_pokedex_number = get_post_meta( $_POST['pokemonId'], 'pokemon_old_pokedex_number', true );

	// Send the JSON response
	if ( ! empty( $pokemon_old_pokedex_number ) ) {
		wp_send_json_success( array(
			'success' => true,
			'pokemon_old_pokedex_number' => $pokemon_old_pokedex_number
		));
	} else {
		wp_send_json_error( array( 'message' => 'No old pokedex number found.' ) );
	}
}
add_action('wp_ajax_understrap_fetch_old_pokedex_num_ajax', 'understrap_fetch_pokedex_num');
add_action('wp_ajax_nopriv_understrap_fetch_old_pokedex_num_ajax', 'understrap_fetch_pokedex_num');
