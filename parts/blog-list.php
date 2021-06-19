<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <div class="card mb-3">
        <div class="media">
            <div class="media-left">
                <figure class="image">
                    <a href="<?php the_permalink(); ?>">
                        <?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
                    </a>
                </figure>
            </div>
            <div class="card-content">
                <div class="mb-3">
                    <h3 class="title is-3">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <?php the_excerpt(); ?>
                    <?php //include (TEMPLATEPATH . '/inc/meta.php' ); ?>
                </div>
                <div>
                    <nav class="level">
                        <div class="level-left">
                            <div class="level-item">
                                <a class="button is-secondary" href="<?php the_permalink(); ?>">
                                    <?php echo __('Ver Más') ?>
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
