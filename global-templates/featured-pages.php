<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$post_type = 'menu';

if ( have_rows( 'featured-pages', 'option' ) ) { ?>

	<div class="featured-pages">

		<div class="featured-pages-carousel slick-carousel-padded">

			<?php while ( have_rows( 'featured-pages', 'option' ) ) { the_row(); ?>

				<?php
				$page_id = get_sub_field( 'page_id' );

				$shop_page_id = wc_get_page_id( 'shop' );
				if ( is_shop() && $shop_page_id == $page_id ) {
					continue;
				}

				$page_thumbnail_id = get_sub_field( 'page_thumbnail_id' );
				?>

				<div class="featured-pages-carousel-item">

					<div class="wp-block-group is-style-featured-shadow mb-2">

						<div class="wp-block-group__inner-container">

							<div class="d-flex gap-3 align-items-center">

								<div class="text-center">
									<?php echo wp_get_attachment_image( $page_thumbnail_id, array(100,100), false, array( 'class' => 'rounded-circle' ) ); ?>
								</div>

								<div class="text-left">
									<p class="wp-block-heading lead text-uppercase mb-1"><?php echo get_the_title( $page_id ); ?></p>
								</div>

							</div>

							<div class="d-flex justify-content-end">

								<a href="<?php echo get_the_permalink( $page_id ); ?>" class="btn btn-link"><span class="bnt-text">Ver más</span><span class="btn-arrow"><?php echo SVG_FLECHA; ?></span></a>

							</div>

						</div>

					</div>

				</div>
				
			<?php } ?>

		</div>

	</div>

<?php }