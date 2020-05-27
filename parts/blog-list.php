<?php
//grab data
/*
$data            = get_post_meta($post->ID);
$prop_title      = get_the_title();
$prop_img        = get_the_post_thumbnail_url(null, 'thumbnail');
$prop_address    = $data['_prop_address'][0];
$prop_extra      = $data['_prop_extra'][0];
$prop_sale       = ($data['_prop_price_sale'][0]!= 0) ? number_format($data['_prop_price_sale'][0], 0, ',', '.') : '';
$prop_rent       = ($data['_prop_price_rent'][0]!= 0) ? number_format($data['_prop_price_rent'][0], 0, ',', '.') : '';
$prop_link       = get_the_permalink();
$mapGPS          = get_post_meta($post->ID, '_prop_map', true);

$prop_rooms      = $data['_prop_rooms'][0];
$prop_sup        = $data['_prop_sup'][0];
$prop_dormrooms  = $data['_prop_dormrooms'][0];
$prop_bathrooms  = $data['_prop_bathrooms'][0];
$prop_garage     = $data['_prop_garage'][0];
$prop_time       = $data['_prop_time'][0];

$prop_feat       = $data['_prop_featured'][0];
$prop_phrase     = phrases()[$data['_prop_phrase'][0]];
//$prop_loc        = wp_get_post_terms($post->ID, 'location');
//pr($post);

$type            = get_the_terms($post, 'tipo')[0];
$ops             = get_the_terms($post->ID, 'operacion');
$thumb           = get_the_post_thumbnail($post->ID, 'medium');
$prop_loc        = get_location($post);
*/

//var_dump($prop_sale);

?>
<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <div class="media">
        <div class="img">
            <a href="<?php the_permalink(); ?>">
                <?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
            </a>
        </div>
        <div class="bd list-bd">
            <h3 class="h3">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h3>
            <p>
                <?php the_excerpt(); ?>
            </p>
            <?php include (TEMPLATEPATH . '/inc/meta.php' ); ?>
            <div class="align-right">
                <a class="btn btn-secondary" href="<?php the_permalink(); ?>">
                    <?php echo __('Ver Más') ?>
                </a>
            </div>
        </div>
    </div>
</div>
