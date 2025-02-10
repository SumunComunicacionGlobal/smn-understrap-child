<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// obtener id del placeholder de woocommerce
$placeholder_id = PLACEHOLDER_ID;
?>

<article <?php post_class( 'hfeed-post' ); ?> id="post-<?php the_ID(); ?>">

	<div class="card">

		<div class="card-img-top">

		<?php if ( has_post_thumbnail() ) :

			$thumb = get_the_post_thumbnail( $post->ID, 'large' );

			if ( $thumb ) :
				echo $thumb;
			else :
				echo wp_get_attachment_image( $placeholder_id, 'large' );
			endif;

		elseif( function_exists( 'is_woocomemrce' ) ) : 

			echo wp_get_attachment_image( $placeholder_id, 'large' );

		endif; ?>


		</div>

		<div class="card-body">

		<header class="entry-header">

			<?php if ( 'post' === get_post_type() ) : ?>

				<div class="entry-meta">
					<?php understrap_posted_on(); ?>
				</div><!-- .entry-meta -->

			<?php endif; ?>

			<?php
			// Page title
			the_title(
				sprintf( '<p class="h4 text-uppercase card-title"><a class="stretched-link" href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
				'</a></p>'
			);
			?>

		</header><!-- .entry-header -->

		<div class="entry-content">

			<?php
			the_excerpt();
			understrap_link_pages();
			?>

		</div><!-- .entry-content -->

		<footer class="entry-footer">

			<?php understrap_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</div>

</article><!-- #post-## -->

<?php