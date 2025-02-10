<?php
/**
 * Custom hooks.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_filter(
    'wpcf7_sendinblue_contact_parameters',
 
    function ( $params ) {
 
        // Email
        // $params['email'] = 'testing@example.com';
 
        // Attributes
        // Don't forget to cast to an object.
        // $params['attributes'] = (object) array(
        //     'LASTNAME' => 'Test',
        //     'FIRSTNAME' => 'Tester',
        //     'TEST_BOOL' => true,
        // );
 
 
        // Update existing contact
        $params['updateEnabled'] = true;
 
        // See https://developers.brevo.com/reference/createcontact
        // for the full list of available parameters
 
        return $params;
    },
 
    10, 1
);

add_filter( 'wpcf7_form_tag', 'smn_wpcf7_form_control_class', 10, 2 );
function smn_wpcf7_form_control_class( $scanned_tag, $replace ) {

   $excluded_types = array(
        'acceptance',
        'checkbox',
        'radio',
   );

   if ( in_array( $scanned_tag['type'], $excluded_types ) ) return $scanned_tag;

   switch ($scanned_tag['type']) {
    case 'submit':
        $scanned_tag['options'][] = 'class:btn';
        $scanned_tag['options'][] = 'class:btn-primary';
        break;
    
    default:
        $scanned_tag['options'][] = 'class:form-control';
        break;
   }
   
   return $scanned_tag;
}

add_action( 'loop_start', 'archive_loop_start', 10 );
function archive_loop_start( $query ) {

    if ( is_woocommerce() || isset( $query->query['ignore_row'] ) && $query->query['ignore_row'] ) return false;
    
    if ( ( isset( $query->query['add_row'] ) && $query->query['add_row'] ) || ( is_archive() || is_home() || is_search() ) ) {
        echo '<div class="row g-2">';
    }
}

add_action( 'loop_end', 'archive_loop_end', 10 );
function archive_loop_end( $query ) {

    if ( is_woocommerce() || isset( $query->query['ignore_row'] ) && $query->query['ignore_row'] ) return false;

    if ( ( isset( $query->query['add_row'] ) && $query->query['add_row'] ) || ( is_archive() || is_home() || is_search() ) ) {
        echo '</div>';
    }
}

add_filter( 'body_class', 'smn_body_classes' );
function smn_body_classes( $classes ) {

    if ( is_singular() ) {
        $navbar_bg = get_post_meta( get_the_ID(), 'navbar_bg', true );
        if ( 'transparent' == $navbar_bg ) {
            $classes[] = 'navbar-transparent';
        }
    } else {

    }

    return $classes;
}


add_filter( 'post_class', 'bootstrap_post_class', 10, 3 );
function bootstrap_post_class( $classes, $class, $post_id ) {

    if ( is_woocommerce() ) return $classes;

    if ( is_archive() || is_home() || is_search() || in_array( 'hfeed-post', $class ) ) {
        $classes[] = 'col-sm-6 col-lg-4 mb-2 stretch-linked-block'; 
    }

    return $classes;
}

function understrap_add_site_info() {

    $site_info = '';

    // Check if customizer site info has value.
    if ( get_theme_mod( 'understrap_site_info_override' ) ) {
        $site_info = get_theme_mod( 'understrap_site_info_override' );
        $site_info = do_shortcode( $site_info );
    }

    echo apply_filters( 'understrap_site_info_content', $site_info ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}

add_action( 'wp_body_open', 'top_anchor');
function top_anchor() {
    echo '<div id="top"></div>';
}

add_action( 'wp_footer', 'back_to_top' );
function back_to_top() {
    echo '<a href="#top" class="back-to-top"></a>';
}

add_action( 'wp_footer', 'smn_fixed_cta' );
function smn_fixed_cta() {

    if ( is_cart() || is_checkout() || is_account_page() ) return;

    if ( is_active_sidebar( 'fixed-cta' ) ) {

        echo '<div class="fixed-cta">';
            dynamic_sidebar( 'fixed-cta' );
        echo '</div>';
        ?>
                
    <?php }
}

add_action( 'wp_footer', function() {

    echo '<div class="fixed-links">';
        smn_fixed_links();
    echo '</div>';
});

function smn_fixed_links() {

    
    // $show_buttons = false;

    // if ( is_woocommerce() || is_front_page() ) {
    //     $show_buttons = true;
    // }

    // if ( is_page() ) {
    //     $hide_fixed_links = get_field( 'hide_fixed_links' );
    //     $show_buttons = !$hide_fixed_links;
    // }

    // if ( !$show_buttons ) return;

    $fixed_links = get_field( 'fixed-links', 'option' );

    if ( $fixed_links ) {
        // show fixed links as wp-block-buttons
        echo '<div class="global-links">';
            echo '<div class="wp-block-buttons is-layout-flex justify-content-start justify-content-sm-end">';
                foreach ( $fixed_links as $link ) {
                    echo '<div class="wp-block-button">';
                        echo '<a href="' . get_permalink( $link->ID ) . '" class="wp-block-button__link has-white-background-color has-background-color has-body-color has-text-color">' . $link->post_title . '<span CLASS="btn-arrow">'.SVG_FLECHA.'</span></a>';
                    echo '</div>';
                }
            echo '</div>';
        echo '</div>';
    }
}

function es_blog() {

    if( is_singular('post') || is_category() || is_tag() || ( is_home() && !is_front_page() ) ) {
        return true;
    }

    return false;
}

add_filter( 'theme_mod_understrap_sidebar_position', 'cargar_sidebar');
function cargar_sidebar( $valor ) {
    if ( is_singular( 'post' ) ) {
        $valor = 'right';
    }
    return $valor;
}


function smn_nav_menu_submenu_css_class( $classes, $args, $depth ) {

    if ( !$args->walker && 'primary' === $args->theme_location ) {
        $classes[] = 'dropdown-menu';
        // $classes[] = 'collapse';
    }

    return $classes;

}
add_filter( 'nav_menu_submenu_css_class', 'smn_nav_menu_submenu_css_class', 10, 3 );

function smn_add_menu_item_classes( $classes, $item, $args ) {

    // echo '<pre>'; print_r($args); echo '<pre>';
 
    if ( !$args->walker && 'primary' === $args->theme_location ) {
        $classes[] = "nav-item";

        if( in_array( 'current-menu-item', $classes ) ) {
            $classes[] = "active";
        }

        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $classes[] = 'dropdown';
        }
    
    }
 
    return $classes;
}
add_filter( 'nav_menu_css_class' , 'smn_add_menu_item_classes' , 10, 4 );

function smn_add_menu_link_classes( $atts, $item, $args ) {

    if ( !$args->walker && 'primary' == $args->theme_location ) {

    // echo '<pre>'; print_r($atts); echo '<pre>';

    if ( 0 == $item->menu_item_parent ) {
            $atts['class'] = 'nav-link';
        } else {
            $atts['class'] = 'dropdown-item';
        }
    }

    if ( in_array( 'menu-item-has-children', $item->classes ) ) {
        if ( isset( $atts['class'] ) ) $atts['class'] .= ' dropdown-toggle';
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'smn_add_menu_link_classes', 10, 3 );

add_filter('nav_menu_item_args', function ($args, $item, $depth) {

    if ( !$args->walker && 'primary' == $args->theme_location ) {
        
        $args->link_after  = '<span class="sub-menu-toggler"></span>';

    }
    return $args;
}, 10, 3);

add_filter( 'parse_tax_query', 'smn_do_not_include_children_in_product_cat_archive' );
function smn_do_not_include_children_in_product_cat_archive( $query ) {
    if ( 
        ! is_admin() 
        && $query->is_main_query()
        && $query->is_tax( 'product_cat' )
    ) {
        $query->tax_query->queries[0]['include_children'] = 0;
    }
}

// add a modal with content of page with id RESERVA_ID
add_action( 'wp_footer', 'smn_reserva_modal' );
function smn_reserva_modal() {

    $reserva = get_post( RESERVA_ID );
    if ( $reserva ) {
        echo '<div class="modal fade" id="reservaModal" tabindex="-1" aria-labelledby="reservaModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog modal-dialog-centered modal-lg">';
                echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                        echo '<p class="modal-title h5" id="reservaModalLabel">' . $reserva->post_title . '</p>';
                        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                        echo apply_filters( 'the_content', $reserva->post_content );
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
    ?>

    <script>
        jQuery(document).ready(function($) {
            $(document).on('click', 'a[href="<?php echo get_permalink( RESERVA_ID ); ?>"], a[href="#reserva"]', function(e) {
                e.preventDefault();
                $('.modal').modal('hide');
                $('#reservaModal').modal('show');
            });
        });
    </script>

        <?php 
        global $post;

        if ( is_page() && has_shortcode( $post->post_content, 'menu_diario' ) ) {
            $menu_diario = get_field( 'menu_diario', 'option' ); 
            if ( $menu_diario ) {
            ?>

            <div class="modal fade modal-menu-montal" id="menu-diario-modal" tabindex="-1" aria-labelledby="menu-diario-modal-Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content text-center">
                        <div class="modal-header">
                            <h5 class="modal-title" id="menu-diario-modal-Label"><?php echo __( 'Menú diario', 'smn' ); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo __( 'Cerrar', 'smn' ); ?>"></button>
                        </div>
                        <div class="modal-body">
                            <?php echo $menu_diario; ?>
                        </div>
                    </div>
                </div>
            </div>


            <?php } 
            
        } 
        
  
        if ( is_page() && has_shortcode( $post->post_content, 'carta_y_vinos_despensa' ) ) {
            $carta_despensa = get_field( 'carta_despensa', 'option' ); 
            $vinos_despensa = get_field( 'vinos_despensa', 'option' ); 

            $botones = array(
                array(
                    'title'		=> __( 'Carta de La Despensa', 'smn' ),
                    'content'	=> smn_get_lista_de_precios( $carta_despensa ),
                    'slug'		=> 'carta-despensa',
                ),
                array(
                    'title'		=> __( 'Carta de vinos de La Despensa', 'smn' ),
                    'content'	=> smn_get_lista_de_precios( $vinos_despensa ),
                    'slug'		=> 'vinos-despensa',
                ),
            );
        
        
            foreach ( $botones as $boton ) {
                
                if ( $boton['content'] ) {
                ?>

                <div class="modal fade modal-menu-montal" id="<?php echo $boton['slug']; ?>-modal" tabindex="-1" aria-labelledby="<?php echo $boton['slug']; ?>-modal-Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="<?php echo $boton['slug']; ?>-modal-Label"><?php echo $boton['title']; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo __( 'Cerrar', 'smn' ); ?>"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo $boton['content']; ?>
                            </div>
                        </div>
                    </div>
                </div>


                <?php } 

            }
            
        } 
        ?>

<?php }