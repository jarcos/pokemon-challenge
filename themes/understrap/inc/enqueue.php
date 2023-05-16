<?php
/**
 * Understrap enqueue scripts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'understrap_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function understrap_scripts() {
		// Get the theme data.
		$the_theme         = wp_get_theme();
		$theme_version     = $the_theme->get( 'Version' );
		$bootstrap_version = get_theme_mod( 'understrap_bootstrap_version', 'bootstrap4' );
		$suffix            = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Grab asset urls.
		$theme_styles  = "/css/theme{$suffix}.css";
		$theme_scripts = "/js/theme{$suffix}.js";
		if ( 'bootstrap4' === $bootstrap_version ) {
			$theme_styles  = "/css/theme-bootstrap4{$suffix}.css";
			$theme_scripts = "/js/theme-bootstrap4{$suffix}.js";
		}

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . $theme_styles ); // @phpstan-ignore-line -- file exists
		wp_enqueue_style( 'understrap-styles', get_template_directory_uri() . $theme_styles, array(), $css_version );

		// Fix that the offcanvas close icon is hidden behind the admin bar.
		if ( 'bootstrap4' !== $bootstrap_version && is_admin_bar_showing() ) {
			understrap_offcanvas_admin_bar_inline_styles();
		}

		wp_enqueue_script( 'jquery' );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . $theme_scripts ); // @phpstan-ignore-line -- file exists
		wp_enqueue_script( 'understrap-scripts', get_template_directory_uri() . $theme_scripts, array(), $js_version, true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // End of if function_exists( 'understrap_scripts' ).

add_action( 'wp_enqueue_scripts', 'understrap_scripts' );

if ( ! function_exists( 'understrap_offcanvas_admin_bar_inline_styles' ) ) {
	/**
	 * Add inline styles for the offcanvas component if the admin bar is visibile.
	 *
	 * Fixes that the offcanvas close icon is hidden behind the admin bar.
	 *
	 * @since 1.2.0
	 */
	function understrap_offcanvas_admin_bar_inline_styles() {
		$navbar_type = get_theme_mod( 'understrap_navbar_type', 'collapse' );
		if ( 'offcanvas' !== $navbar_type ) {
			return;
		}

		$css = '
		body.admin-bar .offcanvas.show  {
			margin-top: 32px;
		}
		@media screen and ( max-width: 782px ) {
			body.admin-bar .offcanvas.show {
				margin-top: 46px;
			}
		}';
		wp_add_inline_style( 'understrap-styles', $css );
	}
}

/**
 * Enqueue Admin Scripts
 *
 * @return void
 */
function understrap_admin_scripts() {
	wp_enqueue_style( 'admin-styles', get_stylesheet_directory_uri() . '/css/admin-styles.css' );

	wp_enqueue_script( 'admin-script', get_stylesheet_directory_uri() . '/js/fetch-pokemon.js', array(), time(), true );

	$ajax_object = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'ajax-nonce' ),
		'hook'     => 'understrap_fetch_pokemon_ajax',
	);

	$inline_script = 'const ajax_object = ' . wp_json_encode( $ajax_object ) . ';';

	wp_add_inline_script( 'admin-script', $inline_script );
}
add_action( 'admin_enqueue_scripts', 'understrap_admin_scripts' );

/**
 * Enqueue Pokemon Scripts
 *
 * @return void
 */
function understrap_pokemon_scripts() {
	if ( is_singular( 'pokemon' ) ) {
		wp_enqueue_script( 'pokemon-script', get_stylesheet_directory_uri() . '/js/fetch-old-pokedex-num.js', array(), time(), true );

		$ajax_object   = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'ajax-nonce' ),
			'hook'     => 'understrap_fetch_old_pokedex_num_ajax',
		);
		$inline_script = 'const ajax_object = ' . wp_json_encode( $ajax_object ) . ';';

		wp_add_inline_script( 'pokemon-script', $inline_script );
	}
}
add_action( 'wp_enqueue_scripts', 'understrap_pokemon_scripts' );
