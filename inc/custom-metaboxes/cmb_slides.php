<?php
//function remove_title_editor_on_slides() {
//    remove_post_type_support('slides', 'title' );
//    remove_post_type_support('slides', 'editor' );
//}
//add_action( 'init', 'remove_title_editor_on_slides' );
/*
function mytheme_admin_load_scripts($hook) {
    if( $hook != 'post.php' && $hook != 'post-new.php' )
        return;

    wp_enqueue_script( 'custom-js', get_template_directory_uri()."/js/personal-admin.js" );
}
add_action('admin_enqueue_scripts', 'mytheme_admin_load_scripts');
*/

// custom metaboxes
add_action( 'cmb2_init', 'cmb2_slides' );

//print_r($const->teams);die;
/**
 * Define the metabox and field configurations.
 */
function cmb2_slides() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_slides_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => 'slides_metaboxes',
        'title'         => __( 'Lista de slides', 'cmb2' ),
        'object_types'  => array( 'page' ), // post type
        'show_on'       => array( 'key' => 'page-template', 'value' => 'page-slider.php' ),
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    $group_field_id = $cmb->add_field( array(
        'id'          => 'cmb_slides_metabox',
        'type'        => 'group',
        'description' => __( 'Agrega slides al home', 'cmb' ),
        'options'     => array(
            'group_title'   => __( 'Slide {#}', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'    => __( 'Agregar otra slide', 'cmb' ),
            'remove_button' => __( 'Eliminar slide', 'cmb' ),
            'sortable'      => true, // beta
        ),
    ) );
    $cmb->add_group_field( $group_field_id, array(
        'name'    => 'Imagen',
        'desc'    => 'Subir una imagen o ingresar una URL',
        'id'      => $prefix . 'image',
        'type'    => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false,
        ),
    ) );
    $cmb->add_group_field( $group_field_id, array(
        'name'    => 'Color de fondo',
        'id'      => $prefix .'colorpicker',
        'desc'    => __( 'Elegir el color de fondo del slide (util para monitores grandes)', 'cmb2' ),
        'type'    => 'colorpicker',
        'default' => '#ffffff',
    ) );
    // Id's for group's fields only need to be unique for the group. Prefix is not needed.
    $cmb->add_group_field( $group_field_id, array(
        'name'       => __( 'Titulo', 'cmb2' ),
        'desc'       => __( 'La primer linea del slide (opcional)(una palabra el texto es grande)', 'cmb2' ),
        'id'         => $prefix . 'text1',
        'type'       => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );
    // Id's for group's fields only need to be unique for the group. Prefix is not needed.
    $cmb->add_group_field( $group_field_id, array(
        'name'       => __( 'texto', 'cmb2' ),
        'desc'       => __( 'resumen del slide (opcional)', 'cmb2' ),
        'id'         => $prefix . 'description',
        'type'       => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );
    // Id's for group's fields only need to be unique for the group. Prefix is not needed.
    $cmb->add_group_field( $group_field_id, array(
        'name'       => __( 'texto', 'cmb2' ),
        'desc'       => __( 'resumen del slide (opcional)', 'cmb2' ),
        'id'         => $prefix . 'description',
        'type'       => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );
    // Add new field
    $cmb->add_group_field( $group_field_id, array(
        'name'            => __( 'Publicación relacionada (pages o posts)', 'cmb2' ),
        'id'              => $prefix . 'related_post',
        'type'            => 'post_search_text', // This field type
        'post_type'       => array('page','post'), // post type also as array
        'select_type'     => 'radio', // Default is 'checkbox', used in the modal view to select the post type
        'select_behavior' => 'replace', // Will replace any selection with selection from modal. Default is 'add'
    ) );
}
 ?>
