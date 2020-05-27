<?php
/*
 * Register a Custom Post Type (Galería)
 */
add_action('init', 'gallery_init');

function gallery_init() {
    $labels = array(
        'name'               => _x('Galerías', 'post type general name'),
        'singular_name'      => _x('Galería', 'post type singular name'),
        'add_new'            => _x('Agregar Nueva', 'gallery'),
        'add_new_item'       => __('Agregar Nueva galería'),
        'edit_item'          => __('Editar galería'),
        'new_item'           => __('Nueva galería'),
        'view_item'          => __('Ver galería'),
        'search_items'       => __('Buscar galerías'),
        'not_found'          => __('No se encontraron galerías'),
        'not_found_in_trash' => __('No no se encontraron galerías en la papelera'),
        'parent_item_colon'  => '',
        'menu_name'          => 'Galerías'
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => 'gallery',
        'hierarchical'       => false,
        'menu_position'      => 4,
        'menu_icon'          => 'dashicons-format-gallery',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'taxonomies'         => array('gallery-category', 'gallery-tag')
    );
    register_post_type('gallery', $args);
}

/* Update galeria Messages */
add_filter('post_updated_messages', 'gallery_updated_messages');
function gallery_updated_messages($messages) {
    global $post, $post_ID;
    $messages['gallery'] = array(
        0 => '',
        1 => sprintf(__('galeria actualizada.'), esc_url(get_permalink($post_ID))),
        2 => __('Custom field actualizado.'),
        3 => __('Custom field deleted.'),
        4 => __('Galería actualizada.'),
        5 => isset($_GET['revision']) ? sprintf(__('Galeía restaurada de revisión desde %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6 => sprintf(__('Galería publicada.'), esc_url(get_permalink($post_ID))),
        7 => __('Galería guardada.'),
        8 => sprintf(__('Galería publicada.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        9 => sprintf(__('Galería archivada para: <strong>%1$s</strong>. '), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
        10 => sprintf(__('Galería en borrador actualizado.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );
    return $messages;
}

/* Update galeria Help */
add_action('contextual_help', 'gallery_help_text', 10, 3);
    function gallery_help_text($contextual_help, $screen_id, $screen) {
    if ('gallery' == $screen->id) {
        $contextual_help =
        '<p>' . __('Cosas para recordar a la hora de agregar un galería:') . '</p>' .
        '<ul>' .
        '<li>' . __('Darle un título al galería. El título sea usado como cabecera del galería') . '</li>' .
        '<li>' . __('Agregar una imagen destacada para darle el fondo al galería.') . '</li>' .
        '<li>' . __('Agregar texto. El texto aparecerá en cada galeria durante la transición.') . '</li>' .
        '</ul>';
    }
    elseif ('edit-gallery' == $screen->id) {
        $contextual_help = '<p>' . __('Una lista de todos los galerias aparece debajo. para editar un galeria haga click en el título.') . '</p>';
    }
    return $contextual_help;
}
?>
