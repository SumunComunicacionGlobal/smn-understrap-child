<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>
<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

<?php get_template_part( 'sidebar-templates/sidebar', 'prefooter' ); ?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<nav id="legal-nav" class="navbar navbar-expand navbar-light" aria-labelledby="legal-nav-label">

			<p id="legal-nav-label" class="screen-reader-text">
				<?php esc_html_e( 'Legal Navigation', 'understrap' ); ?>
			</p>

			<?php wp_nav_menu( array(
				'theme_location'		  => 'legal',
				'container_class' => 'collapse navbar-collapse navbar-light',
				'container_id'    => 'navbarLegal',
				'menu_class'      => 'navbar-nav mx-auto ms-md-0 flex-wrap',
				'fallback_cb'     => '',
				'menu_id'         => 'legal-menu',
				'depth'           => 1,
				'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
			) ); ?>

		</nav>

		<?php understrap_site_info(); ?>

		<?php if ( is_active_sidebar( 'subvenciones' ) ) { ?>

			<div class="wrapper" id="wrapper-subvenciones">
				<?php dynamic_sidebar( 'subvenciones' ); ?>
			</div>

		<?php } ?>

	</div><!-- .container(-fluid) -->

</div><!-- #wrapper-footer -->

<?php // Closing div#page from header.php. ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>

<?php