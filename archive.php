<?php get_header(); ?>
<div class="section section-primary">
	<div class="grid">
		<?php echo get_search_form(); ?>
	</div>
</div>
<div class="grid">
	<?php if (have_posts()) : ?>
		<?php
		$post = $posts[0]; // Hack. Set $post so that the_date() works.
		if (is_category()) { // If this is a category archive
			echo sprintf('<h2>Archivo para la categoría &laquo; %s &raquo;</h2>', single_cat_title("", false));
		} elseif( is_tag() ) { // If this is a tag archive
			echo sprintf('<h2>Publicaciones etiquetadas &laquo; %s &raquo;</h2>', single_tag_title("", false));
		} elseif (is_day()) { // If this is a daily archive
			echo sprintf('<h2>Archivo del día %s</h2>', get_the_time('F jS, Y'));
		} elseif (is_month()) { // If this is a monthly archive
			echo sprintf('<h2>Archivo del mes %s</h2>', get_the_time('F, Y'));
		} elseif (is_year()) {// If this is a yearly archive */
			echo sprintf('<h2>Archivo del año %s</h2>', get_the_time('Y'));
		} elseif (is_author()) {// If this is an author archive
			echo ('<h2>Archivo de autor</h2>');
		} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { // If this is a paged archive
			echo ('<h2>Blog</h2>');
		} ?>

		<div class="row">
			<div class="quad-3">
				<?php //include (TEMPLATEPATH . '/inc/nav.php' ); ?>

				<div class="row">
				<?php $i = 0; ?>
				<?php while (have_posts()) : the_post(); ?>
					<div class="quad-2">
					<?php get_template_part('parts/post','loop') ?>
					</div>
					<?php /*
					<div <?php post_class() ?>>

						<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
						<?php include (TEMPLATEPATH . '/inc/meta.php' ); ?>
						<div class="entry">
							<?php the_content(); ?>
						</div>

					</div>
					*/ ?>
					<?php $i++; ?>
					<?php echo ($i % 2 == 0) ? '</div><div class="row">':'' ?>
				<?php endwhile; ?>
				</div>
				<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

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
		</div>
		<div class="quad-1">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
