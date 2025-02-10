<?php

/**
 * Content Slider Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */


// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'content-slider-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}
if ( ! empty( $block['backgroundColor'] ) ) {
	$class_name .= ' has-background';
	$class_name .= ' has-' . $block['backgroundColor'] . '-background-color';
}
if ( ! empty( $block['textColor'] ) ) {
	$class_name .= ' has-text-color';
	$class_name .= ' has-' . $block['textColor'] . '-color';
}


if ( have_rows( 'slides' ) ) :

	$unique_id = uniqid();
	$slick_navigation = '<div class="slick-slider-btn-navigation mb-4">';

		while ( have_rows( 'slides' ) ) : the_row();

			// for each slide, add a navigation item with the slide title
			$slide_title = get_sub_field( 'slide-title' );
			$index = get_row_index() - 1;
			$slick_navigation .= '<a data-target="slick-slider-'. $unique_id .'"  data-slide="'. $index .'" class="btn btn-link px-2 me-1 text-white" class="slick-navigation__item"><span class="btn-text">' . $slide_title . '</span><span class="btn-arrow">' . SVG_FLECHA . '</span></a>';			

		endwhile;

	$slick_navigation .= '</div>';
	?>

	<div <?php echo $anchor; ?>class="wp-block-cover py-3 <?php echo esc_attr( $class_name ); ?>">

		<span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim has-background-dim-100"></span>
		
		<div class="content-slider-block__inner-container container-fluid pe-md-0">

			<?php echo $slick_navigation; ?>

			<div class="slick-tabs-slider" id="slick-slider-<?php echo $unique_id; ?>">

				<?php while ( have_rows( 'slides' ) ) : the_row(); ?>

					<?php
					$gallery_unique_id = uniqid();

					$slide_title = get_sub_field( 'slide-title' );
					$slide_description = get_sub_field( 'slide-description' );
					$slide_gallery = get_sub_field( 'slide-gallery' );
					$slide_button_text = __( 'Ver galería', 'smn' );
					?>

					<div class="content-slider__item">

						<div class="row align-items-center">

							<div class="col-md-6">

								<div class="mw-400">

									<h2 class="wp-block-heading h3"><?php echo $slide_title; ?></h2>

									<?php 
									if ( $slide_description ) :
										echo '<div class="mb-4">';
											echo $slide_description;
										echo '</div>';
									endif; 
									?>

								</div>

								<?php
								if ( $slide_gallery ) : 
									$slide_url = $slide_gallery[0]['url'];
									?>
									<div class="wp-block-buttons">
										<div class="wp-block-button is-style-outline">
											<a href="<?php echo $slide_url; ?>" data-lbwps-gid="gallery-<?php echo $gallery_unique_id; ?>" class="wp-block-button__link"><span class="btn-text"><?php echo $slide_button_text; ?></span><span class="btn-arrow"><?php echo SVG_FLECHA; ?></span></a>
										</div>
									</div>
								<?php endif; ?>

							</div>

							<div class="col-md-6">

								<?php if ( $slide_gallery ) : ?>

									<div class="row g-2">

										<?php foreach ( $slide_gallery as $image ) : ?>

											<?php
											$col_class = 'col-7 mt-4';
											// if it's the second image, add a class to make it smaller
											if ( $image === $slide_gallery[1] ) {
												$col_class = 'col-5';
											}

											$display_class = '';
											$index = array_search( $image, $slide_gallery );
											if ( $index > 1 ) {
												$display_class = 'd-none';
												$col_class = 'col-12';
											}


											?>

											<div class="<?php echo $col_class . ' ' . $display_class; ?>">

												<a href="<?php echo $image['url']; ?>" class="gallery__item" data-lbwps-gid="gallery-<?php echo $gallery_unique_id; ?>">
													<?php echo wp_get_attachment_image( $image['ID'], 'medium_large', false, [ 'class' => 'gallery__image' ] ); ?>
												</a>

											</div>

										<?php endforeach; ?>

									</div>

								<?php endif; ?>

							</div>

						</div>

					</div>

				<?php endwhile; ?>

			</div>

		</div>

	</div>

<?php endif;