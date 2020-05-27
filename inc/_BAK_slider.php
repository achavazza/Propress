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
echo '<div id="slider" class="grid">';
if( $slider_query->have_posts() ): while( $slider_query->have_posts() ) : $slider_query->the_post();
    $slider_props = get_term_meta($slider_id);

    $content_align = (get_post_meta($post->ID)['slide_prop_align']) ? get_post_meta($post->ID)['slide_prop_align'][0] : '';
    $atts  = 'width:'.$slider_props['slider_term_w'][0].';';
    $atts .= 'height:'.$slider_props['slider_term_h'][0].';';
    //echo '<div>';
    echo sprintf('<div style="%s">', $atts);
        //echo '<div class="grid">';

        $bg = get_the_post_thumbnail_url(get_the_ID(),'full');
        $props  = 'background-image:url('.$bg.');';
        $props .= 'height:'.$slider_props['slider_term_h'][0];
        $content = sprintf('<div class="content">%s</div>', get_the_content(get_the_ID()));

        echo sprintf('<div class="slide-item %s" style="%s">%s</div>', $content_align, $props, $content);
        //get_template_part('loop');
        //echo '</div>';
    echo '</div>';
endwhile; endif;
echo '</div>';

if($slider_props['slider_term_animated'][0]){
    echo '<script>var animated = true</script>';
};
echo '<script>var loop;</script>';
if($slider_props['slider_term_loop'][0]){
    echo '<script>loop = true</script>';
};
if($slider_props['slider_term_time'][0]){
    echo '<script>var time = '.intval($slider_props['slider_term_time'][0]).'</script>';
};

wp_enqueue_script('siema-slider');
//wp_enqueue_script('slider');
?>
<?php //pr(get_post_meta( get_the_ID(), 'extra_image_position', true )); ?>
<?php //pr(get_post_meta( get_the_ID())); ?>
<?php //pr(get_the_id()); ?>
