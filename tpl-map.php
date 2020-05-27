<?php
/*
Template Name: Mapa
Template Post Type: page
*/
get_header(); ?>
<?php wp_enqueue_script('gmaps'); ?>
<div class="grid">
	<?php get_template_part('parts/map', 'searchform'); ?>
	<?php //get_template_part('parts/toggle', 'search'); ?>
</div>

<?php //the_breadcrumb(); ?>
<?php global $query_string; ?>
<script type="text/javascript">
	// create variables>
	var body = [];
	var markers = [];
	var locations = [];
	var infoBubble;
	var json_props;
</script>
	<?php
	$args = array(
		'post_type'           => 'propiedad',
		//'category_name'       => 'current',
		//'ignore_sticky_posts' => 1,
		//'paged'               => $paged
		/*'meta_query' => array(
			array(
				'key'     => '_prop_map',
				//'value' => '' ,
                'compare' => 'EXISTS',
			),
		),*/
	);
	$loop = new WP_Query( $args );
	if ( $loop->have_posts() ) : ?>
		<?php echo get_search_string($loop); ?>
		<?php $i = 0 ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<?php
				$mapGPS = get_post_meta($post->ID, '_prop_map', true);
				if(!empty($mapGPS['latitude']) && !empty($mapGPS['longitude'])):
					require('inc/map-search/map-post.php');
					$i++;

				endif;
			?>
		<?php endwhile; ?>
		<?php $prop_json = json_encode($props); ?>
		<script type="text/javascript">
		json_props = <?php echo json_encode(json_decode($prop_json,TRUE)); ?>;
		for (i = 0; i < json_props.length; i++) {
			locations.push(json_props[i]['latlng']);
			body.push(json_props[i]['body']);
		}
		</script>
		<div id="gmap_canvas" style="height:100vh;width:100vw;"></div>
	<?php else : ?>
	    <?php _e( 'Sorry, nothing matched your search criteria', 'textdomain' ); ?>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>
