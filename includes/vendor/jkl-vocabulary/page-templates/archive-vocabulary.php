<?php
/**
 * The template for displaying Vocabulary archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package K2K
 */

get_header(); ?>

	<main id="primary" class="site-main">

	<?php
	if ( have_posts() ) :

		/* Display the appropriate header when required. */
		k2k_index_header();

		require_once 'sidebar-vocabulary.php';

		echo '<ul class="vocabulary-posts-grid archive-posts-grid">';

		/* Start the "Official" Loop */
		$count = 0;
		while ( have_posts() && $count < 40 ) :
			the_post();

			/*
			 * Include the component stylesheet for the content.
			 * This call runs only once on index and archive pages.
			 * At some point, override functionality should be built in similar to the template part below.
			 */
			wp_print_styles( array( 'gaya-content' ) ); // Note: If this was already done it will be skipped.

			/*
			 * Include the Post-Type-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
			 */
			?>
			<li class="vocabulary-item" style="grid-columns: span 4;">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php
					$part_of_speech = get_vocab_part_of_speech();

					if ( '' !== $part_of_speech ) {
						?>
						<a class="part-of-speech part-of-speech-circle <?php echo esc_attr( strtolower( $part_of_speech['name'] ) ); ?>"
							href="/part-of-speech/<?php echo esc_attr( $part_of_speech['slug'] ); ?>">
							<?php echo esc_attr( $part_of_speech['letter'] ); ?>
						</a>
					<?php } ?>

					<header class="entry-header">
						<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
							<?php
								display_level_stars( 'vocabulary' );
								the_title( '<h2 class="entry-title">', '</h2>' );
								echo '<span class="entry-subtitle">' . esc_html( get_vocab_subtitle() ) . '</span>';
							?>
						</a>
					</header><!-- .entry-header -->
				</article><!-- #post-<?php the_ID(); ?> -->
			</li>
			<?php

			$count++;
		endwhile;
		?>

		</ul>

		<hr />
		<section class="page-section archive-taxonomies vocabulary-taxonomies-list">
			<?php
				display_taxonomy_list( 'k2k-level', __( 'All Levels', 'k2k' ) );
				display_taxonomy_list( 'k2k-part-of-speech', __( 'All Parts of Speech', 'k2k' ) );
				display_taxonomy_list( 'k2k-topic', __( 'All Topics', 'k2k' ) );
				display_taxonomy_list( 'k2k-vocab-group', __( 'All Vocab Groups', 'k2k' ) );
			?>
		</section>

		<?php

		/*
			Finally a Posts Navigation
		*/
		gaya_paging_nav();

		else :

			get_template_part( 'template-parts/content', 'none' );

	endif;
		?>

	</main><!-- #primary -->

<?php
get_footer();
