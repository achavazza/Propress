<?php get_header(); ?>
<?php /*
<div class="grid">
    <?php get_search_form(); ?>
</div>
*/ ?>
<div class="grid">
    <h2 class="h2 title">
        <?php echo get_search_string($wp_query); ?>
        <?php //get_template_part('parts/toggle', 'search'); ?>
    </h2>
    <?php //the_breadcrumb(); ?>

    <div class="row">
        <div class="quad-3">
        <?php if (have_posts()) : ?>
            <?php $i = 0 ?>
            <div class="row">
                <?php while (have_posts()) : the_post(); ?>
                    <div class="quad-2">
					    <?php get_template_part('parts/post','loop') ?>
					</div>
                    <?php $i++; ?>
					<?php echo ($i % 2 == 0) ? '</div><div class="row">':'' ?>
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
