<?php
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
	echo '<div class="colums is-same-height">';
	while ($related->have_posts()): $related->the_post();
		echo '<div class="columns is-one-third">';
		get_template_part('parts/post','loop');
		echo '</div>';
	endwhile;
	echo '</div>';
}
wp_reset_postdata();
?>
