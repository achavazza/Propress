<div id="gallery">
    <figure class="big-thumb">
        <?php
        $i = 0;
        $postThumbnailID = get_post_thumbnail_id($post->ID);
        $postThumbnail   = wp_get_attachment_image_src( $postThumbnailID, 'full');
        if(isset($postThumbnail) && !empty($postThumbnail)): ?>
                <a class="thumb" data-index="<?php echo $i ?>" href="<?php echo $postThumbnail[0] ?>" itemprop="contentUrl" data-size="<?php echo $postThumbnail[1].'x'.$postThumbnail[2] ?>">
                    <?php echo get_the_post_thumbnail($post->ID, 'large'); ?>
                </a>
            <?php $i++; ?>
        <?php else: ?>
            <img src="<?php echo get_attachment_url_by_slug('default', 'large') ?>" />
        <?php endif; ?>
        <?php
            $btns = get_post_meta( get_the_ID(), '_prop_map-buttons', 1);
            if($btns): ?>
            <ul class="thumb-btns">
                <?php if(in_array('map', $btns)): ?>
                    <li><a class="btn" href="#map_lightbox" id="map_lightbox_trigger"><i class="icon cofasa-linear icon-map"></i></a></li>
                <?php endif; ?>
                <?php if(in_array('street', $btns)): ?>
                    <li><a class="btn" href="#street_lightbox" id="street_lightbox_trigger"><i class="icon cofasa-linear icon-marker"></i></a></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </figure>

    <?php
    $block = '';
    $gallery_images = get_post_meta( get_the_ID(), '_prop_images', 1);
    $thumb_limit = get_option('tnb_config_options')['tnb_config_options_gallery'];
    $limit = 5; //5+1
    if($thumb_limit){
        $limit = intval($thumb_limit);
    }
    if ( ! empty( $gallery_images ) ) :
        $count = count($gallery_images);
        ?>
        <span class="img-list">
            <?php
            foreach ( $gallery_images as $gallery_image ) :
                $image = wp_get_attachment_image_src( attachment_url_to_postid($gallery_image), 'large');
                $thumb = wp_get_attachment_image(attachment_url_to_postid( $gallery_image), 'thumbnail' );
                //$thumb = wp_get_attachment_image( $gallery_image, 'thumbnail' );
                //$img   = wp_get_attachment_image_src( $gallery_image[0], 'thumbnail');
                //$thumb = '<img src="'.$img[0].'" width="'.$img[1].'" height="'.$img[2].'" />';
                if($postThumbnailID == $gallery_image){
                    continue;
                }
                if($i > $limit){
                    $block  = '<figure class="img-limit">';
                    $block .= '<a class="thumb" data-index="'.$i.'" href="'.$image[0].'" itemprop="contentUrl" data-size="'.$image[1].'x'.$image[2].'">';
                    $block .= $thumb;
                    //$block .= wp_get_attachment_image( $gallery_image, 'thumbnail' );
                    $block .= '<span>'.($count - $limit).' más ...'.'</span>';
                    $block .= '</a>';
                    $block .= '</figure>';

                    $style  = 'style="display:none"';
                }
                ?>
                <figure <?php echo $style ?>>
                    <a class="thumb" data-index="<?php echo $i ?>" href="<?php echo $image[0] ?>" itemprop="contentUrl" data-size="<?php echo $image[1].'x'.$image[2] ?>">
                        <?php echo $thumb; ?>
                    </a>
                </figure>
                <?php $i++; ?>
            <?php endforeach; ?>
            <?php echo $block; ?>
        </span>
    <?php endif; ?>
</div>
