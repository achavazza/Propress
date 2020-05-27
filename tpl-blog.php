<?php
/*
Template Name: Blog
Template Post Type: page
*/
get_header(); ?>

<div class="grid">
	<?php //the_breadcrumb(); ?>
	<h2 class="h2 title"><?php the_title(); ?></h2>
	<div class="row">
		<div class="quad-3">
			<?php if (have_posts()) : ?>
				<?php $i = 0 ?>
				<div class="row">
					<?php while (have_posts()) : the_post(); ?>
						<div class="quad-2">
							<?php get_template_part('parts/post','loop') ?>
						</div>
						<?php if(++$i % 2 === 0): ?>
						</div><div class="row">
						<?php endif; ?>
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

		</div>
		<div class="quad-1">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
