<?php
//grab data
$data            = get_post_meta($post->ID);
$prop_title      = get_the_title();
$prop_link       = get_the_permalink();
$prop_img        = get_the_post_thumbnail_url(null, 'thumbnail');

$type            = get_the_terms($post, 'tipo')[0];
$prop_loc        = get_location($post);
$default         = get_attachment_url_by_slug('default', 'thumbnail');

$thumb           = empty($prop_img) ? $default : $prop_img;

$prop_address    = $data['_prop_address'][0];
$prop_sale       = ($data['_prop_price_sale'][0]!= '0,00') ? $data['_prop_price_sale'][0] : '';
$prop_rent       = ($data['_prop_price_rent'][0]!= '0,00') ? $data['_prop_price_rent'][0] : '';

//$mapGPS          = $data['_prop_map'][0];
$mapGPS          = get_post_meta($post->ID, '_prop_map', true);

//$mapGPS['latitude'] = '-31.6330832';
//$mapGPS['longitude'] = '-60.7079291';
$lat = empty($mapGPS['latitude'])  ? get_option('tnb_setup_options')['tnb_setup_lat']  : $mapGPS['latitude'];
$lon = empty($mapGPS['longitude']) ? get_option('tnb_setup_options')['tnb_setup_lon'] : $mapGPS['longitude'];

$props[$i]['latlng'][] = $lat;
$props[$i]['latlng'][] = $lon;

//pr($mapGPS);
$prop_rooms      = ($data['_prop_rooms'][0] != 0) ? $data['_prop_rooms'][0] : '' ;
$prop_sup        = ($data['_prop_sup'][0] != 0) ? $data['_prop_sup'][0] : '';
$prop_dormrooms  = ($data['_prop_dormrooms'][0] != 0) ? $data['_prop_dormrooms'][0] : '';
$prop_bathrooms  = ($data['_prop_bathrooms'][0] != 0) ? $data['_prop_bathrooms'][0] : '';
$prop_garage     = ($data['_prop_garage'][0] != 0) ? $data['_prop_garage'][0] : '';
$prop_time       = ($data['_prop_time'][0] != 0) ? $data['_prop_time'][0] : '';

//create out
ob_start();
//<div id="content">
?>
<div id="bodyContent">
    <div class="media">
        <div class="img">
            <?php echo sprintf('<a href="%s"><img src="%s" /></a>', get_permalink(),  $thumb); ?>
        </div>
        <div class="bd">
            <div class="title-container">
                <span class="h3">
                    <?php echo sprintf('<a href="%s">%s</a>', get_permalink(), $prop_address ? $prop_address : get_the_title()); ?>
                </span>
                <span class="h4 em">
                    <?php if ($prop_loc){
                        echo $prop_loc;
                    } ?>
                </span>
            </div>
            <?php if($type): ?>
                <h4 class="h4">
                    <a href="<?php echo get_term_link($type); ?>">
                        <?php echo $type->name; ?>
                    </a>
                </h4>
            <?php endif; ?>
            <ul class="prop-list flush">
                <?php if($prop_rooms): ?>
                <li title="<?php echo __('Ambientes') ?>">
                        <i class="icons-big icon-rooms"></i>
                        &nbsp;
                        <?php echo $prop_rooms; ?>
                </li>
                <?php endif; ?>
                <?php if($prop_sup): ?>
                <li title="<?php echo __('Superficie') ?>">
                        <i class="icons-big icon-sup"></i>
                        &nbsp;
                        <?php echo $prop_sup; ?>
                        m<sup>2</sup>
                </li>
                <?php endif; ?>
                <?php if($prop_dormrooms): ?>
                <li title="<?php echo __('Dormitorios') ?>">
                        <i class="icons-big icon-bed"></i>
                        &nbsp;
                        <?php echo $prop_dormrooms; ?>
                </li>
                <?php endif; ?>
                <?php if($prop_bathrooms): ?>
                <li title="<?php echo __('Baños') ?>">
                        <i class="icons-big icon-bath"></i>
                        &nbsp;
                        <?php echo $prop_bathrooms; ?>
                </li>
                <?php endif; ?>
                <?php if($prop_garage): ?>
                <li title="<?php echo __('Cochera') ?>">
                        <i class="icons-big icon-garage"></i>
                        &nbsp;
                        <?php echo $prop_garage; ?>
                </li>
                <?php endif; ?>
                <?php if($prop_time): ?>
                <li title="<?php echo __('Antigüedad') ?>">
                        <i class="icons-big icon-time"></i>
                        &nbsp;
                        <?php echo $prop_time; ?>
                </li>
                <?php endif; ?>
            </ul>
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
</div>
<?php
//</div>
$out = ob_get_contents();

//clean
$out = trim(preg_replace('/\t+/', '', $out));
$out = preg_replace('~[\r\n]+~', '', $out);
ob_end_clean();

//send to var
//$props[$i]['icon'] = $prop['icon'];
$props[$i]['body'] = $out;
?>
