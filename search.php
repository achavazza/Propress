<?php get_header(); ?>
<div class="search-panel block">
	<div class="container">
		<?php echo get_search_form(); ?>
	</div>
</div>
<div class="container">
    <?php the_breadcrumb(); ?>
    <h2 class="title is-3">
        <?php echo get_search_string($wp_query); ?>
        <?php //get_template_part('parts/toggle', 'search'); ?>
    </h2>

    <div class="columns">
        <div class="column is-three-quarters">
        <?php if (have_posts()) : ?>
            <?php $i = 0 ?>
            <?php while (have_posts()) : the_post(); ?>
				    <?php get_template_part('parts/post','list') ?>
                <?php $i++; ?>
				<?php //echo ($i % 2 == 0) ? '</div><div class="row">':'' ?>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="card mb-5">
            <div class="card-content">
                <h2 class="title is-2">:( No encontramos propiedades</h2>
                <p>
                    Por favor, vuelva al inicio
                    <hr />
                    <a class="button is-secondary" href="<?php echo get_bloginfo('home') ?>">Volver al Inicio</a>
                </p>
            </div>
            </div>
        <?php endif; ?>
        <?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

        </div>
        <div class="column is-one-quarter">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
