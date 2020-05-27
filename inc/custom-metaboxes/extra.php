<?php
add_action( 'cmb2_init', 'cmb2_extra' );

/**
 * Define the metabox and field configurations.
 */
function cmb2_extra() {
    // Start with an underscore to hide fields from custom fields list
    $prefix = 'extra_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => 'extra_metabox',
        'title'         => __( 'Opciones', 'tnb' ),
        'object_types'  => array( 'post','page' ), // post type
        //'show_on'       => array( 'key' => 'page-template', 'value' => 'page-products.php' ),
        'context'       => 'normal',
        //'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );
    // Single term
	$cmb->add_field( array(
        'name'          => __( 'Slider', 'tnb' ),
		'id'            => 'extra_slider',
		'type'          => 'term_ajax_search',
		'query_args'	=> array(
			'taxonomy'			=> 'slider',
			'childless'			=> true
		)
	) );
    $cmb->add_field( array(
		'name'             => __( 'Posicion de la imagen destacada', 'tnb' ),
		'id'               => 'extra_image_position',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => array(
                'top'      => __('Arriba del título', 'tnb'),
                'bottom'   => __('Debajo del título', 'tnb'),
            )
	));
}
 ?>
