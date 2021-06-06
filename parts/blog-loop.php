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
$prop_sale       = ($data['_prop_price_sale'][0]!= '0,00') ? number_format($data['_prop_price_sale'][0], 0, ',', '.') : '';
$prop_rent       = ($data['_prop_price_rent'][0]!= '0,00') ? number_format($data['_prop_price_rent'][0], 0, ',', '.') : '';
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
$prop_loc        = wp_get_post_terms($post->ID, 'location');
pr($post);

$prop_currency   = currency()[$data['_prop_currency'][0]];
$cur_symbol      = $prop_currency ? 'U$S' : '$';

$type            = get_the_terms($post, 'tipo')[0];
$ops             = get_the_terms($post->ID, 'operacion');
$thumb           = get_the_post_thumbnail($post->ID, 'medium');

$prop_loc        = get_location($post);

$statuses        = get_the_terms($post->ID, 'status')[0];
var_dump($prop_sale);
*/
?>
<div <?php post_class('card h-100') ?> id="post-<?php the_ID(); ?>">
    <div class="card-img">
        <div class="card-img-top thumb-head">
            <?php echo get_the_post_thumbnail($post->ID, 'medium'); ?>
        </div>
    </div>
    <div class="card-body">
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </div>
     <div class="card-footer d-flex flex-row justify-content-between align-items-right">
        <a class="btn btn-primary" href="<?php the_permalink() ?>">
            <?php echo __('Ver Más') ?>
        </a>
    </div>
</div>
