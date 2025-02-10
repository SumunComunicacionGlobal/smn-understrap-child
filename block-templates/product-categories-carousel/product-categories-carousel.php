<?php

/**
 * Products Carousel Template.
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
$class_name = 'products-carousel-block';
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


$term_id = get_field( 'products-carousel-term-id' );
$arrows_position = get_field( 'arrows_position' );
$arrows_position = $arrows_position ? 'slick-arrows-' . $arrows_position : 'slick-arrows-right';

if ( $term_id ) {
	if ( !is_array( $term_id ) ) {
		$term_id = array( $term_id );
	}

	$terms = get_terms( array(
		'taxonomy' => 'product_cat',
		'include' => $term_id,
	) );

} else {

	if ( is_tax( 'product_cat' ) ) {
		$parent_term_id = get_queried_object_id();
	} else {
		$parent_term_id = 0;
	}

	$terms = get_terms( array(
		'taxonomy' => 'product_cat',
		'parent' => $parent_term_id,
	) );

}
?>

<div <?php echo $anchor; ?>class="woocommerce <?php echo esc_attr( $class_name ); ?>">

	<div class="products-carousel__inner-container">


				<?php

				if ( $terms ) :
					?>

					<div class="slick-carousel slick-carousel-padded products-carousel product-categories-carousel slick-arrows-bottom <?php echo $arrows_position; ?>">

						<?php foreach( $terms as $term ) : ?>

							<?php
							global $carousel_category;
							$carousel_category = $term;
							?>

							<?php wc_get_template_part( 'content', 'product-cat' ); ?>

						<?php endforeach; ?>

					</div>

					<?php

				endif;
				?>

	</div>

</div>