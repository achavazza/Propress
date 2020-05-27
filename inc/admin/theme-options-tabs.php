<?php
add_action( 'cmb2_admin_init', 'theme_options_page' );

function theme_options_page() {

    // the options key fields will be saved under
    $opt_key = 'theme_options';

    // the show_on parameter for configuring the CMB2 box, this is critical!
    $show_on = array( 'key' => 'options-page', 'value' => array( $opt_key ) );

    // an array to hold our boxes
    $boxes = array();

    // an array to hold some tabs
    $tabs = array();

    // Tabs - an array of configuration arrays.
    $tabs[] = array(
         'id'    => 'your_tab_id',
         'title' => 'First',
         'desc'  => '<p>Optional HTML above the metabox on this tab.</p>',
         'boxes' => array(
             'test2_metabox'
         ),
    );
    $tabs[] = array(
        'id'    => 'your_tab_id2',
        'title' => 'Second',
        'desc'  => '',
        'boxes' => array(
            'test_metabox'
        ),
    );

    // add first box: this is just normal CMB2 box creation, with the exception
    // of the show_on parameter and call to object_type method, both essential
    $cmb = new_cmb2_box( array(
        'id'          => 'test_metabox',
        'title'       => __( 'Test Metabox', 'cmb2' ),
        'parent_slug' => 'options-page',
        'show_on'     => $show_on,
    ));

    $cmb->add_field( array(
        'name'       => __( 'Test Text', 'cmb2' ),
        'desc'       => __( 'field description (optional)', 'cmb2' ),
        'id'         => 'my_text_1',
        'type'       => 'text',
    ));
    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;

    // box 2
    $cmb = new_cmb2_box( array(
        'id'        => 'test2_metabox',
        'title'     => __( 'Another Metabox', 'cmb2' ),
        'parent_slug' => 'options-page',
        'show_on'   => $show_on,
    ));
    $cmb->add_field( array(
        'name'       => __( 'Text 2', 'cmb2' ),
        'desc'       => __( 'Text 2', 'cmb2' ),
        'id'         => 'my_text2',
        'type'       => 'text',
    ));
    $cmb->object_type( 'options-page' );
    $boxes[] = $cmb;

    // box 3, in sidebar of our two-column layout
    $cmb = new_cmb2_box( array(
        'id'        => 'side_metabox',
        'title'     => __( 'Save Options', 'cmb2' ),
        //'menu_title' => false,
        'parent_slug' => 'options-page',
        'show_on'   => $show_on,
        'context'    => 'side',
    ));
    $cmb->add_field( array(
        'name'       => __( 'Publish?', 'cmb2' ),
        'desc'       => __( 'Save These Options', 'cmb2' ),
        'id'         => 'my_save_button',
        'type'       => 'options_save_button',
        'show_names' => false,
    ));
    $cmb->object_type( 'options-page' );

    $boxes[] = $cmb;

    // Arguments array. See the arguments page for more detail
    $args = array(
        'key'        => $opt_key,
        'title'      => 'TNB Options',
        'topmenu'    => 'options-general.php',
        'boxes'      => $boxes,
        'tabs'       => $tabs,
        'cols'       => 2,
        'savetxt'    => '',
    );

    new Cmb2_Metatabs_Options( $args );
}
?>
