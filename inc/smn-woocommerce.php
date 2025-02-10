<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Homogeneiza el breakpoint de WC con el de WP
add_filter( 'woocommerce_style_smallscreen_breakpoint', function() {
    return '782px'; 
});

// replace woocommerce breadcrumbs with smn_breadcrumb
function woocommerce_breadcrumb() {
    
    if ( !is_shop() ) {
        smn_breadcrumb();
    }

    return false;
}

// remove product price in loop
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

// remove add to cart button in loop
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

// remove page title in shop page
add_filter( 'woocommerce_show_page_title', 'smn_hide_woocommerce_page_title' );
function smn_hide_woocommerce_page_title() {
    if ( is_shop() ) return false;

    return true;

}

// limit number of related products to 3
add_filter( 'woocommerce_output_related_products_args', 'smn_related_products_args' );
function smn_related_products_args( $args ) {
    $args['posts_per_page'] = 3;
    $args['columns'] = 3;
    return $args;
}

// Remove product count from category loop
add_filter( 'woocommerce_subcategory_count_html', 'smn_remove_category_product_count' );
function smn_remove_category_product_count( $html ) {
    return '';
}

// move product tabs after related products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_after_single_product', 'woocommerce_output_product_data_tabs', 10 );


// Show full description after short description
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'smn_template_single_excerpt', 20 );
function smn_template_single_excerpt() {
    global $product;
    echo '<div class="product-description my-4">';
        echo apply_filters( 'the_content', $product->get_description() );
    echo '</div>';
}

// Remove description tab
add_filter( 'woocommerce_product_tabs', 'smn_remove_product_tabs', 98 );
function smn_remove_product_tabs( $tabs ) {
    unset( $tabs['description'] );
    unset( $tabs['additional_information'] );
    return $tabs;
}

add_filter( 'woocommerce_product_review_comment_form_args', 'smn_review_form_args' );
function smn_review_form_args( $args ) {

    foreach( $args['fields'] as $key => $field_html ) {
        $args['fields'][$key] = str_replace( 
            array(
                '<input ', 
                '<textarea ',
            ),
            array(
                '<input class="form-control" ', 
                '<textarea class="form-control" ', 
            ),
        $field_html );
    }

    return $args;
}

// Remove categories from single product
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// If free shipping is available, remove other shipping methods except local pickup
add_filter( 'woocommerce_package_rates', 'smn_hide_shipping_when_free_is_available', 10, 2 );
function smn_hide_shipping_when_free_is_available( $rates, $package ) {
    $free_rates = array();
    $is_free = false;
    
    foreach ( $rates as $rate_id => $rate ) {
        if ( 'free_shipping' === $rate->method_id ) {
            $free_rates[ $rate_id ] = $rate;
            $is_free = true;
        }
        if ( 'pickup_location' == $rate->method_id ) {
            $free_rates[ $rate_id ] = $rate;
        }
    }

    if ( $is_free ) {
        return $free_rates;
    }

    return $rates;
}


// Esto lo hacemos porque si no en la página principal de la tienda
// se insertan <br> y <p> vacíos en los saltos de línea PHP
// Quitamos el hook de woocommerce_product_taxonomy_archive_description
// y lo reemplazamos por el contenido de la página de la tienda sin pasar por wc_format_content

remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

add_action( 'woocommerce_shop_loop_header', 'smn_product_archive_header', 9 );
function smn_product_archive_header() {

    if ( !is_shop() ) return false;

    // get shop page content
    $shop_page = get_post( wc_get_page_id( 'shop' ) );
    echo apply_filters( 'the_content', $shop_page->post_content );

}

// Quitar segunda línea de las direcciones
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
     unset($fields['order']['billing_address_2']);     
     unset($fields['order']['shipping_address_2']);

     return $fields;
}

function custom_remove_checkout_fields($fields) {
    unset($fields['order']['billing_address_2']);     
    unset($fields['order']['shipping_address_2']);
    return $fields;
}

add_filter( 'woocommerce_default_address_fields', 'custom_remove_checkout_fields' );

