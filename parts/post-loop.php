<?php
//grab data
$data            = get_post_meta($post->ID);
$prop_title      = get_the_title();
$prop_img        = get_the_post_thumbnail_url(null, 'thumbnail');
$prop_address    = $data['_prop_address'][0];
$prop_extra      = $data['_prop_extra'][0];
$prop_sale       = ($data['_prop_price_sale'][0]!= 0) ? number_format($data['_prop_price_sale'][0], 0, ',', '.') : '';
$prop_rent       = ($data['_prop_price_rent'][0]!= 0) ? number_format($data['_prop_price_rent'][0], 0, ',', '.') : '';
//$prop_sale       = ($data['_prop_price_sale'][0]!= '0,00') ? number_format($data['_prop_price_sale'][0], 0, ',', '.') : '';
//$prop_rent       = ($data['_prop_price_rent'][0]!= '0,00') ? number_format($data['_prop_price_rent'][0], 0, ',', '.') : '';
$prop_link       = get_the_permalink();
$mapGPS          = get_post_meta($post->ID, '_prop_map', true);

$prop_rooms      = $data['_prop_rooms'][0];
$prop_sup        = $data['_prop_sup'][0];
$prop_dormrooms  = $data['_prop_dormrooms'][0];
$prop_bathrooms  = $data['_prop_bathrooms'][0];
//$prop_garage     = $data['_prop_garage'][0];
//$prop_time       = $data['_prop_time'][0];

$prop_feat       = $data['_prop_featured'][0];
//$prop_phrase     = phrases()[$data['_prop_phrase'][0]];
//$prop_loc        = wp_get_post_terms($post->ID, 'location');
//pr($post);

$prop_currency   = currency()[$data['_prop_currency'][0]];
$cur_symbol      = $prop_currency ? 'U$S' : '$';

$type            = get_the_terms($post, 'tipo')[0];
$ops             = get_the_terms($post->ID, 'operacion');
$thumb           = get_the_post_thumbnail($post->ID, 'medium');

$prop_loc        = get_location($post);

$statuses        = get_the_terms($post->ID, 'status')[0];

//var_dump($prop_sale);

?>
<div <?php post_class('card') ?> id="post-<?php the_ID(); ?>">
    <div class="card-image">
        <div class="card-image-top">
            <?php
            echo '<ul class="list-inline">';
                if($statuses):
                    echo sprintf('<li><a class="tag is-info" href="%s">%s</a></li>', get_term_link($statuses), $statuses->name);
                endif;
                if($ops):
                    foreach($ops as $op):
                        echo sprintf('<li><a class="tag is-primary" href="%s">%s</a></li>', get_term_link($op), $op->name);
                    endforeach;
                endif;
                if($prop_feat):
                    echo sprintf('<li><span class="tag is-warning">%s</span></li>', __('Destacado', 'propress'));
                endif;
            echo '</ul>';
            ?>
        </div>
        <?php
        echo '<figure class="image">';
            echo '<a href="'.get_the_permalink().'">';
                echo $thumb ? $thumb : sprintf('<img src="%s" />', get_attachment_url_by_slug('default', 'medium'));
            echo '</a>';
        echo '</figure>';
        ?>
    </div>
    <div class="card-content">
        <div class="media">
            <div class="media-content">
            <div class="prop-info">
                <a href="<?php the_permalink() ?>">
                    <span class="title is-4">
                        <?php the_title(); ?>
                    </span>
                    <span class="subtitle is-6">
                        <?php
                        if($prop_address):
                            echo $prop_address;
                        endif;
                        if ($prop_loc):
                            echo sprintf('- %s', $prop_loc);
                        endif;
                        ?>
                    </span>
                    <span class="price-block">
                        <?php
                        if(!$prop_sale && !$prop_rent):
                            echo __('Consultar');
                        else:
                            if($prop_rent):
                                $val = '';
                                if(isset($_GET['operacion']) && $_GET['operacion'] == 'alquiler'){
                                    $val = '<span>'.'$'.$prop_rent.'</span>';
                                }else{
                                    $val = '$'.$prop_rent;
                                }
                                echo sprintf('<span class="price rent-price" title="Precio de alquiler">%s</span>', $val);
                            endif;
                            if($prop_sale && $prop_rent):
                                echo ' | ';
                            endif;
                            if($prop_sale):
                                $val = '';
                                if(isset($_GET['operacion']) && $_GET['operacion'] != 'alquiler'){
                                    $val = '<span>'.$cur_symbol.' '.$prop_sale.'</span>';
                                }else{
                                    $val = $cur_symbol.' '.$prop_sale;
                                }
                                echo sprintf('<span class="price sale-price" title="Precio de venta">%s</span>', $val);
                            endif;
                        endif;
                        ?>
                    </span>
                </a>
            </div>
        </div>
        <?php if(isset($type)): ?>
        <div class="media-right">
            <a class="prop-icon-type" href="<?= isset($type) ? get_term_link($type) : get_bloginfo('home').'/?s='; ?>" title="<?php echo __('Tipo de propiedad') ?>">
                <span class="material-icons md-36" <?= isset($type) ? $type->name : __('Propiedad', 'tnb'); ?>>business</span>
                <span>
                    <?= $type->name  ?>
                </span>
            </a>
        </div>
        <?php endif; ?>
    </div>


    </div>
     <div class="card-footer">
         <div class="card-footer-item is-justify-content-flex-start is-flex-grow-2">
             <ul class="list-inline">
                 <?php if(isset($prop_dormrooms)):
                    $dorms = intval($prop_dormrooms);
                    ?>
                     <li class="icon-text">
                        <span class="icon material-icons icon-small" title="<?php echo sprintf(ngettext("%d Dormitorio", "%d Dormitorios", $dorms), $dorms); ?>">
                            hotel
                        </span>
                        <span><?php echo sprintf("%d", $dorms); ?></span>
                     </li>
                 <?php endif; ?>
                 <?php
                    if(isset($prop_bathrooms)):
                    $baths = intval($prop_bathrooms);
                    ?>
                     <li class="icon-text">
                        <span class="icon material-icons icon-small" title="<?php echo sprintf(ngettext("%d Baño", "%d Baños", $baths), $baths);?>">
                            bathtub
                        </span>
                        <span><?= sprintf("%d", $baths);?></span>
                     </li>
                 <?php endif; ?>
            </ul>
        </div>
        <a class="card-footer-item" href="<?php the_permalink() ?>">
            <?php echo __('Ver Más') ?>
        </a>
    </div>
</div>
