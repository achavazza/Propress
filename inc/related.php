
<?php /*
<?php
//for use in the loop, list 5 post titles related to first tag on current post
$terms = get_the_terms( $post->ID , 'location', 'string');
//Pluck out the IDs to get an array of IDS
$term_ids = wp_list_pluck($terms,'term_id');

//Query posts with tax_query. Choose in 'IN' if want to query posts with any of the terms
//Chose 'AND' if you want to query for posts with all terms
$second_query = new WP_Query( array(
'post_type' => 'propiedad',
'tax_query' => array(
    array(
        'taxonomy' => 'location',
        'field' => 'id',
        'terms' => $term_ids,
        'operator'=> 'IN' //Or 'AND' or 'NOT IN'
    )),
'posts_per_page' => 2,
'ignore_sticky_posts' => 1,
'orderby' => 'rand',
'post__not_in'=>array($post->ID)
));

//Loop through posts and display...
if($second_query->have_posts()) : ?>
    <div class="related">
        <h3>Propiedades similares</h3>
    <div class="row">
    <?php
    while ($second_query->have_posts() ) : $second_query->the_post(); ?>


        <div class="quad-2">
            <?php get_template_part('parts/post','loop') ?>
        </div>
    <?php endwhile; ?>
    </div>
    </div>
    <?php
    wp_reset_query();
endif;
?>
*/ ?>
<?php
/*$post_terms_ids     = wp_get_object_terms($post->ID, 'tipo', array('fields'=>'ids'));
$location_terms     = wp_get_object_terms($post->ID, 'location', array('fields'=>'all'));

$location_ids       = Array();
foreach($location_terms as $term){
	if($term->parent != 0){
		array_push($location_ids, $term->term_id);
	}
}
pr($post_terms_ids);
pr($location_terms);*/
//$location_terms_ids = wp_get_object_terms($post->ID, 'location', array('fields'=>'ids'));
//pr($location_ids);
//pr(wp_get_post_terms($post->ID, 'operacion')[0]->term_id);
//pr(wp_get_post_terms($post->ID));
//pr(get_the_terms($post, 'operacion'));
//pr(get_the_terms($post, 'operacion')[0]->term_id);
$args = array(
	'post_type'  	 => 'propiedad',
	'posts_per_page' => 2,
	'order'			 => 'DESC',
	'orderby'		 => 'ID',
	'post__not_in'   => array($post->ID),
	'tax_query'      => array(
		array(
			'taxonomy'     => 'operacion',
			'field'        => 'id',
			'terms'        => wp_get_post_terms($post->ID, 'operacion')[0]->term_id,
		),
		array(
			'taxonomy'     => 'location',
			'field'        => 'id',
			'terms'        => wp_get_post_terms($post->ID, 'location')[0]->term_id,
		),
		/*array(
			'taxonomy'     => 'tipo',
			'field'        => 'id',
			'terms'        => wp_get_post_terms($post->ID, 'tipo')[0]->term_id,
		),*/
		//array(
			//'taxonomy'     => 'location',
			//'terms'        => 'location',
			//'field' => 'slug',
        	//'operator' => 'IN'
			//'include_children' => true,
			//'terms'        => $location_ids,
			//'field'        => 'slug',
		//),
		//array(
			//'taxonomy'     => 'tipo',
			//'terms'        => 'tipo',
			//'field' => 'slug',
        	//'operator' => 'IN'
			//'include_children' => true,
			//'terms'        => $post_terms_ids,
			//'field'        => 'slug',
		//),

	),
    /*
    'meta_query'  => array(
	array(
	'key'     => '_prop_featured',
	//'value'   => true,
	'compare' => '=',
)
)*/
);
$related = new WP_Query( $args );
//pr($related);
if ( $related->have_posts()) {
	echo '<h2 class="h3 title">Propiedades Similares</h2>';
	echo '<div class="row">';
	while ($related->have_posts()): $related->the_post();
		echo '<div class="quad-2">';
		get_template_part('parts/post','loop');
		echo '</div>';
	endwhile;
	echo '</div>';
}
wp_reset_postdata();
?>
