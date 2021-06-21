<?php
/**
 * Plugin Name: CMB2 Widget Boilerplate
 * Description: A boilerplate for building widgets with CMB2. Early alpha version. NEEDS WORK.
 */

// Exit if accessed directly
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

/**
 * @todo Properly hook in JS events, etc. Fields which require JS are not working.
 * @todo Fix css styling. Probably needs a sep. CSS file enqueued for widgets.
 */
class CMB2_Widget_Agent extends WP_Widget {
	protected $widget_slug = 'widget-agent';
	protected static $shortcode = 'widget-agent';
	protected $cmb2 = null;
	protected static $defaults = array();
	protected $_instance = array();
	protected $cmb2_fields = array();
	public function __construct() {

		parent::__construct(
			$this->widget_slug,
			esc_html__( 'Agentes asociados', 'tnb' ),
			array(
				'classname' => $this->widget_slug,
				//'customize_selective_refresh' => true,
				'description' => esc_html__( 'Lista el agente asociado a la propiedad', 'tnb' ),
			)
		);

		self::$defaults = array(
			'title'         => 'Agentes asociados',
			'desc'          => '',
            'contact_type'  => null,
            'contact_check' => null,
            'contact_phone' => null,
            'contact_mail'  => null,
            'contact_wa'    => null,
            //'image'         => '',
			//'posts_num'  => 3,
			//'color' => '#bada55',
		);

		$this->cmb2_fields = array(
			array(
                'name'   => __('Título', 'tnb'),
				'id_key' => 'title',
				'id'     => 'widget-agent-title',
				'type'   => 'text',
			),
            array(
            	'name'   => '',
            	'desc'   => __('Mostrar tipo de agente', 'tnb'),
                'id_key' => 'contact_type',
            	'id'     => 'contact_type',
            	'type'   => 'checkbox',
            ),
            array(
            	'name'   => '',
            	'desc'   => __('Mostrar formulario de contacto', 'tnb'),
                'id_key' => 'contact_check',
            	'id'     => 'contact_check',
            	'type'   => 'checkbox',
            ),
            array(
            	'name'   => '',
            	'desc'   => __('Mostrar teléfono', 'tnb'),
                'id_key' => 'contact_phone',
            	'id'     => 'contact_phone',
            	'type'   => 'checkbox',
            ),
            array(
            	'name'   => '',
            	'desc'   => __('Mostrar e-mail', 'tnb'),
                'id_key' => 'contact_mail',
            	'id'     => 'contact_mail',
            	'type'   => 'checkbox',
            ),
            array(
            	'name'   => '',
            	'desc'   => __('Mostrar WhatAapp', 'tnb'),
                'id_key' => 'contact_wa',
            	'id'     => 'contact_wa',
            	'type'   => 'checkbox',
            )
			/*array(
				'name'    => 'Image',
				'desc'    => 'Upload an image or enter an URL.',
				'id_key'  => 'image',
				'id'      => 'image',
				'type'    => 'file',
				'options' => array(
					'url'	=> false
				),
				'text' => array(
					'add_upload_file_text' => 'Upload An Image'
				),
			),
			array(
				'name'    => 'Numero de posts',
				'id_key'  => 'posts_num',
				'id'      => 'posts_num',
				'type'     => 'text',
		        'attributes' => array(
		            'type' => 'number',
		            'pattern' => '\d*',
		        ),
			),
			array(
				'name'   => 'Color',
				'id_key' => 'color',
				'id'     => 'color',
				'type'   => 'colorpicker',
			),
            */
		);

		add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
		add_shortcode( self::$shortcode, array( __CLASS__, 'get_widget' ) );
	}

