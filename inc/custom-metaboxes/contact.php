<?php

// custom metaboxes
add_action( 'cmb2_init', 'cmb2_contact' );

/**
 * Define the metabox and field configurations.
 */
function cmb2_contact() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_contact_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => 'contact_metabox',
        'title'         => __( 'Datos de contacto', 'cmb2' ),
        'object_types'  => array( 'page' ), // post type
        'show_on'       => array( 'key' => 'page-template', 'value' => 'page-contact.php' ),
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    // Regular text field
    $cmb->add_field( array(
        'name'       => __( 'Teléfono', 'cmb2' ),
        'desc'       => __( 'agregar un telefono (opcional)', 'cmb2' ),
        'id'         => $prefix . 'phone',
        'type'       => 'text',
        'repeatable' => true,
        'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );
    // Regular text field
    $cmb->add_field( array(
        'name'       => __( 'Dirección', 'cmb2' ),
        'desc'       => __( 'Agregar una dirección (opcional)', 'cmb2' ),
        'id'         => $prefix . 'address',
        'type'       => 'text',
        'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );
    $cmb->add_field( array(
        'name'       => __( 'Información extra', 'cmb2' ),
        'desc'       => __( 'Agregar información extra (por ejemplo código postal, localidad, pais) (opcional)', 'cmb2' ),
        'id'         => $prefix . 'extra',
        'type'       => 'text',
        'default'    => '(3000) Santa Fé, Argentina',
        'show_on_cb' => 'cmb2_hide_if_no_cats', // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );

}
 ?>
