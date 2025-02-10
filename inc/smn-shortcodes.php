<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function contenido_pagina($atts) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
				'imagen'	=> 'no',
				'dominio'	=> false,

		), $atts)	
	);
	if ($dominio) {
		$api_url = $dominio . '/wp-json/wp/v2/pages/' . $id;
		$data = wp_remote_get( $api_url );
		$data_decode = json_decode( $data['body'] );

		// echo '<pre>'; print_r($data_decode); echo '</pre>';

		$content = $data_decode->content->rendered;
		return $content;
	} else {
		if ( 0 != $id) {
			$content_post = get_post($id);
			$content = $content_post->post_content;
			$content = '<div class="post-content-container">'.apply_filters('the_content', $content) .'</div>';
			if ('si' == $imagen) {
				$content = '<div class="entry-thumbnail">'.get_the_post_thumbnail($id, 'full') . '</div>' . $content;
			}
			return $content;
		}
	}
}
add_shortcode('contenido_pagina','contenido_pagina');

function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');

function paginas_hijas() {
	global $post;
	if ( is_post_type_hierarchical( $post->post_type ) /*&& '' == $post->post_content */) {
		$args = array(
			'post_type'			=> array($post->post_type),
			'posts_per_page'	=> -1,
			'post_status'		=> 'publish',
			'orderby'			=> 'menu_order',
			'order'				=> 'ASC',
			'post_parent'		=> $post->ID,
		);
		$r = '';
		$query = new WP_Query($args);
		if ($query->have_posts() ) {
			$r .= '<div class="contenido-adicional mt-5">';
			// $r .= '<h3>'.__( 'Contenido en', 'smn' ).' "'.$post->post_title.'"</h3>';
			// $r .= '<ul>';
			while($query->have_posts() ) {
				$query->the_post();
				// $r .= '<li>';
					$r .= '<a class="btn btn-primary btn-lg me-2 mb-2 pagina-hija" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'" role="button" aria-pressed="false">'.get_the_title().'</a>';
				$r .= '</li>';
			}
			// $r .= '</ul>';
			// $r .= '</div>';
		} elseif(0 != $post->post_parent) {
			wp_reset_postdata();
			$current_post_id = get_the_ID();
			$args['post_parent'] = $post->post_parent;
			$query = new WP_Query($args);
			if ($query->have_posts() && $query->found_posts > 1 ) {
				$r .= '<div class="contenido-adicional">';
				while($query->have_posts() ) {
					$query->the_post();
					if ($current_post_id == get_the_ID()) {
						$r .= '<span class="btn btn-primary btn-sm me-2 mb-2">'.get_the_title().'</span>';
					} else {
						$r .= '<a class="btn btn-outline-primary btn-sm me-2 mb-2" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'" role="button" aria-pressed="false">'.get_the_title().'</a>';
					}
				}
				$r .= '</div>';
			}
		}
		wp_reset_postdata();
		return $r;
	}
}
add_shortcode( 'paginas_hijas', 'paginas_hijas' );

// add_filter('the_content', 'mostrar_paginas_hijas', 100);
function mostrar_paginas_hijas($content) {
	global $post;
	if (is_admin() || !is_singular() || !in_the_loop() || is_front_page() ) return $content;
	global $post;
	if (has_shortcode( $post->post_content, 'paginas_hijas' )) return $content;

	return $content . paginas_hijas();

}

function sitemap() {
	$pt_args = array(
		'has_archive'		=> true,
	);
	$pts = get_post_types( $pt_args );
	// if (isset($pts['rl_gallery'])) unset $pts['rl_gallery'];
	$pts = array_merge( array('page'), $pts, array('post') );
	$r = '';

	foreach ($pts as $pt) {
		$pto = get_post_type_object( $pt );
		$taxonomies = get_object_taxonomies( $pt );

		$posts_args = array(
				'post_type'			=> $pt,
				'posts_per_page'	=> -1,
				'orderby'			=> 'menu_order',
				'order'				=> 'asc',
		);

		$posts_q = new WP_Query($posts_args);
		if ($posts_q->have_posts()) {

			$r .= '<h3 class="mt-3">'.$pto->labels->name.'</h3>';
			if ($taxonomies) {
				foreach ($taxonomies as $tax) {
					$terms = get_terms( array('taxonomy' => $tax) );
					foreach ($terms as $term) {
						$r .= '<a href="'.get_term_link( $term ).'" class="btn btn-dark btn-sm me-1 mb-1">'.$term->name.'</a>';
					}
				}
			}

			while ($posts_q->have_posts()) { $posts_q->the_post();
				$r .= '<a href="'.get_the_permalink().'" class="btn btn-outline-primary btn-sm me-1 mb-1">'.get_the_title().'</a>';
			}
		}

		wp_reset_postdata();
	}

	return $r;
}
add_shortcode( 'sitemap', 'sitemap' );

