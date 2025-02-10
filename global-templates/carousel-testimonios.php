<?php
/**
 * Hero setup
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$testimonios = get_field( 'testimonios', 'option' );
$testimonios_array = explode( PHP_EOL, $testimonios );

if ( $testimonios_array ) { ?>

	<div class="slick-carousel-testimonios slick-carousel-padded slider-testimonios">

		<?php foreach( $testimonios_array as $t ) { 
			
			$testimonio = explode( '/', $t ); 
			$texto = '"' . $testimonio[0] . '"';
			if ( isset( $testimonio[1] ) ) {
				$autor = $testimonio[1];
			} else {
				$autor = '*';
			}
			?>

			<div class="slide-testimonio">
			
				<div class="wp-block-group block-testimonio shadow rounded">
					<p class="block-testimonio-autor"><?php echo $autor; ?></p>
					<p class="block-testimonio-texto"><?php echo $texto; ?></p>
					<p class="block-testimonio-valoracion d-flex align-items-center justify-content-center">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/estrellas.svg" width="100" alt="<?php echo __( 'Valoración', 'smn' ); ?>" /><span class="ms-1"> 5/5</span>
					</p>
				</div>

			</div>

		<?php } ?>

	</div>

<?php }

wp_reset_postdata();