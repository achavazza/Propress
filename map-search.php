<?php
get_header(); ?>
<?php wp_enqueue_script('gmaps'); ?>
<?php /*
<div class="grid">

	<?php //get_template_part('parts/map', 'searchform'); ?>
	<?php //get_template_part('parts/toggle', 'search'); ?>
</div>
<?php //the_breadcrumb(); ?>
<?php global $query_string; ?>
<h2 class="h2 title"><?php echo get_search_string($wp_query); ?></h2>
*/ ?>
<div id="map-container">
	<div class="map-layout" id="gmap_canvas"></div>
	<div class="content">
		<div class="section section-primary">
			<?php echo get_search_form(); ?>
		</div>

<script type="text/javascript">
	// create variables>
	var body = [];
	var markers = [];
	var locations = [];
	var infoBubble;
	var json_props;
</script>
<?php /*
<?php
$search_string = get_search_query();

$args = array(
    's'              => $search_string,
    'posts_per_page' => -1,
    //'order'          => 'DESC',
);
$args = array(
	'post_type'      => 'propiedad',
	'posts_per_page' => -1,
);
$loop = new WP_Query( $args );
if ( $loop->have_posts() ) :
	$i = 0 ?>
	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
*/ ?>

<?php
// Open this line to Debug what's query WP has just run
// Show the results
//query_posts( array( 'post_type' => 'propiedad'));
if(have_posts() ) : ?>
    <?php $i = 0 ?>
	<div div class="post-results">
		<div class="row">
		    <?php while (have_posts()) : the_post(); ?>
				<div class="quad-2">
			        <?php require('inc/map-search/map-post.php') ?>
					<?php get_template_part('parts/post','loop') ?>
				</div>
				<?php $i++; ?>
				<?php echo ($i % 2 == 0) ? '</div><div class="row">':'' ?>
		    <?php endwhile; ?>
		</div>
	</div>

	<?php $prop_json = json_encode($props); ?>
	<script type="text/javascript">
		json_props = <?php echo json_encode(json_decode($prop_json,TRUE)); ?>;
		for (i = 0; i < json_props.length; i++) {
			locations.push(json_props[i]['latlng']);
			body.push(json_props[i]['body']);
		}
	</script>
	<?php else : ?>
		<div class="map-layout">
			<div class="content-wrap">
			    <h2><?php _e( 'Lo sentimos :(', 'ureta' ); ?></h2>
			    <p>
					<?php _e( 'no encontramos ninguna propiedad con esa búsqueda', 'ureta' ); ?>
				</p>
			</div>
		</div>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</div>
</div>

<?php //get_footer(); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
