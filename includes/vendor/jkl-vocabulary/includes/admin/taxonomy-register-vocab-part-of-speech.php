<?php
/**
 * K2K - Register Vocabulary Part of Speech Taxonomy.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create Vocabulary Part of Speech taxonomy.
 *
 * @see register_post_type() for registering custom post types.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function k2k_register_taxonomy_vocab_ps() {

	// PARTS OF SPEECH taxonomy, make it hierarchical (like categories).
	$labels = array(
		'name'                       => _x( 'Vocabulary Part of Speech', 'taxonomy general name', 'k2k' ),
		'singular_name'              => _x( 'Vocabulary Part of Speech', 'taxonomy singular name', 'k2k' ),
		'search_items'               => __( 'Search Vocabulary Parts of Speech', 'k2k' ),
		'popular_items'              => __( 'Popular Vocabulary Parts of Speech', 'k2k' ),
		'all_items'                  => __( 'All Vocabulary Parts of Speech', 'k2k' ),
		'parent_item'                => __( 'Parent Vocabulary Part of Speech', 'k2k' ),
		'parent_item_colon'          => __( 'Parent Vocabulary Part of Speech:', 'k2k' ),
		'edit_item'                  => __( 'Edit Vocabulary Part of Speech', 'k2k' ),
		'update_item'                => __( 'Update Vocabulary Part of Speech', 'k2k' ),
		'add_new_item'               => __( 'Add New Vocabulary Part of Speech', 'k2k' ),
		'new_item_name'              => __( 'New Vocabulary Part of Speech Name', 'k2k' ),
		'separate_items_with_commas' => __( 'Separate Vocabulary Parts of Speech with commas', 'k2k' ),
		'add_or_remove_items'        => __( 'Add or remove Vocabulary Parts of Speech', 'k2k' ),
		'choose_from_most_used'      => __( 'Choose from the most used Vocabulary Parts of Speech', 'k2k' ),
		'not_found'                  => __( 'No Vocabulary Parts of Speech found.', 'k2k' ),
		'menu_name'                  => __( 'Parts of Speech', 'k2k' ),
		'view_item'                  => __( 'View Vocabulary Part of Speech', 'k2k' ),
		'back_to_items'              => __( '← Back to Vocabulary Parts of Speech', 'k2k' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'show_in_rest'          => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'vocabulary/part-of-speech' ),
	);

	register_taxonomy( 'k2k-vocab-part-of-speech', 'k2k-vocabulary', $args );

}
add_action( 'init', 'k2k_register_taxonomy_vocab_ps' );

/**
 * Add Terms to taxonomy.
 */
function k2k_register_new_terms_vocab_ps() {

	$taxonomy = 'k2k-vocab-part-of-speech';
	$terms    = array(
		'0' => array(
			'name'        => __( 'Noun', 'k2k' ),
			'slug'        => 'vocab-noun',
			'description' => __( 'Nouns', 'k2k' ),
		),
		'1' => array(
			'name'        => __( 'Verb', 'k2k' ),
			'slug'        => 'vocab-verb',
			'description' => __( 'Verbs', 'k2k' ),
		),
		'2' => array(
			'name'        => __( 'Adjective', 'k2k' ),
			'slug'        => 'vocab-adjective',
			'description' => __( 'Adjectives', 'k2k' ),
		),
		'3' => array(
			'name'        => __( 'Adverb', 'k2k' ),
			'slug'        => 'vocab-adverb',
			'description' => __( 'Adverbs', 'k2k' ),
		),
	);

	foreach ( $terms as $term ) {

		if ( ! term_exists( $term['slug'], $taxonomy ) ) {

			wp_insert_term(
				$term['name'], // The term.
				$taxonomy,     // The taxonomy.
				array(
					'description' => $term['description'],
					'slug'        => $term['slug'],
				)
			);

			unset( $term );

		}
	}
}
if ( 'on' === k2k_get_option( 'k2k_use_default_terms' ) && 'on' === k2k_get_option( 'k2k_enable_vocab' ) ) {
	add_action( 'init', 'k2k_register_new_terms_vocab_ps' );
}
