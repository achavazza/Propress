
<?php
/*
$args = array(
	'post_type'  	 => 'agent',
	'posts_per_page' => 4,
	'order'			 => 'DESC',
	'orderby'		 => 'ID'

);
$related = new WP_Query( $args );
if ( $related->have_posts()) {
	echo '<div class="panel">';
		echo sprintf('<div class="panel-head"><h3 class="h5">%s</h3></div>', __('Asesores'));
		echo '<div class="panel-content">';
		echo '<div class="row">';
			while ($related->have_posts()): $related->the_post();
				echo '<div class="quad-2">';
					get_template_part('parts/agent','loop');
				echo '</div>';
			endwhile;
		echo '</div>';
		echo '</div>';
	echo '</div>';
}
wp_reset_postdata();
*/
?>

<?php
$attached_agents = get_post_meta( get_the_ID(), '_prop_attached_agents', true );
if($attached_agents){
echo '<div class="panel">';
	echo sprintf('<div class="panel-head"><h3 class="h5">%s</h3></div>', __('Asesores'));
		echo '<div class="panel-content">';
		echo '<div class="row">';
		foreach ( $attached_agents as $attached_agent ) {
			$agent = get_post( $attached_agent );
			//pr($agent);
			echo '<div class="quad-2">';
			//pr(get_post_meta($agent->ID));
			set_query_var( 'agent', $agent );
			get_template_part('parts/agent','attached');
			//get_template_part('parts/agent','loop');
			echo '</div>';
		}
		echo '</div>';
	echo '</div>';
echo '</div>';
}

?>
