<?php
/*
Template Name: Destacadas
Template Post Type: page
*/
get_header(); ?>

<div class="grid">
<?php //the_breadcrumb(); ?>
	<?php
		$args = array(
			'post_type'           => 'propiedad',
			//'category_name'       => 'current',
			//'ignore_sticky_posts' => 1,
			//'paged'               => $paged
			'meta_query'  => array(
		            array(
		                'key'     => '_prop_featured',
		                //'value'   => true,
						'compare' => '=',
		            )
		        )
		);
		$loop = new WP_Query( $args );
	?>
	<div class="row">
		<div class="triad-2">
			<?php if ( $loop->have_posts() ) : ?>
				<?php $i = 0 ?>
				<div class="post-list">
					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<?php get_template_part('parts/post','list') ?>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
					<div class="panel">
						<h2 class="title">:( No encontramos propiedades</h2>
						<p>
							Por favor, vuelva al inicio
							<hr />
							<a class="btn btn-primary" href="<?php echo get_bloginfo('home') ?>">< Volver al Inicio</a>
						</p>
					</div>
			<?php endif; ?>
			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
				<?php /*
				<?php if (  $loop->max_num_pages > 1 ) : ?>
					<div id="nav-below" class="navigation">
						<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Previous', 'domain' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Next <span class="meta-nav">&rarr;</span>', 'domain' ) ); ?></div>
					</div>
				<?php endif; ?>
				*/ ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<div class="triad-1">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
