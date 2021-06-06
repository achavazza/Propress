<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <div class="card mb-3">
    <div class="d-flex">
        <div class="flex-shrink-0">
            <div class="img">
                <a href="<?php the_permalink(); ?>">
                    <?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
                </a>
            </div>
        </div>
        <div class="flex-grow-1 card-body">
                <div class="d-flex flex-column align-content-between">
                <div class="d-flex flex-column h-100">
                    <h3 class="h3">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <?php the_excerpt(); ?>
                    <?php //include (TEMPLATEPATH . '/inc/meta.php' ); ?>
                </div>
                <div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a class="btn btn-secondary" href="<?php the_permalink(); ?>">
                            <?php echo __('Ver Más') ?>
                        </a>
                    </div>
                </div>
                </div>
        </div>
    </div>
    </div>
</div>
