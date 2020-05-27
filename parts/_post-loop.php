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

//var_dump($prop_sale);

?>
<div <?php post_class('box') ?> id="post-<?php the_ID(); ?>">
    <div class="box-head">
        <div class="thumb-head">
            <ul class="thumb-badges flush">
                <?php if($prop_phrase): ?>
                    <li>
                        <span class="badge badge-danger">
                            <?php echo $prop_phrase; ?>
                        </span>
                    </li>
                <?php endif; ?>
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
            <span class="title-container">
                <span class="h3">
                    <a href="<?php the_permalink() ?>">
                        <?php if($prop_address): ?>
                            <?php echo $prop_address; ?>
                            <span class="sub-title">
                                <?php
                                if ($prop_extra):
                                    echo ' - ' . $prop_extra;
                                endif;
                                ?>
                            </span>
                        <?php else: ?>
                            <?php the_title(); ?>
                        <?php endif; ?>
                    </a>
                </span>
                <span class="h4 em">
                    <?php if ($prop_loc){
                        echo $prop_loc;
                    } ?>
                </span>
            </span>
        </div>
    </div>

    <div class="box-body">
        <?php if($type): ?>
            <h4 class="h4 h4-title">
                <a href="<?php echo get_term_link($type); ?>">
                    <?php echo $type->name; ?>
                </a>
            </h4>
        <?php endif; ?>
        <ul class="prop-list flush">
            <?php if($prop_rooms): ?>
            <li>
                <span title="<?php echo __('Ambientes') ?>">
                    <i class="icons-big icon-rooms"></i>
                    &nbsp;
                    <?php echo $prop_rooms; ?>
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
            <li>
                <span title="<?php echo __('Dormitorios') ?>">
                    <i class="icons-big icon-bed"></i>
                    &nbsp;
                    <?php echo $prop_dormrooms; ?>
                </span>
            </li>
            <?php endif; ?>
            <?php if($prop_bathrooms): ?>
            <li>
                <span title="<?php echo __('Baños') ?>">
                    <i class="icons-big icon-bath"></i>
                    &nbsp;
                    <?php echo $prop_bathrooms; ?>
                </span>
            </li>
            <?php endif; ?>
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
        </ul>
    </div>
    <div class="box-foot">
        <div class="price-block">
            <?php if(!$prop_sale && !$prop_rent): ?>
                <strong>Precio: </strong>
                <?php echo __('Consultar') ?>
            <?php else: ?>
                <?php if($prop_rent): ?>
                    <strong>Alquiler: </strong>
                    <?php if(isset($_GET['operacion']) && $_GET['operacion'] == 'alquiler'){
                        echo '<strong class="highlight">'.'$'.$prop_rent.'</strong>';
                    }else{
                        echo '$'.$prop_rent;
                    } ?>
                <?php endif; ?>
                <?php if($prop_sale && $prop_rent): ?>
                    <?php echo ' | ' ?>
                <?php endif; ?>
                <?php if($prop_sale): ?>
                    <strong>Venta: </strong>
                    <?php if(isset($_GET['operacion']) && $_GET['operacion'] != 'alquiler'){
                        echo '<strong class="highlight">'.'$'.$prop_sale.'</strong>';
                    }else{
                        echo '$'.$prop_sale;
                    } ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <a class="btn btn-secondary btn-block" href="<?php the_permalink() ?>">
            <?php echo __('Mas Info') ?>
        </a>
    </div>
</div>
