<?php get_header(); ?>
<div class="section section-primary bg-dark">
	<div class="container">
		<?php echo get_search_form(); ?>
	</div>
</div>
<div class="container">
	<div class="columns">
		<div class="column">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php get_template_part('parts/blog','list') ?>

			<?php endwhile; ?>

			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
			<?php else : ?>
				<h2><?php echo _e('No encontramos ninguna Noticia :(', 'tnb') ?></h2>
			<?php endif; ?>
		</div>
		<div class="column">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