function testimonios() {
	ob_start();
	get_template_part( 'global-templates/carousel-testimonios' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'testimonios', 'testimonios' );

function timeline() {
	ob_start();
	get_template_part( 'global-templates/timeline' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'timeline', 'timeline' );

function smn_menus_montal( $atts) {
	extract( shortcode_atts( array(
        'tipo_menu' => '',
    ), $atts ) );

	ob_start();
	get_template_part( 'global-templates/menus-montal', 'acf', $atts );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'menus', 'smn_menus_montal' );

function smn_menu_diario() {

	$menu_diario = get_field( 'menu_diario', 'option' );
	
	if ( $menu_diario) {
		$r = '<a href="#menu-diario-modal" class="btn btn-outline-primary" data-bs-toggle="modal"><span class="btn-text">'.__( 'Ver menú diario', 'smn' ).'</span><span class="btn-arrow">'.SVG_FLECHA.'</span></a>';
	}

	return $r;

}
add_shortcode( 'menu_diario', 'smn_menu_diario' );

function smn_carta_y_vinos_despensa() {

	$carta_despensa = get_field( 'carta_despensa', 'option' );
	$vinos_despensa = get_field( 'vinos_despensa', 'option' );

	$botones = array(
		array(
			'title'		=> __( 'Ver carta de La Despensa', 'smn' ),
			'content'	=> $carta_despensa,
			'slug'		=> 'carta-despensa',
		),
		array(
			'title'		=> __( 'Ver carta de vinos', 'smn' ),
			'content'	=> $vinos_despensa,
			'slug'		=> 'vinos-despensa',
		),
	);

	$r = '';

	foreach( $botones as $boton ) {
	
		if ( $boton['content'] ) {
			$r .= '<a href="#'. $boton['slug'] .'-modal" class="btn btn-outline-primary me-1 mb-1" data-bs-toggle="modal"><span class="btn-text">'. $boton['title'].'</span><span class="btn-arrow">'.SVG_FLECHA.'</span></a>';
		}

	}

	return $r;

}
add_shortcode( 'carta_y_vinos_despensa', 'smn_carta_y_vinos_despensa' );

function smn_get_reusable_block( $block_id = '' ) {
    if ( empty( $block_id ) || (int) $block_id !== $block_id ) {
        return;
    }
    $content = get_post_field( 'post_content', $block_id );
    return apply_filters( 'the_content', $content );
}

function smn_reusable_block( $block_id = '' ) {
    echo smn_get_reusable_block( $block_id );
}

function smn_reusable_block_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'id' => '',
    ), $atts ) );
    if ( empty( $id ) || (int) $id !== $id ) {
        return;
    }
    $content = smn_get_reusable_block( $id );
    return $content;
}
add_shortcode( 'reusable', 'smn_reusable_block_shortcode' );

