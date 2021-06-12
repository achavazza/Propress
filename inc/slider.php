<?php //pr(get_post_meta( get_the_ID(), 'extra_metabox', true )); ?>
<?php
$slider_id = get_post_meta( get_the_ID(), 'extra_slider', true  );
$args = array(
'post_type' => 'slide',
'tax_query' => array(
    array(
        'taxonomy' => 'slider',
        'field' => 'term_id',
        'terms' => $slider_id
    )
  )
);
$slider_query = new WP_Query( $args );
if( $slider_query->have_posts() ):
$slider_props = get_term_meta($slider_id);
//$atts  = 'width:'.$slider_props['slider_term_w'][0].'px;';
//$atts .= 'height:'.$slider_props['slider_term_h'][0].'px;';


if(empty((int)$slider_props['slider_term_w'][0])){
    $slider_props['slider_term_w'][0] = 1200;
    //$slider_props['slider_term_w'][0] = 1200;
}
if(empty((int)$slider_props['slider_term_h'][0])){
    $slider_props['slider_term_h'][0] = 400;
    //$slider_props['slider_term_h'][0] = 675;
}

$calc = round(((int)$slider_props['slider_term_h'][0] * 100) / (int)$slider_props['slider_term_w'][0], 2);

$sliderHeight = $slider_props['slider_term_h'][0].'px';

//$padding = 'style="padding-bottom:'.$calc.'%"';

//echo '<div class="container">';
//echo sprintf('<div id="slider" %s>', $padding);
$active = 'active';

$wrap     = sprintf('data-bs-wrap="%s"', $slider_props['slider_term_loop'][0] ? 'true' : 'false');
$interval = $slider_props['slider_term_time'][0] ? $slider_props['slider_term_time'][0] : 5000;
$animated = sprintf('data-bs-interval="%s"', $slider_props['slider_term_animated'][0] ? $interval : 'false' );
?>
<div id="mainPageSlider" class="carousel slide" data-bs-ride="carousel" <?= $wrap ?> <?= $animated  ?> >
    <div class="carousel-indicators">
        <?php
        $i = 0;
        $active = 'active';
        ?>
        <?php while( $slider_query->have_posts() ) : $slider_query->the_post(); ?>
            <button type="button" data-bs-target="#mainPageSlider" data-bs-slide-to="<?php echo $i ?>" class="<?php echo $active ?>"></button>
            <?php
            $i++;
            $active = ''; ?>
        <?php endwhile; ?>
    </div>
    <div class="carousel-inner">
    <?php
    $active = 'active';
    while( $slider_query->have_posts() ) : $slider_query->the_post();
        $content_align = (get_post_meta($post->ID)['slide_prop_align']) ? get_post_meta($post->ID)['slide_prop_align'][0] : '';
        //echo '<div>';
        //echo sprintf('<div style="%s">', $atts);
            //echo '<div class="container">';

            //$bg = get_the_post_thumbnail_url(get_the_ID(),'full');
            //$props  = 'background-image:url('.$bg.');';
            //echo sprintf('<div class="carousel-item" style="%s">%s</div>', $props, $content);
            $img = '<div class="carousel-bg" style="background:url('. get_the_post_thumbnail_url(get_the_ID(),'full').');"></div>';
            /* es el original que funcaba
            $img = '<img src="'. get_the_post_thumbnail_url(get_the_ID(),'full').'" class="d-block w-100" alt="" style="height:'.$sliderHeight.';object-fit:cover;">';
            */
            $content = sprintf('%s <div class="carousel-caption %s">%s</div>', $img, $content_align, wpautop(get_the_content(get_the_ID())));
            $height = 'style="padding-bottom:'.$calc.'%"';
            echo sprintf('<div class="carousel-item %s" %s>%s</div>', $active, $height, $content);
            //get_template_part('loop');
            //echo '</div>';
            $active = '';
        //echo '</div>';
    endwhile;
    //echo '</div>';
    //echo '</div>';
    ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#mainPageSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainPageSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>

</div>

<?php
else:
    echo '<div class="container">';
    echo sprintf('<div id="post-thumbnail">');
    echo get_the_post_thumbnail(get_the_ID(),'large');
    echo '</div>';
    echo '</div>';
endif;



/*
if($slider_props['slider_term_animated'][0]){
    echo '<script>var animated = true</script>';
};
echo '<script>var loop;</script>';
if($slider_props['slider_term_loop'][0]){
    data-bs-wrap="false"
    echo '<script>loop = true</script>';
};
if($slider_props['slider_term_time'][0]){
    echo '<script>var time = '.intval($slider_props['slider_term_time'][0]).'</script>';
};
*/

//wp_enqueue_script('siema-slider');
//wp_enqueue_script('slider');
?>
<?php //pr(get_post_meta( get_the_ID(), 'extra_image_position', true )); ?>
<?php //pr(get_post_meta( get_the_ID())); ?>
<?php //pr(get_the_id()); ?>
