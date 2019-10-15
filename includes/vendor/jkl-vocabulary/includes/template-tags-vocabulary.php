<?php
/**
 * JKL Vocabulary Template Tags.
 *
 * @package K2K
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create a button (or link) for the custom meta value.
 *
 * @param array  $meta The array of data to create a button for.
 * @param string $name The name of the taxonomy (used for correct permalinks).
 */
function get_vocabulary_meta_buttons( $meta, $name = '' ) {

	$classnames = '';

	$output  = '<a class="' . $classnames . '" title="' . $meta['name'];
	$output .= '" href="' . home_url() . '/' . $name . '/' . $meta['slug'] . '/';
	$output .= '">';

	if ( array_key_exists( 'translation', $meta ) ) {
		$output .= $meta['translation'];
	} else {
		$output .= $meta['name'];
	}

	$output .= '</a>';

	return $output;

}

/**
 * Function to return links of related terms.
 *
 * @param array $meta An array of linked vocabulary meta data.
 */
function get_linked_terms( $meta ) {

	$output = '';

	foreach ( $meta as $item ) {
		$post    = get_post( $item );
		$output .= '<li>';
		$output .= '<a class="btn button" rel="tag" href="' . get_the_permalink( $post->ID ) . '">' . $post->post_title . '</a>';
		$output .= '</li>';
	}

	return $output;

}

/**
 * Function to return a list of related terms.
 *
 * @param array $meta An array of unlinked vocabulary meta data.
 */
function get_unlinked_terms( $meta ) {

	$output = '';

	$items = explode( ',', $meta );
	foreach ( $items as $item ) {
		$output .= '<li>' . $item . '</li>';
	}

	return $output;

}

/**
 * Function to output the meta data at the top of the flashcard.
 *
 * @param array $meta An array of vocabulary meta data.
 */
function display_vocabulary_top_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_vocabulary_get_meta_data();
	}

	if ( jkl_has_vocabulary_meta( $meta ) ) {
		?>
		<ul class="vocabulary-meta">
		<?php
			echo array_key_exists( 'level', $meta )
				? '<li>' . wp_kses_post( get_vocabulary_meta_buttons( $meta['level'], 'level' ) ) . '</li>'
				: '';
			echo array_key_exists( 'part-of-speech', $meta )
				? '<li>' . wp_kses_post( get_vocabulary_meta_buttons( $meta['part-of-speech'], 'part-of-speech' ) ) . '</li>'
				: '';
			echo array_key_exists( 'topic', $meta )
				? '<li>' . wp_kses_post( get_vocabulary_meta_buttons( $meta['topic'], 'topic' ) ) . '</li>'
				: '';
			echo array_key_exists( 'vocab-group', $meta )
				? '<li class="vocab-group">' . wp_kses_post( get_vocabulary_meta_buttons( $meta['vocab-group'], 'vocab-group' ) ) . '</li>'
				: '';
		?>
		</ul>
		<?php
	}

}

/**
 * Function to output the related data at the bottom of the vocabulary post.
 *
 * @param array $meta An array of vocabulary meta data.
 */
function display_vocabulary_related_meta( $meta = [] ) {

	if ( empty( $meta ) ) {
		$meta = jkl_vocabulary_get_meta_data();
	}

	$prefix = 'k2k_vocab_meta_';

	// Related Words.
	if ( array_key_exists( 'related', $meta ) ) {
		echo '<ul class="related-terms">';
		esc_html_e( 'Related Words: ', 'k2k' );
		echo wp_kses_post( get_linked_terms( $meta['related'][0][ $prefix . 'related_linked' ] ) );
		echo wp_kses_post( get_unlinked_terms( $meta['related'][0][ $prefix . 'related_unlinked' ] ) );
		echo '</ul>';
	}

	// Synonyms.
	if ( array_key_exists( 'synonyms', $meta ) ) {
		echo '<ul class="related-terms">';
		esc_html_e( 'Synonyms: ', 'k2k' );
		echo wp_kses_post( get_linked_terms( $meta['synonyms'][0][ $prefix . 'synonyms_linked' ] ) );
		echo wp_kses_post( get_unlinked_terms( $meta['synonyms'][0][ $prefix . 'synonyms_unlinked' ] ) );
		echo '</ul>';
	}

	// Antonyms.
	if ( array_key_exists( 'antonyms', $meta ) ) {
		echo '<ul class="related-terms">';
		esc_html_e( 'Antonyms: ', 'k2k' );
		echo wp_kses_post( get_linked_terms( $meta['antonyms'][0][ $prefix . 'antonyms_linked' ] ) );
		echo wp_kses_post( get_unlinked_terms( $meta['antonyms'][0][ $prefix . 'antonyms_unlinked' ] ) );
		echo '</ul>';
	}

	// Hanja.
	if ( array_key_exists( 'hanja', $meta ) ) {
		echo '<ul class="related-terms">';
		esc_html_e( 'Hanja: ', 'k2k' );
		echo wp_kses_post( get_linked_terms( $meta['hanja'][0][ $prefix . 'hanja_linked' ] ) );
		echo wp_kses_post( get_unlinked_terms( $meta['hanja'][0][ $prefix . 'hanja_unlinked' ] ) );
		echo '</ul>';
	}

}

/**
 * Custom Search Form for Vocabulary Post Type.
 */
function display_vocabulary_search_form() {
	?>
	<form action="/" method="get" class="vocabulary-search">
		<label for="search" class="screen-reader-text"><?php esc_html_e( 'Search Vocabulary', 'k2k' ); ?></label>
		<input type="text" name="s" id="search" placeholder="<?php esc_html_e( 'Search Vocabulary', 'k2k' ); ?>" value="<?php the_search_query(); ?>" />
		<!-- <input type="submit" value="<?php esc_html_e( 'Search', 'k2k' ); ?>" /> -->
		<input type="hidden" value="k2k-vocabulary" name="post_type" id="post_type" />
	</form>
	<?php
}

/**
 * Custom navigation for Vocabulary Post Type.
 *
 * Default Taxonomy is 'Level' - but can pass in a different taxonomy if desired.
 * Possible taxonomies for Vocabulary are 'Level', 'Part-of-Speech', 'Topic', 'Vocab-Group'.
 *
 * @param string $taxonomy The taxonomy to display post navigation for.
 */
function display_vocabulary_navigation( $taxonomy = 'k2k-part-of-speech' ) {
	?>
	<nav id="nav-above" class="navigation post-navigation vocabulary-navigation" role="navigation">
		<p class="screen-reader-text"><?php esc_html_e( 'Vocabulary Navigation', 'k2k' ); ?></p>
		<div class="nav-index">
			<span class="meta-nav"><a href="<?php echo esc_url( get_home_url() ) . '/vocabulary/'; ?>"><?php esc_html_e( 'Vocabulary Index', 'jkl-grammar' ); ?></a></span>
		</div>
		<div class="nav-links">
			<div class="nav-previous">
				<?php previous_post_link( '%link', '&#9668; %title', true, '', $taxonomy ); ?>
			</div>
			<div class="nav-next">
				<?php next_post_link( '%link', '%title &#9658;', true, '', $taxonomy ); ?>
			</div>
		</div>
	</nav><!-- #nav-above -->
	<?php
}
