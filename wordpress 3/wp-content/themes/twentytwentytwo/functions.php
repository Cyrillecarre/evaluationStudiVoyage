<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */


if ( ! function_exists( 'twentytwentytwo_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );
	}

endif;

add_action( 'after_setup_theme', 'twentytwentytwo_support' );

if ( ! function_exists( 'twentytwentytwo_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'twentytwentytwo-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'twentytwentytwo-style' );
	}

endif;

add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';

function afficher_categories_sous_categories_shortcode() {
    $output = '';

    $categories = get_categories(array(
        'hide_empty' => 0,
        'parent'     => 0,
    ));

    foreach ($categories as $category) {
        $output .= '<h2>' . $category->name . '</h2>'; // Afficher le nom de la catégorie parente

        // Récupérer les sous-catégories de la catégorie parente
        $subcategories = get_categories(array(
            'hide_empty' => 0,
            'parent'     => $category->term_id,
        ));

        if (!empty($subcategories)) {
            $output .= '<ul>';
            foreach ($subcategories as $subcategory) {
                $output .= '<li><a href="' . get_category_link($subcategory->term_id) . '">' . $subcategory->name . '</a></li>';
            }
            $output .= '</ul>';
        }
    }

    return $output;
}
add_shortcode('afficher_categories_sous_categories', 'afficher_categories_sous_categories_shortcode');
