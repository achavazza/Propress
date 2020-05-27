<?php
/**
 * This snippet has been updated to reflect the official supporting of options pages by CMB2
 * in version 2.2.5.
 *
 * If you are using the old version of the options-page registration,
 * it is recommended you swtich to this method.
 */
add_action( 'cmb2_admin_init', 'tnb_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function tnb_register_theme_options_metabox() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb = new_cmb2_box( array(
		'id'           => 'tnb_option_info_metabox',
		'title'        => esc_html__( 'Información', 'tnb' ),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'tnb_options', // The option key and admin menu page slug.
		'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'tnb' ), // Falls back to 'title' (above).
		// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'tnb' ), // The text for the options-page save button. Defaults to 'Save'.
	) );

	/*
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */

	$cmb->add_field( array(
 		'name' => 'Email',
 		'id'   => $prefix.'email',
 		'desc' => 'A que email se enviaran los correos del formulario',
 		'type' => 'text_email',
 	) );
 	$cmb->add_field( array(
 		'name'     => 'Teléfono/s',
 		'id'       => $prefix.'phone',
 		'type'     => 'text',
 		'repeatable' => true
 	));
 	$cmb->add_field( array(
 		'name'     => 'Fax',
 		'id'       => $prefix.'fax',
 		'type'     => 'text',
 	));

 	$cmb->add_field( array(
 		'name'     => 'Dirección',
 		'id'       => $prefix.'address',
 		'type'     => 'textarea',
 	));
 	$cmb->add_field( array(
 		'name'     => 'Localidad',
 		'id'       => $prefix.'location',
 		'type'     => 'textarea',
 	));
 	$cmb->add_field( array(
 		'name' => 'Mapa',
 		'desc' => 'Drag the marker to set the exact location',
 		'id'   => $prefix.'map',
 		'type' => 'pw_map',
 		'save_address' => true,
 		// 'split_values' => true, // Save latitude and longitude as two separate fields
 	));
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
function tnb_get_option( $key = '', $default = false ) {
	if ( function_exists( 'cmb2_get_option' ) ) {
		// Use cmb2_get_option as it passes through some key filters.
		return cmb2_get_option( 'tnb_options', $key, $default );
	}

	// Fallback to get_option if CMB2 is not loaded yet.
	$opts = get_option( 'tnb_options', $default );

	$val = $default;

	if ( 'all' == $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}

	return $val;
}
