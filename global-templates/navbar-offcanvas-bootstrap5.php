<?php
/**
 * Header Navbar (bootstrap5)
 *
 * @package Understrap
 * @since 1.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
$navbar_class = smn_get_navbar_class();
?>

<nav id="main-nav" class="navbar <?php echo $navbar_class; ?>" aria-labelledby="main-nav-label">

	<p id="main-nav-label" class="screen-reader-text">
		<?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
	</p>


	<div class="<?php echo esc_attr( $container ); ?>">

		<!-- Your site branding in the menu -->
		<?php get_template_part( 'global-templates/navbar-branding' ); ?>


		<!-- The WordPress Menu goes here -->
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'desktop',
				'container_class' => 'navbar-expand flex-grow-1 d-none d-lg-block',
				'container_id'    => '',
				'menu_class'      => 'navbar-nav justify-content-end pe-3',
				'fallback_cb'     => '',
				'menu_id'         => 'desktop-menu',
				'depth'           => 2,
				'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
			)
		);
		?>

		<div class="d-flex align-items-center gap-1">

			<?php smn_cart_icon(); ?>

			<?php smn_my_account_icon(); ?>

			<button
				class="navbar-toggler"
				type="button"
				data-bs-toggle="offcanvas"
				data-bs-target="#navbarNavOffcanvas"
				aria-controls="navbarNavOffcanvas"
				aria-expanded="false"
				aria-label="<?php esc_attr_e( 'Open menu', 'understrap' ); ?>"
			>
				<span class="navbar-toggler-icon"></span>
			</button>

		</div>


		<div class="offcanvas offcanvas-start" tabindex="-1" id="navbarNavOffcanvas">

			<div class="offcanvas-header row g-0">

					<div class="col-auto">

						<?php get_template_part( 'global-templates/navbar-branding' ); ?>

					</div>

					<div class="col-auto order-sm-3">

						<button
							class="btn-close text-reset ms-3"
							type="button"
							data-bs-dismiss="offcanvas"
							aria-label="<?php esc_attr_e( 'Close menu', 'understrap' ); ?>"
						></button>

					</div>

					<div class="my-2 col-12 col-sm-auto flex-grow-1">
						<?php smn_fixed_links(); ?>
					</div>

			</div><!-- .offcancas-header -->

			<div class="offcanvas-body">

				<div class="row">

					<div class="col-lg-7">

						<!-- The WordPress Menu goes here -->
						<?php
						wp_nav_menu(
							array(
								'theme_location'  => 'primary',
								'container_class' => 'navbar navbar-light',
								'container_id'    => '',
								'menu_class'      => 'navbar-nav justify-content-end flex-grow-1 pe-3',
								'fallback_cb'     => '',
								'menu_id'         => 'main-menu',
								'depth'           => 2,
								'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
							)
						);
						?>

						<?php
						wp_nav_menu(
							array(
								'theme_location'  => 'secondary',
								'container_class' => 'navbar navbar-light',
								'container_id'    => '',
								'menu_class'      => 'navbar-nav flex-sm-row gap-2 flex-wrap justify-content-lg-between flex-grow-1 text-uppercase py-3 my-3 border-top border-bottom',
								'fallback_cb'     => '',
								'menu_id'         => 'secondary-menu',
								'depth'           => 2,
								'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
							)
						);
						?>

						<?php dynamic_sidebar( 'social' ); ?>

					</div><!-- .col -->

					<div class="col-lg-5">

						<div id="featured-offcanvas">

							<?php dynamic_sidebar( 'featured-offcanvas' ); ?>

						</div>

					</div><!-- .col -->

				</div><!-- .row -->

			</div><!-- .offcanvas-body -->

		</div><!-- .offcanvas -->

	</div><!-- .container(-fluid) -->

</nav><!-- #main-nav -->

<?php