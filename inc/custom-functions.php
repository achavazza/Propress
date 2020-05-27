<?php
/*
* Custom Functions
* ========================================================================================================
*/
function tnb_post_by_slug($the_slug, $post_type = "page"){
    $args = array(
        'name'        => $the_slug,
        'post_type'   => $post_type,
        'post_status' => 'publish',
        'numberposts' => 1
    );
    $my_page = get_posts($args)[0]->guid;
    //$my_page = get_posts($args)[0];
    return $my_page;
}


add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);

function posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __('Miniatura');
    return $defaults;
}

function posts_custom_columns($column_name, $id){
    if($column_name === 'riv_post_thumbs'){
        echo the_post_thumbnail( 'thumbnail' );
    }
}
/**
* CUSTOM FUNCTION: retrieve template if input="hidden" pressent in search or meta value
**/
add_action('pre_get_posts', 'search_no_paging');
function search_no_paging( $q ) {
  if ( isset( $_REQUEST['search'] ) && $_REQUEST['search'] == 'advanced' && is_search() ) {
      if ( $q->is_main_query() && $q->is_search() && ! is_admin() ) {
        $q->set('posts_per_page', -1);
      }
  }
}
function advanced_search_template( $template ) {
    if ( isset( $_REQUEST['search'] ) && $_REQUEST['search'] == 'advanced' && is_search() ) {
        $t = locate_template('map-search.php');
        //$t = locate_template('map-search.php');
        if ( ! empty($t) ) {
            $template = $t;
        }
    }
    return $template;
}
add_action('template_include', 'advanced_search_template');

/**
* Search Within a Taxonomy
*
* Support search with tax_query args
*
* $query = new WP_Query( array(
*  'search_tax_query' => true,
*  's' => $keywords,
*  'tax_query' => array( array(
*      'taxonomy' => 'country',
*      'field' => 'id',
*      'terms' => $country,
*  ) ),
* ) );
*/
class WP_Query_Taxonomy_Search {
    public function __construct() {
        add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
    }

    public function pre_get_posts( $q ) {
        if ( is_admin() ) return;

        $wp_query_search_tax_query = filter_var(
            $q->get( 'search_tax_query' ),
            FILTER_VALIDATE_BOOLEAN
        );

        // WP_Query has 'tax_query', 's' and custom 'search_tax_query' argument passed
        if ( $wp_query_search_tax_query && $q->get( 'tax_query' ) && $q->get( 's' ) ) {
            add_filter( 'posts_groupby', array( $this, 'posts_groupby' ), 10, 1 );
        }
    }

    public function posts_groupby( $groupby ) {
        return '';
    }
}

new WP_Query_Taxonomy_Search();

/**
* CUSTOM FUNCTION, SEARCH image by slug (ej: "default")
*/
function get_attachment_url_by_slug( $slug , $size) {
    $args = array(
        'post_type' => 'attachment',
        'name' => sanitize_title($slug),
        'posts_per_page' => 1,
        'post_status' => 'inherit',
    );
    $_header = get_posts( $args );
    $header = $_header ? array_pop($_header) : null;
    return $header ? wp_get_attachment_image_src($header->ID, $size)[0] : '';
}

