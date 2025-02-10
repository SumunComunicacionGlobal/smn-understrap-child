<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if( function_exists('acf_add_local_field_group') ):

    // add a local field group "Menús del restaurante" in "cartas" options page, with a repeater field with some subfields:
    // Nombre del menú, imagen, archivo PDF, descripción y precio

    acf_add_local_field_group(array(
        'key' => 'group_62b9b37e73206',
        'title' => 'Menús del restaurante',
        'fields' => array(
            array(
                'key' => 'field_62b9b3a173207',
                'label' => 'Modifica aquí los menús del restaurante. Para el resto de menús y cartas (despensa, catering, celebraciones...) utiliza la sección "Configuración de otras cartas y menús" más abajo',
                'name' => 'menus',
                'type' => 'repeater',
                'instructions' => 'Añadir los menús del restaurante.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => 'field_62b9b3b073208',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Añadir menú al restaurante',
                'sub_fields' => array(
                    array(
                        'key' => 'field_62c210963a1e8',
                        'label' => 'Ocultar temporalmente este menú',
                        'name' => 'ocultar',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '100',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),
                    array(
                        'key' => 'field_62b9b3b073208',
                        'label' => 'Nombre del menú',
                        'name' => 'menu_name',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '33',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_62b9b3c073209',
                        'label' => 'Archivo PDF',
                        'name' => 'menu_pdf',
                        'type' => 'file',
                        'instructions' => 'Usar el siguiente shortcode para insertar el enlace en cualquier botón: <code>[enlace_pdf nombre="nombre-del-menu"]</code>',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '33',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'url',
                        'library' => 'all',
                        'min_size' => '',
                        'max_size' => '',
                        'mime_types' => 'pdf',
                    ),
                    array(
                        'key' => 'field_62b9b3e07320b',
                        'label' => 'Precio',
                        'name' => 'menu_price',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '33',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_62b9b3f07320c',
                        'label' => 'Imagen',
                        'name' => 'menu_image',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '33',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                    array(
                        'key' => 'field_62b9b3d07320a',
                        'label' => 'Descripción',
                        'name' => 'menu_description',
                        'type' => 'wysiwyg',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '66',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'tabs' => 'visual',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                        'delay' => 0,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'cartas',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    // add a local field group "Configuración de cartas" in "cartas" options page, with a file field for each carta

    $cartas_pdf = get_field('cartas_pdf', 'option');
    $cartas_pdf = explode( PHP_EOL, $cartas_pdf );

    if ( $cartas_pdf ) {

        $fields = array();

        foreach ( $cartas_pdf as $carta ) {

            $parts = explode( '|', $carta );

            if ( count( $parts ) == 1 ) {

                $slug = 'section_title_' . sanitize_title( $parts[0] );   
                $title = $parts[0];

                // add a message field
                $fields[] = array(
                    'key' => 'field_62b9b37e73206_' . $slug,
                    'label' => '<h1>Sección: <br><strong>' . $title . '</strong></h1>',
                    'name' => $slug,
                    'type' => 'message',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => '',
                    'new_lines' => 'wpautop',
                    'esc_html' => 0,
                );


            } else {

                $slug = sanitize_title( $parts[0] );   
                // $title = $parts[1] . ' (' . $slug . ')';         
                $title = $parts[1];         

                $fields[] = array(
                    'key' => 'field_62b9b37e73206_' . $slug,
                    'label' => 'Carta PDF: <strong>' . $title . '</strong>',
                    'name' => 'carta_pdf_' . $slug,
                    'type' => 'file',
                    'instructions' => 'Usar el siguiente shortcode para insertar el enlace en cualquier botón: <code>[enlace_pdf nombre="' . $slug . '"]</code>',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'url',
                    'library' => 'all',
                    'min_size' => '',
                    'max_size' => '',
                    'mime_types' => 'pdf',
                );

            }

        }
        
        // add a local field group in "cartas" options page
        acf_add_local_field_group(array(
            'key' => 'group_62b9b353de7b6_' . sanitize_title( $carta ),
            'title' => 'Configuración de otras cartas y menús',
            'fields' => $fields,
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'cartas',
                    ),
                ),
            ),
            'menu_order' => 10,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));

    }

    acf_add_local_field_group(array(
        'key' => 'group_629dfb4e7fd46',
        'title' => 'Campos para Categorías',
        'fields' => array(
            array(
                'key' => 'field_629dfb572084c',
                'label' => 'Imagen principal de la categoría',
                'name' => 'thumbnail_id',
                'type' => 'image',
                'instructions' => 'Se muestra en la cabecera.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'id',
                'preview_size' => 'medium',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array(
                'key' => 'field_62bec55ca8713',
                'label' => 'Contenido bajo la cabecera',
                'name' => 'secondary_description',
                'type' => 'wysiwyg',
                'instructions' => 'Aparece bajo la cabecera de página.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_62bf00ec539dc',
                'label' => 'Fragmentos de contenido en la parte superior',
                'name' => 'top_fragments',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'content_fragment',
                ),
                'taxonomy' => '',
                'allow_null' => 1,
                'multiple' => 1,
                'return_format' => 'id',
                'ui' => 1,
            ),
            array(
                'key' => 'field_62bf0111539dd',
                'label' => 'Fragmentos de contenido en la parte inferior',
                'name' => 'bottom_fragments',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'content_fragment',
                ),
                'taxonomy' => '',
                'allow_null' => 1,
                'multiple' => 1,
                'return_format' => 'id',
                'ui' => 1,
            ),
            array(
                'key' => 'field_62beea3792dd3',
                'label' => 'Contenido al pie',
                'name' => 'terciary_description',
                'type' => 'wysiwyg',
                'instructions' => 'Aparece al final de la página.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_62bef184cd1f5',
                'label' => 'Entradas relacionadas',
                'name' => 'related_posts',
                'type' => 'post_object',
                'instructions' => 'Entradas de blog relacionadas',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'post',
                ),
                'taxonomy' => '',
                'allow_null' => 1,
                'multiple' => 1,
                'return_format' => 'id',
                'ui' => 1,
            ),
            array(
                'key' => 'field_62bef184cd1f6',
                'label' => 'Categorías relacionadas',
                'name' => 'related_categories',
                'type' => 'taxonomy',
                'instructions' => 'Selecciona las categorías relacionadas',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'taxonomy' => 'product_cat',
                'field_type' => 'multi_select',
                'allow_null' => 1,
                'add_term' => 1,
                'save_terms' => 1,
                'load_terms' => 1,
                'return_format' => 'id',
                'multiple' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'product_cat',
                ),
            ),
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'category',
                ),
            ),
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'product_tag',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    
    acf_add_local_field_group(array(
        'key' => 'group_62b9b353de7b6',
        'title' => 'Configuración de cabecera y footer',
        'fields' => array(
            array(
                'key' => 'field_62b9b37e73206',
                'label' => 'Fondo de la barra de menú',
                'name' => 'navbar_bg',
                'type' => 'radio',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'navbar-dark' => 'Oscuro',
                    'navbar-light' => 'Claro',
                    'transparent' => 'Transparente',
                ),
                'allow_null' => 1,
                'other_choice' => 0,
                'default_value' => '',
                'layout' => 'vertical',
                'return_format' => 'value',
                'save_other_choice' => 0,
            ),
            array(
                'key' => 'field_62c210963a1e9',
                'label' => 'Ocultar Prefooter',
                'name' => 'ocultar_prefooter',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    
    endif;		