function sumun_shortcode_subcategorias() {
	ob_start();
	get_template_part( 'global-templates/subcategories' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'subcategorias', 'sumun_shortcode_subcategorias' );

function sumun_shortcode_blog() {
	ob_start();
	get_template_part( 'global-templates/blog' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'blog', 'sumun_shortcode_blog' );

function sumun_shortcode_casos_de_exito() {
	ob_start();
	get_template_part( 'global-templates/casos-de-exito' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'casos_de_exito', 'sumun_shortcode_casos_de_exito' );

add_shortcode( 'blog', 'sumun_shortcode_blog' );

function sumun_shortcode_paginas_destacadas() {
	ob_start();
	get_template_part( 'global-templates/featured-pages' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'paginas_destacadas', 'sumun_shortcode_paginas_destacadas' );

add_shortcode( 'breadcrumb', 'smn_get_breadcrumb' );
add_shortcode( 'breadcrumbs', 'smn_get_breadcrumb' );

add_shortcode( 'infografia', 'smn_get_infografia' );
function smn_get_infografia() {

	if ( have_rows( 'estancias', 'option' ) ) :

		$estancias_completa = get_field( 'estancias-completa', 'option' );

		$r = '<div class="estancias-infografia d-none d-md-block">';

			$r .= '<div class="estancias-infografia-completa active">';
				$r .= wp_get_attachment_image( $estancias_completa, 'large' );
			$r .= '</div>';

			while ( have_rows( 'estancias', 'option' ) ) : the_row();

				$estancia_infografia = get_sub_field( 'estancia_infografia' );

				$estancia_destacado_uno_image_id = get_sub_field( 'estancia_destacado_uno_image_id' );
				$estancia_destacado_dos_image_id = get_sub_field( 'estancia_destacado_dos_image_id' );
				$estancia_destacado_uno_texto = get_sub_field( 'estancia_destacado_uno_texto' );
				$estancia_destacado_dos_texto = get_sub_field( 'estancia_destacado_dos_texto' );
				$estancia_destacado_uno_css = get_sub_field( 'estancia_destacado_uno_css' );
				$estancia_destacado_dos_css = get_sub_field( 'estancia_destacado_dos_css' );

				$destacado_uno = '';
				$destacado_dos = '';

				if ( $estancia_destacado_uno_image_id || $estancia_destacado_uno_texto ) {

					$destacado_uno .= '<div class="row align-items-center g-1">';

						if ( $estancia_destacado_uno_image_id ) {
							$destacado_uno .= '<div class="col-4">';
								$destacado_uno .= wp_get_attachment_image( $estancia_destacado_uno_image_id, 'thumbnail', false, array( 'class' => 'rounded-circle' ) );
							$destacado_uno .= '</div>';
						}

						if ( $estancia_destacado_uno_texto ) {
							$destacado_uno .= '<div class="col">';
								$destacado_uno .= '<div class="small">'. $estancia_destacado_uno_texto .'</div>';
							$destacado_uno .= '</div>';
						}

					$destacado_uno .= '</div>';

				}

				if ( $estancia_destacado_dos_image_id || $estancia_destacado_dos_texto ) {

					$destacado_dos .= '<div class="row align-items-center g-1">';

						if ( $estancia_destacado_dos_image_id ) {
							$destacado_dos .= '<div class="col-4">';
								$destacado_dos .= wp_get_attachment_image( $estancia_destacado_dos_image_id, 'thumbnail', false, array( 'class' => 'rounded-circle' ) );
							$destacado_dos .= '</div>';
						}

						if ( $estancia_destacado_dos_texto ) {
							$destacado_dos .= '<div class="col">';
								$destacado_dos .= '<div class="small">'. $estancia_destacado_dos_texto .'</div>';
							$destacado_dos .= '</div>';
						}

					$destacado_dos .= '</div>';

				}


				if ( $destacado_uno ) {
					$destacado_uno = '<div class="estancia-infografia-destacado estancia-infografia-destacado-uno" style="'. $estancia_destacado_uno_css .'">' . $destacado_uno . '</div>';
				}

				if ( $destacado_dos ) {
					$destacado_dos = '<div class="estancia-infografia-destacado estancia-infografia-destacado-dos" style="'. $estancia_destacado_dos_css .'">' . $destacado_dos . '</div>';
				}

				$r .= '<div class="estancia-infografia" data-infografia-image-id="'. $estancia_infografia .'">';
					$r .= $destacado_uno;
					$r .= wp_get_attachment_image( $estancia_infografia, 'large' );
					$r .= $destacado_dos;
				$r .= '</div>';
			
			endwhile;

		$r .= '</div>';

		return $r;

	endif;

}

add_shortcode( 'infografia_botones', 'smn_get_infografia_botones' );
function smn_get_infografia_botones() {

	if ( have_rows( 'estancias', 'option' ) ) :

		$estancias_completa = get_field( 'estancias-completa', 'option' );

		$r = '<div class="d-none d-md-flex flex-wrap my-3 gap-1 flex-column align-items-stretch">';
		$r_mobile = '<div class="d-md-none accordion accordion-flush" id="accordion-infografia">';

		while ( have_rows( 'estancias', 'option' ) ) : the_row();

			$estancia_title = get_sub_field( 'estancia_title' );
			$estancia_description = get_sub_field( 'estancia_description' );
			$estancia_page_id = get_sub_field( 'estancia_page_id' );
			$estancia_foto = get_sub_field( 'estancia_foto' );
			$estancia_infografia = get_sub_field( 'estancia_infografia' );

			$index = get_row_index() - 1;

			if ( !$estancia_title ) {
				$estancia_title = get_the_title( $estancia_page_id ); 
			}


			$pop_content = '<div class="row g-0 align-items-start">';
				$pop_content .= '<div class="col-4">';
					$pop_content .= wp_get_attachment_image( $estancia_foto, array(80, 80), false, array( 'class' => 'rounded-circle' ) );
				$pop_content .= '</div>';
				$pop_content .= '<div class="col-8 ps-1">';
					$pop_content .= '<p class="h6">'.$estancia_title.'</p>';
					$pop_content .= wpautop( $estancia_description );
					$pop_content .= '<p class="mb-0"><a class="btn btn-sm btn-outline-primary" href="'. get_the_permalink( $estancia_page_id ).'">'. __( 'Ir allí', 'smn' ) .'</a></p>';
				$pop_content .= '</div>';
			$pop_content .= '</div>';

			$pop_content = esc_html( $pop_content );


			$r .= '<a 
				tabindex="0" 
				data-infografia-target-image-id="'. $estancia_infografia .'" 
				data-bs-toggle="popover" 
				data-bs-trigger="focus" 
				data-bs-content="'. $pop_content .'" 
				data-bs-html="true" 
				data-bs-placement="top" 
				role="button" 
				href="'.get_the_permalink( $estancia_page_id ).'" 
				class="btn btn-link text-start border-bottom d-flex flex-no-wrap justify-content-between"
				>
				<span class="btn-text">'.$estancia_title.'</span>
				<span class="btn-arrow">'.SVG_FLECHA.'</span>
			</a>';

			$accordion_show_class = ( $index == 0 ) ? 'show' : '';
			$accordion_button_class = ( $index == 0 ) ? '' : 'collapsed';

			$r_mobile .= '<div class="accordion-item">';
				$r_mobile .= '<p class="accordion-header" id="heading-collapse-infografia-'. $estancia_infografia .'">';
					$r_mobile .= '<button class="accordion-button '. $accordion_button_class.' small btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-infografia-'. $estancia_infografia .'" aria-expanded="false" aria-controls="collapse-infografia-'. $estancia_infografia .'">';
						$r_mobile .= $estancia_title;
					$r_mobile .= '</button>';
				$r_mobile .= '</p>';
				$r_mobile .= '<div id="collapse-infografia-'. $estancia_infografia .'" class="accordion-collapse collapse '. $accordion_show_class .'" data-bs-parent="#accordion-infografia" aria-labelledby="heading-collapse-infografia-'. $estancia_infografia .'">';
					$r_mobile .= '<div class="accordion-body">';

						$r_mobile .= '<div class="estancias-infografia">';

							$r_mobile .= '<div class="estancias-infografia-completa opacity-25">';
								$r_mobile .= wp_get_attachment_image( $estancias_completa, 'large' );
							$r_mobile .= '</div>';

							$r_mobile .= '<div class="estancia-infografia active" data-infografia-image-id="'. $estancia_infografia .'">';
								$r_mobile .= wp_get_attachment_image( $estancia_infografia, 'large' );
							$r_mobile .= '</div>';

						$r_mobile .= '</div>';

						$r_mobile .= '<div class="row g-0 align-items-start">';
							$r_mobile .= '<div class="col-4">';
								$r_mobile .= wp_get_attachment_image( $estancia_foto, array(80, 80), false, array( 'class' => 'rounded-circle' ) );
							$r_mobile .= '</div>';
							$r_mobile .= '<div class="col-8 ps-1">';
								$r_mobile .= '<p class="h6">'.$estancia_title.'</p>';
								$r_mobile .= wpautop( $estancia_description );
								$r_mobile .= '<p class="mb-0"><a class="btn btn-sm btn-outline-primary" href="'. get_the_permalink( $estancia_page_id ).'">'. __( 'Ir allí', 'smn' ) .'</a></p>';
							$r_mobile .= '</div>';
						$r_mobile .= '</div>';
					$r_mobile .= '</div>';
				$r_mobile .= '</div>';
			$r_mobile .= '</div>';
		
		endwhile;

		$r .= '</div>';
		$r_mobile .= '</div>';

		return $r . $r_mobile;

	endif;


}

add_shortcode( 'contador_historia', 'smn_get_contador_historia' );
function smn_get_contador_historia() {

	$current_year = date('Y');
	$origin_year = 1919;

	$start = 1;
	$end = $current_year - $origin_year;

	$r = '';

	$r .= '<span id="counters_1">';

		$r .= '<span class="counter" data-targetnum="'. $end .'" data-speed="5000">';
			$r .= $start;
		$r .= '</span>';

	$r .= '</span>';

	return $r;

}

add_shortcode( 'enlace_pdf', 'smn_enlace_pdf' );
function smn_enlace_pdf( $atts ) {
	extract( shortcode_atts(
		array(
				'nombre' 	=> '',
				'texto'		=> '',
		), $atts)	
	);

	if ( $nombre ) {

		$nombre = explode( ',', $nombre );
		$texto = explode( ',', $texto );

		$r = '';
		$r .= '<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">';

			foreach ( $nombre as $n ) {

				$i = array_search( $n, $nombre );
				$t = ( isset( $texto[$i] ) ) ? $texto[$i] : $n;

				$slug = sanitize_title( $n );
				$url = get_field( 'carta_pdf_' . $slug, 'option' );

				if ( $url ) {
					$url = add_query_arg( 'v', time(), $url );
					$r .= '<div class="wp-block-button is-style-outline">';
						$r .= '<a href="'. $url .'" class="wp-block-button__link enlace-pdf-button" target="_blank"><span class="btn-text">'. $t .'</span><span class="btn-arrow">'. SVG_FLECHA .'</span></a>';
					$r .= '</div>';
				}

			}

		$r .= '</div>';

		return $r;

		// if ( $url ) {
		// 	// remove url protocol
		// 	// $url = preg_replace( '/^https?:\/\//', '', $url );
		// 	return $url;
		// }

	}


}

add_shortcode( 'todos_los_menus_y_cartas', 'smn_todos_los_menus_y_cartas' );
function smn_todos_los_menus_y_cartas() {

	$r = '';
	$r .= '<p class="h3">'. __( 'Todos nuestros menús y cartas', 'smn' ) .'</p>';

	$r .= '<p class="h4">'. __( 'Menús del Restaurante', 'smn' ) .'</p>';
	
	ob_start();
	get_template_part( 'global-templates/menus-montal', 'acf' );
	$r .= ob_get_clean();




	$cartas_pdf = get_field( 'cartas_pdf', 'option' );
	$cartas_pdf = explode( PHP_EOL, $cartas_pdf );

	foreach ( $cartas_pdf as $carta ) {

		$parts = explode( '|', $carta );

		if ( count( $parts ) == 1 ) {
			$r .= '<p class="h4 my-2 mt-3">'. $parts[0] .'</p>';
		} else {

			$slug = sanitize_title( $parts[0] );
			$slug = str_replace( '-', '_', $slug );
			$name = $parts[1];

			$url = get_field( 'carta_pdf_' . $slug, 'option' );
			// $url = wp_get_attachment_url( $pdf_id );

			if ( $url ) {
				$url = add_query_arg( 'v', time(), $url );
				$r .= '<a href="'. $url .'" class="btn btn-outline-primary me-1 mb-1" target="_blank"><span class="btn-text">'. $name .'</span><span class="btn-arrow">'. SVG_FLECHA .'</span></a>';
			}

		}

	}

	return $r;

}