/**
* CUSTOM FUNCTION, SEARCH BY META_VALUE
*/
function wpa_filter_home_query( $query ){
    $low  = $_GET['price_low'];
    $high = $_GET['price_high'];
    $tax  = $_GET['operacion'];

    $price_key  = '_prop_price_sale';

    $dorm_key  = '_prop_dormrooms';
    $dorms  = $_GET['dormitorios'];

    if($tax == 'alquiler'){
        $price_key = '_prop_price_rent';
    }

    if(
        //$query->is_search() &&
        $query->is_main_query()) {

            if(isset( $dorms ) && !empty($dorms) ){
                $meta_query = array(
                    //'relation' => 'AND',
                    array(
                        'key'     => $dorm_key,
                        'value'   => $dorms,
                        'type'    => 'numeric',
                        'compare' => '='
                        //'compare' => '<='
                    )
                );
                $query->set( 'meta_query', $meta_query );
            }

            if(isset( $low ) || isset($high)){
                if(empty($high)){
                    $meta_query = array(
                        //'relation' => 'AND',
                        array(
                            'key'     => $price_key,
                            'value'   => $low,
                            'type'    => 'numeric',
                            'compare' => '>='
                        )
                    );
                }elseif(empty($low)){
                    $meta_query = array(
                        //'relation' => 'AND',
                        array(
                            'key'     => $price_key,
                            'value'   => $high,
                            'type'    => 'numeric',
                            'compare' => '<='
                        )
                    );
                }else{
                    $meta_query = array(
                        'relation' => 'BETWEEN',
                        array(
                            'key'     => $price_key,
                            'value'   => $low,
                            'type'    => 'numeric',
                            'compare' => '>='
                        ),
                        array(
                            'key'     => $price_key,
                            'value'   => $high,
                            'type'    => 'numeric',
                            'compare' => '<='
                        )
                    );
                }
                $query->set( 'meta_query', $meta_query );
            }
        }
        //pr($query);
        //pr($meta_query);
        //die();
    }
    add_action( 'pre_get_posts', 'wpa_filter_home_query' );

    /*
    * CUSTOM Function, get location (is a tax hierachy)
    */
    function get_location($post){
    	foreach( wp_get_post_terms( $post->ID, 'location') as $terms ) {
    		if($terms->parent != 0){
    			$child_term  = $terms;
    			$parent_term = get_term_by('id', $terms->parent, 'location');

    			$prop_loc = $child_term->name . ' - ';
                $prop_loc .= $parent_term->name;
                //$prop_loc .= $parent_term->name . ' - ';
                //$prop_loc = $child_term->name;
                break;
    		}else{
    			$child_term  = $terms;
    			$prop_loc = $child_term->name;
    		}
    	}

        /*  OLD Version
        foreach( wp_get_post_terms( $post->ID, 'location', array('parent' => 0 )) as $parent_term ) {
            // display top level term name
            $prop_loc = $parent_term->name . ' - ';
            foreach(  wp_get_post_terms( $post->ID, 'location', array('parent' => $parent_term->term_id ) ) as $child_term ) {
                // display name of all childs of the parent term
                $prop_loc .= $child_term->name;
            }
        }
        */
        return $prop_loc;
    }

    /**
    * CUSTOM FUNCTION: get page link by template name
    */
    function get_page_url($template_name){
        $pages = get_posts([
            'post_type' => 'page',
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key' => '_wp_page_template',
                    'value' => $template_name.'.php',
                    'compare' => '='
                ]
            ]
        ]);
        if(!empty($pages)){
            foreach($pages as $pages__value)
            {
                return get_permalink($pages__value->ID);
            }
        }
        return get_bloginfo('url');
    }
    ?>

    <?php
    /**
     * Sample template tag function for outputting a cmb2 file_list
     *
     * @param  string  $file_list_meta_key The field meta key. ('wiki_test_file_list')
     * @param  string  $img_size           Size of image to show
     */
    function cmb2_output_file_list( $file_list_meta_key, $img_size = 'medium' ) {

    	// Get the list of files
    	$files = get_post_meta( get_the_ID(), $file_list_meta_key, 1 );

    	echo '<div class="file-list-wrap">';
    	// Loop through them and output an image
    	foreach ( (array) $files as $attachment_id => $attachment_url ) {
    		echo '<div class="file-list-image">';
    		echo wp_get_attachment_image( $attachment_id, $img_size );
    		echo '</div>';
    	}
    	echo '</div>';
    }
    function cmb2_get_file_list( $file_list_meta_key, $img_size = 'medium' ) {

    	// Get the list of files
        $out = array();
    	$files = get_post_meta( get_the_ID(), $file_list_meta_key, 1 );
        pr($files);

    	foreach ( (array) $files as $attachment_id => $attachment_url ) {
    		$out[] = wp_get_attachment_image( $attachment_id, $img_size );
    	}
        return $out;
    }


/* COOKIES */

function wpb_cookies_ID() {
    // Time of user's visit
    $visit_time = date('F j, Y g:i a');
    $value ='';
    $values = explode(";", $_COOKIE['wpb_visited_props']);
    $time   = time()+2628000;
    //$time   = time()+2628000;
    $domain = get_home_url();
    if (('propiedad' === get_post_type()) AND is_single()){
        $value = get_the_ID();
    }
    // Check if cookie is already set
    if(!isset($_COOKIE['wpb_visited_props'])){
        setcookie('wpb_visited_props', $value, $time, COOKIEPATH, COOKIE_DOMAIN, false);
    }else{
        if(!in_array($value, $values)){
            setcookie('wpb_visited_props', $_COOKIE['wpb_visited_props'].';'.$value, $time, COOKIEPATH, COOKIE_DOMAIN, false);
        }
    }
    //add_shortcode('greet_me', 'visitor_greeting');
}
add_action('wp', 'wpb_cookies_ID');


/* wrappea una div en embeds (se supone que es youtube) */
function wrap_embed_with_div($html, $url, $attr) {
    return '<div class="youtube-wrap">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'wrap_embed_with_div', 10, 3);

?>
