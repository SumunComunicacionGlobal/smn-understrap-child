<?php 

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_post_type_support( 'page', 'excerpt' );

if ( ! function_exists('custom_post_type_slide') ) {

	// Register Custom Post Type
	function custom_post_type_slide() {

		$labels = array(
			'name'                  => _x( 'Slides', 'Post Type General Name', 'smn' ),
			'singular_name'         => _x( 'Slide', 'Post Type Singular Name', 'smn' ),
			'menu_name'             => __( 'Slides', 'smn-admin' ),
			'name_admin_bar'        => __( 'Slides', 'smn-admin' ),
			'add_new'               => __( 'Añadir nueva Slide', 'smn-admin' ),
			'new_item'              => __( 'Nueva Slide', 'smn-admin' ),
			'edit_item'             => __( 'Editar Slide', 'smn-admin' ),
			'update_item'           => __( 'Actualizar Slide', 'smn-admin' ),
			'view_item'             => __( 'Ver Slide', 'smn-admin' ),
			'view_items'            => __( 'Ver Slide', 'smn-admin' ),
		);
		$args = array(
			'label'                 => __( 'Slides', 'smn' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 3,
			'menu_icon'             => 'dashicons-slides',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest' 			=> true,
			'taxonomies'			=> array(),
		);
		register_post_type( 'slide', $args );

	}
	// add_action( 'init', 'custom_post_type_slide', 0 );

}

function wpb_change_title_text( $title ){
     $screen = get_current_screen();
  
     if  ( 'slide' == $screen->post_type ) {
          $title = 'Título de la slide';
     }
  
     return $title;
}
add_filter( 'enter_title_here', 'wpb_change_title_text' );

// ADD NEW COLUMN
add_filter('manage_posts_columns', 'smn_columns_head');
add_filter('manage_pages_columns', 'smn_columns_head');
add_action('manage_posts_custom_column', 'smn_columns_content', 10, 2);
add_action('manage_pages_custom_column', 'smn_columns_content', 10, 2);
function smn_columns_head($defaults) {
    $defaults['extracto'] = 'Resumen';
    return $defaults;
}
 
function smn_columns_content($column_name, $post_ID) {

    if ($column_name == 'extracto') {
    	$post = get_post($post_ID);
    	echo $post->post_excerpt;
    }
	
}

function change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = __('Noticias', 'smn-admin');
	$submenu['edit.php'][5][0] = __('Noticias', 'smn-admin');
	$submenu['edit.php'][10][0] = __('Añadir Noticias', 'smn-admin');
	$submenu['edit.php'][16][0] = __('Etiquetas de Noticias', 'smn-admin');
}
add_action( 'admin_menu', 'change_post_menu_label' );

function change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = __('Noticias', 'smn');
	$labels->singular_name = __('Noticia', 'smn');
	$labels->add_new = __('Añadir Noticia', 'smn-admin');
	$labels->add_new_item = __('Añadir Noticia', 'smn-admin');
	$labels->edit_item = __('Editar Noticia', 'smn-admin');
	$labels->new_item = __('Nueva Noticia', 'smn-admin');
	$labels->view_item = __('Ver Noticia', 'smn-admin');
}
add_action( 'init', 'change_post_object_label' );