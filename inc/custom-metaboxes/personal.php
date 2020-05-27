<?php
//function remove_title_editor_on_position() {
//    remove_post_type_support('position', 'title' );
//    remove_post_type_support('position', 'editor' );
//}
//add_action( 'init', 'remove_title_editor_on_position' );
/*
function mytheme_admin_load_scripts($hook) {
    if( $hook != 'post.php' && $hook != 'post-new.php' )
        return;

    wp_enqueue_script( 'custom-js', get_template_directory_uri()."/js/personal-admin.js" );
}
add_action('admin_enqueue_scripts', 'mytheme_admin_load_scripts');
*/

// custom metaboxes
add_action( 'cmb2_init', 'cmb2_personal' );

//print_r($const->teams);die;
/**
 * Define the metabox and field configurations.
 */
function cmb2_personal() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_position_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => 'position_metaboxes',
        'title'         => __( 'Lista de personal', 'cmb2' ),
        'object_types'  => array( 'page' ), // post type
        'show_on'       => array( 'key' => 'page-template', 'value' => 'page-about.php' ),
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    $group_field_id = $cmb->add_field( array(
        'id'          => 'cmb_personal_metabox',
        'type'        => 'group',
        'description' => __( 'Agrega individuos del personal', 'cmb' ),
        'options'     => array(
            'group_title'   => __( 'Empleado {#}', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'    => __( 'Agregar otro empleado', 'cmb' ),
            'remove_button' => __( 'Eliminar empleado', 'cmb' ),
            'sortable'      => true, // beta
        ),
    ) );
    $cmb->add_group_field( $group_field_id, array(
        'name'    => 'Imagen',
        'desc'    => 'Subir una imagen o ingresar una URL',
        'id'      => 'image',
        'type'    => 'file',
        // Optionally hide the text input for the url:
        'options' => array(
            'url' => false,
        ),
    ) );
    // Id's for group's fields only need to be unique for the group. Prefix is not needed.
    $cmb->add_group_field( $group_field_id, array(
        'name' => 'Nombre',
        'id'   => 'name',
        'type' => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );
    $cmb->add_group_field( $group_field_id, array(
        'name' => 'Título',
        'id'   => 'degree',
        'type' => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );
    $cmb->add_group_field( $group_field_id, array(
        'name' => 'Rol',
        'id'   => 'role',
        'type' => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );


}
 ?>
