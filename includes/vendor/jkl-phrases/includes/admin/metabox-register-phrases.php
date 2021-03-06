<?php
/**
 * K2K - Register Phrases Metabox.
 *
 * @package K2K
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'cmb2_admin_init', 'k2k_register_metabox_phrases' );
/**
 * Register a custom metabox for the 'k2k' Post Type.
 *
 * @link https://github.com/CMB2/CMB2/wiki
 */
function k2k_register_metabox_phrases() {

	$prefix = 'k2k_phrase_meta_';

	$k2k_metabox = new_cmb2_box(
		array(
			'id'           => $prefix . 'metabox',
			'title'        => esc_html__( 'Phrases Meta', 'k2k' ),
			'object_types' => array( 'k2k-phrases' ),
			'closed'       => false,
		)
	);

	/**
	 * Info - Translation
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Literal Translation (EN)', 'k2k' ),
			'desc' => esc_html__( 'The translation will be used as the subtitle.', 'k2k' ),
			'id'   => $prefix . 'translation',
			'type' => 'text',
		)
	);

	/**
	 * Info - Meaning (Subtitle)
	 */
	$k2k_metabox->add_field(
		array(
			'name'   => esc_html__( 'Meaning (EN)', 'k2k' ),
			'desc'   => esc_html__( 'If present, the meaning of the phrase will be used as the subtitle (not the literal translation above).', 'k2k' ),
			'id'     => $prefix . 'meaning',
			'type'   => 'text',
			'column' => array( 'position' => 2 ),
		)
	);

	/**
	 * Info - Meaning (Korean)
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Meaning (KO)', 'k2k' ),
			'desc' => esc_html__( 'The meaning in Korean, if applicable.', 'k2k' ),
			'id'   => $prefix . 'meaning_ko',
			'type' => 'text',
		)
	);

	/**
	 * Info - Related Hanja
	 */
	$k2k_metabox->add_field(
		array(
			'name' => esc_html__( 'Related Hanja', 'k2k' ),
			'desc' => esc_html__( 'Add hanja from or related to the phrase here.', 'k2k' ),
			'id'   => $prefix . 'hanja',
			'type' => 'text',
		)
	);

	/**
	 * Info - Topic Selection
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Topic', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'topic',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-phrase-topic', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Info - Detailed Description
	 */
	$k2k_metabox->add_field(
		array(
			'name'            => esc_html__( 'Detailed Explanation / Usage', 'k2k' ),
			// 'desc'    => esc_html__( 'Leave fields blank if no conjugations.', 'k2k' ),
			'id'              => $prefix . 'wysiwyg',
			'type'            => 'wysiwyg',
			'options'         => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => get_option( 'default_post_edit_rows', 5 ),
			),
			'sanitization_cb' => false,
		)
	);

	/**
	 * Info - Phrase Type
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Phrase Type', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'type',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-phrase-type', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

	/**
	 * Info - Keywords
	 */
	$k2k_metabox->add_field(
		array(
			'name'     => esc_html__( 'Keywords', 'k2k' ),
			// 'desc'     => esc_html__( 'field description (optional)', 'k2k' ),
			'id'       => $prefix . 'keywords',
			'type'     => 'taxonomy_radio_inline',
			'taxonomy' => 'k2k-phrase-keywords', // Taxonomy Slug.
			// 'inline'   => true, // Toggles display to inline.
		)
	);

}
