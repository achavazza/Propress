<?php
$data              = get_post_meta($post->ID);
$prop_rooms        = $data['_prop_rooms'][0];
$prop_sup          = $data['_prop_sup'][0];
$prop_dormrooms    = $data['_prop_dormrooms'][0];
$prop_bathrooms    = $data['_prop_bathrooms'][0];
//$prop_garage     = $data['_prop_garage'][0];
//$prop_time       = $data['_prop_time'][0];
 ?>
<div class="card block">
<div class="card-content">
    <ul class="prop-list is-unstyled">
        <li>
            <?php if(!$type):?>
            <a class="icon-text" href="<?php echo get_bloginfo('home').'/?s=' ?>" title="<?php echo __('Tipo de propiedad') ?>">
                <span class="block align-center">
                    <i class="material-icons">business</i>
                </span>
                &nbsp;
                <?php echo 'Propiedad' ?>
            </a>
            <?php else: ?>
            <a class="icon-text" href="<?php echo get_term_link($type); ?>" title="<?php echo __('Tipo de propiedad') ?>">
                <span class="icon">
                    <i class="material-icons">business</i>
                </span>
                <span>
                    <?php echo $type->name; ?>
                </span>
            </a>
            <?php endif; ?>
        </li>
        <?php if($prop_dormrooms): ?>
        <li>
            <span class="icon-text" title="<?php echo __('Dormitorios') ?>">
                <span class="icon">
                    <i class="material-icons">bed</i>
                </span>
                <span>
                <?php
                    if(!$prop_dormrooms):
                        $prop_dormrooms = 0;
                    endif;
                    $dorms = intval($prop_dormrooms);
                    echo sprintf(ngettext("%d Dormitorio", "%d Dormitorios", $dorms), $dorms);
                ?>
                </span>
            </span>
        </li>
        <?php endif; ?>
        <?php if($prop_bathrooms): ?>
        <li>
            <span class="icon-text" title="<?php echo __('Baños') ?>">
                <span class="icon">
                    <i class="material-icons">bathtub</i>
                    <!-- <i class="icon cofasa-linear icon-l icon-bath"></i> -->
                </span>
                <span>
                    <?php
                        //if(!$prop_bathrooms):
                        //    $prop_bathrooms = 0;
                        //endif;
                        $baths = intval($prop_bathrooms);
                        echo sprintf(ngettext("%d Baño", "%d Baños", $baths), $baths);
                    ?>
                </span>
            </span>
        </li>
        <?php endif; ?>
    </ul>
</div>
</div>
