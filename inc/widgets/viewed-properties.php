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
class CMB2_Widget_Viewed_Prop extends WP_Widget {

	/**
	 * Unique identifier for this widget.
	 *
	 * Will also serve as the widget class.
	 *
	 * @var string
	 */
	protected $widget_slug = 'viewed-properties';

	/**
	 * Shortcode name for this widget
	 *
	 * @var string
	 */
	protected static $shortcode = 'viewed-properties';

	/**
	 * This widget's CMB2 instance.
	 *
	 * @var CMB2
	 */
	protected $cmb2 = null;

	/**
	 * Array of default values for widget settings.
	 *
	 * @var array
	 */
	protected static $defaults = array();

	/**
	 * Store the instance properties as property
	 *
	 * @var array
	 */
	protected $_instance = array();

	/**
	 * Array of CMB2 fields args.
	 *
	 * @var array
	 */
	protected $cmb2_fields = array();

	/**
	 * Contruct widget.
	 */
	public function __construct() {

		parent::__construct(
			$this->widget_slug,
			esc_html__( 'Propiedades vistas', 'tnb' ),
			array(
				'classname' => $this->widget_slug,
				'customize_selective_refresh' => true,
				'description' => esc_html__( 'Lista las propiedades vistas', 'tnb' ),
			)
		);

		self::$defaults = array(
			'title' => esc_html__( 'Propiedades vistas', 'tnb' ),
			'image' => '',
			'desc'  => '',
			'posts_num'  => 3,
			'color' => '#bada55',
		);

		$this->cmb2_fields = array(
			array(
				'name'   => 'Title',
				'id_key' => 'title',
				'id'     => 'title',
				'type'   => 'text',
			),
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
			),*/
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
			//array(
			//	'name'   => 'Color',
			//	'id_key' => 'color',
			//	'id'     => 'color',
			//	'type'   => 'colorpicker',
			//),
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
			//isset( $atts['args'] ) ? (array) $atts['args'] : array(),
			self::$shortcode
		);

        //pr($attribs);
		$instance = shortcode_atts(
			self::$defaults,
			! empty( $atts['instance'] ) ? (array) $atts['instance'] : $attribs['args'],
			//! empty( $atts['instance'] ) ? (array) $atts['instance'] : array(),
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
            $values = explode(";", $_COOKIE['wpb_visited_props']);
            $widget = '';
            $post_num = intval($instance['posts_num']);
			//pr($instance);
        	$widget_query = new WP_Query([
				'post_type'           => 'propiedad',
        		'posts_per_page'      => $post_num,
        		'ignore_sticky_posts' => 1,
                'post__in'            => $values,
        		'post__not_in'        => array(get_the_ID()),
        		//'post__not_in'        => $featPosts
			]);
			$widget_title = ( $instance['title'] ) ? $atts['before_title'] . esc_html( $instance['title'] ) . $atts['after_title'] : '';

			$id      = $atts['args']['widget_id'];
			$class   = 'widget '. $atts['args']['id'];

            $widget .= sprintf('<div id="%s" class="%s">', $id, $class);
            $widget .= $atts['before_widget'];
			$widget .= sprintf('<h2>%s</h2>', $widget_title);

        	if ( $widget_query->have_posts() ) :
                //$widget .= '<div style="background-color:'. esc_attr( $instance['color'] ) .'">';
                //$widget .= wpautop( wp_kses_post( $instance['desc'] ) );
                //$widget .= '</div>';
                while ( $widget_query->have_posts() ) : $widget_query->the_post();
                    $this_ID         = get_the_ID();
                    $thumb           = get_the_post_thumbnail($this_ID, 'thumbnail');
					$data            = get_post_meta($this_ID);
					$prop_sale       = ($data['_prop_price_sale'][0]!= 0) ? number_format($data['_prop_price_sale'][0], 0, ',', '.') : '';
					$prop_rent       = ($data['_prop_price_rent'][0]!= 0) ? number_format($data['_prop_price_rent'][0], 0, ',', '.') : '';
					$prop_address    = $data['_prop_address'][0];
					$prop_type       = get_the_terms($post, 'tipo')[0];
					$prop_currency   = currency()[$data['_prop_currency'][0]];


	                if(!$prop_sale && !$prop_rent):
	                    $val =__('Consultar');
	                else:
	                    if($prop_rent):
	                        $val = '';
	                        if(isset($_GET['operacion']) && $_GET['operacion'] == 'alquiler'){
	                            $val = '<strong class="highlight">'.'$'.$prop_rent.'</strong>';
	                        }else{
	                            $val = '$'.$prop_rent;
	                        }
	                        $val = sprintf('<span class="price rent-price" title="Precio de alquiler">%s</span>', $val);
	                    endif;
	                    if($prop_sale && $prop_rent):
	                        echo ' | ';
	                    endif;
	                    if($prop_sale):
	                        $val = '';
	                        if(isset($_GET['operacion']) && $_GET['operacion'] != 'alquiler'){
	                            //echo '<strong class="highlight">'.'$'.$prop_sale.'</strong>';
	                            $val = '<strong class="highlight">'.$prop_currency.' '.$prop_sale.'</strong>';
	                        }else{
	                            $val = $prop_currency.' '.$prop_sale;
	                            //echo '$'.$prop_sale;
	                        }
	                        $val = sprintf('<span class="price sale-price" title="Precio de venta">%s</span>', $val);
	                    endif;
	                endif;
					$title = $prop_address ? $prop_address: get_the_title();

                    $widget .= sprintf('<a class="widget-property media" href="%s">', get_the_permalink());
                    $widget .= sprintf('<span class="img">%s</span>', $thumb);
                    $widget .= '<span class="bd">';
                    $widget .= sprintf('<span class="h5">%s</span>',$title);
                    $widget .= sprintf('<span class="block">%s</span>', $val);
                    $widget .= sprintf('<span class="block">%s</span>', $prop_type->name);
                    $widget .= '</span>';
                    $widget .= '</a>';
					 wp_reset_query();
        		endwhile;
            endif;
			//wp_reset_postdata();
            $widget .= $atts['after_widget'];
            $widget .= '</div>';


			// Before widget hook


			// After widget hook

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
		CMB2_hookup::enqueue_cmb_css();
		CMB2_hookup::enqueue_cmb_js();
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
function register_wds_widget_viewed_prop() {
	register_widget( 'CMB2_Widget_Viewed_Prop' );
}
add_action( 'widgets_init', 'register_wds_widget_viewed_prop' );
?>
