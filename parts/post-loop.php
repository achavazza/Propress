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
    <div class="card-img">
        <div class="card-img-top thumb-head">
            <?php
            echo '<ul class="list-unstyled list-inline list-badges">';
                if($statuses):
                    $out  = '';
                    $out .= '<li class="list-inline-item">';
                    $out .= sprintf('<a class="badge bg-info" href="%s">%s</a>', get_term_link($statuses), $statuses->name);
                    $out .= '</li>';
                    echo $out;
                endif;
                if($ops):
                    foreach($ops as $op):
                        $out = '';
                        $out .= '<li class="list-inline-item">';
                        $out .= sprintf('<a class="badge bg-primary" href="%s">%s</a>', get_term_link($op), $op->name);
                        $out .= '</li>';
                        echo $out;
                    endforeach;
                endif;
                if($prop_feat):
                    $out = '';
                    $out .= '<li class="list-inline-item">';
                        $out .= sprintf('<span class="badge bg-warning">%s</span>', __('Destacado', 'propress'));
                    $out .= '</li>';
                    echo $out;
                endif;
            echo '</ul>';
            echo '<a href="'.get_the_permalink().'">';
                echo $thumb ? $thumb : sprintf('<img src="%s" />', get_attachment_url_by_slug('default', 'medium'));
            echo '</a>';
            ?>
        </div>
    </div>
    <div class="card-header">
        <a href="<?php the_permalink() ?>">
            <span class="h3 prop-title align-center">
                <?php
                    if($prop_address):
                        echo $prop_address;
                    else:
                        the_title();
                    endif;
                ?>
            </span>
            <span class="h4 sub-title align-center">
                <?php
                if ($prop_loc):
                    echo $prop_loc;
                else:
                    echo '&nbsp;';
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
    <div class="card-body">
        <ul class="list-unstyled prop-list">
            <li>
                <?php if(!$type):?>
                <a href="<?php echo get_bloginfo('home').'/?s=' ?>" title="<?php echo __('Tipo de propiedad') ?>">
                    <span class="block align-center">
                        <i class="icon cofasa-img-icons icon-l icon-property"></i>
                    </span>
                    <?php echo 'Propiedad' ?>
                </a>
                <?php else: ?>
                <a href="<?php echo get_term_link($type); ?>" title="<?php echo __('Tipo de propiedad') ?>">
                    <span class="block align-center">
                        <i class="icon cofasa-img-icons icon-l icon-property"></i>
                    </span>
                    <?php echo $type->name; ?>
                </a>
                <?php endif; ?>
            </li>
            <?php if($prop_dormrooms): ?>
            <li>
                <span title="<?php echo __('Dormitorios') ?>">
                    <span class="block align-center">
                        <i class="icon cofasa-img-icons icon-l icon-bed"></i>
                    </span>
                    <?php
                        $dorms = intval($prop_dormrooms);
                        echo sprintf(ngettext("%d Dormitorio", "%d Dormitorios", $dorms), $dorms);
                    ?>
                </span>
            </li>
            <?php endif; ?>
            <?php if($prop_bathrooms): ?>
            <li>
                <span title="<?php echo __('Baños') ?>">
                    <span class="block align-center">
                        <i class="icon cofasa-img-icons icon-l icon-bath"></i>
                    </span>
                    <?php
                        $baths = intval($prop_bathrooms);
                        echo sprintf(ngettext("%d Baño", "%d Baños", $baths), $baths);
                    ?>
                </span>
            </li>
            <?php endif; ?>
        </ul>
    </div>
     <div class="card-body text-right">
        <a class="btn btn-primary" href="<?php the_permalink() ?>">
            <?php echo __('Mas Información') ?>
        </a>
    </div>
</div>
