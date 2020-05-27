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
$prop_phrase     = phrases()[$data['_prop_phrase'][0]];
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
<div <?php post_class('box') ?> id="post-<?php the_ID(); ?>">
    <div class="box-head">
        <div class="thumb-head">
            <ul class="thumb-badges flush">
                <?php /*
                <?php if($prop_phrase): ?>
                    <li>
                        <span class="badge badge-danger">
                            <?php echo $prop_phrase; ?>
                        </span>
                    </li>
                <?php endif; ?>
                */ ?>
                <?php
                if($statuses){  ?>
                    <li>
                        <a class="badge badge-info" href="<?php echo get_term_link($statuses); ?>">
                            <?php echo $statuses->name; ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if($ops):
                    foreach($ops as $op): ?>
                        <li>
                            <a href="<?php echo get_term_link($op); ?>" class="badge badge-primary">
                                <?php echo $op->name; ?>
                            </a>
                        </li>
                    <?php endforeach;
                    endif; ?>
                <?php if($prop_feat): ?>
                    <li>
                        <span class="badge badge-warning">
                            <?php echo 'Destacado'; ?>
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
            <a href="<?php the_permalink() ?>">
                <?php if($thumb): ?>
                    <?php echo $thumb ?>
                <?php else: ?>
                    <img src="<?php echo get_attachment_url_by_slug('default', 'medium') ?>" />
                <?php endif; ?>
            </a>
        </div>
        <a href="<?php the_permalink() ?>">
            <span class="h3 prop-title align-center">
            <?php if($prop_address): ?>
                <?php echo $prop_address; ?>
                <?php /*
                <span class="sub-title">
                    <?php
                    if ($prop_extra):
                        echo ' - ' . $prop_extra;
                    endif;
                    ?>
                </span>
                */ ?>
            <?php else: ?>
                <?php the_title(); ?>
            <?php endif; ?>
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
            <div class="price-block">
                <?php
                if(!$prop_sale && !$prop_rent):
                    echo __('Consultar');
                else:
                    if($prop_rent):
                        $val = '';
                        if(isset($_GET['operacion']) && $_GET['operacion'] == 'alquiler'){
                            $val = '<span>'.'$'.$prop_rent.'</span>';
                            //$val = '<strong class="highlight">'.'$'.$prop_rent.'</strong>';
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
                            //echo '<strong class="highlight">'.'$'.$prop_sale.'</strong>';
                            $val = '<span>'.$cur_symbol.' '.$prop_sale.'</span>';
                            //$val = '<span class="highlight">'.$cur_symbol.' '.$prop_sale.'</span>';
                        }else{
                            $val = $cur_symbol.' '.$prop_sale;
                            //echo '$'.$prop_sale;
                        }
                        echo sprintf('<span class="price sale-price" title="Precio de venta">%s</span>', $val);
                    endif;
                endif;
                ?>
            </div>
        </a>
    </div>

    <div class="box-body">
        <ul class="prop-list">
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
                        //if(!$prop_dormrooms):
                        //    $prop_dormrooms = 0;
                        //endif;
                        $dorms = intval($prop_dormrooms);
                        echo sprintf(ngettext("%d Dormitorio", "%d Dormitorios", $dorms), $dorms);
                        //echo $prop_rooms . 'Dormitorios';
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
                        //if(!$prop_bathrooms):
                        //    $prop_bathrooms = 0;
                        //endif;
                        $baths = intval($prop_bathrooms);
                        echo sprintf(ngettext("%d Baño", "%d Baños", $baths), $baths);
                        //echo $prop_rooms . 'Dormitorios';
                    ?>
                </span>
            </li>
            <?php endif; ?>
            <?php /*
            <?php if($prop_rooms): ?>
            <li>
                <span title="<?php echo __('Ambientes') ?>">
                    <span class="block">
                        <i class="icons-big icon-rooms"></i>
                    </span>
                    &nbsp;
                    <?php
                        $rooms = intval($prop_rooms);
                        echo sprintf(ngettext("%d Ambiente", "%d Ambientes", $rooms), $rooms);
                        //echo $prop_rooms . 'Dormitorios';
                    ?>

                </span>
            </li>
            <?php endif; ?>
            <?php if($prop_sup): ?>
            <li>
                <span title="<?php echo __('Superficie') ?>">
                    <i class="icons-big icon-sup"></i>
                    &nbsp;
                    <?php echo $prop_sup; ?>
                    m<sup>2</sup>
                </span>
            </li>
            <?php endif; ?>
            <?php if($prop_dormrooms): ?>

            <?php if($prop_garage): ?>
            <li>
                <span title="<?php echo __('Cochera') ?>">
                    <i class="icons-big icon-garage"></i>
                    &nbsp;
                    <?php echo $prop_garage; ?>
                </span>
            </li>
            <?php endif; ?>
            <?php if($prop_time): ?>
            <li>
                <span title="<?php echo __('Antigüedad') ?>">
                    <i class="icons-big icon-time"></i>
                    &nbsp;
                    <?php echo $prop_time; ?>
                </span>
            </li>
            <?php endif; ?>
            */ ?>
        </ul>
    </div>
    <div class="box-foot">
        <div class="align-center">
            <a class="btn btn-primary" href="<?php the_permalink() ?>">
                <?php echo __('Mas Información') ?>
            </a>
        </div>
    </div>
</div>
