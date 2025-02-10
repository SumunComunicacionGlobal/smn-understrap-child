<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$terms = false;

if ( is_shop() ) {

	$terms = get_terms( array( 
		'taxonomy' 		=> 'product_cat', 
		'parent' 		=> 0, 
		'hide_empty' 	=> true,
	) );

} else {

	 return false;

	if ( !is_tax() && !is_category() && !is_tag() ) return;
	$current_term = get_queried_object();

	$terms = get_terms( array( 
		'taxonomy' 		=> $current_term->taxonomy, 
		'parent' 		=> $current_term->term_id, 
		'hide_empty' 	=> true,
	) );

}

if ( $terms ) { ?>

	<p class="text-center">
		<a class="btn btn-outline-dark" href="#desplegable-subcategorias" data-bs-toggle="collapse" aria-expanded="false" aria-controls="desplegable-subcategorias">
			<?php _e( 'Ver todo', 'smn' ); ?>
		</a>
	</p>

	<div class="collapse" id="desplegable-subcategorias">

		<div class="py-3">
	
			<div class="row g-2">

				<?php foreach ( $terms as $key => $term ) { ?>

					<div class="col-md-4">

						<div class="card subcategory shadow">

							<div class="card-body">

								<p class="text-uppercase card-title fw-bold">
									<a class="stretched-link" href="<?php echo get_term_link( $term ); ?>" title="<?php echo $term->name; ?>">
										<?php echo $term->name; ?>
									</a>	
								</p>

								<p class="text-end">
									<span class="btn btn-link pe-0 pb-0">
										<span class="btn-text">
											<?php _e( 'Ver más', 'smn' ); ?>
										</span>
										<span class="btn-arrow">
											<?php echo SVG_FLECHA; ?>
										</span>
									</span>
								</p>

							</div>

						</div>

					</div>

				<?php } ?>

			</div>

		</div>

	</div>

<?php }