<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$post_type = 'timeline';

$args = array(
	'post_type'			=> $post_type,
	'posts_per_page'	=> -1,
	'ignore_row'		=> true,
	'order'				=> 'ASC',
);

$q = new WP_Query($args);

if ( $q->have_posts() ) { ?>

	<div class="wrapper-timeline alignfull">

		<div class="slick-slider-timeline">

			<?php while ( $q->have_posts() ) { $q->the_post(); ?>

				<div class="timeline-item">

					<div class="container timeline-item-content">

						<?php the_content(); ?>

					</div>

					<div class="timeline-item-header mt-lg-3">
								
						<div class="container">
							
							<div class="timeline-item-header__inner-container d-md-flex align-items-center gap-3 py-3 py-lg-4 ms-lg-5">
								
								<div class="timeline-item-title">

									<p class="display-1 text-muted"><?php the_title(); ?></p>

								</div>

								<?php if ( $post->post_excerpt ) : ?>

									<div class="timeline-item-title-arrow d-none d-md-block">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/flecha-derecha-montal.svg" alt="<?php echo __( 'Flecha', 'smn' ); ?>" />
									</div>

									<div class="timeline-item-excerpt text-muted mw-400">

										<?php echo wpautop( $post->post_excerpt ); ?>
										
									</div>

								<?php endif; ?>

							</div>

							<?php edit_post_link(); ?>

						</div>

					</div>

				</div>

			<?php } ?>

		</div>

	</div>

<?php }

wp_reset_postdata();