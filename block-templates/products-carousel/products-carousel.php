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
$titulo = get_field( 'products-carousel-title' );
$top_sellers = get_field( 'products-carousel-top-sellers' );
$posts_per_page = get_field( 'products-carousel-posts-per-page' );

if( !$posts_per_page ) {
	$posts_per_page = 10;
}

if ( ! $term_id ) {
	return;
}

$args = array(
	'post_type' => 'product',
	'posts_per_page' => $posts_per_page,
	'ignore_row' => 1,
	'tax_query' => array(
		array(
			'taxonomy' => 'product_cat',
			'field' => 'term_id',
			'terms' => $term_id,
		),
	),
);

if ( $top_sellers ) {
	$args['meta_key'] = 'total_sales';
	$args['orderby'] = 'meta_value_num';
	$args['posts_per_page'] = 6;
}

$products = new WP_Query( $args );

if ( !$products->have_posts() ) return false;
?>

<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">

	<div class="products-carousel__inner-container">

		<div class="row">

			<div class="col-md-6 col-lg-4">

				<div class="mw-400 ms-auto mb-4">

					<h2 class="my-4"><?php echo $titulo; ?></h2>

					<p><a class="btn btn-outline-primary" href="<?php echo get_term_link( $term_id ); ?>"><span class="btn-text"><?php echo __( 'Ver todos', 'smn' ); ?></span><span class="btn-arrow"><?php echo SVG_FLECHA; ?></span></a></p>

				</div>

			</div>

			<div class="col-md-6 col-lg-8">

				<div class="slick-carousel slick-carousel-padded products-carousel slick-arrows-bottom">

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; ?>

				</div>

				<?php wp_reset_postdata(); ?>

			</div>

		</div>

	</div>

</div>

<?php