<?php
/*
 * Include CMB2 & Plugins
 * ========================================================================================================
 */

//$base_path    = str_replace('\\', '/', dirname( __FILE__ ) ."/inc/cmb2");
$base_path    = str_replace('\\', '/', dirname( __FILE__ ) ."/inc/CMB2-develop");
$plugins_path = str_replace('\\', '/', dirname( __FILE__ ) ."/inc/cmb2-plugins");
//$plugins_path = str_replace('\\', '/', dirname( __FILE__ ) ."/inc/CMB2-plugins");

define('CMB_PATH', $base_path);
define('CMB_PLUGINS', $plugins_path);

if ( file_exists(CMB_PATH . '/init.php' ) ) {

    require_once (CMB_PATH . '/init.php');

    //grid
    require_once (CMB_PLUGINS . '/CMB2-grid-master/Cmb2GridPlugin.php');

    //custom show_on
    //include(CMB_PLUGINS . '/CMB2-show-on/show_on.php');

    //custom post search field
    //include(CMB_PLUGINS . '/CMB2-post-search-field/cmb2_post_search_field.php');

    //gallery plugin
    //usando file list
    //require_once (CMB_PLUGINS . '/CMB2-field-gallery/cmb-field-gallery.php');

    //gallery plugin
    require_once (CMB_PLUGINS . '/CMB2_field_map/cmb-field-map.php');

    //MetaTabs
    require_once (CMB_PLUGINS . '/CMB2-metatabs-options/cmb2-metatabs-options.php');

    //ButtonSet
    require_once (CMB_PLUGINS . '/CMB2-Buttonset-Field-master/buttonset_metafield.php');

    //require_once (CMB_PLUGINS . '/CMB2-term-select/cmb2-term-select.php');
    require_once (CMB_PLUGINS . '/CMB2-field-ajax-search/cmb2-field-ajax-search.php');

    //Attached agents
    require_once (CMB_PLUGINS . '/CMB2-attached-posts/cmb2-attached-posts-field.php');

    //metaboxes list
    //include('inc/custom-metaboxes/contact.php');
    //include('inc/post-types/internal.php');
}

// post-types & metaboxes
require_once ('inc/post-types/slides.php');
require_once ('inc/post-types/propiedad.php');
//include('inc/post-types/propiedad.php');
require_once ('inc/post-types/agents.php');

//include('inc/custom-metaboxes/propiedad.php');
require_once ('inc/custom-metaboxes/gallery.php');
require_once ('inc/custom-metaboxes/extra.php');


