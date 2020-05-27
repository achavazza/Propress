<?php

define( 'BUTTONS_URL', get_template_directory_uri() . '/inc/cmb2-plugins/CMB2-Buttonset-Field-master/');
function setup_buttonset_metafield_scripts() {
	wp_enqueue_script( 'buttonset-metafield', BUTTONS_URL . 'buttonset_metafield.js'   );
	wp_enqueue_style(  'buttonset-metafield',  BUTTONS_URL . 'buttonset_metafield.css' , array() );
}
function cmb2_render_buttonset( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
	setup_buttonset_metafield_scripts();

	$buttonset = '<div class="cmb2-buttonset">';
	$conditional_value =(isset($field->args['attributes']['data-conditional-value'])?'data-conditional-value="' .esc_attr($field->args['attributes']['data-conditional-value']).'"':'');
    $conditional_id =(isset($field->args['attributes']['data-conditional-id'])?' data-conditional-id="'.esc_attr($field->args['attributes']['data-conditional-id']).'"':'');
    $default_value = $field->args['attributes']['default'];

	foreach ( $field->options() as $value => $item ) {
		$selected_input = ($value === ($escaped_value==''?$default_value:$escaped_value )) ? 'checked="checked"' : '';
		$selected_label = ($value === ($escaped_value==''?$default_value:$escaped_value )) ? ' selected' : '';
		$buttonset .= '<input '.$conditional_value.$conditional_id.' type="radio" id="' .$field->args['_name'] . esc_attr( $value ) . '" name="' . $field->args['_name'] . '" value="' . esc_attr( $value ) . '" ' . $selected_input . ' class="cmb2-buttonset-item">
		<label class="cmb2-buttonset-label button button-large state-default'.$selected_label.'" for="' .$field->args['_name'] . esc_attr( $value ) . '"><span class="buttonset-text">' . esc_html( $item ) . '</span></label>';
	}

	$buttonset .= '</div>';
	$buttonset .= $field_type_object->_desc( true );
	echo $buttonset;

}
add_action( 'cmb2_render_buttonset', 'cmb2_render_buttonset', 10, 5 );
