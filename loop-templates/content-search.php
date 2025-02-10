<?php
/**
 * Search results partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class( 'type-post' ); ?> id="post-<?php the_ID(); ?>">

	<div class="card h-100">

		<header class="card-header entry-header">

			<?php
			the_title(
				sprintf( '<p class="entry-title fw-bold mb-0"><a class="stretched-link" href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
				'</a></p>'
			);
			?>

		</header><!-- .entry-header -->

		<div class="card-body entry-summary small text-muted">

		<?php the_excerpt(); ?>

			<footer class="entry-footer">

				<?php understrap_entry_footer(); ?>

			</footer><!-- .entry-footer -->

		</div><!-- .entry-summary -->

	</div>

</article><!-- #post-## -->

<?php