<?php
/**
* Define the metabox and field configurations.
*/

// custom metaboxes
add_action( 'cmb2_init', 'cmb2_post_gallery' );

function cmb2_post_gallery() {

    // Start with an underscore to hide fields from custom fields list
    //$prefix = '_gallery_';

    /**
    * Initiate the metabox
    */
    $cmb = new_cmb2_box( array(
        'id'            => 'post_gallery_metabox',
        //'id'            => 'gallery_metabox',
        'title'         => __( 'Galería de imágenes', 'cmb2' ),
        'object_types'  => array( 'post','page' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        'priority'      => 'low',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    $cmb->add_field( array(
        'name' => 'Imágenes',
        'desc' => 'Subir y administrar imágenes',
        'id'   => '_prop_images',
        //'id'   => $prefix . 'images',
        'type' => 'file_list',
        // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
        'query_args' => array( 'type' => 'image' ), // Only images attachment
        // Optional, override default text strings
        'text' => array(
            'add_upload_files_text' => 'Agregar Imágenes', // default: "Add or Upload Files"
            'remove_image_text' => 'Eliminar', // default: "Remove Image"
            'file_text' => 'Archivo:', // default: "File:"
            'file_download_text' => 'Descarga', // default: "Download"
            'remove_text' => 'Eliminar', // default: "Remove"
        ),
    ) );
}

?>
