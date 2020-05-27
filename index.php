<?php get_header(); ?>
<div class="section section-primary">
	<div class="grid">
		<?php echo get_search_form(); ?>
	</div>
</div>
<div class="grid">
	<div class="row">
		<div class="quad-3">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
					<?php //include (TEMPLATEPATH . '/inc/meta.php' ); ?>
					<div class="entry">
						<?php the_content(); ?>
					</div>
				</div>

			<?php endwhile; ?>

			<?php //include (TEMPLATEPATH . '/inc/nav.php' ); ?>
			<?php else : ?>
				<h2>No encontramos ninguna Noticia :(</h2>
			<?php endif; ?>
		</div>
		<div class="quad-1">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