	/**
	 * Delete this widget's cache.
	 *
	 * Note: Could also delete any transients
	 * delete_transient( 'some-transient-generated-by-this-widget' );
	 */
	public function flush_widget_cache() {
		wp_cache_delete( $this->id, 'widget' );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @param  array  $args      The widget arguments set up when a sidebar is registered.
	 * @param  array  $instance  The widget settings as set by user.
	 */
	public function widget( $args, $instance ) {
		echo self::get_widget( array(
			'args'     => $args,
			'instance' => $instance,
			'cache_id' => $this->id, // whatever the widget id is
		) );
	}
	/**
	 * Return the widget/shortcode output
	 *
	 * @param  array  $atts Array of widget/shortcode attributes/args
	 * @return string       Widget output
	 */
	public static function get_widget( $atts ) {
		$widget = '';
		// Set up default values for attributes
		//$atts = shortcode_atts(
		$attribs = shortcode_atts(
			array(
				// Ensure variables
				'instance'      => array(),
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
				'cache_id'      => '',
				'flush_cache'   => isset( $_GET['delete-trans'] ), // Check for cache-buster
			),
			isset( $atts['args'] ) ? (array) $atts['args'] : (array) $attribs['args'],
			self::$shortcode
		);

        //pr($attribs);
		$instance = shortcode_atts(
			self::$defaults,
			! empty( $atts['instance'] ) ? (array) $atts['instance'] : $attribs['args'],
			self::$shortcode
		);

		//pr($atts);
		//pr($defaults);

		/*
		 * If cache_id is not passed, we're not using the widget (but the shortcode),
		 * so generate a hash cache id from the shortcode arguments
		 */
		if ( empty( $atts['cache_id'] ) ) {
			$atts['cache_id'] = md5( serialize( $atts ) );
		}

		// Get from cache unless being requested not to
		$widget = ! $atts['flush_cache']
			? wp_cache_get( $atts['cache_id'], 'widget' )
			: '';

		// If $widget is empty, rebuild our cache
		if ( empty( $widget ) ) {
            //$values = explode(";", $_COOKIE['wpb_visited_props']);
            $widget = '';
            $contact_check = $instance['contact_check'];
            //$post_num = intval($instance['posts_num']);
			//pr($instance);
            /*
        	$widget_query = new WP_Query([
				'post_type'           => 'propiedad',
        		'posts_per_page'      => $post_num,
        		'ignore_sticky_posts' => 1,
                'post__in'            => $values,
        		'post__not_in'        => array(get_the_ID()),
        		//'post__not_in'        => $featPosts
			]);
            */
			$widget_title = ( $instance['title'] ) ? $atts['before_title'] . esc_html( $instance['title'] ) . $atts['after_title'] : '';
            //pr($widget_title);

			$id      = $atts['args']['widget_id'];
			$class   = 'widget card '. $atts['args']['id'];

            $widget .= sprintf('<div id="%s" class="%s">', $id, $class);
            $widget .= $atts['before_widget'];
			$widget .= sprintf('<div class="card-header"><h2 class="card-header-title">%s</h2></div>', $widget_title);
			$widget .= '<div class="card-content">';

                //$this_ID         = get_the_ID();
                $attached_agents = get_post_meta( get_the_ID(), '_prop_attached_agents' );
                //pr($attached_agents);
                foreach ($attached_agents as $agent){
                    $this_ID = $agent[0];
                    $data            = get_post_meta($this_ID);
                    $thumb           = get_the_post_thumbnail($this_ID, 'thumbnail', 'class=image is-96x96');
                    $title           = get_the_title($this_ID);
                    $phone           = $data['_agent_phone'][0];
                    $whats           = $data['_agent_whatsapp'][0];
                    $email           = $data['_agent_email'][0];
                    $contact         = $data['_agent_contact'][0];
                    $type            = get_the_terms($this_ID, 'agent_type')[0];
                    if($email){
                        $email_link = sprintf('<a href="mailto:%s">%s</a>', $email, $email);
                    }

                    $widget .= sprintf('<div class="widget-agent media" href="%s">', get_the_permalink());
                    $widget .= sprintf('<span class="media-left">%s</span>', $thumb);
                    $widget .= '<span class="media-content">';
                    $widget .= sprintf('<h5 class="title is-5">%s</h5>', $title);
                    $widget .= $instance['contact_type'] ? sprintf('<span class="subtitle is-5">%s</span>', $type->name) : '';
                    $widget .= '<ul class="list-vertical">';
                    $widget .= $phone && $instance['contact_phone'] ? sprintf('<li class="icon-text"><i class="icon material-icons">phone</i><span>%s</span></li>', $phone) : '';
                    $widget .= $whats && $instance['contact_wa'] ? sprintf('<li class="icon-text"><i class="icon material-icons">whatsapp</i><span>%s</span></li>', $whats) : '';
                    $widget .= $email && $instance['contact_mail'] ? sprintf('<li class="icon-text"><i class="icon material-icons">email</i><span>%s</span></li>', $email_link) : '';
                    $widget .= '</ul>';
                    $widget .= '</span>';
                    $widget .= '</div>';
                    //pr($instance);
                    if($instance['contact_check']){
                        $widget .= '<hr />';
                        $widget .= do_shortcode($contact);
                    }

                }
                $widget .= '</div>';
                $widget .= $atts['after_widget'];
                $widget .= '</div>';

			wp_cache_set( $atts['cache_id'], $widget, 'widget', WEEK_IN_SECONDS );
		}

		return $widget;
	}

	/**
	 * Update form values as they are saved.
	 *
	 * @param  array  $new_instance  New settings for this instance as input by the user.
	 * @param  array  $old_instance  Old settings for this instance.
	 * @return array  Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$this->flush_widget_cache();
		$sanitized = $this->cmb2( true )->get_sanitized_values( $new_instance );
		return $sanitized;
	}
	/**
	 * Back-end widget form with defaults.
	 *
	 * @param  array  $instance  Current settings.
	 */
	public function form( $instance ) {
		// If there are no settings, set up defaults
		$this->_instance = wp_parse_args( (array) $instance, self::$defaults );

		$cmb2 = $this->cmb2();

		$cmb2->object_id( $this->option_name );
		//CMB2_hookup::enqueue_cmb_css();
		//CMB2_hookup::enqueue_cmb_js();
		$cmb2->show_form();
	}

	/**
	 * Creates a new instance of CMB2 and adds some fields
	 * @since  0.1.0
	 * @return CMB2
	 */
	public function cmb2( $saving = false ) {

		// Create a new box in the class
		$cmb2 = new CMB2( array(
			'id'      => $this->option_name .'_box', // Option name is taken from the WP_Widget class.
			'hookup'  => false,
			'show_on' => array(
				'key'   => 'options-page', // Tells CMB2 to handle this as an option
				'value' => array( $this->option_name )
			),
		), $this->option_name );

		foreach ( $this->cmb2_fields as $field ) {

			if ( ! $saving ) {
				$field['id'] = $this->get_field_name( $field['id'] );
			}

			$field['default_cb'] = array( $this, 'default_cb' );

			$cmb2->add_field( $field );
		}

		return $cmb2;
	}

	/**
	 * Sets the field default, or the field value.
	 *
	 * @param  array      $field_args CMB2 field args array
	 * @param  CMB2_Field $field CMB2 Field object.
	 *
	 * @return mixed      Field value.
	 */
	public function default_cb( $field_args, $field ) {
		return isset( $this->_instance[ $field->args( 'id_key' ) ] )
			? $this->_instance[ $field->args( 'id_key' ) ]
			: null;
	}

}

/**
 * Register this widget with WordPress.
 */
function register_cmb2_widget_agent() {
	register_widget( 'CMB2_Widget_Agent' );
}
add_action( 'widgets_init', 'register_cmb2_widget_agent' );
?>
