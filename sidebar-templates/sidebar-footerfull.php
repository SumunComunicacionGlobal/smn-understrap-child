<?php
/**
 * Sidebar setup for footer full
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'footerfull' ) ) {
	return;
}

$container = get_theme_mod( 'understrap_container_type' );
?>

<!-- ******************* The Footer Full-width Widget Area ******************* -->

<div class="wrapper" id="wrapper-footer-full" role="complementary">

	<div class="<?php echo esc_attr( $container ); ?>" id="footer-full-content" tabindex="-1">

		<div class="row">

			<div class="col-lg-9">

				<?php
				// print wordpress logo
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
				if ( has_custom_logo() ) {
					echo '<div id="wrapper-footer-logo">';
						echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" width="224" class="img-fluid">';
					echo '</div>';
				}

				?>

				<div class="row">

					<?php dynamic_sidebar( 'footerfull' ); ?>

				</div>

				<?php dynamic_sidebar( 'social' ); ?>


			</div>

			<div class="col-lg-3 text-center text-lg-right">

				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/plafon-montal.svg" alt="Logo" class="img-fluid">

			</div>

			</div>

	</div>

</div><!-- #wrapper-footer-full -->

<?php