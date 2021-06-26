<?php
//grab data
$data            = get_post_meta($post->ID);
$prop_title      = get_the_title();

$prop_link       = get_the_permalink();
$mapGPS          = get_post_meta($post->ID, '_prop_map', true);

//$mapGPS['latitude'] = '-31.6330832';
//$mapGPS['longitude'] = '-60.7079291';
$lat = empty($mapGPS['latitude'])  ? get_option('tnb_setup_options')['tnb_setup_lat']  : $mapGPS['latitude'];
$lon = empty($mapGPS['longitude']) ? get_option('tnb_setup_options')['tnb_setup_lon'] : $mapGPS['longitude'];

$props[$i]['latlng'][] = $lat;
$props[$i]['latlng'][] = $lon;


//create out
ob_start();
//<div id="content">
?>
<div id="bodyContent">
    <?php get_template_part('parts/map','loop', $data) ?>
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