// theme settings
require_once 'inc/admin/disable-comments.php';
require_once 'inc/admin/wp-cpt-archives-in-menu.php';
//require_once 'inc/admin/theme-options-alt.php';
require_once 'inc/admin/theme-options-sub.php';
//require_once 'inc/admin/theme-options.php';
//require_once 'inc/admin/theme-options-tabs.php';
require_once 'inc/custom-functions.php';



    /*
     * INIT
     * ========================================================================================================
     */

    //add_action('wp_head', 'show_template');

    function show_template() {
      global $template;
      global $current_user;
      get_currentuserinfo();
      if ($current_user->user_level == 10 ) print_r($template);
    }

    function pr($out){
        echo '<pre>';
        print_r($out);
        echo '</pre>';
    }

    function check($out){
        if(isset($out) && !empty($out)){
            return true;
        }
        return false;
    }

    if(empty(get_option('tnb_setup_options')['tnb_setup_API'])){
        echo('falta en configuraciones la clave de gmaps');
    }
    define('GMAPS_KEY', get_option('tnb_setup_options')['tnb_setup_API']);

    /*
     * Properly enqueue of styles and scripts
     */
    function theme_name_scripts() {

        //wp_enqueue_style( 'qs'      , get_template_directory_uri().'/css/qs.min.css' );
        wp_enqueue_style( 'style'      , get_template_directory_uri().'/css/style.min.css' );
        //wp_enqueue_style( 'goglefonts',    '//fonts.googleapis.com/css2?family=Oxygen:wght@400;700&display=swap' );
        wp_enqueue_style( 'icons',  '//fonts.googleapis.com/icon?family=Material+Icons' );
        //wp_enqueue_style( 'icons',  '//fonts.googleapis.com/css2?family=Material+Icons' );

        wp_enqueue_style( 'roboto', '//fonts.googleapis.com/css?family=Roboto:400,400i,700,700i&display=swap' );
        //wp_enqueue_style( 'opensans', '//fonts.googleapis.com/css?family=Open+Sans:400' );

        //wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
        if ( !is_admin() ) {
           wp_deregister_script('jquery');
        }
        wp_register_script('jquery'       , get_template_directory_uri().'/js/jquery.slim.min.js', array(), '3.5.1', true);
        //wp_register_script('bootstrap'    , get_template_directory_uri().'/js/bootstrap.bundle.min.js', array('jquery'), '5.0.0-alpha1', true);

        wp_register_script('photoswipe'   , get_template_directory_uri().'/js/plugins/photoswipe.min.js', array(), '4.1.3', true);
        wp_register_script('photoswipe-ui' , get_template_directory_uri().'/js/plugins/photoswipe-ui-default.min.js', array('photoswipe'), '4.1.3', true);
        wp_register_script('photoswipe-init'   , get_template_directory_uri().'/js/photoswipe.init.js', array('photoswipe','photoswipe-ui','jquery'), '1.0.0', true);
        wp_register_script('validate'     , get_template_directory_uri().'/js/jquery.validate.min.js', array('jquery'), '1.0.0', true);
        wp_register_script('form'         , get_template_directory_uri().'/js/form.js', array('jquery','validate'), '1.0.0', true);
        wp_register_script('siema'         , get_template_directory_uri().'/js/plugins/siema.min.js', array(), '1.5.1', true);
        wp_register_script('siema-init'    , get_template_directory_uri().'/js/plugins/siema-init.js', array('siema'), '1', true);
        wp_register_script('lity'         , get_template_directory_uri().'/js/plugins/lity.js', array('jquery'), '2.4.1', true);

        wp_register_script('infobubble'   , (get_template_directory_uri().'/js/plugins/infobubble.js'), array(), null, true);
        wp_register_script('initmaps'     , (get_template_directory_uri().'/js/map-search/initmaps.js'), array('infobubble'), '1.0.0', true);
        wp_register_script('gmaps'        , ('http://maps.google.com/maps/api/js?&key='.GMAPS_KEY.'&callback=initMap'), array('initmaps'), null, true);
        //wp_register_script('gmapscluster' , (''), array('gmaps'), null, true);
        wp_register_script('map'          , ('http://maps.google.com/maps/api/js?&key='.GMAPS_KEY), array(), null, true);
        wp_register_script('renderMap'     , (get_template_directory_uri().'/js/map-search/renderMap.js'), array('map', 'infobubble', 'jquery'), '1.0.0', true);

        //wp_register_script('scripts'      , get_template_directory_uri().'/js/scripts.js', array('bootstrap', 'jquery'), null, true);
        wp_register_script('scripts'      , get_template_directory_uri().'/js/scripts.js', array('jquery'), null, true);
        //wp_register_script('scripts'      , get_template_directory_uri().'/js/scripts.js', array('jquery', 'bootstrap'), null, true);

        wp_enqueue_script('scripts');
    }
    add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

    /* bulma y cf7 */
    /*
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (is_plugin_active( 'contact-form-7/wp-contact-form-7.php' )) {
       wp_enqueue_script('cf7_loading', get_template_directory_uri().'/js/cf7bulma.js' , array('jquery'), null, true);
    }
    */
    add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
    function wpcf7_autop_return_false() {
        return false;
    }


    //wp_enqueue_script('jquery');
    //wp_enqueue_script('scripts');

    //require_once('inc/admin/bs4navwalker.php');

    //https://github.com/Poruno/Bulma-Navwalker
    require_once('inc/admin/navwalker.php');
    function register_menus() {
        register_nav_menus(
            array(
                'header-menu' => __( 'Menu Header' ),
                'search-menu' => __( 'Menu en el panel de búsqueda' ),
                //'footer-menu' => __( 'Menu Footer' )
            )
        );
    }

    add_action( 'init', 'register_menus' );

    /*
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => 'Sidebar Widgets',
            'id'   => 'sidebar-widgets',
            'description'   => 'These are widgets for the sidebar.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
    }
    */

    /*
     * Add support RSS feed, thumbnails and stuff
     * ========================================================================================================
     */
    require_once 'inc/admin/add-support.php';
    require_once 'inc/the_search_string.php';
    require_once 'inc/pagenavi.php';
    require_once 'inc/breadcrumb.php';

    /*
     * Cunstom frontend functions
     * ========================================================================================================
     */
    function currency(){
         global $currency;
         $currency = array(
             1 => __('$', 'cmb' ),
             2 => __('U$S', 'cmb' ),
         );
         return $currency;
    }
    function orientation(){
        global $orientation;
        $orientation = array(
            1 => 'Norte',
    		2 => 'Este',
    		3 => 'Sur',
    		4 => 'Oeste',
        );
        return $orientation;
    }
    function front(){
        global $front;
        $front = array(
            1 => 'Frente',
     		2 => 'Contrafrente',
            3 => 'Interna',
        );
        return $front;
    }
    function phrases(){
         global $phrases;
         $phrases = array(
             1   => __('Apta para crédito', 'cmb' ),
             2   => __('Destacados', 'cmb' ),
             3   => __('Inversiones desde el pozo', 'cmb' ),
             4   => __('Oportunidad', 'cmb' ),
         );
         return $phrases;
    }
    function status(){
        global $status;
        $status = array(
            1 => __('En construcción', 'cmb' ),
            2 => __('Apta crédito', 'cmb' ),
            3 => __('En sucesión', 'cmb' ),
        );
        return $status;
    }
    function services(){
        global $services;
        $services = array(
            1 => __('Agua Corriente', 'cmb' ),
            2 => __('Gas Natural', 'cmb' ),
            3 => __('Conexión Eléctrica', 'cmb' ),
        );
        return $services;
    }
    




    /*
     * Widgets
     * ========================================================================================================
     */

    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => 'Sidebar Widgets',
            'id'   => 'sidebar-widgets',
            'description'   => 'Estos son los widgets del sidebar.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
        register_sidebar(array(
            'name' => 'Sidebar Propiedad Widgets',
            'id'   => 'sidebar-propiedad-widgets',
            'description'   => 'Estos son los widgets del sidebar de la propiedad.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
        register_sidebar(array(
            'name' => 'Footer 1',
            'id'   => 'footer-1-widgets',
            'description'   => 'Estos son los widgets de la columna 1 del footer.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
        register_sidebar(array(
            'name' => 'Footer 2',
            'id'   => 'footer-2-widgets',
            'description'   => 'Estos son los widgets de la columna 2 del footer.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
        register_sidebar(array(
            'name' => 'Footer 3',
            'id'   => 'footer-3-widgets',
            'description'   => 'Estos son los widgets de la columna 3 del footer.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));

    }


    //unregister all default WP Widgets
    function unregister_default_wp_widgets() {
        //unregister_widget('WP_Widget_Pages');
        //unregister_widget('WP_Widget_Calendar');
        //unregister_widget('WP_Widget_Archives');
        //unregister_widget('WP_Widget_Links');
        //unregister_widget('WP_Widget_Meta');
        unregister_widget('WP_Widget_Search');
        //unregister_widget('WP_Widget_Text');
        //unregister_widget('WP_Widget_Categories');
        //unregister_widget('WP_Widget_Recent_Posts');
        //unregister_widget('WP_Widget_Recent_Comments');
        //unregister_widget('WP_Widget_RSS');
        //unregister_widget('WP_Widget_Tag_Cloud');
     }
    add_action('widgets_init', 'unregister_default_wp_widgets', 1);

    require_once ('inc/widgets/viewed-properties.php');
    require_once 'inc/renderMap.php';


    /*
    add_filter( 'get_the_archive_title', function ( $title ) {
    if( is_taxonomy() ) {
       $title = 'coso';
       //$title = single_cat_title( '', false );
    }
    return $title;
    });
    */


    /**
    * Test if a WordPress plugin is active
    */
    /*
    if(in_array('elementor/elementor.php', apply_filters('active_plugins', get_option('active_plugins')))){
        require_once('elementor-widgets/my-widgets.php');
    }
    */
?>
