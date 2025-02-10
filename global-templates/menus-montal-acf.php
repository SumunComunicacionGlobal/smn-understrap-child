<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$post_type = 'menu';

if ( have_rows( 'menus', 'option' ) ) { ?>

	<div class="wrapper" id="wrapper-menus">

		<!-- <div class="slick-carousel slick-carousel-padded slick-carousel-same-height"> -->
		<div class="row justify-content-center">

			<?php while ( have_rows( 'menus', 'option' ) ) { the_row();

				$ocultar = get_sub_field( 'ocultar' );
				if ( $ocultar ) {
					continue;
				}

				$menu_name = get_sub_field( 'menu_name' );
				$menu_image = get_sub_field( 'menu_image' );
				$menu_pdf = get_sub_field( 'menu_pdf' );
				if ( $menu_pdf ) {
					// add timestamp to avoid caching
					$menu_pdf = add_query_arg( 'v', time(), $menu_pdf );
				}
				$menu_description = get_sub_field( 'menu_description' );
				$menu_price = get_sub_field( 'menu_price' );

				// get_template_part( 'loop-templates/content', 'menu-montal' );

				$placeholder_id = PLACEHOLDER_ID;
				$precio = $menu_price;
				$titulo_original = $menu_name;

				if ( str_contains( $titulo_original, 'Menú' ) ) {
					$resto_titulo = str_replace( 'Menú', '', $titulo_original );
					$titulo = '<p><span class="text-uppercase fw-bold text-lead d-block">' . __( 'Menú' , 'smn' ) . '</span> <span class="h1 d-block"><em>' . $resto_titulo . '</em></span></p>';
				} else {
					$titulo = '<p class="h2"><em>' . $titulo_original . '</em></p>';
				}
				?>

				<!-- <article class="type-menu"> -->
				<article class="type-menu col-lg-6 col-xl-4 mb-4">

					<div class="h-100 d-flex flex-column justify-content-between text-center">

						<div>

							<?php echo wp_get_attachment_image( $menu_image, 'medium', false, array( 'class' => 'wp-post-image menu-image aligncenter mb-3' ) ); ?>

							<header class="entry-header">

								<?php echo $titulo; ?>

							</header><!-- .entry-header -->

							<div class="entry-content px-2 mw-400 mx-auto">

								<?php
								echo $menu_description;
								?>

							</div><!-- .entry-content -->

						</div>

						<footer class="entry-footer mt-2">

							<?php if ( $precio ) { ?>
								<p class="h4"><?php echo $precio; ?></p>
							<?php } ?>

							<div class="d-flex flex-wrap justify-content-center">
								<?php if ( $menu_pdf ) { ?>
									<a href="<?php echo $menu_pdf; ?>" class="btn btn-outline-dark me-1 mb-1" target="_blank"><span class="btn-text"><?php echo __( 'Ver menú', 'smn' ); ?></span><span class="btn-arrow"><?php echo SVG_FLECHA; ?></span></a>
								<?php } ?>
								<a href="<?php echo get_the_permalink( RESERVA_ID ); ?>" class="btn btn-outline-dark me-1 mb-1"><span class="btn-text"><?php echo __( 'Reserva', 'smn' ); ?></span><span class="btn-arrow"><?php echo SVG_FLECHA; ?></span></a>
							</div>

						</footer><!-- .entry-footer -->

					</div>

				</article><!-- #post-## -->

			<?php } ?>

		</div>

	</div>

<?php }