// Cambiar  Código Postal / ZIP* por Código Postal*
add_filter( 'woocommerce_default_address_fields', 'smn_change_postcode_label' );
function smn_change_postcode_label( $fields ) {
    unset($fields['address_2']);
    $fields['postcode']['label'] = 'Código Postal';
    return $fields;
}

/**
 * @snippet       Plus Minus Quantity Buttons @ WooCommerce Single Product Page
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 8
 * @community     https://businessbloomer.com/club/
 */
 
 add_action( 'woocommerce_before_quantity_input_field', 'bbloomer_display_quantity_minus' );
 
 function bbloomer_display_quantity_minus() {
    if ( ! is_product() ) return;
    echo '<button type="button" class="btn btn-primary p-0 px-2 minus" >-</button>';
 }
  
 add_action( 'woocommerce_after_quantity_input_field', 'bbloomer_display_quantity_plus' );
  
 function bbloomer_display_quantity_plus() {
    if ( ! is_product() ) return;
    echo '<button type="button" class="btn btn-primary p-0 px-2 plus" >+</button>';
 }
  
 add_action( 'woocommerce_before_single_product', 'bbloomer_add_cart_quantity_plus_minus' );
  
 function bbloomer_add_cart_quantity_plus_minus() {
    wc_enqueue_js( "
       $('form.cart').on( 'click', 'button.plus, button.minus', function() {
             var qty = $( this ).closest( 'form.cart' ).find( '.qty' );
             var val   = parseFloat(qty.val());
             var max = parseFloat(qty.attr( 'max' ));
             var min = parseFloat(qty.attr( 'min' ));
             var step = parseFloat(qty.attr( 'step' ));
             if ( $( this ).is( '.plus' ) ) {
                if ( max && ( max <= val ) ) {
                   qty.val( max );
                } else {
                   qty.val( val + step );
                }
             } else {
                if ( min && ( min >= val ) ) {
                   qty.val( min );
                } else if ( val > 1 ) {
                   qty.val( val - step );
                }
             }
          });
    " );
 }

 // remove the subcategories from the product loop
remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );

// add subcategories before the product loop (yet after catalog_ordering and result_count -> see priority 40)
add_action( 'woocommerce_before_shop_loop', 'smn_show_product_subcategories', 40 );
function smn_show_product_subcategories() {
    $subcategories = woocommerce_maybe_show_product_subcategories();
    if ($subcategories) {
        echo '<ul class="products columns-3">',$subcategories,'</ul>';
        $cat = get_queried_object();
        echo '<h2 class="h4 mt-4">' . sprintf( __( 'Todos los productos de %s', 'smn' ), $cat->name ) . '</h2>';
    }
}

function woocommerce_taxonomy_archive_description() {
    if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
        $term = get_queried_object();

        if ( $term ) {
            /**
             * Filters the archive's raw description on taxonomy archives.
             *
             * @since 6.7.0
             *
             * @param string  $term_description Raw description text.
             * @param WP_Term $term             Term object for this taxonomy archive.
             */
            $term_description = apply_filters( 'woocommerce_taxonomy_archive_description_raw', $term->description, $term );

            if ( ! empty( $term_description ) ) {
                echo '<div class="term-description leer-mas-wrapper"><div class="leer-mas">' . wc_format_content( wp_kses_post( $term_description ) ) . '</div>'. smn_get_leer_mas_buttons() .'</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }
    }
}

function woocommerce_template_loop_product_title() {
    echo '<p class="h2 ' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

add_filter('woocommerce_product_subcategories_args', 'custom_woocommerce_product_subcategories_args');
function custom_woocommerce_product_subcategories_args( $args ) {

    if ( is_tax( 'product_cat' ) ) {

        $current_term = get_queried_object();
        $related_terms = get_field( 'related_categories', $current_term );

        if ( $related_terms ) {

            unset( $args['parent'] );

            $child_categories = get_categories( array(
                'parent'        => $current_term->term_id,
                'hide_empty'    => 0,
                'hierarchical'  => 1,
                'pad_counts'    => 1,
                'taxonomy'      => 'product_cat',
                'fields'        => 'ids',
            ) );

            $related_terms = array_merge( $child_categories, $related_terms );
            $args['include'] = $related_terms;
            $args['orderby'] = 'include';

        }
    }

	return $args;
}