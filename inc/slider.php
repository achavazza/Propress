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

    $calc    = round(((int)$slider_props['slider_term_h'][0] * 100) / (int)$slider_props['slider_term_w'][0], 2);
    $padding = 'style="padding-bottom:'.$calc.'%"';

    //echo '<div class="container">';
    echo sprintf('<div id="main-slider" %s>', $padding);
    while( $slider_query->have_posts() ) : $slider_query->the_post();
        $content_align = (get_post_meta($post->ID)['slide_prop_align']) ? get_post_meta($post->ID)['slide_prop_align'][0] : '';

        $bg      = get_the_post_thumbnail_url(get_the_ID(),'full');
        $props   = 'background-image:url('.$bg.');';
        $content = sprintf('<div class="container"><div class="content %s">%s</div></div>', $content_align, get_the_content(get_the_ID()));

        echo sprintf('<div class="slide-item" style="%s">%s</div>', $props, $content);
    endwhile;
    //echo '</div>';
echo '</div>';

if($slider_props['slider_term_animated'][0]){
    echo '<script>var animated = true</script>';
};
echo '<script>var loop;</script>';
if($slider_props['slider_term_loop'][0]){
    echo '<script>var loop = true</script>';
};
if($slider_props['slider_term_time'][0]){
    echo '<script>var time = '.intval($slider_props['slider_term_time'][0]).'</script>';
};



else:
    echo '<div class="container">';
    echo sprintf('<div id="main-thumbnail">');
    echo get_the_post_thumbnail(get_the_ID(),'large');
    echo '</div>';
    echo '</div>';
endif;
wp_enqueue_script('siema-init');

//wp_enqueue_script('slider');
?>
<?php //pr(get_post_meta( get_the_ID(), 'extra_image_position', true )); ?>
<?php //pr(get_post_meta( get_the_ID())); ?>
<?php //pr(get_the_id()); ?>
