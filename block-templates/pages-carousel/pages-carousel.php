<?php

/**
 * Pages Carousel Template.
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
$class_name = 'pages-carousel-block';
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


$page_ids = get_field( 'page-ids' );
$slides_to_show = 3;

if ( ! $page_ids ) {
	return;
}

$q = new WP_Query( [
	'post_type' => 'any',
	'post__in' => $page_ids,
	'orderby' => 'post__in',
	'posts_per_page' => -1,
	'ignore_sticky_posts' => 1,
] );

$col_classes = 'col-12 col-md-6 col-lg-4';

if ( $q->found_posts < 3 ) {
	$slides_to_show = $q->found_posts;
	$col_classes = 'col-12 col-md';
}

$col_classes .= ' mb-3';

?>

<div <?php echo $anchor; ?>class="alignfull <?php echo esc_attr( $class_name ); ?>">

	<div class="container-fluid">

		<!-- <div class="slick-pages-carousel slick-carousel-padded slick-arrows-bottom"> -->
		<div class="row g-3 justify-content-center">

			<?php while ( $q->have_posts() ) : $q->the_post(); ?>

				<div class="pages-carousel__item <?php echo $col_classes; ?>">

					<div class="wp-block-cover is-style-reveal has-white-color has-text-color has-link-color">

						<span aria-hidden="true" class="wp-block-cover__background has-black-background has-background-dim"></span>

						<?php if ( has_post_thumbnail() ) {
							echo get_the_post_thumbnail( null, 'large', array( 'class' => 'wp-block-cover__image-background' ) ); 
						} else {
							echo wp_get_attachment_image( PLACEHOLDER_ID, 'medium_large', false, array( 'class' => 'wp-block-cover__image-background' ) );
						} ?>

						<div class="wp-block-cover__inner-container has-text-align-center">

							<h2 class="wp-block-heading h3"><?php the_title(); ?></h2>

							<a href="<?php the_permalink(); ?>" class="btn btn-outline-white"><span class="bnt-text">Ver más</span><span class="btn-arrow"><?php echo SVG_FLECHA; ?></span></a>

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
		
	if ( $q->found_posts > 1 ) : ?>

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

	<?php endif; ?>

<?php endif; ?>

<?php wp_reset_postdata();