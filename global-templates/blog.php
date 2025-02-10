<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( es_blog() ) {
	return false;
}

$args = array(
	'posts_per_page'	=> 6,
	'ignore_row'		=> true,
);

$q = new WP_Query($args); ?>

<div class="wrapper blog-block" id="wrapper-blog">

	<?php if ( $q->have_posts() ) { ?>

		<div class="slick-carousel slick-carousel-padded slick-carousel-same-height slick-arrows-bottom">

			<?php while ( $q->have_posts() ) { $q->the_post();

				get_template_part( 'loop-templates/content', 'post' );

			} ?>

		</div>

		<div class="mt-5">
			<a class="btn btn-outline-primary" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><span class="btn-text"><?php _e( 'Ver todas las noticias', 'smn' ); ?></span><span class="btn-arrow"><?php echo SVG_FLECHA; ?></span></a>
		</div>

	<?php } else {

		echo '<p class="text-start">' . __( 'Aún no hay nada aquí, pero pon atención a lo que viene…', 'smn' ) . '</p>'; 

	} ?>

</div>

<?php wp_reset_postdata();