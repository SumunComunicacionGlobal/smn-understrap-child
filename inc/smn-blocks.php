<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


if ( function_exists( 'register_block_style' ) ) {

    register_block_style(
        'core/cover',
        array(
            'name'         => 'image-header',
            'label'        => __( 'Cabecera', 'smn-admin' ),
            'is_default'   => false,
        )
    );
    
    register_block_style(
        'core/cover',
        array(
            'name'         => 'reveal',
            'label'        => __( 'Revelar', 'smn-admin' ),
            'is_default'   => false,
        )
    );
    
    register_block_style(
        'core/cover',
        array(
            'name'         => 'video-desplegable',
            'label'        => __( 'Vídeo desplegable', 'smn-admin' ),
            'is_default'   => false,
        )
    );
    
    register_block_style(
        'core/button',
        array(
            'name'         => 'arrow-link',
            'label'        => __( 'Con flecha', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    register_block_style(
        'core/button',
        array(
            'name'         => 'btn-link',
            'label'        => __( 'Solo link', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    register_block_style(
        'core/image',
        array(
            'name'         => 'overflow-right-bottom',
            'label'        => __( 'Superpuesta Abajo Derecha', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    register_block_style(
        'core/columns',
        array(
            'name'         => 'gapless',
            'label'        => __( 'Sin espacio', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    register_block_style(
        'core/list',
        array(
            'name'         => 'list-unstyled',
            'label'        => __( 'Sin viñetas', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    register_block_style(
        'core/group',
        array(
            'name'         => 'featured-shadow',
            'label'        => __( 'Destacado con sombra', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    register_block_style(
        'core/heading',
        array(
            'name'         => 'paragraph',
            'label'        => __( 'Párrafo normal', 'smn-admin' ),
            'is_default'   => false,
        )
    );

       
    $display_text_block_types = array(
        'core/paragraph',
        'core/heading',
    );

    foreach( $display_text_block_types as $block_type ) {

        register_block_style(
            $block_type,
            array(
                'name'         => 'lined-heading',
                'label'        => __( 'Con línea', 'smn-admin' ),
                'is_default'   => false,
            )
        );
    
        for ($i=1; $i <= 6; $i++) { 

            register_block_style(
                $block_type,
                array(
                    'name'         => 'h' . $i,
                    'label'        => sprintf( __( 'Imita un h%s', 'smn-admin' ), $i ),
                    'is_default'   => false,
                )
            );

        }
            
        for ($i=1; $i <= 4; $i++) { 

            register_block_style(
                $block_type,
                array(
                    'name'         => 'display-' . $i,
                    'label'        => sprintf( __( 'Display %s', 'smn-admin' ), $i ),
                    'is_default'   => false,
                )
            );

        }
            
    }

    register_block_style(
        'core/praragrap',
        array(
            'name'         => 'cifra-circulo',
            'label'        => __( 'Cifra círculo', 'smn-admin' ),
            'is_default'   => false,
        )
    );

    $carousel_block_types = array(
        'core/group',
        'core/gallery',
    );

    foreach( $carousel_block_types as $block_type ) {

        register_block_style(
            $block_type,
            array(
                'name'         => 'slick-carousel',
                'label'        => sprintf( __( 'Carrusel', 'smn-admin' ) ),
                'is_default'   => false,
            )
        );

        register_block_style(
            $block_type,
            array(
                'name'         => 'slick-carousel-logos',
                'label'        => __( 'Carrusel Logos', 'smn-admin' ),
                'is_default'   => false,
            )
        );

    }
            

}

add_filter( 'render_block', 'remove_is_style_prefix', 10, 2 );
function remove_is_style_prefix( $block_content, $block ) {

    if ( isset( $block['attrs']['className'] ) ) {
    
        $components = array(
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'display-1',
            'display-2',
            'display-3',
            'display-4',
            'lead',
            'list-unstyled',
        );

        $prefixed_components = array();
    
        foreach ( $components as $component ) {
            $prefixed_components[] = 'is-style-' . $component;
        }

        $block_content = str_replace(
            $prefixed_components,
            $components,
            $block_content
        );

    }
    
    return $block_content;
}

add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {
    register_block_type( get_stylesheet_directory() . '/block-templates/products-carousel' );
    register_block_type( get_stylesheet_directory() . '/block-templates/product-categories-carousel' );
    register_block_type( get_stylesheet_directory() . '/block-templates/menu-tabs' );
    register_block_type( get_stylesheet_directory() . '/block-templates/pages-carousel' );
    register_block_type( get_stylesheet_directory() . '/block-templates/links-carousel' );
    register_block_type( get_stylesheet_directory() . '/block-templates/content-slider' );
}

add_filter( 'render_block', 'list_block_wrapper', 10, 2 );
function list_block_wrapper( $block_content, $block ) {
    if ( $block['blockName'] === 'core/list' ) {
        $block_content = str_replace( 
            array( '<ul class="', '<ol class="'), 
            array( '<ul class="wp-block-list ', '<ol class="wp-block-list '), $block_content );
        
        $block_content = str_replace( 
            array( '<ul>', '<ol>'), 
            array( '<ul class="wp-block-list">', '<ol class="wp-block-list">'), $block_content );
    }
    return $block_content;
}

add_filter( 'render_block', 'smn_add_inner_span_to_heading_blocks', 10, 2 );
function smn_add_inner_span_to_heading_blocks( $block_content, $block ) {
    if ( in_array( $block['blockName'], array( 'core/heading', 'core/paragraph' ) ) ) {
        // Utiliza expresiones regulares para añadir <span> manteniendo las clases en las etiquetas originales
        $patterns = array(
            '/<h1(.*?)>/', '/<h2(.*?)>/', '/<h3(.*?)>/', '/<h4(.*?)>/', '/<h5(.*?)>/', '/<h6(.*?)>/', '/<p(.*?)>/'
        );
        $replacements = array(
            '<h1$1><span>', '<h2$1><span>', '<h3$1><span>', '<h4$1><span>', '<h5$1><span>', '<h6$1><span>', '<p$1><span>'
        );

        $block_content = preg_replace($patterns, $replacements, $block_content);

        $block_content = str_replace(
            array('</h1>', '</h2>', '</h3>', '</h4>', '</h5>', '</h6>', '</p>'),
            array('</span></h1>', '</span></h2>', '</span></h3>', '</span></h4>', '</span></h5>', '</span></h6>', '</span></p>'),
            $block_content
        );
    }
    return $block_content;
}

// modify wp-block-button to wrap text in a span and add a span for the arrow, only for is-style-outline
add_filter( 'render_block', 'smn_modify_button_block', 10, 2 );
function smn_modify_button_block( $block_content, $block ) {
    if ( $block['blockName'] === 'core/button' ) {
        if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'is-style-outline' ) !== false ) {
            $block_content = str_replace( 
                array( '</a>' ), 
                array( '<span class="btn-arrow">'. SVG_FLECHA .'</span></a>' ), $block_content );
        }

    }
    return $block_content;
}

// modify wp-block-post-title block to show the breadcrumb before the title (with smn_get_breadcrumb function)
add_filter( 'render_block', 'smn_modify_post_title_block', 10, 2 );
function smn_modify_post_title_block( $block_content, $block ) {

    if ( !is_page() && !is_shop() ) return $block_content;

    if ( $block['blockName'] === 'core/post-title' || 
        ( $block['blockName'] === 'core/heading' && isset( $block['attrs']['level'] ) && $block['attrs']['level'] == 1 )
    ) {

        $block_content = smn_get_breadcrumb() . $block_content;

    }
    return $block_content;
    
}

// modify wp-block-galery to add class slick-arrows-bottom if has is-style-slick-carousel class
add_filter( 'render_block', 'smn_modify_gallery_block', 10, 2 );
function smn_modify_gallery_block( $block_content, $block ) {
    if ( $block['blockName'] === 'core/gallery' || $block['blockName'] === 'core/group' ) {
        if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'is-style-slick-carousel' ) !== false ) {
            $block_content = str_replace( 
                array( 'wp-block-gallery' ), 
                array( 'wp-block-gallery slick-arrows-bottom' ), $block_content );
        }
    }
    return $block_content;
}

// if is block cover with class is-style-video-desplegable, add a button to close the video after the .wp-block-cover opening tag
// add_filter( 'render_block', 'smn_modify_cover_block', 10, 2 );
function smn_modify_cover_block( $block_content, $block ) {
    if ( $block['blockName'] === 'core/cover' ) {
        if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'is-style-video-desplegable' ) !== false ) {
            $block_content = str_replace( 
                array( '<span aria-hidden="true" class="wp-block-cover__background' ), 
                array( '<button type="button" class="btn-close btn-close-white" aria-label="Cerrar vídeo"></button><span aria-hidden="true" class="wp-block-cover__background' ), 
                $block_content );
        }
    }
    return $block_content;
}

// add "Leer todo" button after block if is group block and has class .leer-mas
add_filter( 'render_block', 'smn_modify_group_block', 10, 2 );
function smn_modify_group_block( $block_content, $block ) {
    if ( $block['blockName'] === 'core/group' ) {
        if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'leer-mas' ) !== false ) {
            $r = '<div class="leer-mas-wrapper">';
                $r .= $block_content;
                $r .= smn_get_leer_mas_buttons();
            $r .= '</div>';
            
            return $r;
        }
    }

    return $block_content;
}