<?php

/**
 * Links Carousel Template.
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
$class_name = 'pages-carousel-block links-carousel-block';
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

if ( have_rows( 'links' ) ) : 

	$col_classes = 'col-12 col-md-6 col-lg-4';
	// get count of links
	$count = count( get_field( 'links' ) );
	if ( $count < 3 ) {
		$col_classes = 'col-12 col-md';
	}
	?>

	<div <?php echo $anchor; ?>class="alignfull <?php echo esc_attr( $class_name ); ?>">

		<div class="container-fluid">

			<!-- <div class="slick-pages-carousel slick-carousel-padded slick-arrows-bottom"> -->
			<div class="row g-3 justify-content-center">

				<?php while ( have_rows( 'links' ) ) : the_row(); ?>

					<?php
					$link_title = get_sub_field( 'link-title' );
					$link_image_id = get_sub_field( 'link-image' );
					$link_url = get_sub_field( 'link-url' );
					$link_description = get_sub_field( 'link-description' );
					$link_post_id = get_sub_field( 'link-post-id' );
					$link_term_id = get_sub_field( 'link-term-id' );
					$link_button_text = get_sub_field( 'link-button-text' );

					if ( !$link_title && $link_post_id ) {
						$link_title = get_the_title( $link_post_id );
					}

					if ( !$link_image_id && $link_post_id ) {
						$link_image_id = get_post_thumbnail_id( $link_post_id );
					}

					if ( !$link_image_id ) {
						$link_image_id = PLACEHOLDER_ID;
					}

					if ( !$link_url ) {
						
						if ( $link_post_id ) {
							$link_url = get_the_permalink( $link_post_id );
						} elseif ( $link_term_id ) {
							$link_url = get_term_link( $link_term_id );
						}
					}

					if ( !$link_button_text ) {
						$link_button_text = __( 'Quiero saber más', 'smn' );
					}
					?>

					<div class="pages-carousel__item <?php echo $col_classes; ?>">

						<div class="wp-block-cover is-style-reveal has-black-background has-white-color has-text-color has-link-color">

							<span aria-hidden="true" class="wp-block-cover__background has-black-background has-background-dim"></span>

							<?php echo wp_get_attachment_image( $link_image_id, 'medium_large', false, [ 'class' => 'wp-block-cover__image-background' ] ); ?>
							
							<?php echo wp_get_attachment_image( $link_image_id, 'medium_large', false, array( 'class' => 'wp-block-cover__image-background' ) ); ?>

							<div class="wp-block-cover__inner-container has-text-align-center">

								<h2 class="wp-block-heading h3"><?php echo $link_title; ?></h2>

								<?php 
								if ( $link_description ) :
									echo '<div class="mb-4">';
										echo $link_description;
									echo '</div>';
								endif; 
								?>

								<div class="wp-block-buttons">
									<div class="wp-block-button is-style-outline">
										<a href="<?php echo $link_url; ?>" class="wp-block-button__link has-text-white"><span class="btn-text"><?php echo $link_button_text; ?></span><span class="btn-arrow"><?php echo SVG_FLECHA; ?></span></a>
									</div>
								</div>

							</div>

						</div>

					</div>
					
				<?php endwhile; ?>
			
			</div>

		</div>

	</div>

	<?php 
	$carousel = false;
	if ( $carousel ) :
		$slides_to_show = 3;

		if ( $count > 1 ) : 
			if ( $count < 3 ) {
				$slides_to_show = $count;
			}
			?>

			<script>
				// Slick carousel on .slick-pages-carousel
				jQuery( document ).ready( function( $ ) {
					$( '.slick-pages-carousel' ).slick( {
						dots: true,
						arrows: true,
						infinite: false,
						speed: 300,
						slidesToShow: <?php echo $slides_to_show; ?>,
						slidesToScroll: 1,
						autoplay: true,
						responsive: [
							{
							breakpoint: 1200,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 1
							}
							},
							{
							breakpoint: 781,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1
							}
							}
						]
					} );
				} );
			</script>

		<?php endif;

	endif;

endif;