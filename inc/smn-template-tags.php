<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function understrap_posted_on() {

    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    }
    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );
    echo $time_string; // WPCS: XSS OK.

}



/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function understrap_entry_footer() {
	// Hide category and tag text for pages.
	if ( is_singular( 'post') ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'understrap' ) );
		if ( $categories_list && understrap_categorized_blog() ) {
			/* translators: %s: Categories of current post */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %s', 'understrap' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'understrap' ) );
		if ( $tags_list ) {
			/* translators: %s: Tags of current post */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %s', 'understrap' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
	// if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
	// 	echo '<span class="comments-link">';
	// 	comments_popup_link( esc_html__( 'Leave a comment', 'understrap' ), esc_html__( '1 Comment', 'understrap' ), esc_html__( '% Comments', 'understrap' ) );
	// 	echo '</span>';
	// }
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'understrap' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}

function smn_get_breadcrumb() {

	if ( is_front_page() ) return false;

	ob_start();

	if(function_exists('bcn_display')) {
		echo '<div class="breadcrumb" typeof="BreadcrumbList" vocab="https://schema.org/">';
			echo '<div class="breadcrumb-inner">';
				bcn_display();
			echo '</div>';
		echo '</div>';
	} elseif ( function_exists( 'rank_math_the_breadcrumbs') ) {
		echo '<div class="breadcrumb">';
			echo '<div class="breadcrumb-inner">';
				rank_math_the_breadcrumbs(); 
			echo '</div>';
		echo '</div>';
	} elseif ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb( '<div id="breadcrumbs" class="breadcrumb"><div class="breadcrumb-inner">','</div></div>' );
	}

	$r = ob_get_clean();

	if ( $r ) {
		return '<div class="breadcrumb-wrapper py-1">' . $r . '</div>';
	}

}

function smn_breadcrumb() {
	
	$r = smn_get_breadcrumb();

	if ( $r ) {

			echo $r;

	}

}

function smn_get_navbar_class() {

	$navbar_class = 'bg-white-body navbar-light';

	if ( is_singular() ) {

		$navbar_bg = get_post_meta( get_the_ID(), 'navbar_bg', true );

		switch ($navbar_bg) {
			case 'navbar-light':
				$navbar_class = 'bg-white-body navbar-light';
				break;

			case 'transparent':
				$navbar_class = 'navbar-dark';
				break;
			
			default:
				$navbar_class = 'bg-white-body navbar-light';
			break;
		}
	}

	return $navbar_class;

}

function smn_get_lista_de_precios( $content, $separator = '|' ) {

	$lista = '';

	if ( $content ) {

		$content = explode( PHP_EOL, $content );
		$lista = '<div class="price-list">';
		foreach ( $content as $item ) {

			$item = explode( $separator, $item );

			if ( count( $item ) == 0 ) {

				$lista .= '<div class="wp-block-separator"></div>';

			} elseif( count( $item ) == 1 ) {

				$item[0] = trim( $item[0] );

				if ( !$item[0] ) {
					// $lista .= '<div class="wp-block-separator"></div>';
				} else {
					$lista .= '<p class="text-center mt-4"><strong>' . $item[0] . '</strong></p>';
				}

			} else {

				$lista .= '<div class="price-list-item mb-2">';
					if ( isset( $item[0]) ) {
						$lista .= '<div class="price-list-plato-precio d-flex align-items-center justify-content-between">';
							$lista .= '<span class="price-list-plato">' . $item[0] . '</span>';
							if ( isset( $item[1] ) ) {
								$item[1] = str_replace( array( '€', ' €' ), '<span class="price-list-simbolo-moneda"> €</span>', $item[1] );
								$lista .= '<span class="price-list-separador"></span>';
								$lista .= '<span class="price-list-precio">' . $item[1] . '</span>';
							}
						$lista .= '</div>';
					}
					if ( isset( $item[2] ) ) {
						$lista .= '<div class="price-list-plato-descripcion text-muted">' . $item[2] . '</div>';
					}
				$lista .= '</div>';

			}
		}

		$lista .= '</div>';
	}

	return $lista;

}

function smn_cart_icon() {
	
	if ( is_cart() || is_checkout() ) return false;

	echo do_shortcode( '[xoo_wsc_cart]' );

}

function smn_my_account_icon() {

	if ( is_account_page() ) return;

	// Link to my account page
	$my_account_page_id = get_option( 'woocommerce_myaccount_page_id' );
	$my_account_page_url = get_permalink( $my_account_page_id );

	echo '<a class="ms-1" href="' . $my_account_page_url . '"><img width="24" height="24" src="' . get_stylesheet_directory_uri() . '/img/icon-account.svg" alt="'. __( 'Icono de persona misteriosa', 'smn' ) .'"></a>';

}

function smn_get_leer_mas_buttons() {

	$r = '<a href="#" class="btn btn-sm btn-secondary leer-mas-btn leer-mas-btn-mas">'. __( 'Ver más', 'smn' ).'</a>';
	$r .= '<a href="#" class="btn btn-sm btn-secondary leer-mas-btn leer-mas-btn-menos">'. __( 'Ver menos', 'smn' ).'</a>';

	return $r;
}