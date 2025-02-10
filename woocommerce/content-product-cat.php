<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $carousel_category;
if ( is_object( $carousel_category ) ) {
	$category = $carousel_category;
}
?>

<li <?php wc_product_cat_class( '', $category ); ?>>
	<?php
	/**
	 * The woocommerce_before_subcategory hook.
	 *
	 * @hooked woocommerce_template_loop_category_link_open - 10
	 */
	do_action( 'woocommerce_before_subcategory', $category ); ?>

	<div class="card">

		<div class="card-body">

			<div class="card-title">

				<?php
				/**
				 * The woocommerce_shop_loop_subcategory_title hook.
				 *
				 * @hooked woocommerce_template_loop_category_title - 10
				 */
				do_action( 'woocommerce_shop_loop_subcategory_title', $category );
				?>

			</div>

		</div>

		<div class="card-img">

			<?php
			/**
			 * The woocommerce_before_subcategory_title hook.
			 *
			 * @hooked woocommerce_subcategory_thumbnail - 10
			 */
			do_action( 'woocommerce_before_subcategory_title', $category );
			?>

		</div>

		<div class="card-body">

			<?php
			/**
			 * The woocommerce_after_subcategory_title hook.
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
			?>

			<span class="btn btn-link ps-0 pb-0"><?php echo __( 'Saber más', 'smn' ); ?><span class="btn-arrow"><?php echo SVG_FLECHA; ?></span></span>

		</div>

	</div>

	<?php
	/**
	 * The woocommerce_after_subcategory hook.
	 *
	 * @hooked woocommerce_template_loop_category_link_close - 10
	 */
	do_action( 'woocommerce_after_subcategory', $category );
	?>


</li>